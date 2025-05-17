<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Borrowing;
use App\Models\BookRequest;
use App\Models\BorrowExtend;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LibraryController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'STUDENT_ID' => 'required|numeric',
            'password' => 'required',
        ]);

        // Basic login logic (no session, just demo)
        $user = DB::table('TBL_STUDENT')->where('STUDENT_ID', $request->STUDENT_ID)->first();
        if ($user && $user->password === $request->password) {
            $request->session()->put('student_id', $user->student_id);
            return redirect()->route('browse.books')->with('success', 'Login successful!');
        }
        return back()->with('error', 'Invalid credentials');
    }

    // Show book borrowing form
    public function showBorrowForm()
    {
        // Demo: fake books array
        $books = [
            ['id' => 1, 'title' => 'Book A'],
            ['id' => 2, 'title' => 'Book B'],
        ];
        return view('borrow', compact('books'));
    }

    // Handle book borrowing
    public function borrowBook(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer',
        ]);
        // Demo: just return success
        return back()->with('success', 'Book borrowed successfully!');
    }

    // Show meeting room booking form
    public function showMeetingForm()
    {
        // Demo: fake rooms array
        $rooms = [
            ['id' => 1, 'name' => 'Room 101'],
            ['id' => 2, 'name' => 'Room 102'],
        ];
        return view('meeting', compact('rooms'));
    }

    // Handle meeting room booking
    public function bookMeetingRoom(Request $request)
    {
        if (!$request->session()->has('student_id')) {
            return redirect()->route('login');
        }
        $request->validate([
            'room_id' => 'required|integer|min:1|max:5',
            'time_from' => 'required|date_format:Y-m-d\TH:i',
        ]);
        $studentId = $request->session()->get('student_id');
        $roomId = $request->input('room_id');
        $timeFrom = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('time_from'));
        $timeTo = (clone $timeFrom)->addHour();
        $bookDate = Carbon::now();
        // Insert into TBL_ROOM_BOOKING
        DB::table('TBL_ROOM_BOOKING')->insert([
            'ROOM_ID' => $roomId,
            'USER_ID' => $studentId,
            'BOOK_DATE' => $bookDate,
            'TIME_FROM' => $timeFrom,
            'TIME_TO' => $timeTo,
            'AVAILABILITY' => null,
            'STATUS' => null,
        ]);
        return back()->with('success', 'Meeting room booked successfully!');
    }

    // Show browse books page
    public function browseBooks(Request $request)
    {
        // No login check here!
        $studentId = $request->session()->get('student_id');
        $books = DB::table('TBL_BOOKS')->get(); // includes quantity_available
        $pendingRequests = [];
        if ($studentId) {
            $pendingRequests = BookRequest::where('STUDENT_ID', $studentId)
                ->where('STATUS', 'PENDING')
                ->pluck('book_id')->toArray();
        }
        $books = $books->map(function ($book) use ($pendingRequests) {
            if (in_array($book->book_id, $pendingRequests)) {
                $book->status = 'pending';
            } else {
                $book->status = 'available';
            }
            return $book;
        });
        return view('browse_books', ['books' => $books, 'studentId' => $studentId]);
    }

    public function requestBook(Request $request)
    {
        if (!$request->session()->has('student_id')) {
            return redirect()->route('login');
        }
        $studentId = $request->session()->get('student_id');
        $request->validate([
            'book_id' => 'required|integer',
        ]);
        // Count current borrowed books (pending or approved)
        $borrowedCount = BookRequest::where('STUDENT_ID', $studentId)
            ->whereIn('STATUS', ['Pending', 'Approved'])
            ->count();
        if ($borrowedCount >= 5) {
            return redirect()->route('browse.books')->with('error', 'You cannot borrow more than 5 books at a time.');
        }
        $exists = BookRequest::where('STUDENT_ID', $studentId)
            ->where('BOOK_ID', $request->book_id)
            ->where('STATUS', 'PENDING')
            ->exists();
        if (!$exists) {
            BookRequest::create([
                'STUDENT_ID' => $studentId,
                'REQUEST_DATE' => Carbon::now(),
                'STATUS' => 'PENDING',
                'BOOK_ID' => $request->book_id,
                'RESOLUTION_DATE' => null,
            ]);
        }
        return redirect()->route('browse.books');
    }

    // Show book status page
    public function bookStatus(Request $request)
    {
        if (!$request->session()->has('student_id')) {
            return redirect()->route('login');
        }
        $studentId = $request->session()->get('student_id');
        $borrowedBooks = BookRequest::join('TBL_BOOKS', 'TBL_BOOK_REQUEST.BOOK_ID', '=', 'TBL_BOOKS.BOOK_ID')
            ->where('TBL_BOOK_REQUEST.STUDENT_ID', $studentId)
            ->select(
                'TBL_BOOKS.TITLE as title',
                'TBL_BOOKS.AUTHOR as author',
                'TBL_BOOK_REQUEST.REQUEST_DATE as date_borrowed',
                'TBL_BOOK_REQUEST.STATUS as status',
                'TBL_BOOK_REQUEST.REQUEST_ID as REQUEST_ID'
            )
            ->get()
            ->unique(function ($item) {
                return $item->title . '|' . $item->author . '|' . $item->date_borrowed . '|' . $item->status;
            })
            ->values();

        // Fetch all extension requests for these books
        $pendingExtends = BorrowExtend::whereIn('REQUEST_ID', $borrowedBooks->pluck('request_id')->all())
            ->orderByRaw("DECODE(STATUS, 'Pending', 1, 'Approved', 2, 'Declined', 3)")
            ->get()
            ->keyBy('request_id');

        Log::info('BorrowedBooks debug', $borrowedBooks->toArray());

        return view('book_status', [
            'borrowedBooks' => $borrowedBooks,
            'pendingExtends' => $pendingExtends,
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function meetingStatus(Request $request)
    {
        if (!$request->session()->has('student_id')) {
            return redirect()->route('login');
        }
        // Placeholder: show a simple view
        return view('meeting_status');
    }

    public function extendRequest(Request $request)
    {
        Log::info('Extend Request POST', $request->all());
        $request->validate([
            'request_id' => 'required|integer',
        ]);
        try {
            $extend = BorrowExtend::create([
                'REQUEST_ID' => $request->request_id,
                'EXTEND_DATE' => Carbon::now(),
                'STATUS' => 'Pending',
                'RESOLUTION_DATE' => null,
            ]);
            Log::info('Extend Request Created', ['extend' => $extend]);
            return back()->with('success', 'Extend return due request submitted!');
        } catch (\Exception $e) {
            Log::error('Extend Request Error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to submit extend request: ' . $e->getMessage());
        }
    }
} 
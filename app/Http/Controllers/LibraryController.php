<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Borrowing;
use App\Models\BookRequest;
use Carbon\Carbon;

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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Basic login logic (no session, just demo)
        $user = DB::table('TBL_STUDENT')->where('EMAIL', $request->email)->first();
        if ($user && $user->PASSWORD === $request->password) {
            return redirect('/borrow')->with('success', 'Login successful!');
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
        $request->validate([
            'room_id' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required',
        ]);
        // Demo: just return success
        return back()->with('success', 'Meeting room booked successfully!');
    }

    // Show browse books page
    public function browseBooks(Request $request)
    {
        // No login check here!
        $studentId = $request->session()->get('student_id');
        $books = DB::table('TBL_BOOKS')->get();
        $pendingRequests = [];
        if ($studentId) {
            $pendingRequests = BookRequest::where('STUDENT_ID', $studentId)
                ->where('STATUS', 'PENDING')
                ->pluck('BOOK_ID')->toArray();
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
        $borrowedBooks = BookRequest::join('TBL_BOOKS', 'TBL_BOOK_REQUEST.book_id', '=', 'TBL_BOOKS.book_id')
            ->where('TBL_BOOK_REQUEST.student_id', $studentId)
            ->select(
                'TBL_BOOKS.title as title',
                'TBL_BOOKS.author as author',
                'TBL_BOOK_REQUEST.request_date as date_borrowed',
                'TBL_BOOK_REQUEST.status as status'
            )
            ->get()
            ->unique(function ($item) {
                return $item->title . '|' . $item->author . '|' . $item->date_borrowed . '|' . $item->status;
            })
            ->values();
        return view('book_status', ['borrowedBooks' => $borrowedBooks]);
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
} 
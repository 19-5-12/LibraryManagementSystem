<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Borrowing;

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
    public function browseBooks()
    {
        // Fetch books from the BOOKS table (assume columns: id, title, author, description, year, genre)
        $books = DB::table('TBL_BOOKS')->get();
        // Fetch borrowed book ids
        $borrowedBookIds = Borrowing::whereNull('RETURN_DATE')->pluck('BOOK_ID')->toArray();
        // Add status to each book
        $books = $books->map(function ($book) use ($borrowedBookIds) {
            $book->status = in_array($book->id, $borrowedBookIds) ? 'borrowed' : 'available';
            return $book;
        });
        return view('browse_books', ['books' => $books]);
    }

    // Show book status page
    public function bookStatus()
    {
        // Fetch borrowed books for the current user (for demo, fetch all)
        $borrowedBooks = Borrowing::join('BOOKS', 'BORROWING.BOOK_ID', '=', 'BOOKS.id')
            ->select('BOOKS.title', 'BOOKS.author', 'BORROWING.BORROW_DATE as date_borrowed', 'BORROWING.STATUS as status')
            ->get();
        return view('book_status', ['borrowedBooks' => $borrowedBooks]);
    }
} 
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LibraryController;

Route::get('/', function () {
    return view('welcome');
});

// Student Registration Routes
Route::get('/student/register', [StudentController::class, 'showRegistrationForm'])->name('student.register');
Route::post('/student/register', [StudentController::class, 'register']);

// Login
Route::get('/login', [LibraryController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LibraryController::class, 'login']);

// Meeting Room Booking
Route::get('/meeting', [LibraryController::class, 'showMeetingForm'])->name('meeting.form');
Route::post('/meeting', [LibraryController::class, 'bookMeetingRoom'])->name('meeting');

// Browse Books and Book Status
Route::get('/browse-books', [LibraryController::class, 'browseBooks'])->name('browse.books');
Route::get('/book-status', [LibraryController::class, 'bookStatus'])->name('book.status');

// Request a book
Route::post('/request-book', [LibraryController::class, 'requestBook'])->name('request.book');

// Meeting Room Booking Status (placeholder route)
Route::get('/meeting-status', [LibraryController::class, 'meetingStatus'])->name('meeting.status');

// Extend Request
Route::post('/extend-request', [LibraryController::class, 'extendRequest'])->name('extend.request');

// Logout
Route::post('/logout', [LibraryController::class, 'logout'])->name('logout');

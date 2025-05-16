<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function showRegistrationForm()
    {
        return view('students.register');
    }

    public function register(Request $request)
    {
        Log::info('Registration attempt', ['data' => $request->all()]);

        $request->validate([
            'STUDENT_ID' => 'required|numeric|unique:TBL_STUDENT,STUDENT_ID',
            'LAST_NAME' => 'required|string|max:255',
            'FIRST_NAME' => 'required|string|max:255',
            'MIDDLE_NAME' => 'nullable|string|max:255',
            'SEX' => 'required|in:M,F',
            'CONTACT_NUMBER' => 'required|string|max:20',
            'EMAIL' => 'required|email|unique:TBL_STUDENT,EMAIL',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            Log::info('Validation passed, creating student');
            $student = new Student();
            $student->STUDENT_ID = (int)$request->STUDENT_ID;
            $student->LAST_NAME = $request->LAST_NAME;
            $student->FIRST_NAME = $request->FIRST_NAME;
            $student->MIDDLE_NAME = $request->MIDDLE_NAME;
            $student->SEX = $request->SEX;
            $student->CONTACT_NUMBER = $request->CONTACT_NUMBER;
            $student->EMAIL = $request->EMAIL;
            $student->TIME_IN = Carbon::now();
            $student->REGISTERED_DATE = Carbon::now();
            $student->PASSWORD = $request->password;
            $student->STUDENT_STATUS = 'Active';
            $student->ADDRESS = 101;
            $student->CAMPUS_ID = 1;
            $student->GRADUATION_YEAR = Carbon::now()->addYears(4)->year;

            $student->save();
            Log::info('Student saved successfully');

            return redirect()->route('student.register')
                ->with('success', 'Registration successful! You can now login.');
        } catch (\Exception $e) {
            Log::error('Registration failed', ['error' => $e->getMessage()]);
            return redirect()->route('student.register')
                ->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
} 
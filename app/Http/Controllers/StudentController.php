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
        $request->validate([
            'STUDENT_ID' => 'required|numeric|unique:TBL_STUDENT,STUDENT_ID',
            'LAST_NAME' => 'required|string|max:55',
            'FIRST_NAME' => 'required|string|max:55',
            'MIDDLE_NAME' => 'nullable|string|max:55',
            'SEX' => 'required|string|max:11',
            'EMAIL' => 'required|email|unique:TBL_STUDENT,EMAIL|max:255',
            'CONTACT_NUMBER' => 'required|string|max:13',
            'password' => 'required|string|max:30',
        ]);

        try {
            $student = new Student();
            $student->STUDENT_ID = (int)$request->STUDENT_ID;
            $student->LAST_NAME = $request->LAST_NAME;
            $student->FIRST_NAME = $request->FIRST_NAME;
            $student->MIDDLE_NAME = $request->MIDDLE_NAME;
            $student->SEX = $request->SEX;
            $student->CONTACT_NUMBER = $request->CONTACT_NUMBER;
            $student->EMAIL = $request->EMAIL;
            $student->PASSWORD = $request->password;
            $student->STUDENT_STATUS = 'Studying';
            $student->CAMPUS_ID = 1;
            $student->ADDRESS = null;
            $student->TIME_IN = null;
            $student->REGISTERED_DATE = now();
            $student->GRADUATION_YEAR = now()->addYears(4);

            $student->save();

            // Optionally, log the user in after registration
            $request->session()->put('student_id', $student->STUDENT_ID);

            return redirect()->route('browse.books')->with('success', 'Registration successful! You can now login.');
        } catch (\Exception $e) {
            return redirect()->route('student.register')
                ->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
} 
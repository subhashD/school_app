<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\State;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();
        $students = Student::all();
        return view('admin.students',compact('students','states'));
    }
}

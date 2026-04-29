<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\FeeStructure;
class StudentController extends Controller {
    public function dashboard() {
        $student    = Auth::user()->student;
        $payments   = $student ? $student->payments()->with('feeStructure')->latest()->get() : collect();
        $pendingFee = null;
        if ($student) {
            $pendingFee = FeeStructure::where('course',$student->course)
                ->where('branch',$student->branch)
                ->where('semester',$student->semester)
                ->whereDoesntHave('payments', fn($q) => $q->where('student_id',$student->id)->where('status','completed'))
                ->first();
        }
        return view('student.dashboard', compact('student','payments','pendingFee'));
    }
}

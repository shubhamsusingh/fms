<?php
namespace App\Http\Controllers;
use App\Models\FeeStructure;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {

    public function dashboard() {
        $stats = [
            'total_students'   => Student::count(),
            'total_collected'  => Payment::where('status','completed')->sum('amount'),
            'pending_payments' => Payment::where('status','pending')->count(),
            'total_payments'   => Payment::where('status','completed')->count(),
        ];
        $recentPayments = Payment::with('student.user','feeStructure')->where('status','completed')->latest('paid_at')->take(10)->get();
        return view('admin.dashboard', compact('stats','recentPayments'));
    }

    public function students() {
        $students = Student::with('user')->latest()->paginate(20);
        return view('admin.students.index', compact('students'));
    }

    public function createStudent() { return view('admin.students.create'); }

    public function storeStudent(Request $request) {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:8|confirmed',
            'enrollment_no' => 'required|unique:students',
            'course'        => 'required|string',
            'branch'        => 'required|string',
            'semester'      => 'required|integer|between:1,8',
            'batch'         => 'required|string',
        ]);
        $user = User::create(['name'=>$request->name,'email'=>$request->email,'password'=>Hash::make($request->password),'role'=>'student']);
        $user->student()->create($request->only('enrollment_no','course','branch','semester','batch','phone','address'));
        return redirect()->route('admin.students')->with('success','Student added successfully.');
    }

    public function editStudent(Student $student) { return view('admin.students.edit', compact('student')); }

    public function updateStudent(Request $request, Student $student) {
        $request->validate(['course'=>'required','branch'=>'required','semester'=>'required|integer|between:1,8','batch'=>'required']);
        $student->update($request->only('course','branch','semester','batch','phone','address'));
        $student->user->update(['name'=>$request->name]);
        return redirect()->route('admin.students')->with('success','Student updated.');
    }

    public function deleteStudent(Student $student) {
        $student->user->delete();
        return redirect()->route('admin.students')->with('success','Student deleted.');
    }

    public function feeStructures() {
        $structures = FeeStructure::latest()->paginate(20);
        return view('admin.fee_structures.index', compact('structures'));
    }

    public function createFeeStructure() { return view('admin.fee_structures.create'); }

    public function storeFeeStructure(Request $request) {
        $request->validate([
            'course'=>'required','branch'=>'required','semester'=>'required|integer|between:1,8',
            'academic_year'=>'required','tuition_fee'=>'required|numeric|min:0',
            'exam_fee'=>'required|numeric|min:0','library_fee'=>'required|numeric|min:0',
            'lab_fee'=>'required|numeric|min:0','hostel_fee'=>'required|numeric|min:0',
            'other_fee'=>'required|numeric|min:0','due_date'=>'required|date',
        ]);
        FeeStructure::create($request->all());
        return redirect()->route('admin.fee_structures')->with('success','Fee structure created.');
    }

    public function editFeeStructure(FeeStructure $feeStructure) { return view('admin.fee_structures.edit', compact('feeStructure')); }

    public function updateFeeStructure(Request $request, FeeStructure $feeStructure) {
        $feeStructure->update($request->all());
        return redirect()->route('admin.fee_structures')->with('success','Fee structure updated.');
    }

    public function payments(Request $request) {
        $query = Payment::with('student.user','feeStructure')->latest();
        if ($request->status) $query->where('status',$request->status);
        $payments = $query->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function markOfflinePayment(Request $request) {
        $request->validate(['student_id'=>'required|exists:students,id','fee_structure_id'=>'required|exists:fee_structures,id']);
        Payment::create([
            'student_id'       => $request->student_id,
            'fee_structure_id' => $request->fee_structure_id,
            'amount'           => FeeStructure::find($request->fee_structure_id)->total_fee,
            'currency'         => config('paypal.currency'),
            'status'           => 'completed',
            'payment_method'   => 'offline',
            'paid_at'          => now(),
            'notes'            => $request->notes,
        ]);
        return redirect()->route('admin.payments')->with('success','Offline payment recorded.');
    }
}

<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

// Auth routes (no laravel/ui needed)
Route::get('login',  [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'login'])->middleware('guest');
Route::post('logout',[LoginController::class, 'logout'])->name('logout');
Route::get('password/reset',         [ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
Route::post('password/email',        [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset',        [ResetPasswordController::class, 'reset'])->name('password.update');

// Role redirect
Route::middleware('auth')->get('/home', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('student.dashboard');
})->name('home');

// Student
Route::middleware('auth')->prefix('student')->name('student.')->group(function () {
    Route::get('dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
});

// Payments
Route::middleware('auth')->prefix('payment')->name('payment.')->group(function () {
    Route::get('/',                 [PaymentController::class, 'index'])->name('index');
    Route::post('create-order',     [PaymentController::class, 'createOrder'])->name('create');
    Route::get('success',           [PaymentController::class, 'success'])->name('success');
    Route::get('cancel',            [PaymentController::class, 'cancel'])->name('cancel');
    Route::get('receipt/{payment}', [PaymentController::class, 'receipt'])->name('receipt');
});

// Admin
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('students',                 [AdminController::class, 'students'])->name('students');
    Route::get('students/create',          [AdminController::class, 'createStudent'])->name('students.create');
    Route::post('students',                [AdminController::class, 'storeStudent'])->name('students.store');
    Route::get('students/{student}/edit',  [AdminController::class, 'editStudent'])->name('students.edit');
    Route::put('students/{student}',       [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('students/{student}',    [AdminController::class, 'deleteStudent'])->name('students.delete');

    Route::get('fee-structures',                      [AdminController::class, 'feeStructures'])->name('fee_structures');
    Route::get('fee-structures/create',               [AdminController::class, 'createFeeStructure'])->name('fee_structures.create');
    Route::post('fee-structures',                     [AdminController::class, 'storeFeeStructure'])->name('fee_structures.store');
    Route::get('fee-structures/{feeStructure}/edit',  [AdminController::class, 'editFeeStructure'])->name('fee_structures.edit');
    Route::put('fee-structures/{feeStructure}',       [AdminController::class, 'updateFeeStructure'])->name('fee_structures.update');

    Route::get('payments',          [AdminController::class, 'payments'])->name('payments');
    Route::post('payments/offline', [AdminController::class, 'markOfflinePayment'])->name('payments.offline');
    Route::get('payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
});

<?php
namespace App\Http\Controllers;

use App\Models\FeeStructure;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    /**
     * Build and return a fully configured PayPal provider.
     */
    private function getProvider(): PayPalClient
    {
        $provider = new PayPalClient([
            'mode'    => env('PAYPAL_MODE', 'sandbox'),
            'sandbox' => [
                'client_id'     => env('PAYPAL_SANDBOX_CLIENT_ID'),
                'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET'),
                'app_id'        => '',
            ],
            'live' => [
                'client_id'     => env('PAYPAL_LIVE_CLIENT_ID'),
                'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET'),
                'app_id'        => '',
            ],
            'payment_action'    => 'Sale',
            'currency'          => env('PAYPAL_CURRENCY', 'USD'),
            'notify_url'        => '',
            'locale'            => 'en_US',
            'validate_ssl'      => true,
        ]);

        $provider->getAccessToken();
        return $provider;
    }

    /**
     * Show the payment page.
     */
    public function index()
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('student.dashboard')->with('error', 'Student profile not found.');
        }

        $feeStructures = FeeStructure::where('course', $student->course)
            ->where('branch', $student->branch)
            ->where('semester', $student->semester)
            ->get();

        $payments = $student->payments()->with('feeStructure')->latest()->get();

        return view('payments.index', compact('student', 'feeStructures', 'payments'));
    }

    /**
     * Create a PayPal order and redirect to PayPal.
     */
    public function createOrder(Request $request)
    {
        $request->validate(['fee_structure_id' => 'required|exists:fee_structures,id']);

        $student      = Auth::user()->student;
        $feeStructure = FeeStructure::findOrFail($request->fee_structure_id);

        // Prevent duplicate payment
        $alreadyPaid = Payment::where('student_id', $student->id)
            ->where('fee_structure_id', $feeStructure->id)
            ->where('status', 'completed')
            ->exists();

        if ($alreadyPaid) {
            return back()->with('error', 'Fee already paid for this semester.');
        }

        try {
            $provider = $this->getProvider();

            $orderData = [
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url'  => route('payment.success'),
                    'cancel_url'  => route('payment.cancel'),
                    'brand_name'  => config('app.name'),
                    'user_action' => 'PAY_NOW',
                ],
                'purchase_units' => [
                    [
                        'reference_id' => 'FEE-' . $feeStructure->id . '-' . $student->id,
                        'description'  => 'Semester ' . $feeStructure->semester . ' Fee | ' . $student->enrollment_no,
                        'amount'       => [
                            'currency_code' => env('PAYPAL_CURRENCY', 'USD'),
                            'value'         => number_format((float)$feeStructure->total_fee, 2, '.', ''),
                        ],
                    ],
                ],
            ];

            $order = $provider->createOrder($orderData);

            Log::info('PayPal createOrder response', ['response' => $order]);

            if (isset($order['error'])) {
                Log::error('PayPal order error', ['error' => $order['error']]);
                return back()->with('error', 'PayPal error: ' . ($order['error']['message'] ?? 'Unknown error'));
            }

            if (!isset($order['id'])) {
                Log::error('PayPal no order ID', ['response' => $order]);
                return back()->with('error', 'PayPal did not return an order ID. Check your API credentials.');
            }

            // Save pending payment record
            $payment = Payment::create([
                'student_id'       => $student->id,
                'fee_structure_id' => $feeStructure->id,
                'paypal_order_id'  => $order['id'],
                'amount'           => $feeStructure->total_fee,
                'currency'         => env('PAYPAL_CURRENCY', 'USD'),
                'status'           => 'pending',
                'payment_method'   => 'paypal',
            ]);

            session(['paypal_payment_id' => $payment->id]);

            // Find approval link
            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }

            return back()->with('error', 'Could not get PayPal approval link.');

        } catch (\Exception $e) {
            Log::error('PayPal createOrder exception: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'PayPal Error: ' . $e->getMessage());
        }
    }

    /**
     * Handle PayPal success callback.
     */
    public function success(Request $request)
    {
        try {
            $provider = $this->getProvider();
            $result   = $provider->capturePaymentOrder($request->token);

            Log::info('PayPal capture response', ['response' => $result]);

            if (isset($result['status']) && $result['status'] === 'COMPLETED') {
                $paymentId = session('paypal_payment_id');
                $payment   = Payment::findOrFail($paymentId);

                $capture = $result['purchase_units'][0]['payments']['captures'][0] ?? [];

                $payment->update([
                    'transaction_id' => $capture['id'] ?? null,
                    'status'         => 'completed',
                    'paid_at'        => now(),
                ]);

                session()->forget('paypal_payment_id');

                return redirect()->route('payment.receipt', $payment->id)
                    ->with('success', 'Payment successful! Receipt generated.');
            }

            return redirect()->route('payment.index')
                ->with('error', 'Payment not completed. Status: ' . ($result['status'] ?? 'unknown'));

        } catch (\Exception $e) {
            Log::error('PayPal success error: ' . $e->getMessage());
            return redirect()->route('payment.index')
                ->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }

    /**
     * Handle PayPal cancel callback.
     */
    public function cancel()
    {
        if ($id = session('paypal_payment_id')) {
            Payment::where('id', $id)->update(['status' => 'failed']);
            session()->forget('paypal_payment_id');
        }

        return redirect()->route('payment.index')
            ->with('error', 'Payment was cancelled. No charges were made.');
    }

    /**
     * Show payment receipt.
     */
    public function receipt(Payment $payment)
    {
        if (!Auth::user()->isAdmin() && $payment->student_id !== Auth::user()->student?->id) {
            abort(403);
        }

        $payment->load('student.user', 'feeStructure');
        return view('payments.receipt', compact('payment'));
    }
}

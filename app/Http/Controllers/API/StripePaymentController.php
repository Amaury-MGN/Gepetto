<?php

namespace App\Http\Controllers\API;

use App\Models\EstimateAdmin;
use App\Models\Estimate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;
use Stripe;

class StripePaymentController extends BaseController
{
    public function stripe()
    {
        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $user = Auth::user();
        $userId = Auth::user()->id;
        $paymentMethods = $request->paymentId;
        $estimateId = $request->estimateId;
        // dd($estimateId);
        $estimate = Estimate::find($estimateId);
        // dd($estimate);
        $estimateUserId = $estimate->user_id;
        // dd($estimateId);

        $estimateAdminFile = EstimateAdmin::where('estimate_id', $estimateId)->first();
        // dd($estimateAdminFile);

        if ($estimateAdminFile === null) {
            return $this->sendError('Error', 'Unauthorized', 401);
        } else if ($userId !== $estimateUserId) {
            return $this->sendError('Error', 'Unauthorized', 401);
        } else {
            $estimateAdminPrice = $estimateAdminFile->estimateAdminPrice;
            // dd($estimateAdminFile->id);
            Stripe\Stripe::setApiKey('sk_test_51Ji2hqDPUhX8Apb5JMIg8nJeLsu26UxVqNwr2a0QVPzaY5oej5m9tTinBeWQtgypSmAaOs08N2JqBy1F9CB6C08i00gV4s1md3');
            $stripeCharge = $user->charge($estimateAdminPrice * 100, $paymentMethods, [
                "currency"  => "eur",
            ]);

            // return Session::flash('success', 'Payment successful!');
            return response()->json(['status' => 'success', 'users'  => $stripeCharge], 200);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SslCommerz;
class PaymentController extends Controller
{
    public function initiatePayment()

    {

        $post_data = array();

        $post_data['store_id'] = config('sslcommerz.store_id');

        $post_data['store_passwd'] = config('sslcommerz.store_password');

        $post_data['total_amount'] = '100';

        $post_data['currency'] = 'BDT';

        $post_data['tran_id'] = uniqid();

        $post_data['success_url'] = route('payment.success');

        $post_data['fail_url'] = route('payment.fail');

        $post_data['cancel_url'] = route('payment.cancel');

        return SslCommerz::makePayment($post_data, 'hosted');

    }
    public function paymentSuccess(Request $request)
    {

        // Handle successful payment

    }

    public function paymentFail(Request $request)

    {

        // Handle failed payment

    }

    public function paymentCancel(Request $request)

    {

        // Handle cancelled payment

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


//START NAMESPACE FOR PAYSTACK
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use \Unicodeveloper\Paystack\Facades\Paystack;
//END NAMESPACE FOR PAYSTACK



class PaymentController extends Controller
{
    public function payment()
    {
        return view('payment');
    }



    //===START CODE FOR PAYSTACK =====

     /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }        
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }

    
    //===END CODE FOR PAYSTACK =====









    public function thank_you()
    {
        return view('thank_you');
    }









}

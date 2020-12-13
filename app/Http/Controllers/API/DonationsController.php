<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Models\Donations;
class DonationsController extends Controller
{
    public $gateway;
 
    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId('AQ4F9i02Qq2F3s3j8ZTts9E56Ydj5z1UQ3mdKOB-CkArL6agMre37FzPP4a3CbXB3SyqvDj_FGeoARr_');
        $this->gateway->setSecret('EDCLsKJFmeMc9lgTdWo2nmItMnv0BVXejnzvqQyQv_8RIIO75K45EwKzVok0ffV-VnKBPQHjHgXW3SKA');
        $this->gateway->setTestMode(true); //set it to 'false' when go live
    }

    public function charge(Request $request)
    {

        $response = $this->gateway->purchase(array(
            'amount' => $request->amount,
            'currency' => 'PHP',
            'returnUrl' => url('paymentsuccess'),
            'cancelUrl' => url('paymenterror'),
        ))->send();
        
    
        if ($response->isRedirect()) {
            return response()->json($response->getRedirectUrl());
        } else {
            // not successful
            return $response->getMessage();
        }
    }

    public function payment_success(Request $request)
    {
        // dd($request->all());
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
         
            if ($response->isSuccessful())
            {
                // The customer has successfully paid.
                $arr_body = $response->getData();
                // dd($arr_body);
                // Insert transaction data into the database
                $isPaymentExist = Donations::where('payment_id', $arr_body['id'])->first();
                
                if(!$isPaymentExist)
                {
                    $payment = new Donations;
                    $payment->payment_id = $arr_body['id'];
                    $payment->user_id = $user_id = empty($request->user_id) ? null : $request->user_id;
                    $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                    $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                    $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                    $payment->payer_name = $arr_body['payer']['payer_info']['first_name'] ." " .$arr_body['payer']['payer_info']['last_name'];
                    $payment->currency = 'PHP';
                    $payment->payment_status = $arr_body['state'];
                    $payment->save();
                }
                
                // return response()->json("Donation is Successfull. Your transaction id is: ". $arr_body['id']);
                return \Redirect::to('http://localhost:3000/donation/thankyou');
            } else {
                // return $response->getMessage();
                return 'asdasdas';
            }
        } else {
            return response()->json('Transaction is declined');
        }
    }

    public function payment_error()
    {
        return response()->json('User is canceled the payment.');
    }
}

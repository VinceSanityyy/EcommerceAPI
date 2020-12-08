<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Omnipay\Omnipay;

class PaymentController extends Controller
{
    public $gateway;
 
    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId('AQ4F9i02Qq2F3s3j8ZTts9E56Ydj5z1UQ3mdKOB-CkArL6agMre37FzPP4a3CbXB3SyqvDj_FGeoARr_');
        $this->gateway->setSecret('EDCLsKJFmeMc9lgTdWo2nmItMnv0BVXejnzvqQyQv_8RIIO75K45EwKzVok0ffV-VnKBPQHjHgXW3SKA');
        $this->gateway->setTestMode(false); //set it to 'false' when go live
    }

    public function charge(Request $request)
    {
        if($request->input('submit'))
        {
            try {
                $response = $this->gateway->purchase(array(
                    'amount' => $request->amount,
                    'currency' => 'PHP',
                    'returnUrl' => $this->payment_success,
                    'cancelUrl' => $this->payment_error,
                ))->send();
                
                if ($response->isRedirect()) {
                    $response->redirect(); 
                } else {
                    // not successful
                    return $response->getMessage();
                }
            } catch(Exception $e) {
                return $e->getMessage();
            }
        }
        // dd($request->all());
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
                $isPaymentExist = Payment::where('payment_id', $arr_body['id'])->first();
                
                if(!$isPaymentExist)
                {
                    $payment = new Payment;
                    $payment->payment_id = $arr_body['id'];
                    $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                    $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                    $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                    $payment->payer_name = $arr_body['payer']['payer_info']['first_name'] ." " .$arr_body['payer']['payer_info']['last_name'];
                    $payment->currency = 'PHP';
                    $payment->payment_status = $arr_body['state'];
                    $payment->save();
                }
                
                return response()->json("Payment is successful. Your transaction id is: ". $arr_body['id']);
            } else {
                return $response->getMessage();
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

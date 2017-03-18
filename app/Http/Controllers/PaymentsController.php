<?php

namespace App\Http\Controllers;

use App\Mail\Mover\TopedUp;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PaymentsController extends Controller
{

    private $testIp = '151.80.116.200';
    private $productionIp = '176.31.175.45';

    protected function success(Request $request)
    {

        $user = User::find($this->parseUserId($request->REF));
        Auth::login($user);

        return redirect('/account/billing-info')->with('payment_message', 'success');
    }

    protected function cancel(Request $request)
    {
        return redirect('/account/billing-info')->with('payment_message', 'canceled');
    }

    protected function error(Request $request)
    {
        return redirect('/account/billing-info')->with('payment_message', 'no_success');
    }

    protected function notification(Request $request)
    {
        if ($this->getIp() != $this->testIp || $this->getIp() != $this->productionIp) {
            //Create payment
            $payment = Payment::create([
                'type'      => $request->TYP,
                'amount'    => $request->AMT,
                'currency'  => $request->CUR,
                'reference' => $request->REF,
                'result'    => $request->RES,
                'tid'       => $request->TID,
                'oid'       => $request->OID
            ]);
            //Add money to users balance
            $userId = $this->parseUserId($payment->reference);
            $user = User::find($userId);
            $user->addFunds($payment->amount);

            //Send email
            Mail::to('tomas.stasiulionis@gmail.com')->send(new TopedUp($user, $payment));

            //Return request 200 for trustpay
            return response('success', 200);
        }

        return response('No success', 500);
    }

    private function parseUserId($orderName)
    {
        $spilttedString = explode('_', $orderName);
        return $spilttedString[1];
    }

    private function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    return $ip;
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }
}

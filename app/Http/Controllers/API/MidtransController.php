<?php

namespace App\Http\Controllers\API;

use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MidtransController extends Controller
{
    public function callback(Request $request) {
        // configurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // instance midtrans notification
        $notification = new Notification();

        // varibale unutk menampung notofication
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // get transaction by id
        $transaction = Transaction::findOrFail($order_id);

        // handle status notification
        if($status == 'capture') {
            if($type == 'credite_card') {
                if($fraud == 'chellenge') {
                    $transaction->status = 'PENDING';
                } else {
                    $transaction->status = 'SUCCESS';
                }
            }
        } else if($status == 'settlement') {
            $transaction->status = 'SUCCESS';
        } else if($status == 'pending') {
            $transaction->status = 'PENDING';
        } else if($status == 'deny') {
            $transaction->status = 'CANCELLED';
        } else if($status == 'expire') {
            $transaction->status = 'CANCELLED';
        } else if($status == 'cancel') {
            $transaction->status = 'CANCELLED';
        }

        // save status baru
        $transaction->save();
    }

    public function success(Request $request) {
        return view('midtrans/success');
    }

    public function unfinish(Request $request) {
        return view('midtrans/unfinish');
    }

    public function failed(Request $request) {
        return view('midtrans/failed');
    }
}

<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Http;

class FonnteServiceController extends Controller
{

  private function sendMessage($number, $message)
  {
    $url = "https://api.fonnte.com/send";
    $token = env("FONNTE_TOKEN");

    try {
      Http::withHeaders([
        'Authorization' => $token,
      ])->post($url, [
        "target" => $number,
        "message" => $message,
      ]);
    } catch (Exception $e) {
    }
  }

  public function generateMessage(Transaction $transaction)
  {
    $msg = "Dear *" . $transaction->user_name . "* \n \n";
    $msg .= "You made an event purchase with the following details: \n";

    $msg .= "Transaction ID: *" . $transaction->number . "* \n";

    foreach ($transaction->transaction_details as $detail) {
      $msg .= "- " . $detail->event_name . " _" . $detail->event->title . "_ \n";
    }

    $msg .= "Please transfer via ATM, internet banking, or mobile banking with the following amount: \n";
    $msg .= "Amount: Rp *" . number_format($transaction->total, 0, ',', '.') . "* \n";
    $msg .= "Bank: *MANDIRI* \n";
    $msg .= "Account Number: *1370 0013 3133 5* \n";
    $msg .= "Account Name: *Perki Cabang Yogyakarta* \n \n";
    $msg .= "Please upload proof of payment after making payment. \n";

    if (env("APP_ENV") == 'local') {
      return $this->sendMessage('081239709445', $msg);
    } else {
       return $this->sendMessage($transaction->user_phone, $msg);
    }
  }

  public function test()
  {
    $transaction  = Transaction::find(1204);
    return $this->generateMessage($transaction);
  }
}

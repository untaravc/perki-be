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
                "target"  => $number,
                "message" => $message,
            ]);
        } catch (Exception $e) {
        }
    }

    // On registration
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
            $this->sendMessage('081239709445', $msg);
        } else {
            $this->sendMessage($transaction->user_phone, $msg);
        }
    }

    public function generateQrMsg(Transaction $transaction)
    {
        $msg = "Dear *" . $transaction->user_name . "* \n \n";

        $msg .= "Thank you for registering the Jogja Cardiology Update, scheduled to take place from October 18-20 at Tentrem Hotel Yogyakarta. Below are the event details based on your selected events: \n \n";
        $msg .= "- Symposium: October 19 08.00 - 16.00 (WIB) and October 20, 08.00 - 16.00 \n";

        foreach ($transaction->transaction_details as $detail) {
            if ($detail->event_id !== 111) {
                $msg .= "- " . $detail->event_name . ": October 18 " . date("H:i", strtotime($detail->event->date_start)) . " - " . date("H:i", strtotime($detail->event->date_end)) . " \n";
            }
        }

        $msg .= "\n \n";
        $msg .= "Please download the QR code from this following link, which will serve as your access for event check-in. You will need to present this upon entering the venue. \n \n";
        $msg .= "https://src.perki-jogja.com/storage/qr_pdf/" . $transaction->number . ".pdf";

        if (env("APP_ENV") == 'local') {
            $this->sendMessage('081239709445', $msg);
        } else {
            $this->sendMessage($transaction->user_phone, $msg);
        }
    }

    public function test()
    {
        // $email_service = new EmailServiceController();
        // $email_service->qr_code_access(1038);

        // $transaction  = Transaction::find(1204);
        // return $this->generateQrMsg($transaction);
    }
}

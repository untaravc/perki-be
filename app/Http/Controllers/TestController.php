<?php

namespace App\Http\Controllers;

use App\Http\Controllers\System\EmailServiceController;
use App\Models\Contact;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\MailLog;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function reset_presensi_1()
    {
        EventUser::whereIn('event_id', [20, 21, 22, 23])
            ->delete();
    }

    public function test_view()
    {
        $ctrl = new EmailServiceController();
        return $ctrl->send_abstract_certificate();
    }

    public function contactList(Request $request)
    {
        $per_page = 10;
        $active_col = explode(',', $request->cols);

        $contacts = Contact::when($request->type, function ($q) use ($request) {
            $q->whereType($request->type);
        })
            ->paginate($request->per_page ?? $per_page);
        $columns = [
            'no' => in_array('no', $active_col),
            'email' => in_array('email', $active_col),
            'name' => in_array('name', $active_col),
            'phone' => in_array('phone', $active_col),
            'type' => in_array('type', $active_col),
        ];

        return view('print.contacts.index', compact('contacts', 'columns'));
    }

    public function print_by_name(Request $request)
    {
        return view('print.event_user.nametag_by_name', [
            'name'  => $request->name,
            'title' => $request->title ?? "PARTICIPANT",
            'align' => $request->align ?? "center"
        ]);
    }

    public function check_transaction_status()
    {
        $ctlr = new EmailServiceController();
        return $ctlr->send_certificate();
    }

    public function create_certy_mail_log()
    {
        $transaction_details = TransactionDetail::whereStatus(200)
            ->with(['transaction', 'event'])
            ->whereIn('event_id', [1])
            ->whereNotIn('user_id', exclude_user_ids())
            //            ->limit(2)
            ->get();

        //        $service = new EmailServiceController();
        //        return $service->send_certificate();

        foreach ($transaction_details as $detail) {
            $attend = EventUser::whereUserId($detail['user_id'])
                ->whereEventId($detail['event_id'])
                ->first();

            $payload = [
                "email_receiver" => $detail['transaction']['user_email'],
                "receiver_name"  => $detail['transaction']['user_name'],
                "label"          => "jcu23_certificate",
                "category"       => $detail['event']['slug'],
                "title"          => $detail['event']['name'] . ": " . $detail['event']['title'],
                "model"          => "transaction_detail",
                "model_id"       => $detail['id'],
                "status"         => $attend ? 0 : 3,
            ];

            $mail_log = MailLog::whereLabel($payload['label'])
                ->whereModel($payload['model'])
                ->whereModelId($payload['model_id'])
                ->whereCategory($payload['category'])
                ->first();

            if (!$mail_log) {
                MailLog::create($payload);
            } else {
                $mail_log->update($payload);
            }

            if ($detail['event_id'] == 1) {
                $sympo_1 = Event::find(110);

                $attend2 = EventUser::whereUserId($detail['user_id'])
                    ->whereEventId($sympo_1->id)
                    ->first();

                $payload2 = [
                    "email_receiver" => $detail['transaction']['user_email'],
                    "receiver_name"  => $detail['transaction']['user_name'],
                    "label"          => "jcu23_certificate",
                    "category"       => $sympo_1->slug,
                    "title"          => $sympo_1['name'] . ": " . $sympo_1['title'],
                    "model"          => "transaction_detail",
                    "model_id"       => $detail['id'],
                    "status"         => $attend2 ? 0 : 3,
                ];

                $mail_log2 = MailLog::whereLabel($payload2['label'])
                    ->whereModel($payload2['model'])
                    ->whereModelId($payload['model_id'])
                    ->whereCategory($payload2['category'])
                    ->first();

                if (!$mail_log2) {
                    MailLog::create($payload2);
                } else {
                    $mail_log2->update($payload2);
                }
            }
        }
    }

    public function send_certy()
    {
        $new = new EmailServiceController();
        return $new->send_event_certificate();
    }
}

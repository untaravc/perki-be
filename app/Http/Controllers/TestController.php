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
        $mail_service = new EmailServiceController();
        return $mail_service->send_event_certificate();
    }

    public function send_certy()
    {
        $new = new EmailServiceController();
        return $new->send_event_certificate();
    }
}

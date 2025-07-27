<?php

namespace App\Http\Controllers;

use App\Http\Controllers\System\EmailServiceController;
use App\Mail\SendDefaultMail;
use App\Models\Contact;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\MailLog;
use App\Models\Post;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\PersonalAccessToken;

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
        $access_token = PersonalAccessToken::findToken($request->token);
        if (!$access_token) {
            return 'No Access';
        }

        $per_page = 10;
        $active_col = explode(',', $request->cols);

        $contacts = Contact::when($request->type, function ($q) use ($request) {
            $q->whereType($request->type);
        })
            ->paginate($request->per_page ?? $per_page);

        $columns = [
            'no'    => in_array('no', $active_col),
            'email' => in_array('email', $active_col),
            'name'  => in_array('name', $active_col),
            'phone' => in_array('phone', $active_col),
            'type'  => in_array('type', $active_col),
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

    public function send_abstract_email()
    {
//        $oral = Post::whereSection('jcu25')->with('user')->whereStatus(3)->get();
//        foreach ($oral as $or) {
//            $category = '';
//            switch ($or->category) {
//                case 'case_report':
//                case 'case_report_sp':
//                    $category = 'Case Report';
//                    break;
//                case 'research':
//                case 'research_sp':
//                    $category = 'Research';
//                    break;
//                case 'systematic_review':
//                    $category = 'Systematic Review';
//                    break;
//            }
//
//            $payload = [
//                "email_receiver" => $or->user->email,
//                "receiver_name"  => $or->user->name,
//                "label"          => "jcu25_oral_presentation",
//                "category"       => $category,
//                "title"          => $or->title,
//                "model"          => "post",
//                "model_id"       => $or->id,
//                "status"         => 0,
//            ];
//
//            if (!MailLog::whereLabel('jcu25_oral_presentation')->whereModelId($or->id)->first()) {
//                MailLog::create($payload);
//            }
//        }
//
//        $display = Post::whereSection('jcu25')->whereStatus(1)->get();
//
//        foreach ($display as $ds) {
//            $category = '';
//            switch ($ds->category) {
//                case 'case_report':
//                case 'case_report_sp':
//                    $category = 'Case Report';
//                    break;
//                case 'research':
//                case 'research_sp':
//                    $category = 'Research';
//                    break;
//                case 'systematic_review':
//                    $category = 'Systematic Review';
//                    break;
//            }
//
//            $payload = [
//                "email_receiver" => $ds->user->email,
//                "receiver_name"  => $ds->user->name,
//                "label"          => "jcu25_display_poster",
//                "category"       => $category,
//                "title"          => $ds->title,
//                "model"          => "post",
//                "model_id"       => $ds->id,
//                "status"         => 0,
//            ];
//
//            if (!MailLog::whereLabel('jcu25_display_poster')->whereModelId($ds->id)->first()) {
//                MailLog::create($payload);
//            }
//        }
//        return 'set';

        $oral = MailLog::where('label', 'jcu25_oral_presentation')
            ->whereStatus(0)
            ->whereEmailReceiver('vyvy1777@gmail.com')
            ->limit(1)
            ->get();

        foreach ($oral as $or){
            $data['user_name'] = $or->receiver_name;
            $data['title'] = $or->title;
            $data['category'] = $or->category;
            $data['email_subject'] = 'Oral Presentation Notification – Jogja Cardiology Update (JCU) 2025';
            $data['view'] = 'email.jcu25.oral_presentation';
            Mail::to($or['email_receiver'])->send(new SendDefaultMail($data));

            $or->update([
               'status' => 1
            ]);
        }

        $display = MailLog::where('label', 'jcu25_display_poster')
            ->whereStatus(0)
            ->whereEmailReceiver('vyvy1777@gmail.com')
            ->limit(1)
            ->get();

        foreach ($display as $or){
            $data['user_name'] = $or->receiver_name;
            $data['title'] = $or->title;
            $data['category'] = $or->category;
            $data['email_subject'] = 'Poster Presentation Notification – Jogja Cardiology Update (JCU) 2025';
            $data['view'] = 'email.jcu25.displayed_poster';
            Mail::to($or['email_receiver'])->send(new SendDefaultMail($data));

            $or->update([
               'status' => 1
            ]);
        }
    }
}

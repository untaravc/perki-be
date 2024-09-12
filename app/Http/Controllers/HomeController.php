<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Event;
use App\Models\GuestLog;
use App\Models\JobType;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function job_types()
    {
        $data = JobType::get();
        $this->sendGetResponse($data);
    }

    public function guest_log(Request $request)
    {
        if (!$request->perki_app_guest_token) {
            return '';
        }

        $visited = GuestLog::whereToken($request->perki_app_guest_token)
            ->whereDate('date', date('Y-m-d'))
            ->first();

        if ($visited) {
            $visited->update([
                "user_id" => $request->logged_user_id,
                "hits"    => $visited->hits + 1
            ]);
        } else {
            GuestLog::create([
                "token"   => $request->perki_app_guest_token,
                "user_id" => $request->logged_user_id,
                "date"    => date('Y-m-d'),
                "hits"    => 1
            ]);
        }

        return $this->response;
    }

    public function cta_event(Request $request)
    {
        if ($request->ref == 2024) {
            $data = [
                "title"    => "Join Our Webinar JCU",
                "subtitle" => "Free & Full Certificate",
                "image"    => "",
                "link"     => "",
            ];
        } else {
            $data = [
                "title"    => "Join Our Webinar Pre-JCU",
                "subtitle" => "Free & Full Certificate",
                "image"    => "",
                "link"     => "",
            ];
        }

        $this->response['result'] = $data;
        return $this->response;
    }

    public function events()
    {
        $data = [];
        //        $data[] = [
        //            "title"    => "Cardiogenic Shock: not only the Heart, We also Need to Protect the Kidney",
        //            "subtitle" => "August 12, 2023",
        //            "image"    => "/assets/posters/webinar_11ags23.jpg",
        //            "link"     => "https://bit.ly/PreJCU1",
        //        ];

        //        $data[] = [
        //            "title"    => "Update on atrial-septal defect related pulmonary artery hypertension fresh research from COHARD PH registry",
        //            "subtitle" => "August 19, 2023",
        //            "image"    => "/assets/posters/webinar_19ags23a.jpg",
        //            "link"     => "https://docs.google.com/forms/d/1c7fjjNYtY6srR1HBfRSyMXO4eyhlSpUUcfGU5QGHzmA/viewform?edit_requested=true",
        //        ];

        //        $data[] = [
        //            "title"    => "Tackling the Difficulty for Management of Uncontrolled Hypertension in Daily Practise: any Hope from Device Therapy",
        //            "subtitle" => "August 26, 2023",
        //            "image"    => "/assets/posters/webinar_26ags23.jpg",
        //            "link"     => "https://bit.ly/PreJCU2",
        //        ];


        $this->response['result'] = $data;
        return $this->response;
    }

    public function video_on_demand(Request $request)
    {
        //        $transaction_details = TransactionDetail::whereUserId($request->logged_user_id)
        //            ->whereEventId(1)
        //            ->first();
        //
        //        if (!$transaction_details) {
        //            $this->response['success'] = false;
        //            $this->response['message'] = "You are not registered as a symposium participant";
        //            return $this->response;
        //        }

        $event = Event::with(['schedules' => function ($q) {
            $q->with(['schedule_details' => function ($q2) {
                $q2->with('speaker');
            }]);
        }])
            ->select('id', 'title', 'record_link')
            ->find(1);

        $schedule = collect($event['schedules']);

        $data['day_1_a'] = $schedule->whereIn('id', [2, 4, 6, 8]);
        $data['day_1_b'] = $schedule->whereIn('id', [3, 5, 7, 9]);
        $data['day_2_a'] = $schedule->whereIn('id', [12, 14, 58, 60]);
        $data['day_2_b'] = $schedule->whereIn('id', [13, 15, 59, 64]);

        $this->response['result'] = $data;
        return $this->response;
    }
}

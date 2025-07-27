<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Event;
use App\Models\GuestLog;
use App\Models\JobType;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function job_types()
    {
        $data = JobType::whereStatus(1)
            ->orderBy('name')
            ->get();
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
        $event = Event::with(['schedules' => function ($q) {
            $q->with(['schedule_details' => function ($q2) {
                $q2->with('speaker');
            }]);
        }])
            ->select('id', 'title', 'record_link');

        if ($request->ref == 'jcu24') {
            $event = $event->find(111);
        } else {
            $event = $event->find(1);
        }

        $schedule = collect($event['schedules']);

        if ($request->ref === 'jcu24') {
            $data['day_1_a'] = $schedule->whereIn('id', [112, 114, 122, 130, 138, 148]);
            $data['day_1_b'] = $schedule->whereIn('id', [156, 164, 172, 246, 254]);
            $data['day_2_a'] = $schedule->whereIn('id', [113, 118, 126, 134, 142, 152,]);
            $data['day_2_b'] = $schedule->whereIn('id', [160, 168, 176, 250, 258,]);
        } else {
            $data['day_1_a'] = $schedule->whereIn('id', [2, 4, 6, 8]);
            $data['day_1_b'] = $schedule->whereIn('id', [3, 5, 7, 9]);
            $data['day_2_a'] = $schedule->whereIn('id', [12, 14, 58, 60]);
            $data['day_2_b'] = $schedule->whereIn('id', [13, 15, 59, 64]);
        }


        $this->response['result'] = $data;
        return $this->response;
    }

    public function posters(Request $request)
    {
        $data_content = Post::orderByDesc('status')
            ->orderByDesc('score')
            ->when($request->category, function ($q) use ($request) {
                $q->where('category', $request->category);
            })
            ->whereIn('status', [1, 3])
            ->with(['user', 'authors']);
        $data_content = $this->withPostFilter($data_content, $request);
        $data_content = $data_content->paginate($request->per_page ?? 24);

        $collect = collect($this->response);
        return $collect->merge($data_content);
    }

    public function withPostFilter($data_content, $request)
    {
        if ($request->title) {
            $data_content = $data_content->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->type == 'abstract') {
            $data_content = $data_content->whereIn('category', [
                'case_report',
                'research',
                'systematic_review',
                'meta_analysis',
            ])->orderByDesc('score');
        }

        if ($request->category) {
            $data_content = $data_content->where('category', $request->category);
        }

        if ($request->year) {
            $data_content = $data_content->whereYear('created_at', $request->year);
        }

        if ($request->status !== null) {
            $data_content = $data_content->where('status', $request->status);
        }

        return $data_content;
    }

    public function posterShow(Request $request, $id)
    {
        $poster = Post::with('authors')->find($id);

        if ($poster) {
            $poster->update(['comment' => $poster->comment + 1]);

            $this->response['result'] = $poster;
        }

        return $this->response;
    }
}

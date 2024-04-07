<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Event;
use App\Models\GuestLog;
use App\Models\JobType;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function job_types()
    {
        $data = JobType::get();
        $this->sendGetResponse($data);
    }

    public function hero_banner(Request $request)
    {
        $data = [
            [
                "title"    => "Jogja Cardiology Update",
                "subtitle" => "Integrating Technology In Cardiovascular Disease Management: Towards A Harmonic Fusion",
                "date"     => "Yogyakarta, 1-3 September 2023",
                "poster"   => '/assets/posters/1st_announ.png',
                "buttons"  => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ],
            [
                "title"    => "Call for Abstracts",
                "subtitle" => "For Cardiologist, Resident, GP, Medical Student, and Researcher",
                "date"     => "Submit before: August 7th 2023",
                "poster"   => '/assets/posters/extended_poster_7ags23.jpg',
                "buttons"  => [
                    [
                        "theme" => "dark",
                        "text"  => "Submit Now",
                        "link"  => "/abstracts",
                    ]
                ]
            ],
            [
                "title"    => "The Sixth JINCARTOS",
                "subtitle" => "Jogja International Cardiovascular Topic Series: Scientific Breakthrough in Hearth Rhythm Disorder",
                "date"     => "12 Symposium & 8 Workshop",
                "poster"   => '/assets/posters/1st_announ.png',
                "buttons"  => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ]
        ];

        //        return $request->ip();

        $this->response['result'] = $data;
        return $this->response;
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

    public function cta_event()
    {
        $data = [
            "title"    => "Join Our Webinar Pre-JCU",
            "subtitle" => "Free & Full Certificate",
            "image"    => "",
            "link"     => "",
        ];

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

    public function guidance()
    {
        $data = [];
        $data[] = [
            "title" => "Final Announcement",
            "image" => "https://src.perki-jogja.com/assets/posters/ANNOUNCMNT_JCU_2023_1.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/ANNOUNCMNT_JCU_2023_1.pdf",
        ];
        $data[] = [
            "title" => "Jincartos",
            "image" => "https://src.perki-jogja.com/assets/posters/JINCARTOS_1.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/JINCARTOS_1.pdf",
        ];
        $data[] = [
            "title" => "Symposium Day 1",
            "image" => "https://src.perki-jogja.com/assets/posters/SYMPO_DAY_1_1.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/SYMPO_DAY_1_1.pdf",
        ];
        $data[] = [
            "title" => "Symposium Day 2",
            "image" => "https://src.perki-jogja.com/assets/posters/SYMPO_DAY_2_1.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/SYMPO_DAY_2_1.pdf",
        ];

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

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Event;
use App\Models\GuestLog;
use App\Models\JobType;
use App\Models\Price;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function speakers(Request $request)
    {
        $data = User::where('is_speaker', 1)
            ->when($request->limit, function ($q) use ($request) {
                $q->limit($request->limit);
            })
            ->inRandomOrder()
            ->select('id', 'name', 'desc', 'image')
            ->get();

        $this->sendGetResponse($data);
    }

    public function job_types()
    {
        $data = JobType::get();
        $this->sendGetResponse($data);
    }

    public function schedule()
    {
        $events = Event::with(['schedule_details' => function ($q) {
            $q->with('speaker');
        }, 'schedules'])
            ->whereSection('jcu23')
            ->get();

        $saturday = [
            [
                'date_start' => $events->where('slug', 'symposium-jcu23-a1')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu23-a1')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu23-a1')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b2')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu23-a3')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu23-a3')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu23-a3')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b4')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu23-a5')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu23-a5')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu23-a5')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b6')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu23-a7')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu23-a7')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu23-a7')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b8')->first(),
            ],
        ];

        $sunday = [
            [
                'date_start' => $events->where('slug', 'symposium-jcu23-a9')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu23-a9')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu23-a9')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b10')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu23-a11')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu23-a11')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu23-a11')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b12')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu23-a13')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu23-a13')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu23-a13')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b14')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu23-a15')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu23-a15')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu23-a15')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b16')->first(),
            ],
        ];

        $workshop_half_day_1 = $events->where('marker', 'workshop-jcu23-half-day-1')->sortBy('name')->flatten();
        $workshop_half_day_2 = $events->where('marker', 'workshop-jcu23-half-day-2')->flatten();

        $this->response['result']['workshop_half_day_1'] = $workshop_half_day_1;
        $this->response['result']['workshop_half_day_2'] = $workshop_half_day_2;
        $this->response['result']['saturday'] = $saturday;
        $this->response['result']['sunday'] = $sunday;

        return $this->response;
    }

    public function pricing()
    {
        $platinum_desc = "<ul>
            <li>Morning Workshop: Friday, Sep 1st 2023 (08.00-11.30)</li>
            <li>Afternoon Workshop: Friday, Sep 1st 2023 (13.00-15.30)</li>
            <li>Symposium: Saturday, Sept 2nd 2023 (08.00-15.30) - Sunday, Sept 3rd 2023 (08.00-15.30)</li>
        </ul>";

        $gold_desc = "<ul>
            <li>Symposium: Saturday, Sept 2nd 2023 (08.00-15.30) - Sunday, Sept 3rd 2023 (08.00-15.30)</li>
        </ul>";

        $bronze_desc = "<ul>
            <li>Workshop: Friday, Sep 1st 2023 (08.00-11.30) or (13.00-15.30)</li>
        </ul>";

        $data["platinum"] = [
            "name"          => "Platinum",
            "desc"          => $platinum_desc,
            "price_drgn"    => 2250000,
            "price_drgn_eb" => 2000000,
            "price_drsp"    => 3250000,
            "price_drsp_eb" => 3000000,
        ];

        $data["gold"] = [
            "name"       => "Gold",
            "desc"       => $gold_desc,
            "price_drsp" => 1500000,
            "price_drgn" => 1000000,
            "price_stdn" => 500000,
        ];

        $data["bronze"] = [
            "name"          => "Add-On",
            "desc"          => $bronze_desc,
            "price_drgn"    => 750000,
            "price_drgn_eb" => 0,
            "price_drsp"    => 1000000,
            "price_drsp_eb" => 0,
        ];

        $this->response['result'] = $data;
        return $this->response;
    }

    public function sponsor_slider()
    {
        $sponsors = [
            ["image" => "abbott.png"],
            ["image" => "bayer.png"],
            ["image" => "biofarma.png"],
            ["image" => "biolitec.png"],
            ["image" => "biosensor.png"],
            ["image" => "bts.png"],
            ["image" => "feron.png"],
            ["image" => "idsmed.png"],
            ["image" => "indosopha.png"],
            ["image" => "kalbe.png"],
            ["image" => "merck.png"],
            ["image" => "msa.png"],
            ["image" => "novartis.png"],
            ["image" => "otsuka.png"],
            ["image" => "pfizer.png"],
            ["image" => "pharmasolindo.png"],
            ["image" => "philips.png"],
            ["image" => "rum.png"],
            ["image" => "sanofi.png"],
            ["image" => "servier.png"],
            ["image" => "tanabe.png"],
            ["image" => "zp.png"],
        ];

        for ($i = 0; $i < count($sponsors); $i++) {
            $sponsors[$i]['image'] = env('APP_URL') . 'assets/logo/sponsors/' . $sponsors[$i]['image'];
        }

        $this->response['result'] = $sponsors;
        return $this->response;
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

    public function committee()
    {
        $data = [];
        $data[] = [
            'title' => "Advisor",
            'users' => [
                ['user' => 'bambang.irawan'],
                ['user' => 'budi.yuli'],
//                ['user' => 'arjono'],
                ['user' => 'hariadi.hariawan'],
                ['user' => 'irsad.andi'],
            ],
        ];

        $data[] = [
            'title' => "Executive",
            'users' => [
                ['user' => 'anggoro.budi', 'position' => 'Chairperson'],
                ['user' => 'vita.yanti', 'position' => 'Vice chairperson'],
                ['user' => 'dyah.samti', 'position' => 'Secretary'],
                ['user' => 'lucia.kris', 'position' => 'Treasurer'],
                ['user' => 'hendry.purnasidha', 'position' => 'Sponsorship coordinator'],
            ]
        ];

        $names = [];

        $names[] = [
            'title' => "Scientific Section",
            'users' => [
                ['user' => 'fera.hidayati', 'position' => 'Coordinator'],
                ['user' => 'lucia.kris'],
                ['user' => 'nahar.taufiq'],
                ['user' => 'dyah.wulan'],
                ['user' => 'rizky.amalia'],
            ]
        ];

        $names[] = [
            'title' => "Program Section",
            'users' => [
                ['user' => 'hendry.purnasidha', 'position' => 'Coordinator'],
                ['user' => 'hasanah.mumpuni'],
                ['user' => 'erika.maharani'],
                ['user' => 'annisa.tridamayanti'],
            ]
        ];

        $names[] = [
            'title' => "Registration Section",
            'users' => [
                ['user' => 'royhan.rozqie', 'position' => 'Coordinator'],
                ['user' => 'inggita.hanung'],
            ]
        ];

        $names[] = [
            'title' => "Publication, Website and Documentation Section",
            'users' => [
                ['user' => 'taufik.ismail', 'position' => 'Coordinator'],
                ['user' => 'margono.gatot'],
                ['user' => 'firman.fauzan'],
            ]
        ];

        $names[] = [
            'title' => "Logistic and Consumption Section",
            'users' => [
                ['user' => 'real.kusumanjaya', 'position' => 'Coordinator'],
                ['user' => 'indah.paranita'],
                ['user' => 'evita.devi'],
                ['user' => 'dyah.adhi'],
            ]
        ];

        $names[] = [
            'title' => "Free Paper Section (Abstract, Oral Presentation and Proceeding)",
            'users' => [
                ['user' => 'gahan.satwiko', 'position' => 'Coordinator'],
                ['user' => 'dyah.samti'],
                ['user' => 'arditya.damarkusuma'],
                ['user' => 'firandi.saputra'],
                ['user' => 'dyah.adhi'],
            ]
        ];

        $names[] = [
            'title' => "Equipment, Exhibition, and Accommodation Section",
            'users' => [
                ['user' => 'putrika.prastuti', 'position' => 'Coordinator'],
                ['user' => 'wahyu.himawan'],
                ['user' => 'gagah.buana'],
            ]
        ];

        $names[] = [
            'title' => "The sixth JINCARTOS 2023",
            'users' => [
                ['user' => 'dyah.wulan', 'position' => 'Coordinator'],
                ['user' => 'royhan.rozqie'],
                ['user' => 'dyah.samti'],
            ]
        ];

        $names[] = [
            'title' => "Alumni Gathering",
            'users' => [
                ['user' => 'bagus.andi', 'position' => 'Coordinator'],
                ['user' => 'hari.yusti'],
            ]
        ];

//        $names[] = [
//            'title' => "Secretariat",
//            'users' => [
//                ['user' => 'latifah.wulan', 'position' => 'Coordinator'],
//                ['user' => 'aris.widaryanti'],
//                ['user' => 'ice.suciati'],
//                ['user' => 'beti.meitasari'],
//                ['user' => 'intan.rengganis'],
//            ]
//        ];

        $user = User::where('is_speaker', 1)
            ->select('image', 'name', 'slug', 'desc')
            ->get();

        for ($i = 0; $i < count($data); $i++) {
            for ($u = 0; $u < count($data[$i]['users']); $u++) {
                $selected = $user->where('slug', $data[$i]['users'][$u]['user'])->first();

                if ($selected) {
                    $data[$i]['users'][$u]['data'] = $selected;
                }
            }
        }

        for ($i = 0; $i < count($names); $i++) {
            for ($u = 0; $u < count($names[$i]['users']); $u++) {
                $selected = $user->where('slug', $names[$i]['users'][$u]['user'])->first();

                if ($selected) {
                    $names[$i]['users'][$u]['data'] = $selected;
                }
            }
        }

        $this->response['result']['photos'] = $data;
        $this->response['result']['name'] = $names;
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

        $data[] = [
            "title"    => "Update on atrial-septal defect related pulmonary artery hypertension fresh research from COHARD PH registry copy",
            "subtitle" => "August 19, 2023",
            "image"    => "/assets/posters/webinar_19ags23a.jpg",
            "link"     => "https://docs.google.com/forms/d/1c7fjjNYtY6srR1HBfRSyMXO4eyhlSpUUcfGU5QGHzmA/viewform?edit_requested=true",
        ];

        $data[] = [
            "title"    => "Tackling the Difficulty for Management of Uncontrolled Hypertension in Daily Practise: any Hope from Device Therapy",
            "subtitle" => "August 26, 2023",
            "image"    => "/assets/posters/webinar_26ags23.jpg",
            "link"     => "https://bit.ly/PreJCU2",
        ];


        $this->response['result'] = $data;
        return $this->response;
    }
}

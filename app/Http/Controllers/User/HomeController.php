<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Event;
use App\Models\JobType;
use App\Models\Price;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function speakers(Request $request)
    {
        $data = User::orderBy('name')
            ->where('is_speaker', 1)
            ->when($request->limit, function ($q) use ($request) {
                $q->limit($request->limit);
            })
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
        $events = Event::whereSection('jcu23')->get();

        $friday = [
            [
                'date_start' => '2023-09-01 09:10:00',
                'date_end'   => '2023-09-01 10:25:00',
                'room_a'     => $events->where('slug', 'symposium-jcu23-a1')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b2')->first(),
            ],
            [
                'date_start' => '2023-09-01 10:40:00',
                'date_end'   => '2023-09-01 11:55:00',
                'room_a'     => $events->where('slug', 'symposium-jcu23-a3')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b4')->first(),
            ],
            [
                'date_start' => '2023-09-01 13:00:00',
                'date_end'   => '2023-09-01 14:15:00',
                'room_a'     => $events->where('slug', 'symposium-jcu23-a5')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b6')->first(),
            ],
            [
                'date_start' => '2023-09-01 14:15:00',
                'date_end'   => '2023-09-01 15:30:00',
                'room_a'     => $events->where('slug', 'symposium-jcu23-a7')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b8')->first(),
            ],
        ];

        $saturday = [
            [
                'date_start' => '2023-09-02 08:00:00',
                'date_end'   => '2023-09-02 08:45:00',
                'room_a'     => $events->where('slug', 'symposium-jcu23-apanel1')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-bpanel2')->first(),
            ],
            [
                'date_start' => '2023-09-02 08:45:00',
                'date_end'   => '2023-09-02 10:00:00',
                'room_a'     => $events->where('slug', 'symposium-jcu23-a9')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b10')->first(),
            ],
            [
                'date_start' => '2023-09-02 10:15:00',
                'date_end'   => '2023-09-02 11:30:00',
                'room_a'     => $events->where('slug', 'symposium-jcu23-a11')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu23-b12')->first(),
            ],
        ];

        $workshop_half_day = $events->where('marker', 'workshop-jcu23-half-day')->flatten();
        $workshop_full_day = $events->where('marker', 'workshop-jcu23-full-day')->flatten();

        $this->response['result']['friday'] = $friday;
        $this->response['result']['saturday'] = $saturday;
        $this->response['result']['workshop_half_day'] = $workshop_half_day;
        $this->response['result']['workshop_full_day'] = $workshop_full_day;

        return $this->response;
    }

    public function pricing()
    {
        $platinum_desc = "<ul>
        <li>Symposium: Friday, Sept 1st 2023 (09.00-15.00) - Saturday, Sept 2nd 2023 (08.00-11.30)</li>
        <li>Saturday Workshop: Saturday, Sep 2nd 2023 (13.00-15.30)</li>
        <li>Sunday Workshop: Sunday, September 3rd 2023 (09.00-15.30)</li>
        </ul>";

        $gold_desc = "<ul>
        <li>Simposium: Friday, Sept 1st 2023 (09.00-15.00) - Saturday, Sept 2nd 2023 (08.00-11.30)</li>
        <li>Saturday Workshop: Saturday, Sept 2nd 2023 (13.00-15.30)</li>
        </ul>";

        $bronze_desc = "<ul>
        <li>Sunday Workshop: Sunday, Sept 3rd 2023 (09.00-15.30)</li>
        </ul>";

        $data["platinum"] = [
            "name"          => "Platinum",
            "desc"          => $platinum_desc,
            "price_drgn"    => 2000000,
            "price_drgn_eb" => 1750000,
            "price_drsp"    => 4000000,
            "price_drsp_eb" => 3750000,

        ];
        $data["gold"] = [
            "name"          => "Gold",
            "desc"          => $gold_desc,
            "price_drgn"    => 1750000,
            "price_drgn_eb" => 1500000,
            "price_drsp"    => 3000000,
            "price_drsp_eb" => 2750000,
        ];
        $data["bronze"] = [
            "name"          => "Bronze",
            "desc"          => $bronze_desc,
            "price_drgn"    => 750000,
            "price_drgn_eb" => 0,
            "price_drsp"    => 1250000,
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
                "poster"   => '/storage/img/1st_announcement.jpg',
            ],
            [
                "title"    => "12 Symposium & 8 Workshop",
                "subtitle" => "Jogja Cardiology Update in Conjunction with Jogja International Cardiovascular Topic Series",
                "date"     => "Tentrem Hotel, Yogyakarta",
                "poster"   => '/storage/img/1st_announcement.jpg',
            ], [
                "title"    => "The Sixth JINCARTOS",
                "subtitle" => "Jogja International Cardiovascular Topic Series: Scientific Breakthrough in Hearth Rhythm Disorder",
                "date"     => "12 Symposium & 8 Workshop",
                "poster"   => '/storage/img/1st_announcement.jpg',
            ]
        ];

//        return $request->ip();

        $this->response['result'] = $data;
        return $this->response;
    }
}

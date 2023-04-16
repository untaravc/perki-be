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
            ->when($request->limit, function ($q) use ($request){
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
        $data["ws_fd"] = [
            "name"          => "Full Day Workshop",
            "desc"          => "Dilaksanakan pada hari Minggu 3 September 2023, bertempat di Hotel Tentrem Yogyakarta. Mulai pukul 08.00 - 16.00 WIB",
            "price_drgn"    => 750000,
            "price_drgn_eb" => 0,
            "price_drsp"    => 1250000,
            "price_drsp_eb" => 0,
        ];
        $data["sympo_ws"] = [
            "name"          => "Symposium & Workshop",
            "desc"          => "Dilaksanakan pada hari Jumat hingga Sabtu, 1-2 September 2023, bertempat di Hotel Tentrem Yogyakarta.
                Simposium berlangsung di hari Jumat 09.00-16.00 WIB dan hari Sabtu 08.00-11.30 WIB.
                Workshop Half Day berlangsung pada  hari Sabtu pukul 13.00-16.00 WIB",
            "price_drgn"    => 1500000,
            "price_drgn_eb" => 1500000,
            "price_drsp"    => 3000000,
            "price_drsp_eb" => 2750000,
        ];
        $data["all_event"] = [
            "name"          => "All Event",
            "desc"          => "Dilaksanakan pada hari Jumat hingga Minggu, 1-3 September 2023, bertempat di Hotel Tentrem Yogyakarta.
                Simposium berlangsung di hari Jumat 09.00-16.00 WIB dan hari Sabtu 08.00-11.30 WIB.
                Workshop Half Day berlangsung pada hari Sabtu pukul 13.00-16.00 WIB.
                Workshop Full Day berlangsung pada hari Minggu 08.00-16.00 WIB",
            "price_drgn"    => 2000000,
            "price_drgn_eb" => 1750000,
            "price_drsp"    => 4000000,
            "price_drsp_eb" => 3750000,
        ];

        $this->response['result'] = $data;
        return $this->response;
    }
}

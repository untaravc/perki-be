<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function schedule(Request $request)
    {
        if($request->section === 'jcu25'){
            return $this->schedule2025();
        }
        if ($request->ref == 'jfu25') {
            return $this->scheduleJfu25();
        }if ($request->ref == 'carvep') {
            return $this->scheduleCarvep();
        }if ($request->ref == 2024) {
            return $this->schedule2024();
        } else {
            return $this->schedule2023();
        }
    }

    private function scheduleJfu25()
    {
        $events = Event::with(['schedule_details' => function ($q) {
            $q->with('speaker');
        }, 'schedules'])
            ->whereSection('jfu25')
            ->get();

        $thursday = [
            [
                'date_start' => $events->where('slug', 'symposium-jfu25-a1')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jfu25-a1')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jfu25-a1')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jfu25-a2')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jfu25-a2')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jfu25-a2')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jfu25-a3')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jfu25-a3')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jfu25-a3')->first(),
            ],
        ];

        $workshop = $events->where('marker', 'workshop-jfu25')->sortBy('name')->flatten();

        $this->response['result']['thursday'] = $thursday;
        $this->response['result']['workshop'] = $workshop;

        return $this->response;
    }
    private function scheduleCarvep()
    {
        $events = Event::with(['schedule_details' => function ($q) {
            $q->with('speaker');
        }, 'schedules'])
            ->whereSection('carvep')
            ->get();

        $saturday = [
            [
                'date_start' => $events->where('slug', 'symposium-carvep-a0')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-carvep-a0')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-carvep-a0')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-carvep-a1')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-carvep-a1')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-carvep-a1')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-carvep-a2')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-carvep-a2')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-carvep-a2')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-carvep-a3')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-carvep-a3')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-carvep-a3')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-carvep-a4')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-carvep-a4')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-carvep-a4')->first(),
            ],
        ];

        $workshop = $events->where('marker', 'workshop-carvep')->sortBy('name')->flatten();

        $this->response['result']['saturday'] = $saturday;
        $this->response['result']['workshop'] = $workshop;

        return $this->response;
    }

    private function schedule2024()
    {
        $events = Event::with(['schedule_details' => function ($q) {
            $q->with('speaker');
        }, 'schedules'])
            ->whereSection('jcu24')
            ->get();

        $saturday = [
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a0')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a0')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a0')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b0')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a1')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a1')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a1')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b2')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a3')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a3')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a3')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b4')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a5')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a5')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a5')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b6')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a7')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a7')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a7')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b8')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a9')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a9')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a9')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b10')->first(),
            ],
        ];

        $sunday = [
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a11')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a11')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a11')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b12')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a13')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a13')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a13')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b14')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a15')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a15')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a15')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b16')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a17')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a17')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a17')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b18')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'symposium-jcu24-a19')->first()['date_start'],
                'date_end'   => $events->where('slug', 'symposium-jcu24-a19')->first()['date_end'],
                'room_a'     => $events->where('slug', 'symposium-jcu24-a19')->first(),
                'room_b'     => $events->where('slug', 'symposium-jcu24-b20')->first(),
            ],
        ];

        $first_workshop = $events->where('marker', 'first-workshop-jcu24')->sortBy('name')->flatten();
        $second_workshop = $events->where('marker', 'second-workshop-jcu24')->flatten();

        $this->response['result']['workshop_half_day_1'] = $first_workshop;
        $this->response['result']['workshop_half_day_2'] = $second_workshop;
        $this->response['result']['saturday'] = $saturday;
        $this->response['result']['sunday'] = $sunday;

        return $this->response;
    }

    private function schedule2023()
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

    private function schedule2025()
    {
        $events = Event::with(['schedule_details' => function ($q) {
            $q->with('speaker');
        }, 'schedules'])
            ->whereSection('jcu25')
            ->get();

        $saturday = [
            [
                'date_start' => $events->where('slug', 'jcu25-sympo-d1-1a')->first()['date_start'],
                'date_end'   => $events->where('slug', 'jcu25-sympo-d1-1a')->first()['date_end'],
                'room_a'     => $events->where('slug', 'jcu25-sympo-d1-1a')->first(),
                'room_b'     => $events->where('slug', 'jcu25-sympo-d1-1b')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'jcu25-sympo-d1-2a')->first()['date_start'],
                'date_end'   => $events->where('slug', 'jcu25-sympo-d1-2a')->first()['date_end'],
                'room_a'     => $events->where('slug', 'jcu25-sympo-d1-2a')->first(),
                'room_b'     => $events->where('slug', 'jcu25-sympo-d1-2b')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'jcu25-sympo-d1-3a')->first()['date_start'],
                'date_end'   => $events->where('slug', 'jcu25-sympo-d1-3a')->first()['date_end'],
                'room_a'     => $events->where('slug', 'jcu25-sympo-d1-3a')->first(),
                'room_b'     => $events->where('slug', 'jcu25-sympo-d1-3b')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'jcu25-sympo-d1-4a')->first()['date_start'],
                'date_end'   => $events->where('slug', 'jcu25-sympo-d1-4a')->first()['date_end'],
                'room_a'     => $events->where('slug', 'jcu25-sympo-d1-4a')->first(),
                'room_b'     => $events->where('slug', 'jcu25-sympo-d1-4b')->first(),
            ],
        ];

        $sunday = [
            [
                'date_start' => $events->where('slug', 'jcu25-sympo-d2-1a')->first()['date_start'],
                'date_end'   => $events->where('slug', 'jcu25-sympo-d2-1a')->first()['date_end'],
                'room_a'     => $events->where('slug', 'jcu25-sympo-d2-1a')->first(),
                'room_b'     => $events->where('slug', 'jcu25-sympo-d2-1b')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'jcu25-sympo-d2-2a')->first()['date_start'],
                'date_end'   => $events->where('slug', 'jcu25-sympo-d2-2a')->first()['date_end'],
                'room_a'     => $events->where('slug', 'jcu25-sympo-d2-2a')->first(),
                'room_b'     => $events->where('slug', 'jcu25-sympo-d2-2b')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'jcu25-sympo-d2-3a')->first()['date_start'],
                'date_end'   => $events->where('slug', 'jcu25-sympo-d2-3a')->first()['date_end'],
                'room_a'     => $events->where('slug', 'jcu25-sympo-d2-3a')->first(),
                'room_b'     => $events->where('slug', 'jcu25-sympo-d2-3b')->first(),
            ],
            [
                'date_start' => $events->where('slug', 'jcu25-sympo-d2-4a')->first()['date_start'],
                'date_end'   => $events->where('slug', 'jcu25-sympo-d2-4a')->first()['date_end'],
                'room_a'     => $events->where('slug', 'jcu25-sympo-d2-4a')->first(),
                'room_b'     => $events->where('slug', 'jcu25-sympo-d2-4b')->first(),
            ],
        ];

        $workshops = $events->where('marker', 'jcu25-ws')->sortBy('name')->flatten();

        $this->response['result']['workshops'] = $workshops;
        $this->response['result']['saturday'] = $saturday;
        $this->response['result']['sunday'] = $sunday;

        return $this->response;
    }
}

<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class DataInitController extends Controller
{
    public function init()
    {
        return $this->events();
    }

    private function events()
    {
        $data = [
            [
                "event_name"       => "JCU 2023",
                "event_code"       => "JCU23",
                "event_parent_id"  => 0,
                "event_date_start" => "2023-09-01 08:00:00",
                "event_date_end"   => "2023-09-03 16:00:00",
                "event_has_price"  => 0,
                "children"         => [
                    [
                        "event_name"       => "Symposium",
                        "event_code"       => "",
                        "event_date_start" => "2023-09-01 08:00:00",
                        "event_date_end"   => "2023-09-03 16:00:00",
                        "event_has_price"  => 1,
                        "event_prices"     => [
                            [
                                "event_id"      => "",
                                "job_type_code" => "",
                                "price"         => "",
                            ]
                        ]
                    ]
                ],
            ]
        ];

        $this->insert_event($data);
    }

    private function insert_event($data, $parent_id = 0)
    {
        foreach ($data as $datum) {
            $event = Event::whereEventName($datum['event_name'])->first();
            if (!$event) {
                $datum['event_parent_id'] = $parent_id;
                $event = Event::create($datum);
            }

            if (isset($datum['children'])) {
                $this->insert_event($datum['children'], $event->id);
            }
        }
    }
}

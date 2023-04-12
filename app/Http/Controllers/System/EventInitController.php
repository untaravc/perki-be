<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventPrice;
use Illuminate\Http\Request;

class EventInitController extends Controller
{
    public function event_init()
    {
        $data = [
            [
                "name"       => "JCU 2023",
                "section"    => "jcu23",
                "data_type"  => "master",
                "parent_id"  => 0,
                "date_start" => "2023-09-01 08:00:00",
                "date_end"   => "2023-09-03 16:00:00",
                "has_price"  => 0,
                "children"   => [
                    [
                        "name"       => "Symposium",
                        "data_type"  => "product",
                        "section"    => "jcu23",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-03 16:00:00",
                        "has_price"  => 1,
                        "prices"     => [
                            [
                                "job_type_code" => "DRSP",
                                "price"         => 1000000,
                            ],
                            [
                                "job_type_code" => "DRGN",
                                "price"         => 700000,
                            ],
                        ],
                        "children"   => [
                            [
                                "name"       => "Morning Symposium",
                                "data_type"  => "schedule",
                                "title"      => "The titile of morning symposium",
                                "section"    => "jcu23",
                                "date_start" => "2023-09-01 08:00:00",
                                "date_end"   => "2023-09-01 09:00:00",
                                "speakers"   => "Budi Yuli S; Dyah Wulan A",
                            ],
                            [
                                "name"       => "Morning Symposium",
                                "data_type"  => "schedule",
                                "title"      => "The titile of morning symposium",
                                "section"    => "jcu23",
                                "date_start" => "2023-09-01 08:00:00",
                                "date_end"   => "2023-09-01 09:00:00",
                                "speakers"   => "Anggoro Budi; Fera Hidayati",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Workshop Full Day",
                        "data_type"  => "product",
                        "section"    => "jcu23",
                        "date_start" => "2023-09-02 08:00:00",
                        "date_end"   => "2023-09-02 16:00:00",
                        "speakers"   => "Hariadi Hariawan",
                        "has_price"  => 1,
                        "prices"     => [
                            [
                                "job_type_code" => "DRSP",
                                "price"         => 1000000,
                            ],
                            [
                                "job_type_code" => "DRGN",
                                "price"         => 700000,
                            ],
                        ],
                    ]
                ],
            ]
        ];

        return $this->insert_event($data);
    }

    public function insert_event($data, $parent_id = 0)
    {
        foreach ($data as $datum) {
            $event = Event::whereName($datum['name'])
                ->whereParentId($parent_id)
                ->first();

            if (!$event) {
                $datum['parent_id'] = $parent_id;
                $event = Event::create($datum);
            } else {
                $event->update($datum);
            }

            if (isset($datum['children'])) {
                $this->insert_event($datum['children'], $event->id);
            }

            if (isset($datum['prices'])) {
                foreach ($datum['prices'] as $price) {
                    $event_price = EventPrice::whereEventId($event->id)
                        ->whereJobTypeCode($price['job_type_code'])
                        ->first();

                    if ($event_price) {
                        $event_price->update($price);
                    } else {
                        EventPrice::create([
                            "event_id"      => $event->id,
                            "job_type_code" => $price['job_type_code'],
                            "price"         => $price['price'],
                        ]);
                    }
                }
            }
        }

        return 'done';
    }
}

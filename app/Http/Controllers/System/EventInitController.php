<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Price;
use Illuminate\Http\Request;

class EventInitController extends Controller
{
    public function event_init()
    {
        $data = [];

        return $this->insert_event($data);
    }

    private function symposium()
    {
        return [
            [
                "name"       => "Symposium",
                "data_type"  => "product",
                "section"    => "jcu23",
                "marker"     => "symposium-jcu23",
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
                        "name"       => "Symposium 1",
                        "data_type"  => "schedule",
                        "title"      => "The titile of morning symposium",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-channel-1",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 09:00:00",
                        "speakers"   => "Budi Yuli S; Dyah Wulan A",
                    ],
                    [
                        "name"       => "Symposium 2",
                        "data_type"  => "schedule",
                        "title"      => "The titile of morning symposium",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-channel-2",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 09:00:00",
                        "speakers"   => "Anggoro Budi; Fera Hidayati",
                    ]
                ]
            ],
        ];
    }

    private function workshop_full_day()
    {
        return [
            [
                "name"       => "Workshop 1",
                "data_type"  => "product",
                "section"    => "jcu23",
                "marker"     => "workshop-jcu23-half-day",
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
        ];
    }

    private function workshop_half_day()
    {
        return [
            [
                "name"       => "Workshop 5",
                "data_type"  => "product",
                "section"    => "jcu23",
                "marker"     => "workshop-jcu23-full-day",
                "date_start" => "2023-09-02 08:00:00",
                "date_end"   => "2023-09-02 16:00:00",
                "speakers"   => "Hariadi Hariawan",
                "has_price"  => 1,
                "prices"     => [
                    [
                        "job_type_code" => "DRSP",
                        "price"         => 1250000,
                    ],
                    [
                        "job_type_code" => "DRGN",
                        "price"         => 750000,
                    ],
                ],
            ]
        ];
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
                    $event_price = Price::whereEventId($event->id)
                        ->whereJobTypeCode($price['job_type_code'])
                        ->first();

                    if ($event_price) {
                        $event_price->update($price);
                    } else {
                        Price::create([
                            "model"         => 'event',
                            "model_id"      => $event->id,
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

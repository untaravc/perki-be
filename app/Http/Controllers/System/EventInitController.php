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
        $symposium = $this->symposium();
        $this->insert_event($symposium);

        $full_day = $this->workshop_full_day();
        $this->insert_event($full_day);

        $half_day = $this->workshop_half_day();
        $this->insert_event($half_day);
    }

    private function symposium()
    {
        return [
            [
                "name"       => "Symposium",
                "title"      => "Integrating Technology In Cardiovascular Disease Management: Towards A Harmonic Fusion",
                "data_type"  => "product",
                "section"    => "jcu23",
                "marker"     => "symposium-jcu23",
                "slug"       => "symposium-jcu23",
                "date_start" => "2023-09-01 07:00:00",
                "date_end"   => "2023-09-02 11:30:00",
                "has_price"  => 1,
                "prices"     => [
                    [
                        "job_type_code" => "DRSP",
                        "price"         => 2750000,
                    ],
                    [
                        "job_type_code" => "DRGN",
                        "price"         => 1500000,
                    ],
                ],
                "children"   => [
                    [
                        "name"       => "Symposium 1",
                        "title"      => "Beyond the Basics : Atherosclerosis and Antiplatelet Management",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a1",
                        "date_start" => "2023-09-01 09:10:00",
                        "date_end"   => "2023-09-01 10:25:00",
                    ],
                    [
                        "name"       => "Symposium 2",
                        "title"      => "Enhancing Outcomes in Heart Failure: Innovations in Diagnosis and Treatment",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b2",
                        "date_start" => "2023-09-01 09:10:00",
                        "date_end"   => "2023-09-01 10:25:00",
                    ],

                    [
                        "name"       => "Symposium 3",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a3",
                        "date_start" => "2023-09-01 10:40:00",
                        "date_end"   => "2023-09-01 11:55:00",
                    ],
                    [
                        "name"       => "Symposium 4",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b4",
                        "date_start" => "2023-09-01 10:40:00",
                        "date_end"   => "2023-09-01 11:55:00",
                    ],

                    [
                        "name"       => "Symposium 5",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a5",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 14:15:00",
                    ],
                    [
                        "name"       => "Symposium 6",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b6",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 14:15:00",
                    ],

                    [
                        "name"       => "Symposium 7",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a7",
                        "date_start" => "2023-09-01 14:15:00",
                        "date_end"   => "2023-09-01 15:30:00",
                    ],
                    [
                        "name"       => "Symposium 8",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b8",
                        "date_start" => "2023-09-01 14:15:00",
                        "date_end"   => "2023-09-01 15:30:00",
                    ],

                    [
                        "name"       => "Panel 1",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-apanel1",
                        "date_start" => "2023-09-02 08:00:00",
                        "date_end"   => "2023-09-02 08:45:00",
                    ],
                    [
                        "name"       => "Panel 2",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-bpanel2",
                        "date_start" => "2023-09-02 08:00:00",
                        "date_end"   => "2023-09-02 08:45:00",
                    ],

                    [
                        "name"       => "Symposium 9",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a9",
                        "date_start" => "2023-09-02 08:45:00",
                        "date_end"   => "2023-09-02 10:00:00",
                    ],
                    [
                        "name"       => "Symposium 10",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b10",
                        "date_start" => "2023-09-02 08:45:00",
                        "date_end"   => "2023-09-02 10:00:00",
                    ],

                    [
                        "name"       => "Symposium 11",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a11",
                        "date_start" => "2023-09-02 10:15:00",
                        "date_end"   => "2023-09-02 11:30:00",
                    ],
                    [
                        "name"       => "Symposium 12",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b12",
                        "date_start" => "2023-09-02 10:15:00",
                        "date_end"   => "2023-09-02 11:30:00",
                    ]
                ]
            ],
        ];
    }

    private function workshop_full_day()
    {
        return [
            [
                "name"       => "Workshop 5",
                "title"      => "Workshop 5 title sample",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-full-day-5",
                "marker"     => "workshop-jcu23-full-day",
                "date_start" => "2023-09-03 08:00:00",
                "date_end"   => "2023-09-03 14:30:00",
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
            ],
            [
                "name"       => "Workshop 6",
                "title"      => "Workshop 6 title sample",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-full-day-6",
                "marker"     => "workshop-jcu23-full-day",
                "date_start" => "2023-09-03 08:00:00",
                "date_end"   => "2023-09-03 14:30:00",
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
            ],
            [
                "name"       => "Workshop 7",
                "title"      => "Workshop 7 title sample",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-full-day-7",
                "marker"     => "workshop-jcu23-full-day",
                "date_start" => "2023-09-03 08:00:00",
                "date_end"   => "2023-09-03 14:30:00",
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
            ],
            [
                "name"       => "Workshop 8",
                "title"      => "Workshop 8 title sample",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-full-day-8",
                "marker"     => "workshop-jcu23-full-day",
                "date_start" => "2023-09-03 08:00:00",
                "date_end"   => "2023-09-03 14:30:00",
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

    private function workshop_half_day()
    {
        return [
            [
                "name"       => "Workshop 1",
                "title"      => "Workshop 1 title sample",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-1",
                "marker"     => "workshop-jcu23-half-day",
                "date_start" => "2023-09-02 13:00:00",
                "date_end"   => "2023-09-02 16:00:00",
            ],
            [
                "name"       => "Workshop 2",
                "title"      => "Workshop 2 title sample",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-2",
                "marker"     => "workshop-jcu23-half-day",
                "date_start" => "2023-09-02 13:00:00",
                "date_end"   => "2023-09-02 16:00:00",
            ],
            [
                "name"       => "Workshop 3",
                "title"      => "Workshop 3 title sample",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-3",
                "marker"     => "workshop-jcu23-half-day",
                "date_start" => "2023-09-02 13:00:00",
                "date_end"   => "2023-09-02 16:00:00",
            ],
            [
                "name"       => "Workshop 4",
                "title"      => "Workshop 4 title sample",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-4",
                "marker"     => "workshop-jcu23-half-day",
                "date_start" => "2023-09-02 13:00:00",
                "date_end"   => "2023-09-02 16:00:00",
            ],
        ];
    }

    public function insert_event($data, $parent_id = 0)
    {
        foreach ($data as $datum) {
            $event = Event::whereSlug($datum['slug'])
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
                    $event_price = Price::whereModel('event')
                        ->whereJobTypeCode($price['job_type_code'])
                        ->whereModelId($event->id)
                        ->first();

                    if ($event_price) {
                        $event_price->update($price);
                    } else {
                        Price::create([
                            "section"       => 'jcu23',
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

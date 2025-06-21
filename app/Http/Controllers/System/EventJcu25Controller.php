<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Price;
use Illuminate\Http\Request;

class EventJcu25Controller extends Controller
{
    public function event_init()
    {
        $symposium = $this->symposium();
        $this->insert_event($symposium);

        $first_workshop = $this->workshop();
        $this->insert_event($first_workshop);

        return 'event updated';
    }

    private function symposium()
    {
        return [
            [
                "name"       => "Symposium",
                "title"      => "The Future of Cardiovascular Emergency: Aligning Global Progress with Local Needs",
                "data_type"  => "product",
                "section"    => "jcu25",
                "quota"      => 400,
                "marker"     => "jcu25-sympo",
                "slug"       => "jcu25-sympo",
                "date_start" => "2025-08-02 08:00:00",
                "date_end"   => "2025-08-03 16:00:00",
                "has_price"  => 1,
                "prices"     => [
                    [
                        "job_type_code" => "DRSP",
                        "price"         => 2000000,
                    ],
                    [
                        "job_type_code" => "DRGN",
                        "price"         => 1000000,
                    ],
                    [
                        "job_type_code" => "MHSA",
                        "price"         => 800000,
                    ],
                ],
                "children"   => [
                    [
                        "name"       => "Plenary Lecture",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo1",
                        "slug"       => "jcu25-sympo1-1",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],
                ],
            ]
        ];
    }

    private function workshop()
    {
        $ws_price = [
            ["job_type_code" => "DRSP", "price" => 1500000],
            ["job_type_code" => "DRGN", "price" => 800000],
        ];

        return [
            [
                "name"       => "Workshop 1",
                "title"      => "CRRT in Cardiovascular Critical Care",
                "subtitle"   => "",
                "data_type"  => "product",
                "quota"      => 40,
                "section"    => "jcu25",
                "image"      => "",
                "marker"     => "jcu25-ws",
                "slug"       => "jcu25-ws-1",
                "date_start" => "2025-08-01 08:00:00",
                "date_end"   => "2025-08-01 11:00:00",
                "has_price"  => 1,
                "speakers"   => '',
                "prices"     => $ws_price,
                "children"   => [
//                    [
//                        "name"       => "Workshop 1 First Session",
//                        "title"      => "Diagnosis Criteria of  Rheumatic Heart Disease. What is New from Current Guidelines?",
//                        "data_type"  => "schedule",
//                        "section"    => "jcu25",
//                        "speakers"   => "",
//                        "marker"     => "first-workshop-jcu25-1",
//                        "slug"       => "first-workshop-jcu25-1-1",
//                        "date_start" => "2024-10-18 08:00:00",
//                        "date_end"   => "2024-10-18 11:00:00",
//                    ],
                ]
            ],
            [
                "name"       => "Workshop 2 INAPH",
                "title"      => "Navigating the Precipice: Mastering Emergencies in Pulmonary Hypertension",
                "subtitle"   => "",
                "data_type"  => "product",
                "quota"      => 40,
                "section"    => "jcu25",
                "image"      => "",
                "marker"     => "jcu25-ws",
                "slug"       => "jcu25-ws-2",
                "date_start" => "2025-08-01 08:00:00",
                "date_end"   => "2025-08-01 16:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => []
            ],
            [
                "name"       => "Workshop 3",
                "title"      => "Navigating Chronic Coronary Syndromes in 2025: From Optimal Medical Therapy to Precision DEB Angioplasty",
                "subtitle"   => "",
                "data_type"  => "product",
                "quota"      => 40,
                "section"    => "jcu25",
                "image"      => "",
                "marker"     => "jcu25-ws",
                "slug"       => "jcu25-ws-3",
                "date_start" => "2025-08-01 08:00:00",
                "date_end"   => "2025-08-01 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => []
            ],
            [
                "name"       => "Workshop 4",
                "title"      => "ECG Essentials for General Practitioner : Recognizing Common and Critical Arrhythmias",
                "subtitle"   => "",
                "data_type"  => "product",
                "quota"      => 40,
                "section"    => "jcu25",
                "image"      => "",
                "marker"     => "jcu25-ws",
                "slug"       => "jcu25-ws-4",
                "date_start" => "2025-08-01 13:00:00",
                "date_end"   => "2025-08-01 16:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => []
            ],
            [
                "name"       => "Workshop 5",
                "title"      => "A Practical Approach to Acute Coronary Syndrome Across the Care Continuum ",
                "subtitle"   => "",
                "data_type"  => "product",
                "quota"      => 40,
                "section"    => "jcu25",
                "image"      => "",
                "marker"     => "jcu25-ws",
                "slug"       => "jcu25-ws-5",
                "date_start" => "2025-08-01 08:00:00",
                "date_end"   => "2025-08-01 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => []
            ],
            [
                "name"       => "Workshop 6",
                "title"      => "Isthithaah-Based Hajj Preparation: Integrating Physical Fitness, Spiritual Readiness, and Functional Capacity Stress Testing",
                "subtitle"   => "",
                "data_type"  => "product",
                "quota"      => 40,
                "section"    => "jcu25",
                "image"      => "",
                "marker"     => "jcu25-ws",
                "slug"       => "jcu25-ws-6",
                "date_start" => "2025-08-01 13:00:00",
                "date_end"   => "2025-08-01 16:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => []
            ],
        ];
    }

    public function insert_event($data, $parent_id = 0)
    {
        foreach ($data as $datum) {
            $event = Event::whereSlug($datum['slug'])
                ->whereSection($datum['section'])
                ->whereParentId($parent_id)
                ->first();

            if (!$event) {
                $datum['parent_id'] = $parent_id;
                try {
                    $event = Event::create($datum);
                } catch (\Exception $exception) {
                    return $datum;
                }
            } else {
                try {
                    $event->update($datum);
                } catch (\Exception $exception) {
                    return $datum;
                }
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
                            "section"       => 'jcu25',
                            "model"         => 'event',
                            "model_id"      => $event->id,
                            "job_type_code" => $price['job_type_code'],
                            "price"         => $price['price'],
                        ]);
                    }
                }
            }
        }
    }
}

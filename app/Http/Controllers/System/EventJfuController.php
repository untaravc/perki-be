<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Price;
use Illuminate\Http\Request;

class EventJfuController extends Controller
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
                "title"      => "Multidisciplinary Team Collaboration for Managing Diabetic Foot Ulcer: From Wound Care To Endovascular Intervention",
                "data_type"  => "product",
                "section"    => "jfu25",
                "quota"      => 100,
                "marker"     => "symposium-jfu25",
                "slug"       => "symposium-jfu25",
                "date_start" => "2025-05-29 08:00:00",
                "date_end"   => "2025-05-29 15:00:00",
                "has_price"  => 1,
                "prices"     => [
                    [
                        "job_type_code" => "DRSP",
                        "price"         => 500000,
                    ],
                    [
                        "job_type_code" => "DRGN",
                        "price"         => 250000,
                    ],
                ],
                "children"   => [
                    [
                        "name"       => "Symposium 1",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jfu25",
                        "speakers"   => "billy.aditya",
                        "image"      => "",
                        "marker"     => "symposium-jfu25-a",
                        "slug"       => "symposium-jfu25-a1",
                        "date_start" => "2025-05-29 08:30:00",
                        "date_end"   => "2025-05-29 10:00:00",
                        "children"   => [
                            [
                                "name"       => "Session 1",
                                "title"      => "Early Detection and Prevention in Foot Ulcer",
                                "data_type"  => "schedule-detail",
                                "section"    => "jfu25",
                                "speakers"   => "hariadi.hariawan",
                                "marker"     => "symposium-jfu25-a1",
                                "slug"       => "symposium-jfu25-a1-1",
                                "date_start" => "2025-05-29 08:30:00",
                                "date_end"   => "2025-05-29 08:50:00",
                            ],
                            [
                                "name"       => "Session 2",
                                "title"      => "Metabolic Control In Managing Foot Ulcer",
                                "data_type"  => "schedule-detail",
                                "section"    => "jfu25",
                                "speakers"   => "hemi.sinorita",
                                "marker"     => "symposium-jfu25-a1",
                                "slug"       => "symposium-jfu25-a1-2",
                                "date_start" => "2025-05-29 08:50:00",
                                "date_end"   => "2025-05-29 09:10:00",
                            ],
                            [
                                "name"       => "Session 3",
                                "title"      => "Antibiotic Selection in Treatment Foot Ulcer",
                                "data_type"  => "schedule-detail",
                                "section"    => "jfu25",
                                "speakers"   => "rizka.humardewayanti",
                                "marker"     => "symposium-jfu25-a1",
                                "slug"       => "symposium-jfu25-a1-3",
                                "date_start" => "2025-05-29 09:10:00",
                                "date_end"   => "2025-05-29 09:30:00",
                            ],
                        ],
                    ],
                    [
                        "name"       => "Symposium 2",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jfu25",
                        "speakers"   => "gahan.satwiko",
                        "image"      => "",
                        "marker"     => "symposium-jfu25-a",
                        "slug"       => "symposium-jfu25-a2",
                        "date_start" => "2025-05-29 10:00:00",
                        "date_end"   => "2025-05-29 12:30:00",
                        "children"   => [
                            [
                                "name"       => "Session 1",
                                "title"      => "Endovascular Intervention in Managing Foot Ulcer",
                                "data_type"  => "schedule-detail",
                                "section"    => "jfu25",
                                "speakers"   => "taufik.ismail",
                                "marker"     => "symposium-jfu25-a2",
                                "slug"       => "symposium-jfu25-a2-1",
                                "date_start" => "2025-05-29 10:00:00",
                                "date_end"   => "2025-05-29 10:20:00",
                            ],
                            [
                                "name"       => "Session 2",
                                "title"      => "Bypass Arterial and Vein (DVA) Indication and Technique",
                                "data_type"  => "schedule-detail",
                                "section"    => "jfu25",
                                "speakers"   => "yunanto.kurnia",
                                "marker"     => "symposium-jfu25-a2",
                                "slug"       => "symposium-jfu25-a2-2",
                                "date_start" => "2025-05-29 10:20:00",
                                "date_end"   => "2025-05-29 10:40:00",
                            ],
                            [
                                "name"       => "Session 3",
                                "title"      => "VAC, Debridement & Amputation Indication in Foot Ulcer",
                                "data_type"  => "schedule-detail",
                                "section"    => "jfu25",
                                "speakers"   => "meirizal.hasan",
                                "marker"     => "symposium-jfu25-a2",
                                "slug"       => "symposium-jfu25-a2-3",
                                "date_start" => "2025-05-29 10:40:00",
                                "date_end"   => "2025-05-29 11:00:00",
                            ],
                            [
                                "name"       => "Session 4",
                                "title"      => "Current Daily Practice & Update in Wound Care Management",
                                "data_type"  => "schedule-detail",
                                "section"    => "jfu25",
                                "speakers"   => "christantie.effendy",
                                "marker"     => "symposium-jfu25-a2",
                                "slug"       => "symposium-jfu25-a2-4",
                                "date_start" => "2025-05-29 11:00:00",
                                "date_end"   => "2025-05-29 11:20:00",
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function workshop()
    {
        $ws_price = [
            ["job_type_code" => "DRSP", "price" => 3000000,],
            ["job_type_code" => "DRGN", "price" => 2000000,],
        ];

        return [
            [
                "name"       => "Workshop Advanced Doppler Ultrasound",
                "title"      => "",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "jfu25",
                "quota"      => "25",
                "image"      => "",
                "marker"     => "workshop-jfu25",
                "slug"       => "workshop-jfu25-1",
                "date_start" => "2025-05-30 08:00:00",
                "date_end"   => "2025-05-30 12:00:00",
                "children"   => [
                    [
                        "name"       => "Session 1",
                        "title"      => "Basic Ultrasound of Arterial System",
                        "data_type"  => "schedule",
                        "section"    => "jfu25",
                        "speakers"   => "billy.aditya",
                        "marker"     => "workshop-jfu25-1",
                        "slug"       => "workshop-jfu25-1-1",
                        "date_start" => "2025-05-30 08:00:00",
                        "date_end"   => "2025-05-30 08:30:00",
                    ],
                    [
                        "name"       => "Session 2",
                        "title"      => "Carotid, Renal & Upper and Lower Artery Ultrasound and Abnormalities",
                        "data_type"  => "schedule",
                        "section"    => "jfu25",
                        "speakers"   => "taufik.ismail",
                        "marker"     => "workshop-jfu25-1",
                        "slug"       => "workshop-jfu25-1-2",
                        "date_start" => "2025-05-30 08:30:00",
                        "date_end"   => "2025-05-30 09:30:00",
                    ],
                    [
                        "name"       => "Session 3",
                        "title"      => "Venous Disease: Chronic Vein Insufficiency & Deep Vein Thrombosis",
                        "data_type"  => "schedule",
                        "section"    => "jfu25",
                        "speakers"   => "hariadi.hariawan",
                        "marker"     => "workshop-jfu25-1",
                        "slug"       => "workshop-jfu25-1-3",
                        "date_start" => "2025-05-30 09:45:00",
                        "date_end"   => "2025-05-30 10:15:00",
                    ],
                    [
                        "name"       => "Session 4",
                        "title"      => "Hemodialysis AV Fistula: From Mapping to Evaluation",
                        "data_type"  => "schedule",
                        "section"    => "jfu25",
                        "speakers"   => "gahan.satwiko",
                        "marker"     => "workshop-jfu25-1",
                        "slug"       => "workshop-jfu25-1-4",
                        "date_start" => "2025-05-30 10:15:00",
                        "date_end"   => "2025-05-30 10:45:00",
                    ],
                    [
                        "name"       => "Session 5",
                        "title"      => "Technical Aspects in Transcranial Doppler",
                        "data_type"  => "schedule",
                        "section"    => "jfu25",
                        "speakers"   => "sofiawati",
                        "marker"     => "workshop-jfu25-1",
                        "slug"       => "workshop-jfu25-1-5",
                        "date_start" => "2025-05-30 10:45:00",
                        "date_end"   => "2025-05-30 11:15:00",
                    ],
                ],
                "has_price"  => 1,
                "prices"     => $ws_price,
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
                            "section"       => 'jfu25',
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

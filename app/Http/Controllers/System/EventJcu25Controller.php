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
                        "name"       => "Symposium I A",
                        "title"      => "A Guideline-Based Approach to Dyslipidemia",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d1",
                        "slug"       => "jcu25-sympo-d1-1a",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "Symposium I B",
                        "title"      => "Integrating Heart Failure Guidelines into General Practice",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d1",
                        "slug"       => "jcu25-sympo-d1-1b",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],

                    [
                        "name"       => "SYMPOSIUM II A",
                        "title"      => "Reframing Heart Failure Preserved EF from Mechanism to Current Therapy",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d1",
                        "slug"       => "jcu25-sympo-d1-2a",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "Symposium II B",
                        "title"      => "From Pathogenesis to Practice: Contemporary Management of Ventricular Tachycardia",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d1",
                        "slug"       => "jcu25-sympo-d1-2b",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM III A",
                        "title"      => "Update on Optimal Heart Failure Reduced Ejection Fraction Treatment",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d1",
                        "slug"       => "jcu25-sympo-d1-3a",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM III B",
                        "title"      => "Optimizing Outcomes in Advanced Heart Failure",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d1",
                        "slug"       => "jcu25-sympo-d1-3b",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM IV A",
                        "title"      => "A Continuing Challenge of Rheumatic Heart Disease in the Modern Era",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d1",
                        "slug"       => "jcu25-sympo-d1-4a",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM IV B",
                        "title"      => "Cardiovascular Emergency in Pregnancy",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d1",
                        "slug"       => "jcu25-sympo-d1-4b",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM V A",
                        "title"      => "Atherosclerosis and Its Progression to Acute Myocardial Infarction",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d1",
                        "slug"       => "jcu25-sympo-d1-5a",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM V B",
                        "title"      => "Identifying Emergencies in Peripheral Vascular Disease and Referral Pathways",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d1",
                        "slug"       => "jcu25-sympo-d1-5b",
                        "date_start" => "2025-08-02 08:00:00",
                        "date_end"   => "2025-08-02 08:45:00",
                        "children"   => []
                    ],

                    [
                        "name"       => "SYMPOSIUM I A",
                        "title"      => "Cardiogenic Shock: From Diagnosis to Advanced Management",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d2",
                        "slug"       => "jcu25-sympo-d2-1a",
                        "date_start" => "2025-08-03 08:00:00",
                        "date_end"   => "2025-08-03 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM I B",
                        "title"      => "Update on Diagnosis and Treatment of Pulmonary Artery Hypertension",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d2",
                        "slug"       => "jcu25-sympo-d2-1b",
                        "date_start" => "2025-08-03 08:00:00",
                        "date_end"   => "2025-08-03 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM II A",
                        "title"      => "Navigating Atrial Fibrillation in Acute Coronary Syndromes",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d2",
                        "slug"       => "jcu25-sympo-d2-2a",
                        "date_start" => "2025-08-03 08:00:00",
                        "date_end"   => "2025-08-03 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM II B",
                        "title"      => "Pulmonary Artery Hypertension in Specific Population",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d2",
                        "slug"       => "jcu25-sympo-d2-2b",
                        "date_start" => "2025-08-03 08:00:00",
                        "date_end"   => "2025-08-03 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM III A",
                        "title"      => "Emerging Therapies and Future Directions in Lipitension Management",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d2",
                        "slug"       => "jcu25-sympo-d2-3a",
                        "date_start" => "2025-08-03 08:00:00",
                        "date_end"   => "2025-08-03 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM III B",
                        "title"      => "Advancing the Fight Against Hypertension and Metabolic Syndrome",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d2",
                        "slug"       => "jcu25-sympo-d2-3b",
                        "date_start" => "2025-08-03 08:00:00",
                        "date_end"   => "2025-08-03 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM IV A",
                        "title"      => "Cardiovascular Imaging in Emergency",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d2",
                        "slug"       => "jcu25-sympo-d2-4a",
                        "date_start" => "2025-08-03 08:00:00",
                        "date_end"   => "2025-08-03 08:45:00",
                        "children"   => []
                    ],
                    [
                        "name"       => "SYMPOSIUM IV B",
                        "title"      => "Clinical Challenges in SVT and Atrial Fibrillation Management",
                        "data_type"  => "schedule",
                        "section"    => "jcu25",
                        "speakers"   => "",
                        "image"      => "",
                        "marker"     => "jcu25-sympo-d2",
                        "slug"       => "jcu25-sympo-d2-4b",
                        "date_start" => "2025-08-03 08:00:00",
                        "date_end"   => "2025-08-03 08:45:00",
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

        $acm_price = [
            ["job_type_code" => "DRSP", "price" => 1850000],
            ["job_type_code" => "DRGN", "price" => 1850000],
        ];

        return [
            [
                "name"       => "Workshop 1",
                "title"      => "Continuous Renal Replacement Therapy (CRRT) in Cardiovascular Critical Care",
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
                "name"       => "Workshop 2",
                "title"      => "Navigating the Precipice: Mastering Emergencies in Pulmonary Hypertension (INA-PH Workshop)",
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
                "title"      => "Navigating Chronic Coronary Syndromes in 2025: From Optimal Medical Therapy to Precision Drug-Eluting Balloon(DEB) Angioplasty",
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
                "title"      => "ECG Essentials for General Practitioner: Recognizing Common and Critical Arrhythmias",
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
                "title"      => "A Practical Approach to Acute Coronary Syndrome Across the Care Continuum",
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
            [
                "name"       => "Room Thursday",
                "title"      => "Hotel Tentrem Yogyakarta: Deluxe Room",
                "subtitle"   => "Special Price for JCU Participant : IDR 1.850.000/Days",
                "data_type"  => "product",
                "quota"      => 20,
                "section"    => "jcu25",
                "image"      => "",
                "marker"     => "jcu25-acm",
                "slug"       => "jcu25-acm-0",
                "date_start" => "2025-08-31 14:00:00",
                "date_end"   => "2025-08-01 12:00:00",
                "has_price"  => 1,
                "prices"     => $acm_price,
                "children"   => [],
                "body"       => "King Bed Size / Double Twin Bed Size, Minibar, Breakfast for 2 Person"
            ],
            [
                "name"       => "Room Friday",
                "title"      => "Hotel Tentrem Yogyakarta: Deluxe Room",
                "subtitle"   => "Special Price for JCU Participant : IDR 1.850.000/Days",
                "data_type"  => "product",
                "quota"      => 20,
                "section"    => "jcu25",
                "image"      => "",
                "marker"     => "jcu25-acm",
                "slug"       => "jcu25-acm-1",
                "date_start" => "2025-08-01 14:00:00",
                "date_end"   => "2025-08-02 12:00:00",
                "has_price"  => 1,
                "prices"     => $acm_price,
                "children"   => [],
                "body"       => "King Bed Size / Double Twin Bed Size, Minibar, Breakfast for 2 Person"
            ],
            [
                "name"       => "Room Saturday",
                "title"      => "Hotel Tentrem Yogyakarta: Deluxe Room",
                "subtitle"   => "Special Price for JCU Participant : IDR 1.850.000/Days",
                "data_type"  => "product",
                "quota"      => 20,
                "section"    => "jcu25",
                "image"      => "",
                "marker"     => "jcu25-acm",
                "slug"       => "jcu25-acm-2",
                "date_start" => "2025-08-02 14:00:00",
                "date_end"   => "2025-08-03 12:00:00",
                "has_price"  => 1,
                "prices"     => $acm_price,
                "children"   => [],
                "body"       => "King Bed Size / Double Twin Bed Size, Minibar, Breakfast for 2 Person"
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

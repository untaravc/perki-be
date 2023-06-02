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

        return 'event updated';
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
                "date_start" => "2023-09-02 08:00:00",
                "date_end"   => "2023-09-03 15:30:00",
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
                        "name"       => "Plenary Lecture I",
                        "title"      => "The Latest Updates in Cardiovascular Technology and Future of Cardiovascular Medicine",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-ab",
                        "slug"       => "symposium-jcu23-ab1",
                        "date_start" => "2023-09-02 08:30:00",
                        "date_end"   => "2023-09-02 08:50:00",
                    ],
                    [
                        "name"       => "Plenary Lecture II",
                        "title"      => "The Role of Wearable Technologies Aid Patient Monitoring and ArtficiaI Intelegent in Cardiovascular Disease",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-ab",
                        "slug"       => "symposium-jcu23-ab2",
                        "date_start" => "2023-09-02 08:50:00",
                        "date_end"   => "2023-09-02 09:10:00",
                    ],

                    [
                        "name"       => "Symposium 1",
                        "title"      => "Current Status and Future Prospect in Cardiac Pacing as Antibradyarrhythmia Therapy",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a1",
                        "date_start" => "2023-09-02 09:10:00",
                        "date_end"   => "2023-09-02 10:25:00",
                        'children'   => [
                            [
                                "name"       => "Symposium 1 First Session",
                                "title"      => "Evaluation and Management of Bradyarrhythmias : What do The Guideline Say?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-a1",
                                "slug"       => "symposium-jcu23-a1-1",
                                "date_start" => "2023-09-02 09:10:00",
                                "date_end"   => "2023-09-02 09:30:00",
                            ],
                            [
                                "name"       => "Symposium 1 Second Session",
                                "title"      => "Put Together the Puzzles : Is the Pacemaker Working Normally?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a1",
                                "slug"       => "symposium-jcu23-a1-2",
                                "date_start" => "2023-09-02 09:30:00",
                                "date_end"   => "2023-09-02 09:50:00",
                            ],
                            [
                                "name"       => "Symposium 1 Third Session",
                                "title"      => "Evidence Grows for Conduction System Pacing as an Alternative to Cardiac Resynchronization Therapy",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a1",
                                "slug"       => "symposium-jcu23-a1-3",
                                "date_start" => "2023-09-02 09:50:00",
                                "date_end"   => "2023-09-02 10:10:00",
                            ]
                        ],
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
                        "title"      => "Myocarditis and inflammatory cardiomyopathy: current evidence and future directions",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a3",
                        "date_start" => "2023-09-01 10:40:00",
                        "date_end"   => "2023-09-01 11:55:00",
                    ],
                    [
                        "name"       => "Symposium 4",
                        "title"      => "Unpacking the Complexities of Acute Coronary Syndrome and Cardiogenic Shock",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b4",
                        "date_start" => "2023-09-01 10:40:00",
                        "date_end"   => "2023-09-01 11:55:00",
                    ],

                    [
                        "name"       => "Panel 1",
                        "title"      => "Improving Outcomes in Right Heart Failure Treatment; Optimizing Diagnosis & Management of Clinically Myocarditis",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-apanel1",
                        "date_start" => "2023-09-02 08:00:00",
                        "date_end"   => "2023-09-02 08:45:00",
                    ],
                    [
                        "name"       => "Panel 2",
                        "title"      => "Mastering Rate Control Management in Arrhythmia Problem; Strategies for Early Detection & Treatment of Hypertension",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-bpanel2",
                        "date_start" => "2023-09-02 08:00:00",
                        "date_end"   => "2023-09-02 08:45:00",
                    ],

                    [
                        "name"       => "Symposium 5",
                        "title"      => "Current Status and Future Prospect in Cardiac Pacing as Antibradyarrhythmia Therapy",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a5",
                        "date_start" => "2023-09-02 08:45:00",
                        "date_end"   => "2023-09-02 10:15:00",
                    ],
                    [
                        "name"       => "Symposium 6",
                        "title"      => "Tailoring Management in Heart Failure Patients : Focus on Pharmacological therapy",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b6",
                        "date_start" => "2023-09-02 08:45:00",
                        "date_end"   => "2023-09-02 10:15:00",
                    ],

                    [
                        "name"       => "Symposium 7",
                        "title"      => "A Closer Look to New Guideline in Ventricular Arrhythmia",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a7",
                        "date_start" => "2023-09-02 10:15:00",
                        "date_end"   => "2023-09-02 11:30:00",
                    ],
                    [
                        "name"       => "Symposium 8",
                        "title"      => "Uniting Expertise : The Importance of Multidisciplinary Approach in Chronic Limb Threatening Ischemia",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b8",
                        "date_start" => "2023-09-02 10:15:00",
                        "date_end"   => "2023-09-02 11:30:00",
                    ],

                    [
                        "name"       => "Symposium 9",
                        "title"      => "The Current Landscape of Management in Cardiac Channelopathy & Infiltrative Cardiomyopathy",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a9",
                        "date_start" => "2023-09-02 13:00:00",
                        "date_end"   => "2023-09-02 14:15:00",
                    ],
                    [
                        "name"       => "Symposium 10",
                        "title"      => "Navigating the Complexities of Valvular Heart Disease : A Comprehensive Perspective",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b10",
                        "date_start" => "2023-09-02 13:00:00",
                        "date_end"   => "2023-09-02 14:15:00",
                    ],

                    [
                        "name"       => "Symposium 11",
                        "title"      => "Cutting Edge Concepts in Advanced Heart Failure",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a11",
                        "date_start" => "2023-09-02 14:15:00",
                        "date_end"   => "2023-09-02 15:30:00",
                    ],
                    [
                        "name"       => "Symposium 12",
                        "title"      => "Breaking Down Pulmonary Hypertension : From Etiology to Management Strategies",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b12",
                        "date_start" => "2023-09-02 14:15:00",
                        "date_end"   => "2023-09-02 15:30:00",
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
                "title"      => "OMG My Patient Got Metabolic Acidosis While in Ventilator !! Let's Talk About Acid Base Imbalance and Mechanical Ventilation in ICCU”",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-full-day-5",
                "marker"     => "workshop-jcu23-full-day",
                "date_start" => "2023-09-03 09:00:00",
                "date_end"   => "2023-09-03 15:30:00",
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
                "title"      => "Hands-on emergency Ultrasound Worskhop",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-full-day-6",
                "marker"     => "workshop-jcu23-full-day",
                "date_start" => "2023-09-03 09:00:00",
                "date_end"   => "2023-09-03 15:30:00",
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
                "title"      => "Maximizing Cardiovascular Health : A Comprehensive Approach to Outpatient Cardiac Rehabilitation Programs",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-full-day-7",
                "marker"     => "workshop-jcu23-full-day",
                "date_start" => "2023-09-03 09:00:00",
                "date_end"   => "2023-09-03 15:30:00",
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
                "title"      => "ECG Courses in Emergency Care",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-full-day-8",
                "marker"     => "workshop-jcu23-full-day",
                "date_start" => "2023-09-03 09:00:00",
                "date_end"   => "2023-09-03 15:30:00",
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
                "title"      => "Update Management of ACS in 2023: What’s New from the Guideline ?",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-1",
                "marker"     => "workshop-jcu23-half-day",
                "date_start" => "2023-09-01 13:00:00",
                "date_end"   => "2023-09-01 16:00:00",
            ],
            [
                "name"       => "Workshop 2",
                "title"      => "Emerging Trends in Atrial Fibrillation Management : From Stroke Prevention to Latest Method of Ablation",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-2",
                "marker"     => "workshop-jcu23-half-day",
                "date_start" => "2023-09-01 13:00:00",
                "date_end"   => "2023-09-01 16:00:00",
            ],
            [
                "name"       => "Workshop 3",
                "title"      => "Translating Transthoracal Echocardiography into Clinical Practice in Adult and Pediatric Congenital Heart Disease",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-3",
                "marker"     => "workshop-jcu23-half-day",
                "date_start" => "2023-09-01 13:00:00",
                "date_end"   => "2023-09-01 16:00:00",
            ],
            [
                "name"       => "Workshop 4",
                "title"      => "All about shock in Emergency Care",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-4",
                "marker"     => "workshop-jcu23-half-day",
                "date_start" => "2023-09-01 13:00:00",
                "date_end"   => "2023-09-01 16:00:00",
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

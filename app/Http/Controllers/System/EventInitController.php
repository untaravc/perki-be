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

        $full_day = $this->workshop_afternoon();
        $this->insert_event($full_day);

        $half_day = $this->workshop_morning();
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
                        "price"         => 1500000,
                    ],
                    [
                        "job_type_code" => "DRGN",
                        "price"         => 1000000,
                    ],
                    [
                        "job_type_code" => "MHSA",
                        "price"         => 500000,
                    ],
                ],
                "children"   => [
                    [
                        "name"       => "Plenary Lecture I",
                        "title"      => "The Latest Updates in Cardiovascular Technology and Future of Cardiovascular Medicine",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a0",
                        "date_start" => "2023-09-02 08:30:00",
                        "date_end"   => "2023-09-02 08:50:00",
                    ],
                    [
                        "name"       => "Plenary Lecture II",
                        "title"      => "The Role of Wearable Technologies Aid Patient Monitoring and ArtficiaI Intelegent in Cardiovascular Disease",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b0",
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
                        "title"      => "Tailoring Management in Heart Failure Patients : Focus on Pharmacological therapy",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b2",
                        "date_start" => "2023-09-01 09:10:00",
                        "date_end"   => "2023-09-01 10:25:00",
                        'children'   => [
                            [
                                "name"       => "Symposium 2 First Session",
                                "title"      => "The Role of Betablockers in Restoring Function in Failing Hearts",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-b2",
                                "slug"       => "symposium-jcu23-b2-1",
                                "date_start" => "2023-09-02 09:10:00",
                                "date_end"   => "2023-09-02 09:30:00",
                            ],
                            [
                                "name"       => "Symposium 2 Second Session",
                                "title"      => "SGLT-2 Inhibitor Era in HFrEF : From Context to Clinical Pearls",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b2",
                                "slug"       => "symposium-jcu23-b2-2",
                                "date_start" => "2023-09-02 09:30:00",
                                "date_end"   => "2023-09-02 09:50:00",
                            ],
                            [
                                "name"       => "Symposium 2 Third Session",
                                "title"      => "The Use of Rosuvastatin in Heart Failure Patients : Beyond Its Cholesterol-Lowering Impact",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b2",
                                "slug"       => "symposium-jcu23-b2-3",
                                "date_start" => "2023-09-02 09:50:00",
                                "date_end"   => "2023-09-02 10:10:00",
                            ]
                        ],
                    ],
                    [
                        "name"       => "Symposium 3",
                        "data_type"  => "schedule",
                        "title"      => "A Closer Look to New Guideline in Ventricular Arrhythmia",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a3",
                        "date_start" => "2023-09-01 10:40:00",
                        "date_end"   => "2023-09-01 11:55:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 3 First Session",
                                "title"      => "A New Horizon of Ventricular Arrhythmia & Sudden Cardiac Death : Etiology and Risk Stratification",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-a3",
                                "slug"       => "symposium-jcu23-a3-1",
                                "date_start" => "2023-09-02 10:40:00",
                                "date_end"   => "2023-09-02 11:00:00",
                            ],
                            [
                                "name"       => "Symposium 3 Second Session",
                                "title"      => "An Updated Strategy for the Management of Ventricular Arrhythmias: From Guideline to Clinical Practice",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a3",
                                "slug"       => "symposium-jcu23-a3-2",
                                "date_start" => "2023-09-02 11:00:00",
                                "date_end"   => "2023-09-02 11:20:00",
                            ],
                            [
                                "name"       => "Symposium 3 Third Session",
                                "title"      => "3D Catheter Ablation for Ventricular Arrhythmia : Where are we now?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a3",
                                "slug"       => "symposium-jcu23-a3-3",
                                "date_start" => "2023-09-02 11:20:00",
                                "date_end"   => "2023-09-02 11:40:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 4",
                        "title"      => "Beyond the Basics : Atherosclerosis and Antiplatelet Management",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b4",
                        "date_start" => "2023-09-01 10:40:00",
                        "date_end"   => "2023-09-01 11:55:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 4 First Session",
                                "title"      => "Understanding and preventing atherosclerosis: from bench to bedside",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-b4",
                                "slug"       => "symposium-jcu23-b4-1",
                                "date_start" => "2023-09-02 10:40:00",
                                "date_end"   => "2023-09-02 11:00:00",
                            ],
                            [
                                "name"       => "Symposium 4 Second Session",
                                "title"      => "Novel anti-platelet agents for Atherotrombotic Disease",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b4",
                                "slug"       => "symposium-jcu23-b4-2",
                                "date_start" => "2023-09-02 11:00:00",
                                "date_end"   => "2023-09-02 11:20:00",
                            ],
                            [
                                "name"       => "Symposium 4 Third Session",
                                "title"      => "Combining Anticoagulant and Antiplatelet Therapies for Chronic Atherosclerotic Disease",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b4",
                                "slug"       => "symposium-jcu23-b4-3",
                                "date_start" => "2023-09-02 11:20:00",
                                "date_end"   => "2023-09-02 11:40:00",

                            ]
                        ]
                    ],

                    [
                        "name"       => "Symposium 5",
                        "title"      => "The Current Landscape of Management in Cardiac Channelopathy & Infiltrative Cardiomyopathy",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a5",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 14:15:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 5 First Session",
                                "title"      => "Cardiac Channelopathies Disease  : Uncovered The Iceberg Phenomenon",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-a5",
                                "slug"       => "symposium-jcu23-a5-1",
                                "date_start" => "2023-09-02 13:00:00",
                                "date_end"   => "2023-09-02 13:20:00",
                            ],
                            [
                                "name"       => "Symposium 5 Second Session",
                                "title"      => "Multimodality Imaging for The Diagnosis of Infiltrative Cardiomyopathies",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a5",
                                "slug"       => "symposium-jcu23-a5-2",
                                "date_start" => "2023-09-02 13:20:00",
                                "date_end"   => "2023-09-02 13:40:00",
                            ],
                            [
                                "name"       => "Symposium 5 Third Session",
                                "title"      => "When to Put Implantable Cardioverter Defibrilator in Channelopathy & Infiltrative Cardiomyopathy?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a5",
                                "slug"       => "symposium-jcu23-a5-3",
                                "date_start" => "2023-09-02 13:40:00",
                                "date_end"   => "2023-09-02 14:00:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 6",
                        "title"      => "Navigating the Complexities of Valvular Heart Disease : A Comprehensive Perspective",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b6",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 14:15:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 6 First Session",
                                "title"      => "Pathophysiology and management of Rheumatic Heart disease",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-b6",
                                "slug"       => "symposium-jcu23-b6-1",
                                "date_start" => "2023-09-02 13:00:00",
                                "date_end"   => "2023-09-02 13:20:00",
                            ],
                            [
                                "name"       => "Symposium 6 Second Session",
                                "title"      => "Valvular heart disease: shifting the focus to the myocardium",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b6",
                                "slug"       => "symposium-jcu23-b6-2",
                                "date_start" => "2023-09-02 13:20:00",
                                "date_end"   => "2023-09-02 13:40:00",
                            ],
                            [
                                "name"       => "Symposium 6 Third Session",
                                "title"      => "Transcatheter vs Open Surgery in Valvular Heart Disease",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b6",
                                "slug"       => "symposium-jcu23-b6-3",
                                "date_start" => "2023-09-02 13:40:00",
                                "date_end"   => "2023-09-02 14:00:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 7",
                        "title"      => "Cutting Edge Concepts in Advanced Heart Failure",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a7",
                        "date_start" => "2023-09-01 14:15:00",
                        "date_end"   => "2023-09-01 16:00:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 7 First Session",
                                "title"      => "Beyond the clinical aspect of heart failure: Take a look at the social determinant of health",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-a7",
                                "slug"       => "symposium-jcu23-a7-1",
                                "date_start" => "2023-09-02 14:15:00",
                                "date_end"   => "2023-09-02 14:35:00",
                            ],
                            [
                                "name"       => "Symposium 7 Second Session",
                                "title"      => "The Role of Salcubitril-Valsartan in the treatment of HFREF",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a7",
                                "slug"       => "symposium-jcu23-a7-2",
                                "date_start" => "2023-09-02 14:35:00",
                                "date_end"   => "2023-09-02 14:55:00",
                            ],
                            [
                                "name"       => "Symposium 7 Third Session",
                                "title"      => "Device options for the treatment of heart failure: what to know and when to refer",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a7",
                                "slug"       => "symposium-jcu23-a7-3",
                                "date_start" => "2023-09-02 14:55:00",
                                "date_end"   => "2023-09-02 15:15:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 8",
                        "title"      => "Unpacking the Complexities of Acute Coronary Syndrome and Cardiogenic Shock",
                        "section"    => "jcu23",
                        "data_type"  => "schedule",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b8",
                        "date_start" => "2023-09-01 14:15:00",
                        "date_end"   => "2023-09-01 16:00:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 8 First Session",
                                "title"      => "New Insights in Pathophysiology and Classification of Cardiogenic Shock",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-b8",
                                "slug"       => "symposium-jcu23-b8-1",
                                "date_start" => "2023-09-02 14:15:00",
                                "date_end"   => "2023-09-02 14:35:00",
                            ],
                            [
                                "name"       => "Symposium 8 Second Session",
                                "title"      => "From ACS to Cardiogenic Shock: What the guideline can tell us (High bleeding risk)",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b8",
                                "slug"       => "symposium-jcu23-b8-2",
                                "date_start" => "2023-09-02 14:35:00",
                                "date_end"   => "2023-09-02 14:55:00",
                            ],
                            [
                                "name"       => "Symposium 8 Third Session",
                                "title"      => "Managing patients with cardiogenic shock and acute kidney injury: Focus on continuous renal replacement therapy (CRRT)",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b8",
                                "slug"       => "symposium-jcu23-b8-3",
                                "date_start" => "2023-09-02 14:55:00",
                                "date_end"   => "2023-09-02 15:15:00",
                            ]
                        ]
                    ],
                    [

                        "name"       => "Panel 1",
                        "title"      => "Improving Outcomes in Right Heart Failure Treatment; Optimizing Diagnosis & Management of Clinically Myocarditis",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-apanel1",
                        "date_start" => "2023-09-03 08:00:00",
                        "date_end"   => "2023-09-03 08:45:00",
                    ],
                    [
                        "name"       => "Panel 2",
                        "title"      => "Mastering Rate Control Management in Arrhythmia Problem; Strategies for Early Detection & Treatment of Hypertension",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-bpanel2",
                        "date_start" => "2023-09-03 08:00:00",
                        "date_end"   => "2023-09-03 08:45:00",
                    ],

                    [
                        "name"       => "Symposium 9",
                        "title"      => "Strategies for Early Detection & Treatment of Hypertension",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a9",
                        "date_start" => "2023-09-03 08:45:00",
                        "date_end"   => "2023-09-03 10:00:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 9 First Session",
                                "title"      => "New Insights in Pathophysiology and Classification of Cardiogenic Shock",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-a9",
                                "slug"       => "symposium-jcu23-a9-1",
                                "date_start" => "2023-09-03 08:45:00",
                                "date_end"   => "2023-09-03 09:05:00",
                            ],
                            [
                                "name"       => "Symposium 9 Second Session",
                                "title"      => "Overview of new cellular and structural alteration in pathophysiology of Hypertension Mediated Organ Damage",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a9",
                                "slug"       => "symposium-jcu23-a9-2",
                                "date_start" => "2023-09-03 09:05:00",
                                "date_end"   => "2023-09-03 09:25:00",
                            ],
                            [
                                "name"       => "Symposium 9 Third Session",
                                "title"      => "Role of ABPM and HBPM in Management of Hypertension",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a9",
                                "slug"       => "symposium-jcu23-a9-3",
                                "date_start" => "2023-09-03 09:25:00",
                                "date_end"   => "2023-09-03 09:45:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 10",
                        "title"      => "Enhancing Outcomes in Heart Failure  : Innovations in Diagnosis and Treatment",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b10",
                        "date_start" => "2023-09-03 08:45:00",
                        "date_end"   => "2023-09-03 10:00:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 10 First Session",
                                "title"      => "Chronic heart failure : New challenges and new perspectives",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-b10",
                                "slug"       => "symposium-jcu23-b10-1",
                                "date_start" => "2023-09-03 08:45:00",
                                "date_end"   => "2023-09-03 09:05:00",
                            ],
                            [
                                "name"       => "Symposium 10 Second Session",
                                "title"      => "The four pillars of HFrEF therapy: is it time to treat heart failure regardless of ejection fraction?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b10",
                                "slug"       => "symposium-jcu23-b10-2",
                                "date_start" => "2023-09-03 09:05:00",
                                "date_end"   => "2023-09-03 09:25:00",
                            ],
                            [
                                "name"       => "Symposium 10 Third Session",
                                "title"      => "The HFpEF diagnostic algorithm's usefulness in clinical practice",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b10",
                                "slug"       => "symposium-jcu23-b10-3",
                                "date_start" => "2023-09-03 09:25:00",
                                "date_end"   => "2023-09-03 09:45:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 11",
                        "title"      => "Focused update on antiplatelet therapy in CVD",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a11",
                        "date_start" => "2023-09-03 10:15:00",
                        "date_end"   => "2023-09-03 11:30:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 11 First Session",
                                "title"      => "Platelet Activation Pathway to Guide Antiplatelet Therapy",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-a11",
                                "slug"       => "symposium-jcu23-a11-1",
                                "date_start" => "2023-09-03 10:15:00",
                                "date_end"   => "2023-09-03 10:35:00",
                            ],
                            [
                                "name"       => "Symposium 11 Second Session",
                                "title"      => "The Role of Antithrombotic in ACS : When to Use High Potent Antiplatelet?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a11",
                                "slug"       => "symposium-jcu23-a11-2",
                                "date_start" => "2023-09-03 10:35:00",
                                "date_end"   => "2023-09-03 10:55:00",
                            ],
                            [
                                "name"       => "Symposium 11 Third Session",
                                "title"      => "Peri-operative Management of Antiplatelet Therapy in Non Cardiac Surgery",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a11",
                                "slug"       => "symposium-jcu23-a11-3",
                                "date_start" => "2023-09-03 10:55:00",
                                "date_end"   => "2023-09-03 11:15:00",
                            ]
                        ]

                    ],
                    [
                        "name"       => "Symposium 12",
                        "title"      => "Breaking Down Pulmonary Hypertension : From Etiology to Management Strategies",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b12",
                        "date_start" => "2023-09-03 10:15:00",
                        "date_end"   => "2023-09-03 11:30:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 12 First Session",
                                "title"      => "Unravel multimodal tools for diagnosing pulmonary hypertension",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-b12",
                                "slug"       => "symposium-jcu23-b12-1",
                                "date_start" => "2023-09-03 10:15:00",
                                "date_end"   => "2023-09-03 10:35:00",
                            ],
                            [
                                "name"       => "Symposium 12 Second Session",
                                "title"      => "Tackling emergency state in pulmonary hypertension",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b12",
                                "slug"       => "symposium-jcu23-b12-2",
                                "date_start" => "2023-09-03 10:35:00",
                                "date_end"   => "2023-09-03 10:55:00",
                            ],
                            [
                                "name"       => "Symposium 12 Third Session",
                                "title"      => "Managing pulmonary hypertension in high risk population",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b12",
                                "slug"       => "symposium-jcu23-b12-3",
                                "date_start" => "2023-09-03 10:55:00",
                                "date_end"   => "2023-09-03 11:15:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 13",
                        "title"      => "Concurrent Diabetes and Heart Failure: The Interplay and Novel Therapeutic Approaches",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a13",
                        "date_start" => "2023-09-03 13:00:00",
                        "date_end"   => "2023-09-03 14:15:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 13 First Session",
                                "title"      => "Biomarker profiles and pathophysiological pathways in patients with chronic heart failure and metabolic syndrome",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-a13",
                                "slug"       => "symposium-jcu23-a13-1",
                                "date_start" => "2023-09-03 13:00:00",
                                "date_end"   => "2023-09-03 13:20:00",
                            ],
                            [
                                "name"       => "Symposium 13 Second Session",
                                "title"      => "Timing of initiation of sodium-glucose co-transporter 2 inhibitor and Management of Blood Glucose in patients with diabetes and chronic heart failure",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a13",
                                "slug"       => "symposium-jcu23-a13-2",
                                "date_start" => "2023-09-03 13:20:00",
                                "date_end"   => "2023-09-03 13:40:00",
                            ],
                            [
                                "name"       => "Symposium 13 Third Session",
                                "title"      => "Diabetic cardiomyopathy in heart failure: a new target for therapy",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a13",
                                "slug"       => "symposium-jcu23-a13-3",
                                "date_start" => "2023-09-03 13:40:00",
                                "date_end"   => "2023-09-03 14:00:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 14",
                        "title"      => "The Multifaceted Management of Chronic Coronary Syndrome : Understanding the Basics and Beyond",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b14",
                        "date_start" => "2023-09-03 13:00:00",
                        "date_end"   => "2023-09-03 14:15:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 14 First Session",
                                "title"      => "Biomarker profiles and pathophysiological pathways in patients with chronic heart failure and metabolic syndrome",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-b14",
                                "slug"       => "symposium-jcu23-b14-1",
                                "date_start" => "2023-09-03 13:00:00",
                                "date_end"   => "2023-09-03 13:20:00",
                            ],
                            [
                                "name"       => "Symposium 14 Second Session",
                                "title"      => "Timing of initiation of sodium-glucose co-transporter 2 inhibitor and Management of Blood Glucose in patients with diabetes and chronic heart failure",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b14",
                                "slug"       => "symposium-jcu23-b14-2",
                                "date_start" => "2023-09-03 13:20:00",
                                "date_end"   => "2023-09-03 13:40:00",
                            ],
                            [
                                "name"       => "Symposium 14 Third Session",
                                "title"      => "Diabetic cardiomyopathy in heart failure: a new target for therapy",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b14",
                                "slug"       => "symposium-jcu23-b14-3",
                                "date_start" => "2023-09-03 13:40:00",
                                "date_end"   => "2023-09-03 14:00:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 15",
                        "title"      => "Uniting Expertise : The Importance of Multidisciplinary Approach in Chronic Limb Threatening Ischemia",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a15",
                        "date_start" => "2023-09-03 14:15:00",
                        "date_end"   => "2023-09-03 15:30:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 15 First Session",
                                "title"      => "The A to Z of CLTI : All party involved",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-a15",
                                "slug"       => "symposium-jcu23-a15-1",
                                "date_start" => "2023-09-03 14:15:00",
                                "date_end"   => "2023-09-03 14:35:00",
                            ],
                            [
                                "name"       => "Symposium 15 Second Session",
                                "title"      => "Diagnostic Approach to Accurate Treatment of CLTI : Updates on Current guidelines",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a15",
                                "slug"       => "symposium-jcu23-a15-2",
                                "date_start" => "2023-09-03 14:35:00",
                                "date_end"   => "2023-09-03 14:55:00",
                            ],
                            [
                                "name"       => "Symposium 15 Third Session",
                                "title"      => "Reviewing illness perception and risk factor management in patient with CLTI : Knowledge gap and framework for future studies",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-a15",
                                "slug"       => "symposium-jcu23-a15-3",
                                "date_start" => "2023-09-03 14:55:00",
                                "date_end"   => "2023-09-03 15:15:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 16",
                        "title"      => "Myocarditis and inflammatory cardiomyopathy: current evidence and future directions",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b16",
                        "date_start" => "2023-09-03 14:15:00",
                        "date_end"   => "2023-09-03 15:30:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 16 First Session",
                                "title"      => "Pathophysiology and Management of Acute Myocarditis and Chronic Inflammatory Cardiomyopathy: An Expert Consensus Document",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu23-b16",
                                "slug"       => "symposium-jcu23-b16-1",
                                "date_start" => "2023-09-03 14:15:00",
                                "date_end"   => "2023-09-03 14:35:00",
                            ],
                            [
                                "name"       => "Symposium 16 Second Session",
                                "title"      => "Cardiac Imaging in Myocarditis : new Insights and Future Directions (hstroponin)",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b16",
                                "slug"       => "symposium-jcu23-b16-2",
                                "date_start" => "2023-09-03 14:35:00",
                                "date_end"   => "2023-09-03 14:55:00",
                            ],
                            [
                                "name"       => "Symposium 16 Third Session",
                                "title"      => "Novel Non invasive Nuclear Medicine Imaging Techniques for Cardiac Inflammation",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "marker"     => "symposium-jcu23-b16",
                                "slug"       => "symposium-jcu23-b16-3",
                                "date_start" => "2023-09-03 14:55:00",
                                "date_end"   => "2023-09-03 15:15:00",
                            ]
                        ]
                    ],
                ],
            ],
        ];
    }

    private function workshop_afternoon()
    {
        $ws_price = [
            ["job_type_code" => "DRSP", "price" => 1000000,],
            ["job_type_code" => "DRGN", "price" => 750000,],
            ["job_type_code" => "MHSA", "price" => 750000,],
        ];

        return [
            [
                "name"       => "Workshop 5",
                "title"      => "Hey, your patient is in acidosis! Don’t you realize it? Take this workshop and I will help you!",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-5",
                "marker"     => "workshop-jcu23-half-day-2",
                "date_start" => "2023-09-01 13:00:00",
                "date_end"   => "2023-09-01 16:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop 5 First Session",
                        "title"      => "Interpretation of blood gas analysis in ICCU : finally I recognize you acidosis !",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-5",
                        "slug"       => "workshop-half-day-5-1",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 5 Second Session",
                        "title"      => "Effect of acidosis on hemodynamics and the cardiovascular system and what are the causes ?",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-5",
                        "slug"       => "workshop-half-day-5-2",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 5 Third Session",
                        "title"      => "How to deal with acidosis in ICCU : When do we correct and the role of mechanical ventilation?",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-5",
                        "slug"       => "workshop-half-day-5-3",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ]
                ],
                "has_price"  => 1,
                "prices"     => $ws_price,
            ],
            [
                "name"       => "Workshop 6",
                "title"      => "Hands-on emergency Ultrasound Worskhop",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-6",
                "marker"     => "workshop-jcu23-half-day-2",
                "date_start" => "2023-09-01 13:00:00",
                "date_end"   => "2023-09-01 16:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop 6 First Session",
                        "title"      => "Acute Heart Failure vs Pneumonia : Can ultrasound help us to differentiate?",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-6",
                        "slug"       => "workshop-half-day-6-1",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 6 Second Session",
                        "title"      => "Quick Assesment of Left and Right Ventricular Function and Bedside Hemodynamic Echo in Emergency Setting",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-6",
                        "slug"       => "workshop-half-day-6-2",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 6 Third Session",
                        "title"      => "Vascular Ultrasound in Vascular thrombosis and Aortic Dissection : the earlier the better",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-6",
                        "slug"       => "workshop-half-day-6-3",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ]
                ],
                "has_price"  => 1,
                "prices"     => $ws_price,
            ],
            [
                "name"       => "Workshop 7",
                "title"      => "Excercise Stress Test: How to Session",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-7",
                "marker"     => "workshop-jcu23-half-day-2",
                "date_start" => "2023-09-01 13:00:00",
                "date_end"   => "2023-09-01 16:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop 7 First Session",
                        "title"      => "Coming-back to Life After Cardiac Event : A Comprehensive Approach",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-7",
                        "slug"       => "workshop-half-day-7-1",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 7 Second Session",
                        "title"      => "Exercise Stress Test: Right Modality for the Right Person",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-7",
                        "slug"       => "workshop-half-day-7-2",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 7 Third Session",
                        "title"      => "Treadmill Test: Form A to Z How to Session",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-7",
                        "slug"       => "workshop-half-day-7-3",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ]
                ],
                "has_price"  => 1,
                "prices"     => $ws_price,
            ],
            [
                "name"       => "Workshop 8",
                "title"      => "Emerging Trends in Atrial Fibrillation Management : From Stroke Prevention to Latest Method of Ablation",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-8",
                "marker"     => "workshop-jcu23-half-day-2",
                "date_start" => "2023-09-01 13:00:00",
                "date_end"   => "2023-09-01 16:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop 8 First Session",
                        "title"      => "Atrial Fibrillation Management : From Drug, Ablation, to Devices",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-8",
                        "slug"       => "workshop-half-day-8-1",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 8 Second Session",
                        "title"      => "Effectiveness and Safety of Direct Anticoagulation Therapy in Frail Patients with Atrial Fibrillation",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-8",
                        "slug"       => "workshop-half-day-8-2",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 8 Third Session",
                        "title"      => "DOAC: When to Stop or to Re-start ?",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-8",
                        "slug"       => "workshop-half-day-8-3",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ]
                ],
                "has_price"  => 1,
                "prices"     => $ws_price,
            ]
        ];
    }

    private function workshop_morning()
    {
        $ws_price = [
            ["job_type_code" => "DRSP", "price" => 1000000,],
            ["job_type_code" => "DRGN", "price" => 750000,],
            ["job_type_code" => "MHSA", "price" => 750000,],
        ];

        return [
            [
                "name"       => "Workshop 1",
                "title"      => "Update Management of ACS in 2023: What’s New from the Guideline ?",
                "subtitle"   => "Acute Coronary Syndrome",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-1",
                "marker"     => "workshop-jcu23-half-day-1",
                "date_start" => "2023-09-01 08:00:00",
                "date_end"   => "2023-09-01 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => [
                    [
                        "name"       => "Workshop 1 First Session",
                        "title"      => "Management ACS Patient ind Daily Practice : When we should Send the Patient to CL?",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "nahar.taufiq",
                        "marker"     => "workshop-half-day-1",
                        "slug"       => "workshop-half-day-1-1",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 1 Second Session",
                        "title"      => "Drug intervention in Managing ACS Patient : From ER to Discharge Planning",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-1",
                        "slug"       => "workshop-half-day-1-2",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 1 Third Session",
                        "title"      => "Does ACS Patient Have Better Outcome with earlier Statin Intervention?",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-1",
                        "slug"       => "workshop-half-day-1-3",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ]
                ]
            ],
            [
                "name"       => "Workshop 2",
                "title"      => "ECG Courses in Emergency Care",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-2",
                "marker"     => "workshop-jcu23-half-day-1",
                "date_start" => "2023-09-01 08:00:00",
                "date_end"   => "2023-09-01 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => [
                    [
                        "name"       => "Workshop 2 First Session",
                        "title"      => "Deadly ECG in Tachyarrhytmia and Bradyarrhytmia in Emergency Care : How should we handle it?",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-2",
                        "slug"       => "workshop-half-day-2-1",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 2 Second Session",
                        "title"      => "Identifying ACS and ECG-Mimicking STEMI in Emergency Room",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-2",
                        "slug"       => "workshop-half-day-2-2",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 2 Third Session",
                        "title"      => "Miscellaneous ECG in Emergency Care",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-2",
                        "slug"       => "workshop-half-day-2-3",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ]
                ]
            ],
            [
                "name"       => "Workshop 3",
                "title"      => "Late Breaking Science in Adult CHD : Focus on Interatrial Abnormality",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-3",
                "marker"     => "workshop-jcu23-half-day-1",
                "date_start" => "2023-09-01 08:00:00",
                "date_end"   => "2023-09-01 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => [
                    [
                        "name"       => "Workshop 3 First Session",
                        "title"      => "Interatrial Abnormalities : Insights into Cardiac Embriology",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-3",
                        "slug"       => "workshop-half-day-3-1",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 3 Second Session",
                        "title"      => "Assesment of Adult CHD : Focus on Echocardiography",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-3",
                        "slug"       => "workshop-half-day-3-2",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 3 Third Session",
                        "title"      => "PFO in Embolic Stroke of Undetermined Source (ESUS) and Migraine: Imaging and Indication for Closure",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-3",
                        "slug"       => "workshop-half-day-3-3",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ]
                ]
            ],
            [
                "name"       => "Workshop 4",
                "title"      => "All about shock in Emergency Care",
                "data_type"  => "product",
                "section"    => "jcu23",
                "slug"       => "workshop-half-day-4",
                "marker"     => "workshop-jcu23-half-day-1",
                "date_start" => "2023-09-01 08:00:00",
                "date_end"   => "2023-09-01 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => [
                    [
                        "name"       => "Workshop 4 First Session",
                        "title"      => "Cardiogenic Shock: an introduction",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-4",
                        "slug"       => "workshop-half-day-4-1",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 4 Second Session",
                        "title"      => "Invansive vs non invasive monitoring: How Much Is Enough… What More Is Needed?",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-4",
                        "slug"       => "workshop-half-day-4-2",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 2 Third Session",
                        "title"      => "Cases disscussion: learning the pitfalls",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "",
                        "marker"     => "workshop-half-day-4",
                        "slug"       => "workshop-half-day-4-3",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ]
                ]
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

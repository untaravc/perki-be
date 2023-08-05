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
                        "speakers"   => "salvatore.disomma",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a0",
                        "date_start" => "2023-09-02 08:30:00",
                        "date_end"   => "2023-09-02 08:50:00",
                    ],
                    [
                        "name"       => "Plenary Lecture II",
                        "title"      => "The Role of Wearable Technologies Aid Patient Monitoring and ArtficiaI Intelegent in Cardiovascular Disease",
                        "data_type"  => "schedule",
                        "speakers"   => "budi.yuli",
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
                        "moderators" => "",
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
                                "speakers"   => "erika.maharani",
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
                                "speakers"   => "admin.alahmad",
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
                                "speakers"   => "sofian.johar",
                                "marker"     => "symposium-jcu23-a1",
                                "slug"       => "symposium-jcu23-a1-3",
                                "date_start" => "2023-09-02 09:50:00",
                                "date_end"   => "2023-09-02 10:10:00",
                            ]
                        ],
                    ],
                    [
                        "name"       => "Symposium 2",
                        "title"      => "Breaking Down Pulmonary Hypertension : From Etiology to Management Strategies",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "",
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
                                "speakers"   => "dyah.adhi",
                                "marker"     => "symposium-jcu23-b2",
                                "slug"       => "symposium-jcu23-b2-1",
                                "date_start" => "2023-09-02 09:10:00",
                                "date_end"   => "2023-09-02 09:30:00",
                            ],
                            [
                                "name"       => "Symposium 2 Second Session",
                                "title"      => "SGLT-2 Inhibitor Era in HFrEF : From Context to Clinical Pearls",
                                "data_type"  => "schedule-detail",
                                "speakers"   => "dyah.wulan",
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
                                "speakers"   => "lucia.kris",
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
                        "moderators" => "",
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
                                "speakers"   => "fera.hidayati",
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
                                "speakers"   => "erika.maharani",
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
                                "speakers"   => "azzlan.hussin",
                                "marker"     => "symposium-jcu23-a3",
                                "slug"       => "symposium-jcu23-a3-3",
                                "date_start" => "2023-09-02 11:20:00",
                                "date_end"   => "2023-09-02 11:40:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 4",
                        "title"      => "A New Era in Managing Antiplatelet therapies",
                        "data_type"  => "schedule",
                        "moderators" => "",
                        "section"    => "jcu23",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b4",
                        "date_start" => "2023-09-01 10:40:00",
                        "date_end"   => "2023-09-01 11:55:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 4 First Session",
                                "title"      => "A Review Concepts and Mechanism of Antiplatelet Resistance in CVD",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "real.kusumanjaya",
                                "marker"     => "symposium-jcu23-b4",
                                "slug"       => "symposium-jcu23-b4-1",
                                "date_start" => "2023-09-02 10:40:00",
                                "date_end"   => "2023-09-02 11:00:00",
                            ],
                            [
                                "name"       => "Symposium 4 Second Session",
                                "title"      => "Antiplatelet Resistance : Does it Exist and How to Measure it?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "hari.yusti",
                                "marker"     => "symposium-jcu23-b4",
                                "slug"       => "symposium-jcu23-b4-2",
                                "date_start" => "2023-09-02 11:00:00",
                                "date_end"   => "2023-09-02 11:20:00",
                            ],
                            [
                                "name"       => "Symposium 4 Third Session",
                                "title"      => "Tailoring Antiplatelet Therapy for Patient with Antiplatelet Resistance",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "budi.yuli",
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
                        "moderators" => "",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a5",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 14:15:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 5 First Session",
                                "title"      => "Cardiac Channelopathies Disease: Uncovered The Iceberg Phenomenon",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "fera.hidayati",
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
                                "speakers"   => "putrika.prastuti",
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
                                "speakers"   => "muh.yamin",
                                "marker"     => "symposium-jcu23-a5",
                                "slug"       => "symposium-jcu23-a5-3",
                                "date_start" => "2023-09-02 13:40:00",
                                "date_end"   => "2023-09-02 14:00:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 6",
                        "title"      => "Tailoring Management in Heart Failure Patients : Focus on Pharmacological therapy",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "rm.arjono",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b6",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 14:15:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 6 First Session",
                                "title"      => "The Role of Betablockers in Restoring Function in Failing Hearts",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "hasanah.mumpuni",
                                "marker"     => "symposium-jcu23-b6",
                                "slug"       => "symposium-jcu23-b6-1",
                                "date_start" => "2023-09-02 13:00:00",
                                "date_end"   => "2023-09-02 13:20:00",
                            ],
                            [
                                "name"       => "Symposium 6 Second Session",
                                "title"      => "SGLT-2 Inhibitor Era in HFrEF : From Context to Clinical Pearls",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "anggoro.budi",
                                "marker"     => "symposium-jcu23-b6",
                                "slug"       => "symposium-jcu23-b6-2",
                                "date_start" => "2023-09-02 13:20:00",
                                "date_end"   => "2023-09-02 13:40:00",
                            ],
                            [
                                "name"       => "Symposium 6 Third Session",
                                "title"      => "The Use of Rosuvastatin in CVD Patients : Beyond Its Cholesterol-Lowering Impact",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "taufik.ismail",
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
                        "moderators" => "fera.hidayati",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a7",
                        "date_start" => "2023-09-01 14:15:00",
                        "date_end"   => "2023-09-01 16:00:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 7 First Session",
                                "title"      => "Improving Quality of Life in Patient with Heart Failure : From Fondation Therapy to Cardiac Rehabillitation",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "salvatore.disomma",
                                "marker"     => "symposium-jcu23-a7",
                                "slug"       => "symposium-jcu23-a7-1",
                                "date_start" => "2023-09-02 14:15:00",
                                "date_end"   => "2023-09-02 14:35:00",
                            ],
                            [
                                "name"       => "Symposium 7 Second Session",
                                "title"      => "The Role of ARNI in the Treatment of Heart Failure",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "nahar.taufiq",
                                "marker"     => "symposium-jcu23-a7",
                                "slug"       => "symposium-jcu23-a7-2",
                                "date_start" => "2023-09-02 14:35:00",
                                "date_end"   => "2023-09-02 14:55:00",
                            ],
                            [
                                "name"       => "Symposium 7 Third Session",
                                "title"      => "Device Option for Treatment of Heart Failure : What to Know and When to Refer",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "muhammad.munawar",
                                "marker"     => "symposium-jcu23-a7",
                                "slug"       => "symposium-jcu23-a7-3",
                                "date_start" => "2023-09-02 14:55:00",
                                "date_end"   => "2023-09-02 15:15:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 8",
                        "title"      => "Improving outcome of Patient in ICCU : Do Not Just Treat the Heart and Ignore The Kidneys",
                        "section"    => "jcu23",
                        "moderators" => "hariadi.hariawan",
                        "data_type"  => "schedule",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b8",
                        "date_start" => "2023-09-01 14:15:00",
                        "date_end"   => "2023-09-01 16:00:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 8 First Session",
                                "title"      => "AKI in ICCU : Pathomechanism and Consequences for Critically Ill Patient",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "heru.prasanto",
                                "marker"     => "symposium-jcu23-b8",
                                "slug"       => "symposium-jcu23-b8-1",
                                "date_start" => "2023-09-02 14:15:00",
                                "date_end"   => "2023-09-02 14:35:00",
                            ],
                            [
                                "name"       => "Symposium 8 Second Session",
                                "title"      => "Managing AKI in ICCU: From Stable Patient to Shock Condition",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "firandi.saputra",
                                "marker"     => "symposium-jcu23-b8",
                                "slug"       => "symposium-jcu23-b8-2",
                                "date_start" => "2023-09-02 14:35:00",
                                "date_end"   => "2023-09-02 14:55:00",
                            ],
                            [
                                "name"       => "Symposium 8 Third Session",
                                "title"      => "Renal Support in ICCU: Focusing on CRRT Management",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "hendry.purnasidha",
                                "marker"     => "symposium-jcu23-b8",
                                "slug"       => "symposium-jcu23-b8-3",
                                "date_start" => "2023-09-02 14:55:00",
                                "date_end"   => "2023-09-02 15:15:00",
                            ]
                        ]
                    ],
                    [

                        "name"       => "Panel 1",
                        "title"      => "Decongestion Strategy in Acute Heart Failure : The Role of Biomarker",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "anggoro.budi",
                        "speakers"   => "dyah.samti",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-apanel1",
                        "date_start" => "2023-09-03 08:00:00",
                        "date_end"   => "2023-09-03 08:45:00",
                    ],
                    [
                        "name"       => "Panel 2",
                        "title"      => "Comprehensive Management in Cancer Therapy Related Cardiac Dysfunction",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "vita.yanti",
                        "speakers"   => "royhan.rozqie",
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
                        "moderators" => "lima.peni",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a9",
                        "date_start" => "2023-09-03 08:45:00",
                        "date_end"   => "2023-09-03 10:00:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 9 First Session",
                                "title"      => "Overview of New Cellular and Structural Alteration in Pathophysiology of Hypertension Mediated Organ Damage",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "gahan.satwiko",
                                "marker"     => "symposium-jcu23-a9",
                                "slug"       => "symposium-jcu23-a9-1",
                                "date_start" => "2023-09-03 08:45:00",
                                "date_end"   => "2023-09-03 09:05:00",
                            ],
                            [
                                "name"       => "Symposium 9 Second Session",
                                "title"      => "Current Challenges in Management of Hypertension : Towards a Better Care",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "irsad.andi",
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
                                "speakers"   => "bagus.andi",
                                "marker"     => "symposium-jcu23-a9",
                                "slug"       => "symposium-jcu23-a9-3",
                                "date_start" => "2023-09-03 09:25:00",
                                "date_end"   => "2023-09-03 09:45:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 10",
                        "title"      => "Enhancing Outcomes in Heart Failure : Innovations in Diagnosis and Treatment",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "real.kusumanjaya",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b10",
                        "date_start" => "2023-09-03 08:45:00",
                        "date_end"   => "2023-09-03 10:00:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 10 First Session",
                                "title"      => "Chronic heart failure : Cardiovascular Disease Continuum Revisited",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "bambang.irawan",
                                "marker"     => "symposium-jcu23-b10",
                                "slug"       => "symposium-jcu23-b10-1",
                                "date_start" => "2023-09-03 08:45:00",
                                "date_end"   => "2023-09-03 09:05:00",
                            ],
                            [
                                "name"       => "Symposium 10 Second Session",
                                "title"      => "The Four Pillars of HFrEF Therapy: Is it Time to Treat Heart Failure Regardless of Ejection Fraction?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "lucia.kris",
                                "marker"     => "symposium-jcu23-b10",
                                "slug"       => "symposium-jcu23-b10-2",
                                "date_start" => "2023-09-03 09:05:00",
                                "date_end"   => "2023-09-03 09:25:00",
                            ],
                            [
                                "name"       => "Symposium 10 Third Session",
                                "title"      => "The HFpEF Diagnostic Algorithm's Usefulness in Clinical Practice",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "hasanah.mumpuni",
                                "marker"     => "symposium-jcu23-b10",
                                "slug"       => "symposium-jcu23-b10-3",
                                "date_start" => "2023-09-03 09:25:00",
                                "date_end"   => "2023-09-03 09:45:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 11",
                        "title"      => "Diabetes and Heart Failure: The Interplay and Novel Therapeutic Approaches for the Dynamic Duo",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "hasanah.mumpuni",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a11",
                        "date_start" => "2023-09-03 10:15:00",
                        "date_end"   => "2023-09-03 11:30:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 11 First Session",
                                "title"      => "Biomarker Profiles and Pathophysiological Pathways in Patients with Chronic Heart Failure and Metabolic Syndrome",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "anggoro.budi",
                                "marker"     => "symposium-jcu23-a11",
                                "slug"       => "symposium-jcu23-a11-1",
                                "date_start" => "2023-09-03 10:15:00",
                                "date_end"   => "2023-09-03 10:35:00",
                            ],
                            [
                                "name"       => "Symposium 11 Second Session",
                                "title"      => "Timing of Initiation of Sodium-Glucose Co-transporter 2 Inhibitor and Management of Blood Glucose in Patients with Diabetes and Chronic Heart Failure",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "raden.bowo",
                                "marker"     => "symposium-jcu23-a11",
                                "slug"       => "symposium-jcu23-a11-2",
                                "date_start" => "2023-09-03 10:35:00",
                                "date_end"   => "2023-09-03 10:55:00",
                            ],
                            [
                                "name"       => "Symposium 11 Third Session",
                                "title"      => "Diabetic Cardiomyopathy in Heart Failure: A New Target for Therapy",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "vita.yanti",
                                "marker"     => "symposium-jcu23-a11",
                                "slug"       => "symposium-jcu23-a11-3",
                                "date_start" => "2023-09-03 10:55:00",
                                "date_end"   => "2023-09-03 11:15:00",
                            ]
                        ]

                    ],
                    [
                        "name"       => "Symposium 12",
                        "title"      => "Current Challenges and Future Directions in Handling Patients With Cryptogenic Stroke",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "budi.yuli",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b12",
                        "date_start" => "2023-09-03 10:15:00",
                        "date_end"   => "2023-09-03 11:30:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 12 First Session",
                                "title"      => "The Atrium and Embolic Stroke : Myopathy not Atrial Fibrillation as a Clinical Entity",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "hamed.oemar",
                                "marker"     => "symposium-jcu23-b12",
                                "slug"       => "symposium-jcu23-b12-1",
                                "date_start" => "2023-09-03 10:15:00",
                                "date_end"   => "2023-09-03 10:35:00",
                            ],
                            [
                                "name"       => "Symposium 12 Second Session",
                                "title"      => "Clinical Spectrum of Cryptogenic Stroke",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "ismail.setyopranoto",
                                "marker"     => "symposium-jcu23-b12",
                                "slug"       => "symposium-jcu23-b12-2",
                                "date_start" => "2023-09-03 10:35:00",
                                "date_end"   => "2023-09-03 10:55:00",
                            ],
                            [
                                "name"       => "Symposium 12 Third Session",
                                "title"      => "Cryptogenic Stroke: To Close a Patent Foramen Ovale or Not to Close?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "dyah.wulan",
                                "marker"     => "symposium-jcu23-b12",
                                "slug"       => "symposium-jcu23-b12-3",
                                "date_start" => "2023-09-03 10:55:00",
                                "date_end"   => "2023-09-03 11:15:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 13",
                        "title"      => "Focused Update on Antiplatelet Therapy in CVD",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "dini.paranita",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a13",
                        "date_start" => "2023-09-03 13:00:00",
                        "date_end"   => "2023-09-03 14:15:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 13 First Session",
                                "title"      => "Platelet Activation Pathway to Guide Antiplatelet Therapy",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "aditya.damarkusuma",
                                "marker"     => "symposium-jcu23-a13",
                                "slug"       => "symposium-jcu23-a13-1",
                                "date_start" => "2023-09-03 13:00:00",
                                "date_end"   => "2023-09-03 13:20:00",
                            ],
                            [
                                "name"       => "Symposium 13 Second Session",
                                "title"      => "The Role of Antithrombotic in ACS : When to Use High Potent Antiplatelet?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "hariadi.hariawan",
                                "marker"     => "symposium-jcu23-a13",
                                "slug"       => "symposium-jcu23-a13-2",
                                "date_start" => "2023-09-03 13:20:00",
                                "date_end"   => "2023-09-03 13:40:00",
                            ],
                            [
                                "name"       => "Symposium 13 Third Session",
                                "title"      => "Peri-operative Management of Antiplatelet Therapy in Non Cardiac Surgery",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "real.kusumanjaya",
                                "marker"     => "symposium-jcu23-a13",
                                "slug"       => "symposium-jcu23-a13-3",
                                "date_start" => "2023-09-03 13:40:00",
                                "date_end"   => "2023-09-03 14:00:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 14",
                        "title"      => "How Should I Treat A Patient with High Bleeding Risk?",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "hendry.purasidha",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b14",
                        "date_start" => "2023-09-03 13:00:00",
                        "date_end"   => "2023-09-03 14:15:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 14 First Session",
                                "title"      => "Lipid Management in High Bleeding Risk Patient - Less or Aggresive?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "irsad.andi",
                                "marker"     => "symposium-jcu23-b14",
                                "slug"       => "symposium-jcu23-b14-1",
                                "date_start" => "2023-09-03 13:00:00",
                                "date_end"   => "2023-09-03 13:20:00",
                            ],
                            [
                                "name"       => "Symposium 14 Second Session",
                                "title"      => "Antiplatelet Therapy in Patients at High Bleeding Risk: Less is More—More or Less",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "rendi.asmara",
                                "marker"     => "symposium-jcu23-b14",
                                "slug"       => "symposium-jcu23-b14-2",
                                "date_start" => "2023-09-03 13:20:00",
                                "date_end"   => "2023-09-03 13:40:00",
                            ],
                            [
                                "name"       => "Symposium 14 Third Session",
                                "title"      => "Revascularization Strategy in High Bleeding Risk Patient",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "nahar.taufiq",
                                "marker"     => "symposium-jcu23-b14",
                                "slug"       => "symposium-jcu23-b14-3",
                                "date_start" => "2023-09-03 13:40:00",
                                "date_end"   => "2023-09-03 14:00:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 15",
                        "title"      => "Uniting Expertise : The Importance of Multidisciplinary Approach in Diabetic Ulcer due to Chronic Limb Threatening Ischemia",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "gahan.satwiko",
                        "marker"     => "symposium-jcu23-a",
                        "slug"       => "symposium-jcu23-a15",
                        "date_start" => "2023-09-03 14:15:00",
                        "date_end"   => "2023-09-03 15:30:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 15 First Session",
                                "title"      => "A to Z for CLTI : All Part involved in CLTI",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "taufik.ismail",
                                "marker"     => "symposium-jcu23-a15",
                                "slug"       => "symposium-jcu23-a15-1",
                                "date_start" => "2023-09-03 14:15:00",
                                "date_end"   => "2023-09-03 14:35:00",
                            ],
                            [
                                "name"       => "Symposium 15 Second Session",
                                "title"      => "Best Management Strategies for Diabetic Ulcer : From Wound Care to Revascularization",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "hemi.sinorita",
                                "marker"     => "symposium-jcu23-a15",
                                "slug"       => "symposium-jcu23-a15-2",
                                "date_start" => "2023-09-03 14:35:00",
                                "date_end"   => "2023-09-03 14:55:00",
                            ],
                            [
                                "name"       => "Symposium 15 Third Session",
                                "title"      => "Current Approach to Accurate Treatment of CLTI : Medical Treatment vs Revascularization",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "hariadi.hariawan",
                                "marker"     => "symposium-jcu23-a15",
                                "slug"       => "symposium-jcu23-a15-3",
                                "date_start" => "2023-09-03 14:55:00",
                                "date_end"   => "2023-09-03 15:15:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium 16",
                        "title"      => "Myocarditis and Cardiomyopathy: Current Evidence and Future Directions",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "moderators" => "vita.yanti",
                        "marker"     => "symposium-jcu23-b",
                        "slug"       => "symposium-jcu23-b16",
                        "date_start" => "2023-09-03 14:15:00",
                        "date_end"   => "2023-09-03 15:30:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 16 First Session",
                                "title"      => "Pathophysiology and Diagnostic Workup of Myocarditis and Chronic Inflammatory Cardiomyopathy",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "dyah.adhi",
                                "marker"     => "symposium-jcu23-b16",
                                "slug"       => "symposium-jcu23-b16-1",
                                "date_start" => "2023-09-03 14:15:00",
                                "date_end"   => "2023-09-03 14:35:00",
                            ],
                            [
                                "name"       => "Symposium 16 Second Session",
                                "title"      => "Update on Peripartum Cardiomyopathy",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "wahyu.himawan",
                                "marker"     => "symposium-jcu23-b16",
                                "slug"       => "symposium-jcu23-b16-2",
                                "date_start" => "2023-09-03 14:35:00",
                                "date_end"   => "2023-09-03 14:55:00",
                            ],
                            [
                                "name"       => "Symposium 16 Third Session",
                                "title"      => "Cardiac Imaging in Myocarditis and Inflammatory Cardiomyopathy : New Insights and Future Directions",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu23",
                                "speakers"   => "putrika.prastuti",
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
                "subtitle"   => "CRITICAL CARE",
                "data_type"  => "product",
                "section"    => "jcu23",
                "image"      => "/assets/posters/ws5.jpeg",
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
                        "speakers"   => "budi.yuli",
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
                        "speakers"   => "hendry.purnasidha",
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
                        "speakers"   => "firandi.saputra",
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
                "title"      => "Performing Best Care Ultrasound in Daily Emergency Case: Moving Beyond the Basic",
                "subtitle"   => "Echo",
                "data_type"  => "product",
                "section"    => "jcu23",
                "image"      => "/assets/posters/ws6.jpeg",
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
                        "speakers"   => "real.kusumanjaya",
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
                        "speakers"   => "hasanah.mumpuni",
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
                        "speakers"   => "taufik.ismail",
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
                "title"      => "Exercise Stress Test: How to Session",
                "subtitle"   => "Rehabilitation",
                "data_type"  => "product",
                "section"    => "jcu23",
                "image"      => "/assets/posters/ws7.jpeg",
                "slug"       => "workshop-half-day-7",
                "marker"     => "workshop-jcu23-half-day-2",
                "date_start" => "2023-09-01 13:00:00",
                "date_end"   => "2023-09-01 16:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop 7 First Session",
                        "title"      => "Overview : Preparing and Choosing Right Modality for Right Patients",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "anggoro.budi",
                        "marker"     => "workshop-half-day-7",
                        "slug"       => "workshop-half-day-7-1",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 7 Second Session",
                        "title"      => "Treadmill Stress Test : From A to Z How to Session",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "irsad.andi",
                        "marker"     => "workshop-half-day-7",
                        "slug"       => "workshop-half-day-7-2",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 7 Third Session",
                        "title"      => "How to Perform Ergo meter Cycle Stress Test : Hands On",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "ade.meidian",
                        "marker"     => "workshop-half-day-7",
                        "slug"       => "workshop-half-day-7-3",
                        "date_start" => "2023-09-01 13:00:00",
                        "date_end"   => "2023-09-01 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 7 Fourth Session",
                        "title"      => "Testing and Interpretation for Diagnostic and Prognostic Study",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "vita.yanti",
                        "marker"     => "workshop-half-day-7",
                        "slug"       => "workshop-half-day-7-4",
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
                "subtitle"   => "Atrial Fibrillation",
                "data_type"  => "product",
                "section"    => "jcu23",
                "image"      => "/assets/posters/ws8.jpeg",
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
                        "speakers"   => "fera.hidayati",
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
                        "speakers"   => "erika.maharani",
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
                        "speakers"   => "margono.gatot",
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
                "image"      => "/assets/posters/ws1.jpeg",
                "slug"       => "workshop-half-day-1",
                "marker"     => "workshop-jcu23-half-day-1",
                "date_start" => "2023-09-01 08:00:00",
                "date_end"   => "2023-09-01 11:00:00",
                "has_price"  => 1,
                "speakers"   => 'fiemar.fauzan',
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
                        "speakers"   => "lidwina.tarigan",
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
                        "speakers"   => "hendry.purnasidha",
                        "marker"     => "workshop-half-day-1",
                        "slug"       => "workshop-half-day-1-3",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ]
                ]
            ],
            [
                "name"       => "Workshop 2",
                "title"      => "Interpreting ECG in Emergency Setting: Tips and Tricks",
                "subtitle"   => "Emergency Care",
                "data_type"  => "product",
                "section"    => "jcu23",
                "image"      => "/assets/posters/ws2.jpeg",
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
                        "speakers"   => "putrika.prastuti",
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
                        "speakers"   => "anggia.endah",
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
                        "speakers"   => "firman.fauzan",
                        "marker"     => "workshop-half-day-2",
                        "slug"       => "workshop-half-day-2-3",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ]
                ]
            ],
            [
                "name"       => "Workshop 3",
                "title"      => "Translating Transthoracal Echocardiography into Clinical Practice in Adult Congenital Heart Disease",
                "subtitle"   => "Echocardiography",
                "data_type"  => "product",
                "section"    => "jcu23",
                "image"      => "/assets/posters/ws3.jpeg",
                "slug"       => "workshop-half-day-3",
                "marker"     => "workshop-jcu23-half-day-1",
                "date_start" => "2023-09-01 08:00:00",
                "date_end"   => "2023-09-01 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => [
                    [
                        "name"       => "Workshop 3 First Session",
                        "title"      => "Understanding Adult Congenital Heart Disease : Insights into Cardiac Embriology",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "dyah.wulan",
                        "marker"     => "workshop-half-day-3",
                        "slug"       => "workshop-half-day-3-1",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 3 Second Session",
                        "title"      => "Assesment of Adult CHD : Focus on Echocardiography in Interatrial & Interventricular Abnormalities",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "lucia.kris",
                        "marker"     => "workshop-half-day-3",
                        "slug"       => "workshop-half-day-3-2",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 3 Third Session",
                        "title"      => "Multifaceted on Ventricle Septal Defect : An Echo Role",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "dyah.samti",
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
                "subtitle"   => "Cardiovascular Emergency Care",
                "data_type"  => "product",
                "section"    => "jcu23",
                "image"      => "/assets/posters/ws4.jpeg",
                "slug"       => "workshop-half-day-4",
                "marker"     => "workshop-jcu23-half-day-1",
                "date_start" => "2023-09-01 08:00:00",
                "date_end"   => "2023-09-01 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => [
                    [
                        "name"       => "Workshop 4 First Session",
                        "title"      => "Cardiogenic shock: What is the optimal perfusion target    ",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "arditya.damarkusuma",
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
                        "speakers"   => "firandi.saputra",
                        "marker"     => "workshop-half-day-4",
                        "slug"       => "workshop-half-day-4-2",
                        "date_start" => "2023-09-01 08:00:00",
                        "date_end"   => "2023-09-01 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 4 Third Session",
                        "title"      => "Role of Pulmonary Catheter in Cardiogenic Shock",
                        "data_type"  => "schedule",
                        "section"    => "jcu23",
                        "speakers"   => "dewi.suprobo",
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

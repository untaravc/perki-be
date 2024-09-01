<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Price;
use Illuminate\Http\Request;

class Event24Controller extends Controller
{
    public function event_init()
    {
        $symposium = $this->symposium();
        $this->insert_event($symposium);

        $first_workshop = $this->first_workshop();
        $this->insert_event($first_workshop);

        $secon_workshop = $this->second_workshop();
        $this->insert_event($secon_workshop);

        return 'event updated';
    }

    private function symposium()
    {
        return [
            [
                "name"       => "Symposium",
                "title"      => "Artificial Intelligence in Transdisciplinary Cardiovascular Care: The Future is Now",
                "data_type"  => "product",
                "section"    => "jcu24",
                "marker"     => "symposium-jcu24",
                "slug"       => "symposium-jcu24",
                "date_start" => "2024-10-19 08:00:00",
                "date_end"   => "2024-10-20 16:00:00",
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
                        "price"         => 750000,
                    ],
                ],
                "children"   => [
                    [
                        "name"       => "Plenary Lecture",
                        "title"      => "Artificial Intelligent in Transdisciplinary Cardiovascular Care: The Future is Now",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "budi-yuli,bambang-irawan,hyuk-jae,ganesan-karthikeyan",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a0",
                        "date_start" => "2024-10-19 08:00:00",
                        "date_end"   => "2024-10-19 08:45:00",
                    ],
                    [
                        "name"       => "Plenary Lecture",
                        "title"      => "Artificial Intelligent in Transdisciplinary Cardiovascular Care: The Future is Now",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "budi-yuli,bambang-irawan,hyuk-jae,ganesan-karthikeyan",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b0",
                        "date_start" => "2024-10-19 08:00:00",
                        "date_end"   => "2024-10-19 08:45:00",
                    ],
                    [
                        "name"       => "Symposium IA",
                        "title"      => "Challenging Management in Cardiogenic Shock: Where are We Now",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "hasanah-mumpuni",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a1",
                        "date_start" => "2024-10-19 08:45:00",
                        "date_end"   => "2024-10-19 09:35:00",
                        "children"   => [
                            [
                                "name"       => "Symposium 1 First Session",
                                "title"      => "Management of Cardiogenic Shock: Acute Myocardial Infarction Cardiogenic Shock (AMI-CS) vs Non Acute Myocardial Infarction Cardiogenic Shock (Non AMI-CS)",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "evita-devi",
                                "marker"     => "symposium-jcu24-a1",
                                "slug"       => "symposium-jcu24-a1-1",
                                "date_start" => "2024-10-19 08:45:00",
                                "date_end"   => "2024-10-19 09:35:00",
                            ],
                            [
                                "name"       => "Symposium IA",
                                "title"      => "Dobutamin vs Milrinone in Cardiogenic Shock; Which One Wins the Battle?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "budi-yuli",
                                "marker"     => "symposium-jcu24-a1",
                                "slug"       => "symposium-jcu24-a1-2",
                                "date_start" => "2024-10-19 08:45:00",
                                "date_end"   => "2024-10-19 09:35:00",
                            ],
                        ],
                    ],
                    [
                        "name"       => "Symposium IB",
                        "title"      => "Comprehensive Care of Heart Failure: The Emerging Role of Biomarker",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "dyah-adhi",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b2",
                        "date_start" => "2024-10-19 08:45:00",
                        "date_end"   => "2024-10-19 09:35:00",
                        'children'   => [
                            [
                                "name"       => "Symposium IB First Session",
                                "title"      => "Update on Diagnostic Pathway of Chronic Heart Failure",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "bagus-andi",
                                "marker"     => "symposium-jcu24-b2",
                                "slug"       => "symposium-jcu24-b2-1",
                                "date_start" => "2024-10-19 08:45:00",
                                "date_end"   => "2024-10-19 09:35:00",
                            ],
                            [
                                "name"       => "Symposium IB Second Session",
                                "title"      => "NTproBNP in Heart Failure: Diagnosis and Prognosis Application",
                                "data_type"  => "schedule-detail",
                                "speakers"   => "anggoro-budi",
                                "section"    => "jcu24",
                                "marker"     => "symposium-jcu24-b2",
                                "slug"       => "symposium-jcu24-b2-2",
                                "date_start" => "2024-10-19 08:45:00",
                                "date_end"   => "2024-10-19 09:35:00",
                            ],
                        ],
                    ],
                    [
                        "name"       => "Symposium IIA",
                        "data_type"  => "schedule",
                        "title"      => "Deciding Safe and Effective Antithrombotics in Coronary Syndrome",
                        "section"    => "jcu24",
                        "moderators" => "hariadi-hariawan",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a3",
                        "date_start" => "2024-10-19 09:45:00",
                        "date_end"   => "2024-10-19 10:35:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IIA First Session",
                                "title"      => "Optimization Management of Non-ST Elevation Acute Coronary Syndrome  Patients Through Safety and Effective Antithrombotic",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "muhammad-taufik",
                                "marker"     => "symposium-jcu24-a3",
                                "slug"       => "symposium-jcu24-a3-1",
                                "date_start" => "2024-10-19 09:45:00",
                                "date_end"   => "2024-10-19 10:35:00",
                            ],
                            [
                                "name"       => "Symposium IIA Second Session",
                                "title"      => "Potent Antiplatelet in Coronary Artery Disease: Which one is better?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "hendry-purnasidha",
                                "marker"     => "symposium-jcu24-a3",
                                "slug"       => "symposium-jcu24-a3-2",
                                "date_start" => "2024-10-19 09:45:00",
                                "date_end"   => "2024-10-19 10:35:00",
                            ],
                        ]
                    ],
                    [
                        "name"       => "Symposium IIB",
                        "title"      => "Artificial Intelligence and Cardiovascular Disease Risk Stratification in the Realm of Preventive Cardiology",
                        "data_type"  => "schedule",
                        "moderators" => "muhammad-yulianto",
                        "section"    => "jcu24",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b4",
                        "date_start" => "2024-10-19 09:45:00",
                        "date_end"   => "2024-10-19 10:35:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IIB First Session",
                                "title"      => "Artificial Intelligence for Predicting Cardiovascular Disease: The Role for Cardiovascular Disease Prevention",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "arditya-damarkusuma",
                                "marker"     => "symposium-jcu24-b4",
                                "slug"       => "symposium-jcu24-b4-1",
                                "date_start" => "2024-10-19 09:45:00",
                                "date_end"   => "2024-10-19 10:35:00",
                            ],
                            [
                                "name"       => "Symposium IIB Second Session",
                                "title"      => "Antiplatelet Resistance: Does it Exist and How to Measure it?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "irsad-andi",
                                "marker"     => "symposium-jcu24-b4",
                                "slug"       => "symposium-jcu24-b4-2",
                                "date_start" => "2024-10-19 09:45:00",
                                "date_end"   => "2024-10-19 10:35:00",
                            ],
                        ]
                    ],
                    [
                        "name"       => "Symposium IIIA",
                        "title"      => "Re-thinking the Optimal Approach for Atherosclerotic Disease",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "lima-peni",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a5",
                        "date_start" => "2024-10-19 10:35:00",
                        "date_end"   => "2024-10-19 11:25:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IIIA First Session",
                                "title"      => "Integrating Artificial Intelligence into Imaging for the Diagnosis of Atherosclerotic Disease",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "putrika-prastuti",
                                "marker"     => "symposium-jcu24-a5",
                                "slug"       => "symposium-jcu24-a5-1",
                                "date_start" => "2024-10-19 10:35:00",
                                "date_end"   => "2024-10-19 11:25:00",
                            ],
                            [
                                "name"       => "Symposium IIIA Second Session",
                                "title"      => "Beyond Lipid Lowering Effects:  Atorvastatin for Atherosclerotic Disease",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "nahar-taufiq",
                                "marker"     => "symposium-jcu24-a5",
                                "slug"       => "symposium-jcu24-a5-2",
                                "date_start" => "2024-10-19 10:35:00",
                                "date_end"   => "2024-10-19 11:25:00",
                            ],
                        ]
                    ],
                    [
                        "name"       => "Symposium IIIB",
                        "title"      => "Cutting Edge Concepts in the Management of Chronic Heart Failure",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "rm.arjono",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b6",
                        "date_start" => "2024-10-19 10:35:00",
                        "date_end"   => "2024-10-19 11:25:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IIIB First Session",
                                "title"      => "Establishing the Four Pillars of Chronic Heart Failure Therapy",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "habibie-arifianto",
                                "marker"     => "symposium-jcu24-b6",
                                "slug"       => "symposium-jcu24-b6-1",
                                "date_start" => "2024-10-19 10:35:00",
                                "date_end"   => "2024-10-19 11:25:00",
                            ],
                            [
                                "name"       => "Symposium IIIB Second Session",
                                "title"      => "Complementing the Four Pillars: Optimizing Therapy in Chronic Heart Failure with Hypertension",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "hasanah-mumpuni",
                                "marker"     => "symposium-jcu24-b6",
                                "slug"       => "symposium-jcu24-b6-2",
                                "date_start" => "2024-10-19 10:35:00",
                                "date_end"   => "2024-10-19 11:25:00",
                            ],
                        ]
                    ],
                    [
                        "name"       => "Symposium IVA",
                        "title"      => "The Role of Indonesia's Ovine Enoxaparin Sodium: Current Updates and Clinical Use",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "firandi-saputra",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a7",
                        "date_start" => "2024-10-19 13:00:00",
                        "date_end"   => "2024-10-19 14:20:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IVA First Session",
                                "title"      => "Current Guidelines and Clinical Recommendation of Anticoagulant in Acute Coronary Syndrome",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "margono-gatot",
                                "marker"     => "symposium-jcu24-a7",
                                "slug"       => "symposium-jcu24-a7-1",
                                "date_start" => "2024-10-19 13:00:00",
                                "date_end"   => "2024-10-19 14:20:00",
                            ],
                            [
                                "name"       => "Symposium IVA Second Session",
                                "title"      => "Anticoagulants in Acute Coronary Syndrome: Brief Mechanism of Action in  LMWH",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "arditya-damarkusuma",
                                "marker"     => "symposium-jcu24-a7",
                                "slug"       => "symposium-jcu24-a7-2",
                                "date_start" => "2024-10-19 13:00:00",
                                "date_end"   => "2024-10-19 14:20:00",
                            ],
                            [
                                "name"       => "Symposium IVA Third Session",
                                "title"      => "Updates on Clinical Study of Ovine Enoxaparin Sodium in Indonesia",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "bambang-widyantoro",
                                "marker"     => "symposium-jcu24-a7",
                                "slug"       => "symposium-jcu24-a7-3",
                                "date_start" => "2024-10-19 13:00:00",
                                "date_end"   => "2024-10-19 14:20:00",
                            ],
                        ]
                    ],
                    [
                        "name"       => "Symposium IVB",
                        "title"      => "Peripheral Venous Disease in Chronic Kidney Diseases: The Forgotten Entity",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "data_type"  => "schedule",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b8",
                        "date_start" => "2024-10-19 13:00:00",
                        "date_end"   => "2024-10-19 14:20:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IVB First Session",
                                "title"      => "A to Z Peripheral Venous Disease in Chronic Kidney Disease Population",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "muhammad-taufik",
                                "marker"     => "symposium-jcu24-b8",
                                "slug"       => "symposium-jcu24-b8-1",
                                "date_start" => "2024-10-19 13:00:00",
                                "date_end"   => "2024-10-19 14:20:00",
                            ],
                            [
                                "name"       => "Symposium IVB Second Session",
                                "title"      => "AV Shunt Monitoring and Surveillance in Hemodialysis Patients: KDOQI Current Recommendations",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "raden-heru",
                                "marker"     => "symposium-jcu24-b8",
                                "slug"       => "symposium-jcu24-b8-2",
                                "date_start" => "2024-10-19 13:00:00",
                                "date_end"   => "2024-10-19 14:20:00",
                            ],
                            [
                                "name"       => "Symposium IVB Third Session",
                                "title"      => "Current Approach to Accurate Treatment of AV Shunt Failure: Medical Treatment vs. Revascularization",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "hariadi-hariawan",
                                "marker"     => "symposium-jcu24-b8",
                                "slug"       => "symposium-jcu24-b8-3",
                                "date_start" => "2024-10-19 13:00:00",
                                "date_end"   => "2024-10-19 14:20:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium VA",
                        "title"      => "Artificial Intelligence in Intensive Cardiovascular Unit",
                        "section"    => "jcu24",
                        "moderators" => "arditya-damarkusuma",
                        "data_type"  => "schedule",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a9",
                        "date_start" => "2024-10-19 14:20:00",
                        "date_end"   => "2024-10-19 15:40:00",
                        "children"   => [
                            [
                                "name"       => "Symposium VA First Session",
                                "title"      => "Differentiating Shock in Critical Care",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "royhan-rozqie",
                                "marker"     => "symposium-jcu24-a9",
                                "slug"       => "symposium-jcu24-a9-1",
                                "date_start" => "2024-10-19 14:20:00",
                                "date_end"   => "2024-10-19 15:40:00",
                            ],
                            [
                                "name"       => "Symposium VA Second Session",
                                "title"      => "Phenotyping Cardiogenic Shock: Why Do We Need to Know?",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "firman-fauzan",
                                "marker"     => "symposium-jcu24-a9",
                                "slug"       => "symposium-jcu24-a9-2",
                                "date_start" => "2024-10-19 14:20:00",
                                "date_end"   => "2024-10-19 15:40:00",
                            ],
                            [
                                "name"       => "Symposium VA Third Session",
                                "title"      => "Integrating Artificial Intelligence in Intensive Care: Invasive vs Non-Invasive Monitoring",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "firandi-saputra",
                                "marker"     => "symposium-jcu24-a9",
                                "slug"       => "symposium-jcu24-a9-3",
                                "date_start" => "2024-10-19 14:20:00",
                                "date_end"   => "2024-10-19 15:40:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "SYMPOSIUM VB",
                        "title"      => "Navigating the Storm: The Changing Landscape of Cardiogenic Shock in Real Life",
                        "section"    => "jcu24",
                        "moderators" => "nahar-taufiq",
                        "data_type"  => "schedule",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b10",
                        "date_start" => "2024-10-19 14:20:00",
                        "date_end"   => "2024-10-19 15:40:00",
                        "children"   => [
                            [
                                "name"       => "SYMPOSIUM VB First Session",
                                "title"      => "Current Pathophysiology of Cardiogenic Shock",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "rendi-amara",
                                "marker"     => "symposium-jcu24-b10",
                                "slug"       => "symposium-jcu24-b10-1",
                                "date_start" => "2024-10-19 14:20:00",
                                "date_end"   => "2024-10-19 15:40:00",
                            ],
                            [
                                "name"       => "SYMPOSIUM VB Second Session",
                                "title"      => "Optimal Perfusion Target in Cardiogenic Shock",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "lidwina",
                                "marker"     => "symposium-jcu24-b10",
                                "slug"       => "symposium-jcu24-b10-2",
                                "date_start" => "2024-10-19 14:20:00",
                                "date_end"   => "2024-10-19 15:40:00",
                            ],
                            [
                                "name"       => "SYMPOSIUM VB Third Session",
                                "title"      => "Management of Cardiogenic Shock from Pharmacology to Device Therapy: AMI-CS and non AMI-CS ",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "hendry-purnasidha",
                                "marker"     => "symposium-jcu24-b10",
                                "slug"       => "symposium-jcu24-b10-3",
                                "date_start" => "2024-10-19 14:20:00",
                                "date_end"   => "2024-10-19 15:40:00",
                            ]
                        ]
                    ],
                    // DAY 2
                    [
                        "name"       => "Symposium IA",
                        "title"      => "Thromboembolic Events: The Worst Nightmare",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a11",
                        "date_start" => "2024-10-20 08:00:00",
                        "date_end"   => "2024-10-20 09:20:00",
                        "children"   => [
                            [
                                "name"       => "",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a11",
                                "slug"       => "symposium-jcu24-a11-1",
                                "date_start" => "2024-10-20 08:00:00",
                                "date_end"   => "2024-10-20 09:20:00",
                            ],
                            [
                                "name"       => "",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a11",
                                "slug"       => "symposium-jcu24-a11-2",
                                "date_start" => "2024-10-20 08:00:00",
                                "date_end"   => "2024-10-20 09:20:00",
                            ],
                        ]

                    ],
                    [
                        "name"       => "Symposium IB",
                        "title"      => "Contemporary Approaches in Tackling Rheumatic Heart Disease",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b12",
                        "date_start" => "2024-10-20 10:15:00",
                        "date_end"   => "2024-10-20 11:30:00",
                        "children"   => [
                            [
                                "name"       => "",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b12",
                                "slug"       => "symposium-jcu24-b12-1",
                                "date_start" => "2024-10-20 10:15:00",
                                "date_end"   => "2024-10-20 10:35:00",
                            ],
                            [
                                "name"       => "",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b12",
                                "slug"       => "symposium-jcu24-b12-2",
                                "date_start" => "2024-10-20 10:35:00",
                                "date_end"   => "2024-10-20 10:55:00",
                            ],
                        ]
                    ],
                    [
                        "name"       => "Symposium IIA",
                        "title"      => "Heart Failure Reimagined: Pioneering Solutions for Enhanced Outcomes in Management",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a13",
                        "date_start" => "2024-10-20 09:30:00",
                        "date_end"   => "2024-10-20 10:40:00",
                        "children"   => [
                            [
                                "name"       => "",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a13",
                                "slug"       => "symposium-jcu24-a13-1",
                                "date_start" => "2024-10-20 09:30:00",
                                "date_end"   => "2024-10-20 10:40:00",
                            ],
                            [
                                "name"       => "Symposium 13 Second Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a13",
                                "slug"       => "symposium-jcu24-a13-2",
                                "date_start" => "2024-10-20 09:30:00",
                                "date_end"   => "2024-10-20 10:40:00",
                            ],
                            [
                                "name"       => "Symposium 13 Third Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a13",
                                "slug"       => "symposium-jcu24-a13-3",
                                "date_start" => "2024-10-20 09:30:00",
                                "date_end"   => "2024-10-20 10:40:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium IIB",
                        "title"      => "Metabolic Mayhem for the Heart",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b14",
                        "date_start" => "2024-10-20 09:30:00",
                        "date_end"   => "2024-10-20 10:40:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IIB First Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b14",
                                "slug"       => "symposium-jcu24-b14-1",
                                "date_start" => "2024-10-20 09:30:00",
                                "date_end"   => "2024-10-20 10:40:00",
                            ],
                            [
                                "name"       => "Symposium IIB Second Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b14",
                                "slug"       => "symposium-jcu24-b14-2",
                                "date_start" => "2024-10-20 09:30:00",
                                "date_end"   => "2024-10-20 10:40:00",
                            ],
                            [
                                "name"       => "Symposium IIB Third Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b14",
                                "slug"       => "symposium-jcu24-b14-3",
                                "date_start" => "2024-10-20 09:30:00",
                                "date_end"   => "2024-10-20 10:40:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium IIIA",
                        "title"      => "Acute Kidney Injury in Cardiovascular Critical Care Unit",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a15",
                        "date_start" => "2024-10-20 10:50:00",
                        "date_end"   => "2024-10-20 12:10:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IIIA First Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a15",
                                "slug"       => "symposium-jcu24-a15-1",
                                "date_start" => "2024-10-20 14:15:00",
                                "date_end"   => "2024-10-20 14:35:00",
                            ],
                            [
                                "name"       => "Symposium IIIA Second Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a15",
                                "slug"       => "symposium-jcu24-a15-2",
                                "date_start" => "2024-10-20 14:35:00",
                                "date_end"   => "2024-10-20 14:55:00",
                            ],
                            [
                                "name"       => "Symposium IIIA Third Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a15",
                                "slug"       => "symposium-jcu24-a15-3",
                                "date_start" => "2024-10-20 14:55:00",
                                "date_end"   => "2024-10-20 15:15:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium IIIB",
                        "title"      => "Multidisciplinary Perspectives on Arrhythmia: Cardiology, Electrophysiology, and Beyond",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b16",
                        "date_start" => "2024-10-20 14:15:00",
                        "date_end"   => "2024-10-20 15:30:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IIIB First Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b16",
                                "slug"       => "symposium-jcu24-b16-1",
                                "date_start" => "2024-10-20 14:15:00",
                                "date_end"   => "2024-10-20 14:35:00",
                            ],
                            [
                                "name"       => "Symposium IIIB Second Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b16",
                                "slug"       => "symposium-jcu24-b16-2",
                                "date_start" => "2024-10-20 14:35:00",
                                "date_end"   => "2024-10-20 14:55:00",
                            ],
                            [
                                "name"       => "Symposium IIIB Third Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b16",
                                "slug"       => "symposium-jcu24-b16-3",
                                "date_start" => "2024-10-20 14:55:00",
                                "date_end"   => "2024-10-20 15:15:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium IVA",
                        "title"      => "Current Issue in Sport Cardiology",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a17",
                        "date_start" => "2024-10-20 13:00:00",
                        "date_end"   => "2024-10-20 14:20:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IVA First Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a17",
                                "slug"       => "symposium-jcu24-a17-1",
                                "date_start" => "2024-10-20 13:00:00",
                                "date_end"   => "2024-10-20 14:20:00",
                            ],
                            [
                                "name"       => "Symposium IVA Second Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a17",
                                "slug"       => "symposium-jcu24-a17-2",
                                "date_start" => "2024-10-20 13:00:00",
                                "date_end"   => "2024-10-20 14:20:00",
                            ],
                            [
                                "name"       => "Symposium IVA Third Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a17",
                                "slug"       => "symposium-jcu24-a17-3",
                                "date_start" => "2024-10-20 13:00:00",
                                "date_end"   => "2024-10-20 14:20:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium IVB",
                        "title"      => "Preventing Pulmonary Arterial Hypertension: Mission Impossible?",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b18",
                        "date_start" => "2024-10-20 13:00:00",
                        "date_end"   => "2024-10-20 14:20:00",
                        "children"   => [
                            [
                                "name"       => "Symposium IVA First Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b18",
                                "slug"       => "symposium-jcu24-b18-1",
                                "date_start" => "2024-10-20 13:00:00",
                                "date_end"   => "2024-10-20 14:20:00",
                            ],
                            [
                                "name"       => "Symposium IVA Second Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b18",
                                "slug"       => "symposium-jcu24-b18-2",
                                "date_start" => "2024-10-20 13:00:00",
                                "date_end"   => "2024-10-20 14:20:00",
                            ],
                            [
                                "name"       => "Symposium IVA Third Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b18",
                                "slug"       => "symposium-jcu24-b18-3",
                                "date_start" => "2024-10-20 13:00:00",
                                "date_end"   => "2024-10-20 14:20:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium VA",
                        "title"      => "Palliative and Supportive Care in Heart Failure and Pulmonary Hypertension",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "marker"     => "symposium-jcu24-a",
                        "slug"       => "symposium-jcu24-a19",
                        "date_start" => "2024-10-20 14:20:00",
                        "date_end"   => "2024-10-20 15:40:00",
                        "children"   => [
                            [
                                "name"       => "Symposium VA First Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a19",
                                "slug"       => "symposium-jcu24-a19-1",
                                "date_start" => "2024-10-20 13:00:00",
                                "date_end"   => "2024-10-20 14:20:00",
                            ],
                            [
                                "name"       => "Symposium VA Second Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a19",
                                "slug"       => "symposium-jcu24-a19-2",
                                "date_start" => "2024-10-20 13:00:00",
                                "date_end"   => "2024-10-20 14:20:00",
                            ],
                            [
                                "name"       => "Symposium VA Third Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-a19",
                                "slug"       => "symposium-jcu24-a19-3",
                                "date_start" => "2024-10-20 13:00:00",
                                "date_end"   => "2024-10-20 14:20:00",
                            ]
                        ]
                    ],
                    [
                        "name"       => "Symposium VB",
                        "title"      => "Streaming with Four Pathways in Pulmonary Arterial Hypertension",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "moderators" => "",
                        "marker"     => "symposium-jcu24-b",
                        "slug"       => "symposium-jcu24-b20",
                        "date_start" => "2024-10-20 14:20:00",
                        "date_end"   => "2024-10-20 15:40:00",
                        "children"   => [
                            [
                                "name"       => "Symposium VB First Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b20",
                                "slug"       => "symposium-jcu24-b20-1",
                                "date_start" => "2024-10-20 14:20:00",
                                "date_end"   => "2024-10-20 15:40:00",
                            ],
                            [
                                "name"       => "Symposium VB Second Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b20",
                                "slug"       => "symposium-jcu24-b20-2",
                                "date_start" => "2024-10-20 14:20:00",
                                "date_end"   => "2024-10-20 15:40:00",
                            ],
                            [
                                "name"       => "Symposium VB Third Session",
                                "title"      => "",
                                "data_type"  => "schedule-detail",
                                "section"    => "jcu24",
                                "speakers"   => "",
                                "marker"     => "symposium-jcu24-b20",
                                "slug"       => "symposium-jcu24-b20-3",
                                "date_start" => "2024-10-20 14:20:00",
                                "date_end"   => "2024-10-20 15:40:00",
                            ]
                        ]
                    ],
                ],
            ],
        ];
    }

    private function second_workshop()
    {
        $ws_price = [
            ["job_type_code" => "DRSP", "price" => 1500000,],
            ["job_type_code" => "DRGN", "price" => 750000,],
            ["job_type_code" => "MHSA", "price" => 750000,],
        ];

        return [
            [
                "name"       => "Workshop 5",
                "title"      => "Fit in Body and Soul: Isthithaah for Hajj Preparation, Hands on Exercise Stress Test in Determining Functional Capacity",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "jcu24",
                "image"      => "",
                "marker"     => "second-workshop-jcu24",
                "slug"       => "second-workshop-jcu24-5",
                "date_start" => "2024-10-18 13:00:00",
                "date_end"   => "2024-10-18 16:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop 5 First Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-5",
                        "slug"       => "second-workshop-jcu24-5-1",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 5 Second Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-5",
                        "slug"       => "second-workshop-jcu24-5-2",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 5 Third Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-5",
                        "slug"       => "second-workshop-jcu24-5-3",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ]
                ],
                "has_price"  => 1,
                "prices"     => $ws_price,
            ],
            [
                "name"       => "Workshop 6",
                "title"      => "Vascular Insight: Comprehensive Learning from Pathophysiology to Ultrasound Mastery",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "jcu24",
                "image"      => "",
                "marker"     => "second-workshop-jcu24",
                "slug"       => "second-workshop-jcu24-6",
                "date_start" => "2024-10-18 13:00:00",
                "date_end"   => "2024-10-18 16:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop 6 First Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-6",
                        "slug"       => "second-workshop-jcu24-6-1",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 6 Second Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-6",
                        "slug"       => "second-workshop-jcu24-6-2",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 6 Third Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-6",
                        "slug"       => "second-workshop-jcu24-6-3",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ]
                ],
                "has_price"  => 1,
                "prices"     => $ws_price,
            ],
            [
                "name"       => "Workshop 7",
                "title"      => "Decoding the Depths: Beyond the Twelve-Lead Electrocardiogram",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "jcu24",
                "image"      => "",
                "marker"     => "second-workshop-jcu24",
                "slug"       => "second-workshop-jcu24-7",
                "date_start" => "2024-10-18 13:00:00",
                "date_end"   => "2024-10-18 16:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop 7 First Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-7",
                        "slug"       => "second-workshop-jcu24-7-1",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 7 Second Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-7",
                        "slug"       => "second-workshop-jcu24-7-2",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 7 Third Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-7",
                        "slug"       => "second-workshop-jcu24-7-3",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 7 Fourth Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-7",
                        "slug"       => "second-workshop-jcu24-7-4",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ]
                ],
                "has_price"  => 1,
                "prices"     => $ws_price,
            ],
            [
                "name"       => "Workshop 8",
                "title"      => "Simple Concepts and Clinical Practices for Diagnosing and Managing Atrial Septal Defect",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "jcu24",
                "image"      => "",
                "marker"     => "second-workshop-jcu24",
                "slug"       => "second-workshop-jcu24-8",
                "date_start" => "2024-10-18 13:00:00",
                "date_end"   => "2024-10-18 16:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop 8 First Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-8",
                        "slug"       => "second-workshop-jcu24-8-1",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 8 Second Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-8",
                        "slug"       => "second-workshop-jcu24-8-2",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ],
                    [
                        "name"       => "Workshop 8 Third Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "second-workshop-jcu24-8",
                        "slug"       => "second-workshop-jcu24-8-3",
                        "date_start" => "2024-10-18 13:00:00",
                        "date_end"   => "2024-10-18 16:00:00",
                    ]
                ],
                "has_price"  => 1,
                "prices"     => $ws_price,
            ]
        ];
    }

    private function first_workshop()
    {
        $ws_price = [
            ["job_type_code" => "DRSP", "price" => 1500000,],
            ["job_type_code" => "DRGN", "price" => 750000,],
            ["job_type_code" => "MHSA", "price" => 750000,],
        ];

        return [
            [
                "name"       => "Workshop 1",
                "title"      => "Cutting Edge Concepts in Screening, Diagnosis, and Management of Rheumatic Heart Disease: What the Newest Guideline Says",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "jcu24",
                "image"      => "",
                "marker"     => "first-workshop-jcu24",
                "slug"       => "first-workshop-jcu24-1",
                "date_start" => "2024-10-18 08:00:00",
                "date_end"   => "2024-10-18 11:00:00",
                "has_price"  => 0,
                "speakers"   => '',
                "prices"     => $ws_price,
                "children"   => [
                    [
                        "name"       => "Workshop 1 First Session",
                        "title"      => "Diagnosis Criteria of  Rheumatic Heart Disease. What is New from Current Guidelines?",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "lucia.kris",
                        "marker"     => "first-workshop-jcu24-1",
                        "slug"       => "first-workshop-jcu24-1-1",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 1 Second Session",
                        "title"      => "Screening of Rheumatic Heart Disease: Echocardiography Point of View. ",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "real.kusumanjaya",
                        "marker"     => "first-workshop-jcu24-1",
                        "slug"       => "first-workshop-jcu24-1-2",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 1 Third Session",
                        "title"      => "Management of Rheumatic Heart Disease. What to Do Next After Screening",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "hasanah.mumpuni",
                        "marker"     => "first-workshop-jcu24-1",
                        "slug"       => "first-workshop-jcu24-1-3",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ]
                ]
            ],
            [
                "name"       => "Workshop 2",
                "title"      => "Enhancing Ultrasound Utilization in Cardiac Critical Care",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "jcu24",
                "image"      => "",
                "marker"     => "first-workshop-jcu24",
                "slug"       => "first-workshop-jcu24-2",
                "date_start" => "2024-10-18 08:00:00",
                "date_end"   => "2024-10-18 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => [
                    [
                        "name"       => "Workshop 2 First Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "first-workshop-jcu24-2",
                        "slug"       => "first-workshop-jcu24-2-1",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 2 Second Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "first-workshop-jcu24-2",
                        "slug"       => "first-workshop-jcu24-2-2",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 2 Third Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "first-workshop-jcu24-2",
                        "slug"       => "first-workshop-jcu24-2-3",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ]
                ]
            ],
            [
                "name"       => "Workshop 3",
                "title"      => "Prompt and Precise Detection and Management of Diuretic Resistance",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "jcu24",
                "image"      => "",
                "marker"     => "first-workshop-jcu24",
                "slug"       => "first-workshop-jcu24-3",
                "date_start" => "2024-10-18 08:00:00",
                "date_end"   => "2024-10-18 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => [
                    [
                        "name"       => "Workshop 3 First Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "dyah.wulan",
                        "marker"     => "first-workshop-jcu24-3",
                        "slug"       => "first-workshop-jcu24-3-1",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 3 Second Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "first-workshop-jcu24-3",
                        "slug"       => "first-workshop-jcu24-3-2",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 3 Third Session",
                        "title"      => "",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "",
                        "marker"     => "first-workshop-jcu24-3",
                        "slug"       => "first-workshop-jcu24-3-3",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ]
                ]
            ],
            [
                "name"       => "Workshop 4",
                "title"      => "Mastering Cardiac Emergencies for GP: Approaches to Acute Coronary Syndrome with Lethal Arrhythmias",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "jcu24",
                "image"      => "",
                "marker"     => "first-workshop-jcu24",
                "slug"       => "first-workshop-jcu24-4",
                "date_start" => "2024-10-18 08:00:00",
                "date_end"   => "2024-10-18 11:00:00",
                "has_price"  => 1,
                "prices"     => $ws_price,
                "children"   => [
                    [
                        "name"       => "Workshop 4 First Session",
                        "title"      => "Cardiogenic shock: What is the optimal perfusion target    ",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "arditya.damarkusuma",
                        "marker"     => "first-workshop-jcu24-4",
                        "slug"       => "first-workshop-jcu24-4-1",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 4 Second Session",
                        "title"      => "Invansive vs non invasive monitoring: How Much Is Enough… What More Is Needed?",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "firandi.saputra",
                        "marker"     => "first-workshop-jcu24-4",
                        "slug"       => "first-workshop-jcu24-4-2",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ],
                    [
                        "name"       => "Workshop 4 Third Session",
                        "title"      => "Role of Pulmonary Catheter in Cardiogenic Shock",
                        "data_type"  => "schedule",
                        "section"    => "jcu24",
                        "speakers"   => "dewi.suprobo",
                        "marker"     => "first-workshop-jcu24-4",
                        "slug"       => "first-workshop-jcu24-4-3",
                        "date_start" => "2024-10-18 08:00:00",
                        "date_end"   => "2024-10-18 11:00:00",
                    ]
                ]
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
                            "section"       => 'jcu24',
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

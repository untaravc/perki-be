<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Price;

class EventCvepController extends Controller
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
                "title"      => "CardioVascular Disease Prevention and Longevity: Connecting the Dot",
                "data_type"  => "product",
                "section"    => "carvep",
                "quota"      => 150,
                "marker"     => "symposium-carvep",
                "slug"       => "symposium-carvep",
                "date_start" => "2025-02-22 08:00:00",
                "date_end"   => "2025-02-22 16:00:00",
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
                        "name"       => "Plenary Lecture",
                        "title"      => "Healthy Aging and Longevity: How CVD Prevention Prevails",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "bambang.irawan",
                        "image"      => "/carvep/plennary_lecture.jpeg",
                        "marker"     => "symposium-carvep-a",
                        "slug"       => "symposium-carvep-a0",
                        "date_start" => "2025-02-22 09:15:00",
                        "date_end"   => "2025-02-22 10:45:00",
                        "children"   => [
                            [
                                "name"       => "Plenary Lecture I",
                                "title"      => "Healthy Aging and Longevity: How CVD Prevention Prevails",
                                "data_type"  => "schedule-detail",
                                "section"    => "carvep",
                                "speakers"   => "salvatore.disomma",
                                "marker"     => "symposium-carvep-a0",
                                "slug"       => "symposium-carvep-a0-1",
                                "date_start" => "2025-02-22 09:15:00",
                                "date_end"   => "2025-02-22 10:45:00",
                            ],
                        ],
                    ],
                    [
                        "name"       => "Morning Symposium",
                        "title"      => "Dyslipidemia Management for CVD Prevention: Reaching Lipid Target by Novel Armamentarium",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "hariadi.hariawan",
                        "image"      => "/carvep/sympo_1.jpeg",
                        "marker"     => "symposium-carvep-a",
                        "slug"       => "symposium-carvep-a1",
                        "date_start" => "2025-02-22 09:15:00",
                        "date_end"   => "2025-02-22 10:45:00",
                        "children"   => [
                            [
                                "name"       => "Morning Symposium I",
                                "title"      => "Exploring the Pharmacology of PCSK9 Inhibition: Novel Approach for CVD Prevention",
                                "data_type"  => "schedule-detail",
                                "section"    => "carvep",
                                "speakers"   => "budi.yuli",
                                "marker"     => "symposium-carvep-a1",
                                "slug"       => "symposium-carvep-a1-1",
                                "date_start" => "2025-02-22 10:45:00",
                                "date_end"   => "2025-02-22 11:40:00",
                            ],
                            [
                                "name"       => "Morning Symposium II",
                                "title"      => "How PCSK9 Inhibition Revolutionize CVD Prevention: Breakthrough in Clinical Trials",
                                "data_type"  => "schedule-detail",
                                "section"    => "carvep",
                                "speakers"   => "anggoro.budi",
                                "marker"     => "symposium-carvep-a1",
                                "slug"       => "symposium-carvep-a1-2",
                                "date_start" => "2025-02-22 09:15:00",
                                "date_end"   => "2025-02-22 10:45:00",
                            ],
                        ],
                    ],
                    [
                        "name"       => "Lunch Symposium 1",
                        "title"      => "Cardiovascular-Kidney-Metabolic Syndrome as Part of CVD Prevention: Current Evidence",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "monika.putri",
                        "image"      => "/carvep/sympo_2.jpeg",
                        "marker"     => "symposium-carvep-a",
                        "slug"       => "symposium-carvep-a2",
                        "date_start" => "2025-02-22 11:00:00",
                        "date_end"   => "2025-02-22 12:15:00",
                        "children"   => [
                            [
                                "name"       => "Lunch Symposium I",
                                "title"      => "Comprehensive Approach of Cardiovascular-Kidney-Metabolic (CKM) Syndrome: What Do Current Guidelines Say?",
                                "data_type"  => "schedule-detail",
                                "section"    => "carvep",
                                "speakers"   => "lucia.kris",
                                "marker"     => "symposium-carvep-a2",
                                "slug"       => "symposium-carvep-a2-1",
                                "date_start" => "2025-02-22 11:00:00",
                                "date_end"   => "2025-02-22 12:15:00",
                            ],
                            [
                                "name"       => "Morning Symposium II",
                                "title"      => "CVD Prevention through Optimizing CKM Syndrome Management: Integrating GLP1-RA, Semaglutide.",
                                "data_type"  => "schedule-detail",
                                "section"    => "carvep",
                                "speakers"   => "irsad.andi",
                                "marker"     => "symposium-carvep-a2",
                                "slug"       => "symposium-carvep-a2-2",
                                "date_start" => "2025-02-22 11:00:00",
                                "date_end"   => "2025-02-22 12:15:00",
                            ],
                            [
                                "name"       => "Morning Symposium III",
                                "title"      => "Practical Approach of Using GLP1-RA, Semaglutide, in Clinical Practice: Ensuring CVD Prevention Fruitful",
                                "data_type"  => "schedule-detail",
                                "section"    => "carvep",
                                "speakers"   => "nyoman.wiryawan",
                                "marker"     => "symposium-carvep-a2",
                                "slug"       => "symposium-carvep-a2-3",
                                "date_start" => "2025-02-22 11:00:00",
                                "date_end"   => "2025-02-22 12:15:00",
                            ],
                        ],
                    ],
                    [
                        "name"       => "Lunch Symposium 2",
                        "title"      => "Glycemic and Lipid Controls: Achieving Goals for CVD Prevention",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "muhammad.afies",
                        "image"      => "/carvep/sympo_3.jpeg",
                        "marker"     => "symposium-carvep-a",
                        "slug"       => "symposium-carvep-a3",
                        "date_start" => "2025-02-22 13:15:00",
                        "date_end"   => "2025-02-22 14:10:00",
                        "children"   => [
                            [
                                "name"       => "Lunch Symposium IV",
                                "title"      => "Safeguarding CVD Prevention beyond Glycemic Control: Fitting in SGLT2 inhibitor, Dapagliflozin.",
                                "data_type"  => "schedule-detail",
                                "section"    => "carvep",
                                "speakers"   => "irsad.andi",
                                "marker"     => "symposium-carvep-a3",
                                "slug"       => "symposium-carvep-a3-1",
                                "date_start" => "2025-02-22 13:15:00",
                                "date_end"   => "2025-02-22 14:10:00",
                            ],
                            [
                                "name"       => "Morning Symposium V",
                                "title"      => "Statin, Lipid Control, and CVD Prevention: Endless Connection",
                                "data_type"  => "schedule-detail",
                                "section"    => "carvep",
                                "speakers"   => "taufik.ismail",
                                "marker"     => "symposium-carvep-a3",
                                "slug"       => "symposium-carvep-a3-2",
                                "date_start" => "2025-02-22 13:15:00",
                                "date_end"   => "2025-02-22 14:10:00",
                            ],
                        ],
                    ],
                    [
                        "name"       => "Afternoon Symposium",
                        "title"      => "Populational Study and Epidemiology: Not to be Forgotten in CVD Prevention",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "hasanah.mumpuni",
                        "image"      => "/carvep/sympo_4.jpeg",
                        "marker"     => "symposium-carvep-a",
                        "slug"       => "symposium-carvep-a4",
                        "date_start" => "2025-02-22 14:10:00",
                        "date_end"   => "2025-02-22 15:05:00",
                        "children"   => [
                            [
                                "name"       => "Lunch Symposium IV",
                                "title"      => "Epidemiology Study in the Elderly to Identify Factors for Longevity: Lesson from the Cilento on Aging Outcome Study (CIAO) Study",
                                "data_type"  => "schedule-detail",
                                "section"    => "carvep",
                                "speakers"   => "salvatore.disomma",
                                "marker"     => "symposium-carvep-a4",
                                "slug"       => "symposium-carvep-a4-1",
                                "date_start" => "2025-02-22 14:10:00",
                                "date_end"   => "2025-02-22 15:05:00",
                            ],
                            [
                                "name"       => "Morning Symposium V",
                                "title"      => "Regional Populational Longitudinal Survey to Study CVD Occurrence and Its Risk Factors: Nested Study of Sleman Health and Demographic Surveillance System (HDSS)",
                                "data_type"  => "schedule-detail",
                                "section"    => "carvep",
                                "speakers"   => "anggoro.budi",
                                "marker"     => "symposium-carvep-a4",
                                "slug"       => "symposium-carvep-a4-2",
                                "date_start" => "2025-02-22 14:10:00",
                                "date_end"   => "2025-02-22 15:05:00",
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
            ["job_type_code" => "DRSP", "price" => 300000,],
            ["job_type_code" => "DRGN", "price" => 300000,],
        ];

        return [
            [
                "name"       => "Cardio-Pulmonary Exercise Test for Specialist",
                "title"      => "",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "carvep",
                "quota"      => "40",
                "image"      => "/carvep/workshop.jpeg",
                "marker"     => "workshop-carvep",
                "slug"       => "workshop-carvep-1",
                "date_start" => "2025-02-23 08:00:00",
                "date_end"   => "2025-02-23 12:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop CPET Session 1",
                        "title"      => "Indikasi pemeriksaan CPET: pasien atau individu sehat",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "nyoman.wiryawan",
                        "marker"     => "workshop-carvep-1",
                        "slug"       => "workshop-carvep-1-1",
                        "date_start" => "2025-02-23 08:00:00",
                        "date_end"   => "2025-02-23 12:00:00",
                    ],
                    [
                        "name"       => "Workshop CPET Session 2",
                        "title"      => "Best practice dalam CPET: Pemilihan, persiapan dan pelaksanaan protokol CPET",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "basuni.radi",
                        "marker"     => "workshop-carvep-1",
                        "slug"       => "workshop-carvep-1-2",
                        "date_start" => "2025-02-23 08:00:00",
                        "date_end"   => "2025-02-23 12:00:00",
                    ],
                    [
                        "name"       => "Workshop CPET Session 3",
                        "title"      => "Pendekatan komprehensif dalam Interpretasi CPET",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "basuni.radi",
                        "marker"     => "workshop-carvep-1",
                        "slug"       => "workshop-carvep-1-3",
                        "date_start" => "2025-02-23 08:00:00",
                        "date_end"   => "2025-02-23 12:00:00",
                    ],
                ],
                "has_price"  => 1,
                "prices"     => $ws_price,
            ],
            [
                "name"       => "Ambulatory Blood Pressure Monitoring (ABPM) for General Practitioner",
                "title"      => "",
                "subtitle"   => "",
                "data_type"  => "product",
                "section"    => "carvep",
                "quota"      => "40",
                "image"      => "/carvep/workshop.jpeg",
                "marker"     => "workshop-carvep",
                "slug"       => "workshop-carvep-2",
                "date_start" => "2025-02-23 08:00:00",
                "date_end"   => "2025-02-23 12:00:00",
                "children"   => [
                    [
                        "name"       => "Workshop ABPM Session 1",
                        "title"      => "Indikasi pemeriksaan ABPM: Bagaimana memberi manfaat kepada pasien yang tepat",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "monika.putri",
                        "marker"     => "workshop-carvep-2",
                        "slug"       => "workshop-carvep-2-1",
                        "date_start" => "2025-02-23 08:00:00",
                        "date_end"   => "2025-02-23 12:00:00",
                    ],
                    [
                        "name"       => "Workshop ABPM Session 2",
                        "title"      => "Pelaksanaan ABPM: Bagaimana persiapan, pelaksanaan protokol dan best practice",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "moh.afis",
                        "marker"     => "workshop-carvep-2",
                        "slug"       => "workshop-carvep-2-2",
                        "date_start" => "2025-02-23 08:00:00",
                        "date_end"   => "2025-02-23 12:00:00",
                    ],
                    [
                        "name"       => "Workshop ABPM Session 3",
                        "title"      => "Interpretasi ABPM: Bagaimana pendekatan komprehensif interpretasi ABPM",
                        "data_type"  => "schedule",
                        "section"    => "carvep",
                        "speakers"   => "anggoro.budi",
                        "marker"     => "workshop-carvep-2",
                        "slug"       => "workshop-carvep-2-3",
                        "date_start" => "2025-02-23 08:00:00",
                        "date_end"   => "2025-02-23 12:00:00",
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
                            "section"       => 'carvep',
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

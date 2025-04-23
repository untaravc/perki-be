<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function banner(Request $request)
    {
        switch ($request->ref) {
            case 'cvep':
                return $this->bannerCvep();
            case '2024':
                return $this->banner2024();
            case '2023':
                return $this->banner2023();
            case 'jfu':
                return $this->bannerJfu();
        }
    }

    public function bannerJfu()
    {
        $data = [
            [
                "title"   => "Jogja Foot Ulcer Meeting 2025",
                "subtitle" => "In conjunction with basic to advanced doppler workshop",
                "date"    => "Yogyakarta, 29th May 2025",
                "poster"  => 'https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FJFU25%2Fposter_jfu_01.webp?alt=media&token=8f767a1b-6d13-4746-a4cf-0d3917543950',
                "buttons" => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ],
            [
                "title"     => "Basic to Advanced Doppler Workshop",
                "subtitle"  => "Tracing the Flow: From Basics to Mastery in Cardiovascular Doppler",
                "date"      => "Yogyakarta, 30th May 2025",
                "poster"    => '',
                "buttons"   => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ],
        ];

        $this->response['result'] = $data;
        return $this->response;
    }

    public function bannerCvep()
    {
        $data = [
            [
                "title"   => "Jogja Cardiovascular Epidemiology and Prevention Forum 2025",
                // "subtitle" => "Join us to master advanced cardiac care and vascular diagnostics for better patient outcomes! ",
                "date"    => "Yogyakarta, 22nd & 23rd February 2025",
                "poster"  => '/carvep/carvep-first.jpeg',
                "buttons" => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ],
        ];

        $this->response['result'] = $data;
        return $this->response;
    }

    public function banner2024()
    {
        $data = [
            [
                "title"    => "Welcome Message",
                "subtitle" => "Join us to master advanced cardiac care and vascular diagnostics for better patient outcomes! ",
                "date"     => "Yogyakarta, 18th October 2024",
                "poster"   => '/assets24/posters/welcome_msg.jpeg',
                "buttons"  => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ],
            [
                "title"    => "Jogja Cardiology Update Workshop",
                "subtitle" => "Join us to master advanced cardiac care and vascular diagnostics for better patient outcomes! ",
                "date"     => "Yogyakarta, 18th October 2024",
                "poster"   => '/assets24/posters/jcu24_day1.jpeg',
                "buttons"  => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ],
            [
                "title"    => "Jogja Cardiology Update Symposium",
                "subtitle" => "Artificial Intelligence in Transdisciplinary Cardiovascular Care: The Future is Now",
                "date"     => "Yogyakarta, 19th October 2024",
                "poster"   => '/assets24/posters/jcu24_day2.jpeg',
                "buttons"  => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ],
            [
                "title"    => "Jogja International Cardiovascular Topic Series",
                "subtitle" => "Advance Care in Hearth Failure and Pulmonary Hypertension",
                "date"     => "Yogyakarta, 20th October 2024",
                "poster"   => '/assets24/posters/jcu24_day3.jpeg',
                "buttons"  => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ],
        ];

        $this->response['result'] = $data;
        return $this->response;
    }

    public function banner2023()
    {
        $data = [
            [
                "title"    => "Jogja Cardiology Update",
                "subtitle" => "Integrating Technology In Cardiovascular Disease Management: Towards A Harmonic Fusion",
                "date"     => "Yogyakarta, 1-3 September 2023",
                "poster"   => '/assets/posters/1st_announ.png',
                "buttons"  => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ],
            [
                "title"    => "Call for Abstracts",
                "subtitle" => "For Cardiologist, Resident, GP, Medical Student, and Researcher",
                "date"     => "Submit before: August 7th 2023",
                "poster"   => '/assets/posters/extended_poster_7ags23.jpg',
                "buttons"  => [
                    [
                        "theme" => "dark",
                        "text"  => "Submit Now",
                        "link"  => "/abstracts",
                    ]
                ]
            ],
            [
                "title"    => "The Sixth JINCARTOS",
                "subtitle" => "Jogja International Cardiovascular Topic Series: Scientific Breakthrough in Hearth Rhythm Disorder",
                "date"     => "12 Symposium & 8 Workshop",
                "poster"   => '/assets/posters/1st_announ.png',
                "buttons"  => [
                    [
                        "theme" => "light",
                        "text"  => "Schedule",
                        "link"  => "/#schedule",
                    ],
                    [
                        "theme" => "dark",
                        "text"  => "Register",
                        "link"  => "/register",
                    ]
                ]
            ]
        ];

        $this->response['result'] = $data;
        return $this->response;
    }
}

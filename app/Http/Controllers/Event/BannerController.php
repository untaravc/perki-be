<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function banner(Request $request)
    {
        if ($request->ref == 2024) {
            return $this->banner2024();
        } else {
            return $this->banner2023();
        }
    }

    public function banner2024()
    {
        $data = [
            [
                "title"    => "Jogja Cardiology Update",
                "subtitle" => "Artificial Intelligence in Transdisciplinary Cardiovascular Care: The Future is Now",
                "date"     => "Yogyakarta, October 2024",
                // "poster"   => '/assets24/posters/1st_announcement.jpeg',
                "poster"   => null,
                "buttons"  => [
                    // [
                    //     "theme" => "light",
                    //     "text"  => "Schedule",
                    //     "link"  => "/#schedule",
                    // ],
                    // [
                    //     "theme" => "dark",
                    //     "text"  => "Register",
                    //     "link"  => "/register",
                    // ]
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

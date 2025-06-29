<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public function guidance(Request $request)
    {
        if($request->section === 'jcu25'){
            return $this->guidance2025();
        }
        if ($request->ref == 2024) {
            return $this->guidance2024();
        } else {
            return $this->guidance2023();
        }
    }

    public function plataran()
    {
        $data = [];
        $data[] = [
            "title" => "Plataran Sehat Registration",
            "image" => "https://src.perki-jogja.com/assets/posters/TUTORIAL_AKTIVASI_PLATARAN_SEHAT.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/TUTORIAL_AKTIVASI_PLATARAN_SEHAT.pdf",
        ];

        $this->response['result'] = $data;
        return $this->response;
    }

    public function guidance2024()
    {
        $data = [];
        $data[] = [
            "title" => "Plataran Sehat",
            "image" => "https://src.perki-jogja.com/assets/posters/TUTORIAL_AKTIVASI_PLATARAN_SEHAT.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/TUTORIAL_AKTIVASI_PLATARAN_SEHAT.pdf",
        ];

        $data[] = [
            "title" => "First Announcement",
            "image" => "https://src.perki-jogja.com/assets24/posters/1st_announcement.jpg",
            "link"  => "https://src.perki-jogja.com/assets24/posters/1st_announcement.pdf",
        ];

        $data[] = [
            "title" => "Booklet Final Announcement",
            "image" => "https://src.perki-jogja.com/assets24/posters/jcu24_day1.jpeg",
            "link"  => "https://drive.google.com/drive/folders/1MpB9O3-l9RXHHbEzsaW6UWfrYxAO0Cvr?usp=drive_link",
        ];

        $this->response['result'] = $data;
        return $this->response;
    }

    public function guidance2023()
    {
        $data = [];
        $data[] = [
            "title" => "Final Announcement",
            "image" => "https://src.perki-jogja.com/assets/posters/ANNOUNCMNT_JCU_2023_1.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/ANNOUNCMNT_JCU_2023_1.pdf",
        ];
        $data[] = [
            "title" => "Jincartos",
            "image" => "https://src.perki-jogja.com/assets/posters/JINCARTOS_1.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/JINCARTOS_1.pdf",
        ];
        $data[] = [
            "title" => "Symposium Day 1",
            "image" => "https://src.perki-jogja.com/assets/posters/SYMPO_DAY_1_1.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/SYMPO_DAY_1_1.pdf",
        ];
        $data[] = [
            "title" => "Symposium Day 2",
            "image" => "https://src.perki-jogja.com/assets/posters/SYMPO_DAY_2_1.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/SYMPO_DAY_2_1.pdf",
        ];

        $this->response['result'] = $data;
        return $this->response;
    }

    public function guidance2025(){
        $data = [];
        $data[] = [
            "title" => "ECG Championship",
            "image" => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FJCU25%2Fecg-timeline.jpeg?alt=media&token=d1a5728c-cbed-418a-8793-7c4127f72f89",
            "link"  => "https://jcu.perki-jogja.com/ecg-championship-info",
        ];

        $data[] = [
            "title" => "ECG Championship",
            "image" => "https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2FJCU25%2Fcall_abstract.jpeg?alt=media&token=8466da9c-4f9b-4fdf-9916-b3cf6a2a2d97",
            "link"  => "https://jcu.perki-jogja.com/abstracts",
        ];

        $this->response['result'] = $data;
        return $this->response;
    }
}

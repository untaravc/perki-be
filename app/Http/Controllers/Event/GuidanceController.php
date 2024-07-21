<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    public function guidance(Request $request)
    {
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
            "title" => "Plataran Sehat",
            "image" => "https://src.perki-jogja.com/assets/posters/TUTORIAL_AKTIVASI_PLATARAN_SEHAT.png",
            "link"  => "https://src.perki-jogja.com/assets/posters/TUTORIAL_AKTIVASI_PLATARAN_SEHAT.pdf",
        ];

        $this->response['result'] = $data;
        return $this->response;
    }

    public function guidance2024()
    {
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
}

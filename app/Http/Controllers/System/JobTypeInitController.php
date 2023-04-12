<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobTypeInitController extends Controller
{
    public function job_type_init(){
        $data = [
            [
                "name" => "Mahasiswa",
                "code" => "MHSA",
            ],
            [
                "name" => "Coas",
                "code" => "COAS",
            ],
            [
                "name" => "Internship",
                "code" => "ITRS",
            ],
            [
                "name" => "Residen",
                "code" => "RSDN",
            ],
            [
                "name" => "Dokter Umum",
                "code" => "DRGN",
            ],
            [
                "name" => "Dokter Spesialis",
                "code" => "DRSP",
            ],
            [
                "name" => "Perawat",
                "code" => "NURS",
            ],
            [
                "name" => "Tenaga Medis",
                "code" => "TMDS",
            ],
        ];

        foreach ($data as $item){
            $job_type = JobType::whereCode($item['code'])->first();

            if($job_type){
                $job_type->update($item);
            } else {
                JobType::create($item);
            }
        }
    }
}

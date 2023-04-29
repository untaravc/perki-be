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
                "name" => "Medical student",
                "code" => "MHSA",
            ],
            [
                "name" => "Co-ass",
                "code" => "COAS",
            ],
            [
                "name" => "Internship",
                "code" => "ITRS",
            ],
            [
                "name" => "Residency",
                "code" => "RSDN",
            ],
            [
                "name" => "General Practitioner",
                "code" => "DRGN",
            ],
            [
                "name" => "Specialist",
                "code" => "DRSP",
            ],
            [
                "name" => "Nurse",
                "code" => "NURS",
            ],
            [
                "name" => "Other Healthcare Provider",
                "code" => "OTHR",
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

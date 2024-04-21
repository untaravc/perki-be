<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SponsorController extends Controller
{

    public function sponsor_slider(Request $request)
    {
        if ($request->ref == 2024) {
            return $this->sponsor_slider2024();
        } else {
            return $this->sponsor_slider2023();
        }
    }

    public function sponsor_slider2024()
    {
        $sponsors = [
            ["image" => "zp.png"],
        ];

        for ($i = 0; $i < count($sponsors); $i++) {
            $sponsors[$i]['image'] = env('APP_URL') . 'assets/logo/sponsors/' . $sponsors[$i]['image'];
        }

        $this->response['result'] = $sponsors;
        return $this->response;
    }

    public function sponsor_slider2023()
    {
        $sponsors = [
            ["image" => "abbott.png"],
            ["image" => "bayer.png"],
            ["image" => "biofarma.png"],
            ["image" => "biolitec.png"],
            ["image" => "biosensor.png"],
            ["image" => "bts.png"],
            ["image" => "feron.png"],
            ["image" => "idsmed.png"],
            ["image" => "indosopha.png"],
            ["image" => "kalbe.png"],
            ["image" => "merck.png"],
            ["image" => "msa.png"],
            ["image" => "novartis.png"],
            ["image" => "otsuka.png"],
            ["image" => "pfizer.png"],
            ["image" => "pharmasolindo.png"],
            ["image" => "philips.png"],
            ["image" => "rum.png"],
            ["image" => "sanofi.png"],
            ["image" => "servier.png"],
            ["image" => "tanabe.png"],
            ["image" => "zp.png"],
        ];

        for ($i = 0; $i < count($sponsors); $i++) {
            $sponsors[$i]['image'] = env('APP_URL') . '/assets/logo/sponsors/' . $sponsors[$i]['image'];
        }

        $this->response['result'] = $sponsors;
        return $this->response;
    }
}

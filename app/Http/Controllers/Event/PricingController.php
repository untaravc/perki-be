<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function pricing(Request $request)
    {
        if ($request->ref == 2024) {
            return $this->pricing2024();
        } else {
            return $this->pricing2023();
        }
    }
    private function pricing2024()
    {
        $platinum_desc = "<ul>
            <li>Morning Workshop: Friday, Oct 18th 2024 (08.00-11.00)</li>
            <li>Afternoon Workshop: Friday, Oct 18th 2024 (13.00-16.00)</li>
            <li>Symposium: Saturday, Oct 19th 2024 (08.00-16.00) - Sunday, Oct 20rd 2024 (08.00-16.00)</li>
        </ul>";

        $gold_desc = "<ul>
            <li>Morning Workshop: Friday, Oct 18th 2024 (08.00-11.00)</li>
            <li>Afternoon Workshop: Friday, Oct 18th 2024 (13.00-16.00)</li>
            <li>Symposium: Saturday, Oct 19th 2024 (08.00-16.00) - Sunday, Oct 20rd 2024 (08.00-16.00)</li>
        </ul>";

        $bronze_desc = "<ul>
            <li>Symposium: Saturday, Oct 19th 2024 (08.00-16.00) - Sunday, Oct 20rd 2024 (08.00-16.00)</li>
        </ul>";

        $data["platinum"] = [
            "name"          => "Specialist",
            "desc"          => $platinum_desc,
            "price_drgn"    => 2000000,
            // "price_drgn_eb" => 2000000,
            "price_drsp"    => 3500000,
            "price_drsp_eb" => 5000000, // harga corek
        ];

        $data["gold"] = [
            "name"       => "General Practitioner",
            "desc"       => $gold_desc,
            "price_drgn"    => 1000000,
            // "price_drgn_eb" => 2000000,
            "price_drsp"    => 1750000,
            "price_drsp_eb" => 2500000, // harga corek
        ];

        $data["bronze"] = [
            "name"          => "Medical Student",
            "desc"          => $bronze_desc,
            "price_drgn"    => 750000,
            // "price_drgn_eb" => 2000000,
            // "price_drsp"    => 1500000,
            // "price_drsp_eb" => 2250000, // harga corek
        ];

        $this->response['result'] = $data;
        return $this->response;
    }
    private function pricing2023()
    {
        $platinum_desc = "<ul>
            <li>Morning Workshop: Friday, Sep 1st 2023 (08.00-11.30)</li>
            <li>Afternoon Workshop: Friday, Sep 1st 2023 (13.00-15.30)</li>
            <li>Symposium: Saturday, Sept 2nd 2023 (08.00-15.30) - Sunday, Sept 3rd 2023 (08.00-15.30)</li>
        </ul>";

        $gold_desc = "<ul>
            <li>Symposium: Saturday, Sept 2nd 2023 (08.00-15.30) - Sunday, Sept 3rd 2023 (08.00-15.30)</li>
        </ul>";

        $bronze_desc = "<ul>
            <li>Workshop: Friday, Sep 1st 2023 (08.00-11.30) or (13.00-15.30)</li>
        </ul>";

        $data["platinum"] = [
            "name"          => "Platinum",
            "desc"          => $platinum_desc,
            "price_drgn"    => 2250000,
            "price_drgn_eb" => 2000000,
            "price_drsp"    => 3250000,
            "price_drsp_eb" => 3000000,
        ];

        $data["gold"] = [
            "name"       => "Gold",
            "desc"       => $gold_desc,
            "price_drsp" => 1500000,
            "price_drgn" => 1000000,
            "price_stdn" => 500000,
        ];

        $data["bronze"] = [
            "name"          => "Silver",
            "desc"          => $bronze_desc,
            "price_drgn"    => 750000,
            "price_drgn_eb" => 0,
            "price_drsp"    => 1000000,
            "price_drsp_eb" => 0,
        ];

        $this->response['result'] = $data;
        return $this->response;
    }
}

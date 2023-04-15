<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Event;
use App\Models\JobType;
use App\Models\Price;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function speakers(Request $request)
    {
        $data = User::orderBy('name')
            ->where('is_speaker', 1)
            ->select('id', 'name', 'desc', 'image')
            ->get();

        $this->sendGetResponse($data);
    }

    public function job_types()
    {
        $data = JobType::get();
        $this->sendGetResponse($data);
    }
}

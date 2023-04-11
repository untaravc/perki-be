<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class DataInitController extends BaseController
{
    public function init()
    {
        $speakers = new SpeakerInitController();
        $speakers->init_speaker();

        $user = new UserInitController();
        $user->user_init();

        $job_type = new JobTypeInitController();
        $job_type->job_type_init();

        $event = new EventInitController();
        return $event->event_init();

        return $this->response;
    }


}

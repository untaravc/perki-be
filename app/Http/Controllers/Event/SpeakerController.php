<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\BaseController;
use App\Models\Event;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Http\Request;

class SpeakerController extends BaseController
{
    public function speakers(Request $request)
    {
        $slugs = Event::whereSection('jcu24')
            ->pluck('speakers')
            ->toArray();
        $user_slugs = array_unique($slugs);

        $speakers = User::where('is_speaker', 1)
            ->whereIn('slug', $user_slugs)
            ->when($request->limit, function ($q) use ($request) {
                $q->limit($request->limit);
            })
            ->inRandomOrder()
            ->select('id', 'name', 'desc', 'image')
            ->get();

        $this->sendGetResponse($speakers);
    }
}

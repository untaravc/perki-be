<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\BaseController;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Http\Request;

class SpeakerController extends BaseController
{
    public function speakers(Request $request)
    {
        $ids = [];

        if ($request->ref == 2024) {
            $refs = Reference::whereReference($request->ref)
                ->whereModel('user')
                ->get();
            $ids = $refs->pluck('model_id')->toArray();
        }


        $data = User::where('is_speaker', 1)
            ->when($request->limit, function ($q) use ($request) {
                $q->limit($request->limit);
            })
            ->inRandomOrder()
            ->select('id', 'name', 'desc', 'image')
            ->when(count($ids) > 0, function($q) use ($ids){
                $q->whereIn('id', $ids);
            })
            ->get();

        $this->sendGetResponse($data);
    }
}

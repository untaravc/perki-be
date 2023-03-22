<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function speakers(Request $request)
    {
        $data = User::orderBy('user_name')
            ->where('user_is_speaker', 1)
            ->select('user_id', 'user_name', 'user_desc', 'user_image')
            ->get();

        return $this->sendResponse(200, $data);
    }
}

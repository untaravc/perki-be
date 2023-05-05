<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Post;
use Dotenv\Validator;
use Illuminate\Http\Request;

class AbstractController extends BaseController
{
    public function abstract_list(Request $request){
        $user = $request->user();

        $data = Post::whereUserId($user['id'])
            ->whereCategory('abstract')
            ->get();

        $this->sendGetResponse($data);
    }

    public function abstract_submit(Request $request){
//        $validator = Validator::make($request->)
    }
}

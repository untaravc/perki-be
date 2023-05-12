<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbstractController extends BaseController
{
    public function abstract_list(Request $request)
    {
        $user = $request->user();

        $data = Post::whereUserId($user['id'])
            ->whereCategory('abstract')
            ->get();

        $this->sendGetResponse($data);
    }

    public function abstract_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'file'     => 'required',
            'body'     => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            $this->sendError(422, $validator->errors()->first(), $validator->errors());
        }

        $payload = [
            "user_id"  => $request->user() ? $request->user()['id'] : null,
            "title"    => $request->title,
            "category" => $request->category,
            "file"     => $request->file,
            "body"  => $request->body,
            "status"   => 0,
        ];

        Post::create($payload);

        $this->sendPostResponse();
    }
}

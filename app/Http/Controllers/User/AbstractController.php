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
            ->whereIn('category', ['research', 'case_report'])
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
            'subtitle' => 'required',
        ], [
            'body.required'     => 'The abstract field is required.',
            'subtitle.required' => 'The author(s) field is required.',
        ]);

        if ($validator->fails()) {
            $this->sendError(422, $validator->errors()->first(), $validator->errors());
        }

        $payload = [
            "user_id"  => $request->user() ? $request->user()['id'] : null,
            "title"    => $request->title,
            "category" => $request->category,
            "file"     => $request->file,
            "body"     => $request->body,
            "subtitle" => $request->subtitle,
            "status"   => 0,
        ];

        Post::create($payload);

        $this->sendPostResponse();
    }

    public function abstract_update(Request $request, $id)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'file'     => 'required',
            'body'     => 'required',
            'category' => 'required',
            'subtitle' => 'required',
        ], [
            'body.required'     => 'The abstract field is required.',
            'subtitle.required' => 'The author(s) field is required.',
        ]);

        if ($validator->fails()) {
            $this->sendError(422, $validator->errors()->first(), $validator->errors());
        }

        $payload = [
            "title"    => $request->title,
            "category" => $request->category,
            "file"     => $request->file,
            "body"     => $request->body,
            "subtitle" => $request->subtitle,
        ];

        $post = Post::whereUserId($user['id'])
            ->find($id);

        if ($post) {
            $post->update($payload);
        }

        $this->sendPostResponse();
    }

    public function abstract_delete(Request $request, $id){
        $user = $request->user();
        $post = Post::whereUserId($user['id'])
            ->find($id);

        if ($post) {
            $post->delete();
        }

        $this->sendDeleteResponse();
    }
}

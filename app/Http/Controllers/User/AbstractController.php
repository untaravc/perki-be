<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Models\Post;
use App\Models\PostAuthor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbstractController extends BaseController
{
    public function abstract_list(Request $request)
    {
        $user = $request->user();

        $data = Post::whereUserId($user['id'])
            ->whereIn('category', ['research', 'case_report', 'systematic_review'])
            ->with('authors')
            ->get();

        $this->sendGetResponse($data);
    }

    private function toJsonBody($request)
    {
        $data = [];
        if (isset($request->body_background)) {
            $data['body_background'] = $request->body_background;
        }

        if (isset($request->body_aim)) {
            $data['body_aim'] = $request->body_aim;
        }

        if (isset($request->body_method)) {
            $data['body_method'] = $request->body_method;
        }

        if (isset($request->body_results)) {
            $data['body_results'] = $request->body_results;
        }

        if (isset($request->body_conclusions)) {
            $data['body_conclusions'] = $request->body_conclusions;
        }

        return json_encode($data);
    }

    public function abstract_submit(Request $request)
    {
        $request->merge([
            'body' => $this->toJsonBody($request),
        ]);

        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'file'     => 'nullable',
            'body'     => 'required',
            'category' => 'required',
            'subtitle' => 'required',
            'authors'  => 'required',
        ], [
            'body.required'     => 'The abstract field is required.',
            'subtitle.required' => 'The keywords field is required.',
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

        $post = Post::create($payload);

        $authors = $request->authors;

        if (count($authors) > 0) {
            $this->insert_authors($authors, $post);
        }

        $this->sendPostResponse();
    }

    public function abstract_update(Request $request, $id)
    {
        $request->merge([
            'body' => $this->toJsonBody($request),
        ]);

        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'file'     => 'nullable',
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

        $authors = $request->authors;

        if (count($authors) > 0) {
            $this->insert_authors($authors, $post);
        }

        $this->sendPostResponse();
    }

    public function abstract_delete(Request $request, $id)
    {
        $user = $request->user();
        $post = Post::whereUserId($user['id'])
            ->find($id);

        if ($post) {
            $post->delete();
        }

        $this->sendDeleteResponse();
    }

    public function insert_authors($authors, Post $post)
    {
        $ids = [];
        foreach ($authors as $author) {
            $payload = [
                "post_id"     => $post->id,
                "status"      => 1,
                "title"       => $author['title'] ?? null,
                "first_name"  => $author['first_name'] ?? null,
                "surname"     => $author['surname'] ?? null,
                "institution" => $author['institution'] ?? null,
                "email"       => $author['email'] ?? null,
                "type"        => $author['type'] ?? null,
            ];

            $post_author = PostAuthor::wherePostId($post->id)
                ->whereEmail($author['email'])
                ->first();

            if (!$post_author) {
                $post_author = PostAuthor::create($payload);
            } else {
                $post_author->update($payload);
            }

            $ids[] = $post_author->id;
        }

        // delete non used
        PostAuthor::whereNotIn('id', $ids)->delete();
    }
}

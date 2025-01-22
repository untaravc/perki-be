<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\System\EmailServiceController;
use App\Models\Post;
use App\Models\PostAuthor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class AbstractController extends BaseController
{
    public function abstract_list(Request $request)
    {
        $user = $request->user();

        $data = Post::whereUserId($user['id'])
            ->whereIn('category', [
                'research',
                'case_report',
                'systematic_review',
                'meta_analysis',
            ])
            ->when($request->ref, function ($q) use ($request) {
                $q->whereYear('created_at', $request->ref);
            })
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
            'body' => json_encode($request->body),
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

    public function abstract_poster(Request $request, $id)
    {
        $post = Post::find($id);

        if ($post) {
            $post->update([
                'image' => $request->image
            ]);
        }

        $this->sendPostResponse();
    }

    public function abstract_update(Request $request, $id)
    {
        //        $this->sendPostResponse();

        $request->merge([
            'body' => json_encode($request->body),
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
                "post_id"          => $post->id,
                "status"           => 1,
                "title"            => $author['title'] ?? null,
                "first_name"       => $author['first_name'] ?? null,
                "surname"          => $author['surname'] ?? null,
                "institution"      => $author['institution'] ?? null,
                "email"            => $author['email'] ?? null,
                "type"             => $author['type'] ?? null,
                "is_presenter"     => $author['is_presenter'] ?? false,
                "is_corresponding" => $author['is_corresponding'] ?? false,
            ];

            $post_author = null;
            if (isset($author['id'])) {
                $post_author = PostAuthor::find($author['id']);
            }

            if (!$post_author) {
                $post_author = PostAuthor::create($payload);
            } else {
                $post_author->update($payload);
            }

            $ids[] = $post_author->id;
        }

        // delete non used
        PostAuthor::whereNotIn('id', $ids)
            ->wherePostId($post->id)
            ->delete();
    }

    public function abstract_submit_open()
    {
        $this->sendGetResponse([
            'open' => false
        ]);
    }

    public function accepted_notification()
    {
        $posts = Post::with('user')
            ->whereDate('created_at', '>', '2024-06-01')
            ->where('status', 1)
            ->where('comment', null)
            ->limit(50)
            ->get();

        foreach ($posts as $post) {
            $email_service = new EmailServiceController();
            $email_service->accepted_post($post);

            $post->update(['comment' => "notified"]);
        }

        return 'done';
    }
}

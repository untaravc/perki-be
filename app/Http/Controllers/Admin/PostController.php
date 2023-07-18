<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $data_content = Post::orderByDesc('id')->with('user');
        $data_content = $this->withFilter($data_content, $request);
        $data_content = $data_content->paginate($request->per_page ?? 25);

        $collect = collect($this->response);
        return $collect->merge($data_content);
    }

    public function withFilter($data_content, $request)
    {
        if ($request->s) {
            $data_content = $data_content->where('title', 'LIKE', '%' . $request->s . '%');
        }

        if ($request->type == 'abstract') {
            $data_content = $data_content->whereIn('category', [
                'case_report',
                'research',
                'systematic_review',
            ]);
        }

        if ($request->category) {
            $data_content = $data_content->where('category', $request->category);
        }

        return $data_content;
    }

    public function printPost(Request $request)
    {
        $data_content = Post::orderByDesc('id')
            ->with(['user', 'authors'])
            ->whereDate('created_at', '>', '2023-07-07')
            ->when($request->category, function ($q) use ($request) {
                $q->where('category', $request->category);
            })->when($request->post_id, function ($q) use ($request) {
                $q->where('id', $request->post_id);
            })
            ->whereIn('category', [
                'case_report',
                'research',
                'systematic_review',
            ])->get();

        $type = $request->type ?? 'review'; // full_text

        if ($request->json == 1) {
            return $data_content;
        }

        return view('print.posts.abstracts', compact('data_content', 'type'));
    }
}

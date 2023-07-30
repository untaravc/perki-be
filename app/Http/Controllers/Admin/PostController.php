<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $auth = $request->user();
        $type = $auth['type'];

        $data_content = Post::orderByDesc('id')
            ->when($type === 'reviewer', function ($q) use ($auth) {
                $q->where('reviewer_id', $auth['id']);
            })->with('user');
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
                'meta_analysis',
            ]);
        }

        if ($request->category) {
            $data_content = $data_content->where('category', $request->category);
        }

        if ($request->status !== null) {
            $data_content = $data_content->where('status', $request->status);
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

    public function stats(Request $request)
    {
        $auth = $request->user();
        $type = $auth['type'];

        $data['pending'] = Post::whereIn('category', [
            'case_report',
            'research',
            'systematic_review',
            'meta_analysis',
        ])->when($type === 'reviewer', function ($q) use ($auth) {
            $q->where('reviewer_id', $auth['id']);
        })->where('status', 0)
            ->count();

        $data['accept'] = Post::whereIn('category', [
            'case_report',
            'research',
            'systematic_review',
            'meta_analysis',
        ])->when($type === 'reviewer', function ($q) use ($auth) {
            $q->where('reviewer_id', $auth['id']);
        })->where('status', 1)
            ->count();

        $data['reject'] = Post::whereIn('category', [
            'case_report',
            'research',
            'systematic_review',
            'meta_analysis',
        ])->when($type === 'reviewer', function ($q) use ($auth) {
            $q->where('reviewer_id', $auth['id']);
        })->where('status', 2)
            ->count();

        $this->response['result'] = $data;
        return $this->response;
    }

    public function reviewer_list(){
        $ids = [1];
        $data = User::whereIn('id', $ids)
            ->orderBy('name')
            ->get();

        $this->response['result'] = $data;
        return $this->response;
    }

    public function set_reviewer(Request $request, $post_id){
        $data = Post::find($post_id);

        if($data){
            $data->update([
                'reviewer_id' => $request->reviewer_id
            ]);
        }

        return $this->response;
    }
}

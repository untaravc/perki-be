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
}

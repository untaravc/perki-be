<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Score;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $data_content = Post::orderByDesc('id')
            // ->when($type === 'reviewer', function ($q) use ($auth) {
            //     $q->where('reviewer_id', $auth['id']);
            // })
            ->with(['user', 'scores' => function ($q) {
                $q->with('user');
            }]);
        $data_content = $this->withFilter($data_content, $request);
        $data_content = $data_content->paginate($request->per_page ?? 25);

        if ($request->with_transaction == 1) {
            $user_ids = $data_content->pluck('user_id');

            $transaction_details = TransactionDetail::whereIn('user_id', $user_ids)
                ->with('transaction')
                ->where('event_id', 1)
                ->get();

            foreach ($data_content as $data) {
                $trx = $transaction_details->where('user_id', $data->user_id)->first();
                $data->setAttribute('transaction', $trx);
            }
        }

        $collect = collect($this->response);
        return $collect->merge($data_content);
    }

    public function update($id, Request $request)
    {
        $data = Post::find($id);
        $auth = $request->user();

        if ($data) {
            $score = Score::wherePostId($id)
                ->whereUserId($auth['id'])
                ->first();

            if ($score) {
                $score->update([
                    'first_score' => $request->scores['first_score'],
                    'second_score' => $request->scores['second_score'],
                    'third_score' => $request->scores['third_score'],
                    'fourth_score' => $request->scores['fourth_score'],
                    'fifth_score' => $request->scores['fifth_score'],
                    'sixth_score' => $request->scores['sixth_score'],
                    'seventh_score' => $request->scores['seventh_score'],
                    'total' => $request->scores['first_score'] +
                        $request->scores['second_score'] +
                        $request->scores['third_score'] +
                        $request->scores['fourth_score'] +
                        $request->scores['fifth_score'] +
                        $request->scores['sixth_score'] +
                        $request->scores['seventh_score']
                ]);
            } else {
                Score::create([
                    'post_id' => $id,
                    'user_id' => $auth['id'],
                    'first_score' => $request->scores['first_score'],
                    'second_score' => $request->scores['second_score'],
                    'third_score' => $request->scores['third_score'],
                    'fourth_score' => $request->scores['fourth_score'],
                    'fifth_score' => $request->scores['fifth_score'],
                    'sixth_score' => $request->scores['sixth_score'],
                    'seventh_score' => $request->scores['seventh_score'],
                    'total' => $request->scores['first_score'] +
                        $request->scores['second_score'] +
                        $request->scores['third_score'] +
                        $request->scores['fourth_score'] +
                        $request->scores['fifth_score'] +
                        $request->scores['sixth_score'] +
                        $request->scores['seventh_score']
                ]);
            }

            $total = Score::wherePostId($id)->sum('total');

            $data->update([
                'comment' => $request->comment,
                'score' => $total,
                'status' => $request->status,
            ]);
        }

        return $this->response;
    }

    public function show(Request $request, $id)
    {
        $data = Post::find($id);

        $auth = $request->user();
        $score = Score::wherePostId($id)
            ->whereUserId($auth['id'])
            ->first();

        $data['scores'] = $score;

        $this->response['result'] = $data;
        return $this->response;
    }

    public function withFilter($data_content, $request)
    {
        if ($request->title) {
            $data_content = $data_content->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->type == 'abstract') {
            $data_content = $data_content->whereIn('category', [
                'case_report',
                'research',
                'systematic_review',
                'meta_analysis',
            ])->orderByDesc('score');
        }

        if ($request->category) {
            $data_content = $data_content->where('category', $request->category);
        }

        if ($request->year) {
            $data_content = $data_content->whereYear('created_at', $request->year);
        }

        if ($request->status !== null) {
            $data_content = $data_content->where('status', $request->status);
        }

        return $data_content;
    }

    public function printPost(Request $request)
    {
        $data_content = Post::with(['user', 'authors'])
            // ->groupBy('user_id')
            ->whereDate('created_at', '>', '2024-01-01')
            ->when($request->category, function ($q) use ($request) {
                $q->where('category', $request->category);
            })->when($request->post_id, function ($q) use ($request) {
                $q->where('id', $request->post_id);
            })->when($request->ref, function ($q) use ($request) {
                $q->whereYear('created_at', $request->ref);
            })
            ->whereIn('category', [
                'case_report',
                'research',
                'systematic_review',
                'meta_analysis',
            ])->get()->sortBy('user.name');

        $type = $request->type ?? 'review'; // full_text

        if ($request->json == 1) {
            return $data_content;
        }

        $users = [];
        if ($request->user_name == 1) {
            foreach ($data_content as $item) {
                $users[] = $item['user']['name'];
            }
        }
        //        return $users;

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

    public function reviewer_list()
    {
        $data = User::whereType('reviewer')
            ->orderBy('name')
            ->get();

        $this->response['result'] = $data;
        return $this->response;
    }

    public function set_reviewer(Request $request, $post_id)
    {
        $data = Post::find($post_id);

        if ($data) {
            $data->update([
                'reviewer_id' => $request->reviewer_id
            ]);
        }

        return $this->response;
    }

    public function post_review(Request $request, $post_id)
    {
        $post = Post::find($post_id);

        if ($post) {
            $post->update([
                'status' => $request->status,
                'score' => $request->score,
                'comment' => $request->comment,
            ]);
        }

        return $this->response;
    }

    public function previewAbstract(Request $request)
    {
        $data_content = Post::with([
            'user' => function ($q) {
                $q->with('voucher_code', 'success_transactions');
            },
            'authors',
            'scores'
        ])
            ->when($request->category, function ($q) use ($request) {
                $q->where('category', $request->category);
            })
            ->when($request->post_id, function ($q) use ($request) {
                $q->where('id', $request->post_id);
            })
            ->when($request->ref, function ($q) use ($request) {
                $q->whereYear('created_at', $request->ref);
            })
            ->whereIn('category', [
                'case_report',
                'research',
                'systematic_review',
                'meta_analysis',
            ])
            ->orderBy('category')->get();

        return view('print.posts.abstract_preview', compact('data_content'));
    }
}

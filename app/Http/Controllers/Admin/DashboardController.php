<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\GuestLog;
use App\Models\Post;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function statistics()
    {
        $exclude_user_ids = exclude_user_ids();
        $data['transaction_success'] = Transaction::where('status', '>=', 200)
            ->whereSection('carvep')
            ->whereNotIn('user_id', $exclude_user_ids)
            ->where('status', '<', 300)->count();

        $data['transaction_success_nominal'] = Transaction::where('status', '>=', 200)
            ->whereSection('carvep')
            ->whereNotIn('user_id', $exclude_user_ids)
            ->where('status', '<', 300)->sum('total');

        $data['member'] = User::where('is_speaker', '!==', 1)
            ->whereDate('updated_at', '>', '2025-01-01')
            ->count();

        $data['transaction_pending'] = Transaction::where('status', '<', 200)
            ->where('status', '>=', 110)
            ->whereSection('carvep')
            ->whereNotIn('user_id', $exclude_user_ids)
            ->count();

        $data['member_purchase'] = User::where('is_speaker', '!==', 1)
            ->whereHas('success_transactions')
            ->whereNotIn('id', $exclude_user_ids)
            ->count();

        $this->response['result']['stat'] = $data;
        return $this->response;
    }

    public function chart()
    {
        $default_diff = 30;
        $params['date_end'] = $request->end ?? date('Y-m-d');
        $params['date_start'] = $request->start ?? date('Y-m-d', strtotime($params['date_end'] . '-' . $default_diff . ' days'));

        $datediff = strtotime($params['date_end']) - strtotime($params['date_start']);

        $diff_day = round($datediff / (60 * 60 * 24));

        $date = strtotime($params['date_end'] . '+1 day');
        $period = new \DatePeriod(
            new \DateTime(date("Y-m-d", strtotime("-" . $diff_day . " days", $date))),
            new \DateInterval('P1D'),
            new \DateTime(date('Y-m-d', $date))
        );

        $array = [];
        $i = 1;
        foreach ($period as $value) {
            $array[$i]['date'] = $value->format('Y-m-d');
            $array[$i]['count'] = 0;
            $i++;
        }

        $paid = Transaction::where('created_at', '>=', $params['date_start'])
            ->whereDate('created_at', '<=', $params['date_end'])
            ->whereStatus(200)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get(array(
                DB::raw("Date(created_at) as date"),
                DB::raw("COUNT(*) as 'total'"),
            ));

        $pending = Transaction::where('created_at', '>=', $params['date_start'])
            ->whereDate('created_at', '<=', $params['date_end'])
            ->where('status', '<=', 110)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get(array(
                DB::raw("Date(created_at) as date"),
                DB::raw("COUNT(*) as 'total'"),
            ));

        $visitors = GuestLog::where('date', '>=', $params['date_start'])
            ->where('date', '<=', $params['date_end'])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get(array(
                DB::raw("date"),
                DB::raw("COUNT(*) as 'total'"),
            ));

        $trx_day_total = Transaction::where('created_at', '>=', $params['date_start'])
            ->where('created_at', '<=', $params['date_end'])
            ->sum('total');

        for ($i = 1; $i <= count($array); $i++) {
            foreach ($paid as $pd) {
                if (date('Y-m-d', strtotime($pd['date'])) === $array[$i]['date']) {
                    $array[$i]['paid'] = $pd['total'];
                }
            }
        }

        for ($i = 1; $i <= count($array); $i++) {
            foreach ($pending as $pnd) {
                if (date('Y-m-d', strtotime($pnd['date'])) === $array[$i]['date']) {
                    $array[$i]['pending'] = $pnd['total'];
                }
            }
        }

        for ($i = 1; $i <= count($array); $i++) {
            foreach ($visitors as $visitor) {
                if (date('Y-m-d', strtotime($visitor['date'])) === $array[$i]['date']) {
                    $array[$i]['visitor'] = $visitor['total'];
                }
            }
        }

        for ($i = 1; $i <= count($array); $i++) {
            if (!isset($array[$i]['visitor'])) {
                $array[$i]['visitor'] = 0;
            }
            if (!isset($array[$i]['paid'])) {
                $array[$i]['paid'] = 0;
            }

            if (!isset($array[$i]['pending'])) {
                $array[$i]['pending'] = 0;
            }
        }

        $this->response['result'] = $array;
        $this->response['total'] = $trx_day_total;
        return $this->response;
    }

    public function event_purchase()
    {
        $events = Event::whereDataType('product')
            ->where('status', 1)
            ->whereSection('carvep')
            ->orderBy('name')
            ->select(
                'id',
                'name',
                'title',
                'quota',
                'slug',
            )->withCount([
                'transaction_success',
                'transaction_success_std',
                'transaction_success_gp',
                'transaction_success_sp',
                'transaction_pending',
            ])->get();

        $this->response['result'] = $events;
        return $this->response;
    }

    public function user_stat()
    {
        $abstracts = Post::whereIn('category', [
            'case_report',
            'research',
            'systematic_review',
            'meta_analysis',
        ])->select('category', DB::raw('count(*) as total'))
            ->whereSection('carvep')
            ->groupBy('category')
            ->get();

        $abstract_status = Post::whereIn('category', [
            'case_report',
            'research',
            'systematic_review',
            'meta_analysis',
        ])->select('status', DB::raw('count(*) as total'))
            ->whereSection('carvep')
            ->groupBy('status')
            ->get();

        $this->response['result'] = [
            "abstract_categories"   => $this->abstract_category($abstracts),
            "abstract_status"       => $this->abstract_status($abstract_status),
        ];

        return $this->response;
    }

    private function abstract_status($data)
    {
        $pending = collect($data)->where('status', 0)->first();
        $accepted = collect($data)->where('status', 1)->first();
        $rejected = collect($data)->where('status', 2)->first();
        $moderated = collect($data)->where('status', 3)->first();
        $result = [
            'pending' => $pending ? $pending['total'] : 0,
            'accepted' => $accepted ? $accepted['total'] : 0,
            'rejected' => $rejected ? $rejected['total'] : 0,
            'moderated' => $moderated ? $moderated['total'] : 0,
        ];

        return $result;
    }

    private function abstract_category($data)
    {
        $case_report = collect($data)->where('category', 'case_report')->first();
        $research = collect($data)->where('category', 'research')->first();
        $meta_analysis = collect($data)->where('category', 'meta_analysis')->first();
        $systematic_review = collect($data)->where('category', 'systematic_review')->first();
        $result = [
            'case_report' => $case_report ? $case_report['total'] : 0,
            'research' => $research ? $research['total'] : 0,
            'meta_analysis' => $meta_analysis ? $meta_analysis['total'] : 0,
            'systematic_review' => $systematic_review ? $systematic_review['total'] : 0,
        ];

        return $result;
    }

    public function sidebar_label()
    {
        $data['transactions'] = Transaction::whereStatus(120)->count();

        $this->response['result'] = $data;
        return $this->response;
    }
}

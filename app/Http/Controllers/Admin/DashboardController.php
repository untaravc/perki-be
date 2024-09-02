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
            ->whereSection('jcu24')
            ->whereNotIn('user_id', $exclude_user_ids)
            ->where('status', '<', 300)->count();

        $data['transaction_success_nominal'] = Transaction::where('status', '>=', 200)
            ->whereSection('jcu24')
            ->whereNotIn('user_id', $exclude_user_ids)
            ->where('status', '<', 300)->sum('total');

        $data['member'] = User::where('is_speaker', '!==', 1)
            ->whereYear('updated_at', '2024')
            ->count();

        $data['transaction_pending'] = Transaction::where('status', '<=', 200)
            ->whereSection('jcu24')
            ->whereNotIn('user_id', $exclude_user_ids)
            ->count();

        $data['transaction_pending'] = Transaction::where('status', '<=', 200)
            ->whereSection('jcu24')
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

        $trx_day = Transaction::where('created_at', '>=', $params['date_start'])
            ->whereDate('created_at', '<=', $params['date_end'])
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
            foreach ($trx_day as $trx) {
                if (date('Y-m-d', strtotime($trx['date'])) === $array[$i]['date']) {
                    $array[$i]['count'] = $trx['total'];
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
            if (!isset($array[$i]['count'])) {
                $array[$i]['count'] = 0;
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
            ->whereSection('jcu24')
            ->orderBy('name')
            ->select(
                'id',
                'name',
                'title',
                'quota',
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
        // $user['register'] = User::where('is_speaker', 0)
        //     ->whereType('user')
        //     ->whereYear('updated_at',  )
        //     ->count();
        // $user['register_paid'] = User::whereHas('success_transactions')->count();

        // $user_job_type = User::select('job_type_code', DB::raw('count(*) as total'))
        //     ->whereHas('success_transactions')
        //     ->groupBy('job_type_code')
        //     ->get();

        $abstracts = Post::whereIn('category', [
            'case_report',
            'research',
            'systematic_review',
            'meta_analysis',
        ])->select('category', DB::raw('count(*) as total'))
            ->whereYear('created_at', 2024)
            ->groupBy('category')
            ->get();

        $abstract_status = Post::whereIn('category', [
            'case_report',
            'research',
            'systematic_review',
            'meta_analysis',
        ])->select('status', DB::raw('count(*) as total'))
            ->whereYear('created_at', 2024)
            ->groupBy('status')
            ->get();

        $this->response['result'] = [
            // "users"     => $user,
            "abstract_status" => $this->abstract_status($abstract_status),
        ];

        return $this->response;
    }

    private function abstract_status($data)
    {
        $pending = collect($data)->where('status', 0)->first();
        $accepted = collect($data)->where('status', 1)->first();
        $rejected = collect($data)->where('status', 2)->first();
        $result = [
            'pending' => $pending ? $pending['total'] : 0,
            'accepted' => $accepted ? $accepted['total'] : 0,
            'rejected' => $rejected ? $rejected['total'] : 0,
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

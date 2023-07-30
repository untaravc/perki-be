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
        $data['transaction_success'] = Transaction::where('status', '>=', 200)->where('status', '<', 300)->count();
        $data['transaction_success_nominal'] = Transaction::where('status', '>=', 200)->where('status', '<', 300)->sum('total');

        $data['member'] = User::where('is_speaker', '!==', 1)->count();
        $data['member_purchase'] = User::where('is_speaker', '!==', 1)
            ->whereHas('success_transactions')
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
            ->where('created_at', '<', $params['date_end'])
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
            ->where('created_at', '<', $params['date_end'])
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

        $this->response['result'] = $array;
        $this->response['total'] = $trx_day_total;
        return $this->response;
    }

    public function event_purchase()
    {
        $events = Event::whereDataType('product')
            ->where('status', 1)
            ->orderBy('name')
            ->select(
                'id',
                'name',
                'title',
            )
            ->withCount([
                'transaction_success',
                'transaction_success_std',
                'transaction_success_gp',
                'transaction_success_sp',
            ])
            ->get();

        $this->response['result'] = $events;
        return $this->response;
    }

    public function user_stat()
    {
        $user['register'] = User::where('is_speaker', 0)->whereType('user')->count();
        $user['register_paid'] = User::whereHas('success_transactions')->count();

        $user_job_type = User::select('job_type_code', DB::raw('count(*) as total'))
            ->whereHas('success_transactions')
            ->groupBy('job_type_code')
            ->get();

        $abstracts = Post::whereIn('category', [
            'case_report',
            'research',
            'systematic_review',
            'meta_analysis',
        ])->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get();

        $this->response['result'] = [
            "users"     => $user,
            "abstracts" => $abstracts,
            "type_code" => $user_job_type,
        ];

        return $this->response;
    }

    public function sidebar_label()
    {
        $data['transactions'] = Transaction::whereStatus(120)->count();

        $this->response['result'] = $data;
        return $this->response;
    }
}

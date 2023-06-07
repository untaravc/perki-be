<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function statistics(){
        $data['speakers'] = User::where('is_speaker', 1)->count();
        $data['member'] = User::where('is_speaker', '!==', 1)->count();
        $data['transaction_success'] = Transaction::where('status', '>=', 200)->where('status', '<',300)->count();
        $data['transaction_pending'] = Transaction::where('status', '>=', 100)->where('status', '<',200)->count();

        $member = User::where('job_type_code', '!=', null)
            ->select('job_type_code', DB::raw('count(*) as total'))
            ->groupBy('job_type_code')
            ->get();

        $this->response['result']['stat'] = $data;
        $this->response['result']['member'] = $member;
        return $this->response;
    }

    public function chart(){
        $default_diff = 30;
        $params['date_end'] = $request->end ?? date('Y-m-d');
        $params['date_start'] = $request->start ?? date('Y-m-d', strtotime($params['date_end'] . '-' . $default_diff . ' days'));

        $datediff = strtotime($params['date_end']) - strtotime($params['date_start']);

        $diff_day = round($datediff / (60 * 60 * 24));

        $date = strtotime( $params['date_end'] . '+1 day');
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

        $this->response['result'] = $array;
        $this->response['total'] = $trx_day_total;
        return $this->response;
    }
}

<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Dachoagit\GoogleKeywordView\Models\Proxy;
use Dachoagit\Search\Models\LogProxy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

/**
 * Class LogProxyStatusChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LogProxyStatusChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();


        $data = LogProxy::where('proxy_id', request()->route('id'))
            ->orderBy('created_at', 'asc')
            ->get();



        $this->chart->title('Biểu đồ thông kê chất lượng Proxy');

        $this->chart->load(backpack_url('charts/log-proxy-status'));



        $date_start = Request()->get('date_start');
        $date_end = Request()->get('date_end');

        // $proxies = LogProxy::when($date_start && $date_end, function ($query) use ($date_start, $date_end) {
        //     return $query->whereBetween('timestamps', [$date_start, $date_end]);
        // })->get()->groupBy('proxy_id');

        $total_count = LogProxy::when($date_start && $date_end, function ($query) use ($date_start, $date_end) {
            return $query->whereBetween('created_at', [$date_start, $date_end]);
        })->count();

        $total_count_error = LogProxy::when($date_start && $date_end, function ($query) use ($date_start, $date_end) {
            return $query->whereBetween('created_at', [$date_start, $date_end]);
        })->where('status_code', '!=', 200)->count();
        $total = $total_count - $total_count_error;


        $logProxies = DB::table('log_proxies')
            ->when($date_start && $date_end, function ($query) use ($date_start, $date_end) {
                return $query->whereBetween('created_at', [$date_start, $date_end]);
            })
            ->select(
                'proxy_id',
                DB::raw('COUNT(*) as total_requests'),
                DB::raw('SUM(CASE WHEN status_code >= 200 AND status_code < 300 THEN 1 ELSE 0 END) as success_count'),
                DB::raw('SUM(CASE WHEN status_code < 200 AND status_code >= 400 AND status_code < 600 THEN 1 ELSE 0 END) as error_count')
            )
            ->groupBy('proxy_id')
            ->get();

        $arrayProxy = [];
        $percen = [];

        foreach ($logProxies as $each) {
            array_push($arrayProxy, Proxy::where('id', $each->proxy_id)->first()->proxy);
            $success_rate = (($each->success_count) / ($total)) * 100;
            array_push($percen, $success_rate);
        }

        $this->chart->labels($arrayProxy);

        
        // OPTIONAL.
        $this->chart->minimalist(true);
        $this->chart->displayLegend(true);

    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $date_start = Request()->get('date_start');
        $date_end = Request()->get('date_end');

        // $proxies = LogProxy::when($date_start && $date_end, function ($query) use ($date_start, $date_end) {
        //     return $query->whereBetween('timestamps', [$date_start, $date_end]);
        // })->get()->groupBy('proxy_id');

        $total_count = LogProxy::when($date_start && $date_end, function ($query) use ($date_start, $date_end) {
            return $query->whereBetween('created_at', [$date_start, $date_end]);
        })->count();

        $total_count_error = LogProxy::when($date_start && $date_end, function ($query) use ($date_start, $date_end) {
            return $query->whereBetween('created_at', [$date_start, $date_end]);
        })->where('status_code', '!=', 200)->count();

        $total = $total_count - $total_count_error;


        $logProxies = DB::table('log_proxies')
            ->when($date_start && $date_end, function ($query) use ($date_start, $date_end) {
                return $query->whereBetween('created_at', [$date_start, $date_end]);
            })
            ->select(
                'proxy_id',
                DB::raw('COUNT(*) as total_requests'),
                DB::raw('SUM(CASE WHEN status_code >= 200 AND status_code < 300 THEN 1 ELSE 0 END) as success_count'),
                DB::raw('SUM(CASE WHEN status_code < 200 AND status_code >= 400 AND status_code < 600 THEN 1 ELSE 0 END) as error_count')
            )
            ->groupBy('proxy_id')
            ->get();

        $arrayProxy = [];
        $success_rates = [];
        $error_rates = [];

        foreach ($logProxies as $each) {
            array_push($arrayProxy, Proxy::where('id', $each->proxy_id)->first()->proxy);
            $success_rate = (($each->success_count) / ($total)) * 100;
            $error_rate = (($each->error_count) / ($total)) * 100;
            array_push($success_rates, $success_rate);
            array_push($error_rates, $error_rate);
        }

        $this->chart->labels($arrayProxy);

        $this->chart->dataset('Success rate', 'line', $success_rates)
            ->color('rgb(77, 189, 116)')
            ->options([
                'tooltip' => [
                    'show' => true,
                    'fields' => ['id', 'value'],
                    'formatter' => 'function(value) { return value.y + " " + value.label; }',
                ]
            ])
            ->backgroundColor('rgba(77, 189, 116, 0.4)');

        $this->chart->dataset('Error rate', 'line', $error_rates)
            ->color('rgb(255,0,0)')
            ->backgroundColor('rgba(255,0,0,0.7)');

            
    }
}

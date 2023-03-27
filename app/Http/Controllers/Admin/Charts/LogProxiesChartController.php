<?php

namespace App\Http\Controllers\Admin\Charts;

use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Dachoagit\Search\Models\LogProxy;

/**
 * Class LogProxiesChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LogProxiesChartController extends ChartController
{
    private $id;
    protected $data;
    

    public function setup()
    {
        dd($this);
        $this->chart = new Chart();
        $this->id = request()->route('id');
        $data = LogProxy::where('proxy_id', request()->route('id'))
            ->orderBy('created_at', 'asc')
            ->get();

        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels(
            $data->pluck('created_at')->map(function ($created_at) {
                return \Carbon\Carbon::parse($created_at)->format('Y-m-d H:i:s'); // định dạng giống với DB
                // return \Carbon\Carbon::parse($created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'); // định dạng giờ chuẩn Việt Nam
            })
        );

        

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/log-proxies'));

        // OPTIONAL
        $this->chart->minimalist(false);
        $this->chart->displayLegend(true);
    }

    public function data()
    {


        $data = LogProxy::where('proxy_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $this->chart->dataset('status_code', 'line', $data->pluck('status_code'))
            ->fill(false)
            ->color('rgb(96, 92, 168)')
            ->backgroundColor('rgba(96, 92, 168, 0.4)');
    }
}

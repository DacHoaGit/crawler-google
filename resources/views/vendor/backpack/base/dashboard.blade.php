@extends(backpack_view('blank'))

@php
    $widgets['before_content'][] = [
        'type'        => 'jumbotron',
        'heading'     => trans('backpack::base.welcome'),
        'content'     => trans('backpack::base.use_sidebar'),
        'button_link' => backpack_url('logout'),
        'button_text' => trans('backpack::base.logout'),
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-sm-6 col-lg-2">
            <div class="card text-white bg-danger">
                <div class="card-body pb-0">

                    <div class="text-value">{{$searches['fail']}}</div>
                    <div>Xử lý Thất bại</div>
                </div>
                <div class="chart-wrapper mt-3 mx-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas class="chart chartjs-render-monitor" id="card-chart4" height="70" width="212" style="display: block; width: 212px; height: 70px;"></canvas>
                    <div id="card-chart4-tooltip" class="chartjs-tooltip top bottom" style="opacity: 0; left: 88.875px; top: 157.6px;"><div class="tooltip-header"><div class="tooltip-header-item">June</div></div><div class="tooltip-body"><div class="tooltip-body-item"><span class="tooltip-body-item-color" style="background-color: rgba(255, 255, 255, 0.2);"></span><span class="tooltip-body-item-label">My First dataset</span><span class="tooltip-body-item-value">12</span></div></div></div></div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-2">
            <div class="card text-white bg-success">
                <div class="card-body pb-0">

                    <div class="text-value">{{$searches['success']}}</div>
                    <div>Xử lý Thành Công</div>
                </div>
                <div class="chart-wrapper mt-3 mx-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas class="chart chartjs-render-monitor" id="card-chart4" height="70" width="212" style="display: block; width: 212px; height: 70px;"></canvas>
                    <div id="card-chart4-tooltip" class="chartjs-tooltip top bottom" style="opacity: 0; left: 88.875px; top: 157.6px;"><div class="tooltip-header"><div class="tooltip-header-item">June</div></div><div class="tooltip-body"><div class="tooltip-body-item"><span class="tooltip-body-item-color" style="background-color: rgba(255, 255, 255, 0.2);"></span><span class="tooltip-body-item-label">My First dataset</span><span class="tooltip-body-item-value">12</span></div></div></div></div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-2">
            <div class="card text-white bg-warning">
                <div class="card-body pb-0">

                    <div class="text-value">{{$searches['pending']}}</div>
                    <div>Chưa xử lý</div>
                </div>
                <div class="chart-wrapper mt-3 mx-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas class="chart chartjs-render-monitor" id="card-chart4" height="70" width="212" style="display: block; width: 212px; height: 70px;"></canvas>
                    <div id="card-chart4-tooltip" class="chartjs-tooltip top bottom" style="opacity: 0; left: 88.875px; top: 157.6px;"><div class="tooltip-header"><div class="tooltip-header-item">June</div></div><div class="tooltip-body"><div class="tooltip-body-item"><span class="tooltip-body-item-color" style="background-color: rgba(255, 255, 255, 0.2);"></span><span class="tooltip-body-item-label">My First dataset</span><span class="tooltip-body-item-value">12</span></div></div></div></div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-2">
            <div class="card text-info">
                <div class="card-body pb-0">

                    <div class="text-value">{{$searches['fail'] + $searches['success'] + $searches['pending']}}</div>
                    <div>Tổng Từ Khóa</div>
                </div>
                <div class="chart-wrapper mt-3 mx-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas class="chart chartjs-render-monitor" id="card-chart4" height="70" width="212" style="display: block; width: 212px; height: 70px;"></canvas>
                    <div id="card-chart4-tooltip" class="chartjs-tooltip top bottom" style="opacity: 0; left: 88.875px; top: 157.6px;"><div class="tooltip-header"><div class="tooltip-header-item">June</div></div><div class="tooltip-body"><div class="tooltip-body-item"><span class="tooltip-body-item-color" style="background-color: rgba(255, 255, 255, 0.2);"></span><span class="tooltip-body-item-label">My First dataset</span><span class="tooltip-body-item-value">12</span></div></div></div></div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-2">
            <div class="card text-success">
                <div class="card-body pb-0">

                    <div class="text-value">{{$searches['links']}}</div>
                    <div>Tổng Liên kết</div>
                </div>
                <div class="chart-wrapper mt-3 mx-3" style="height:70px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <canvas class="chart chartjs-render-monitor" id="card-chart4" height="70" width="212" style="display: block; width: 212px; height: 70px;"></canvas>
                    <div id="card-chart4-tooltip" class="chartjs-tooltip top bottom" style="opacity: 0; left: 88.875px; top: 157.6px;"><div class="tooltip-header"><div class="tooltip-header-item">June</div></div><div class="tooltip-body"><div class="tooltip-body-item"><span class="tooltip-body-item-color" style="background-color: rgba(255, 255, 255, 0.2);"></span><span class="tooltip-body-item-label">My First dataset</span><span class="tooltip-body-item-value">12</span></div></div></div></div>
            </div>
        </div>

    </div>
@endsection


<input type="text" name="daterange" value="" />

<div class="chart-container" style="position: relative; height:40vh; width:80vw">
    <canvas id="chartLogProxyStatus"></canvas>
</div>

<div class="row mt-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-info mb-2">
            <div class="card-body">
                <div class="text-value" id="total-log-success"></div>
                <div>Total Success</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar progress-log-success" role="progressbar" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <small class="text-muted total-log"></small>
            </div>

        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-error mb-2">
            <div class="card-body">
                <div class="text-value" id="total-log-error"></div>
                <div>Total Error</div>

                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar progress-log-error" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>

                <small class="text-muted total-log"></small>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@push('after_scripts')
    <script>
        
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                
            }, function(start, end, label) {
                
                var date_start = start.format('YYYY-MM-DD');
                var date_end = end.format('YYYY-MM-DD');
                
                renderChartLogProxyStatus(date_start, date_end);
                
                console.log("A new date selection was made: " + date_start + ' to ' + date_end);
            });
        });
        // renderChartLogProxyStatus();
        

        function renderChartLogProxyStatus(date_start = null, date_end = null) {


            if (window.myChart !== undefined) {
                // Nếu có, hủy bỏ biểu đồ cũ
                window.myChart.destroy();
            }


            const ctx = document.getElementById('chartLogProxyStatus');



            $.ajax({
                url: '{{ route('log-proxy-status') }}',
                data: {
                    date_start: date_start,
                    date_end: date_end
                },
                success: function(result) {


                    const successCounts = result.success_count;
                    const sumSuccessCounts = successCounts.reduce((acc, val) => acc + parseInt(val), 0);

                    const errorCounts = result.error_count;
                    const sumErrorCounts = errorCounts.reduce((acc, val) => acc + parseInt(val), 0);

                
                    
                    const progressSuccess = isNaN((sumSuccessCounts / (sumSuccessCounts + sumErrorCounts)) * 100) ? 0 : (sumSuccessCounts / (sumSuccessCounts + sumErrorCounts)) * 100;
                    const progressError = isNaN((sumErrorCounts / (sumSuccessCounts + sumErrorCounts)) * 100) ? 0 : (sumErrorCounts / (sumSuccessCounts + sumErrorCounts)) * 100;

                    $('.progress-log-success').width(progressSuccess + "%");
                    $('.progress-log-error').width(progressError+ "%");
                    $('#total-log-success').text(sumSuccessCounts);
                    $('#total-log-error').text(sumErrorCounts);
                    $('.total-log').text('Total Log: ' + (sumSuccessCounts + sumErrorCounts));


                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: result.proxies,
                            datasets: [{
                                    label: '# success rates',
                                    data: result.success_rates,
                                    borderWidth: 1,
                                }, {
                                    label: '# error rates',
                                    data: result.error_rates,
                                    borderWidth: 1,
                                },
                                {
                                    label: '# count success',
                                    data: result.success_count,
                                    borderWidth: 1,
                                },
                                {
                                    label: '# count errors',
                                    data: result.error_count,
                                    borderWidth: 1,
                                }
                            ]
                        },
                        options: {
                            interaction: {
                                intersect: false,
                                mode: 'index',
                            },


                            scales: {
                                x: {
                                    ticks: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true
                                }
                            },
                            onClick: (e) => {
                                const canvasPosition = Chart.helpers.getRelativePosition(e,
                                    myChart);

                                // Substitute the appropriate scale IDs
                                const dataX = myChart.scales.x.getValueForPixel(canvasPosition.x);
                                const dataY = myChart.scales.y.getValueForPixel(canvasPosition.y);

                                console.log(canvasPosition);
                            },



                        }
                    });

                    window.myChart = myChart;


                }
            });

        }
    </script>
@endpush

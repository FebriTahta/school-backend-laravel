@extends('be_layouts.be_master')


@section('content')
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 310px;
            max-width: 800px;
            margin: 1em auto;
        }

        #container {
            height: 400px;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>

    <div class="page has-sidebar-left height-full">
        <header class="blue accent-3 relative nav-sticky">
            <div class="container-fluid text-white">
                <div class="row p-t-b-10 ">
                    <div class="col">
                        <h4>
                            <i class="icon-box"></i>
                            Dashboard
                        </h4>
                    </div>
                </div>
                <div class="row">
                    <ul class="nav responsive-tab nav-material nav-material-white" id="v-pills-tab">
                        <li>
                            <a class="nav-link active" id="v-pills-1-tab" data-toggle="pill" href="#v-pills-1">
                                <i class="icon icon-home2"></i>Today</a>
                        </li>

                    </ul>

                </div>
            </div>
        </header>
        <div class="container-fluid relative animatedParent animateOnce">
            <div class="tab-content pb-3" id="v-pills-tabContent">
                <!--Today Tab Start-->
                <div class="tab-pane animated fadeInUpShort  active" id="v-pills-1">
                    <div class="row my-3">
                        <div class="col-md-4">
                            <div class="counter-box white r-5 p-3">
                                <div class="p-4">
                                    <div class="float-right">
                                        <span class="icon icon-stop-watch3 s-48"></span>
                                    </div>
                                    <div class="counter-title">Total User Online</div>
                                    <h5 id="total"></h5>
                                </div>
                                <div class="progress progress-xs r-0">
                                    <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="128"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <figure class="highcharts-figure">
                            <div id="container" style="height: 405px"></div>
                        </figure>
                    </div>
                    <div class="col-md-8">
                        <div class="card my-3 no-b ">
                            <div class="card-header white b-0 p-3">
                                <div class="card-handle">
                                    <a data-toggle="collapse" href="#salesCard" aria-expanded="false"
                                       aria-controls="salesCard">
                                        <i class="icon-menu"></i>
                                    </a>
                                </div>
                                <small class="card-subtitle mb-2 text-muted">Display the last 4 online user (proses kalkulasi data dalam 1 menit)</small>
                            </div>
                            <div class="collapse show" id="salesCard">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover earning-box">
                                            <thead class="bg-light">
                                            <tr>
                                                <th colspan="2">User</th>
                                                <th>Last Seen</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tabel-user">
                                            {{-- <tr>
                                                <td class="w-10">
                                                    <a href="panel-page-profile.html" class="avatar avatar-lg">
                                                        <img src="{{ asset('avatar.png') }}" alt="">
                                                    </a>
                                                </td>
                                                <td>
                                                    <h6>Sara Kamzoon</h6>
                                                    <small class="text-muted">Marketing Manager</small>
                                                </td>
                                                <td>25</td>
                                                <td>$250</td>
                                            </tr>
                                            </tbody> --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>


    <script>
        // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar
        // Create the chart
        
    </script>

    <script>
        $(document).ready(function () {
                $.ajax({
                    type: 'GET',
                    url: '/total-user-online',
                    success: function(response) {
                        let total = ''+response.data;
                        if (total.length == 1) {
                            $('#total').html('0'+total+' User');   
                        }else{
                            $('#total').html(total+' User');
                        }

                        console.log(response);

                        Highcharts.chart('container', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                align: 'left',
                                text: 'Realtime Online User'
                            },
                            subtitle: {
                                align: 'left',
                                text: 'keep online for 2 min'
                            },
                            accessibility: {
                                announceNewData: {
                                    enabled: true
                                }
                            },
                            xAxis: {
                                type: 'category'
                            },
                            yAxis: {
                                title: {
                                    text: 'Total online user'
                                }

                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: true,
                                        format: '{point.y:.0f}'
                                    }
                                }
                            },

                            tooltip: {
                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
                            },

                            series: [{
                                name: 'Browsers',
                                colorByPoint: true,
                                data: [{
                                        name: 'Online',
                                        y: response.data,
                                    },
                                    {
                                        name: 'Offline',
                                        y: response.offline,
                                    },
                                ]
                            }],
                        });
                    }
                });

                $.ajax({
                    type: 'GET',
                    url: '/last-4-online-user',
                    success: function(response) {
                        $.each(response.online, function(key, value) {
                            // $.each(response.online, function(key, value) {
                            //     $('.' + key).parents('a').remove();
                            // })

                            $("#tabel-user").append('<a id='+key+'><tr>'
                                +'<td class="w-10">'
                                    +'<img src="{{ asset('avatar.png') }}" alt="">'
                                +'</td>'
                                +'<td>'
                                    +'<h6'+value.username+'</h6>'
                                    +'<small class="text-muted">'+value.role+'</small>'
                                +'</td>'
                                    +'<td>'+response.last_seen[key]+'</td>'
                                +'<td>online</td>'
                            +'</tr></a>');
                        })
                    }
                });


            total_user_online();
            last_4_online_user();
            chart();
            
        })

        function total_user_online() {
            setInterval(function() {
                // your code goes here...
                $.ajax({
                    type: 'GET',
                    url: '/total-user-online',
                    success: function(response) {
                        let total = ''+response.data;
                        if (total.length == 1) {
                            $('#total').html('0'+total+' User');   
                        }else{
                            $('#total').html(total+' User');
                        }
                    }
                });
            }, 60 * 1000); // 60 * 1000 milsec
        }

        function chart() {
            setInterval(function() {
            $.ajax({
                    type: 'GET',
                    url: '/total-user-online',
                    success: function(response) {
                        let total = ''+response.data;
                        if (total.length == 1) {
                            $('#total').html('0'+total+' User');   
                        }else{
                            $('#total').html(total+' User');
                        }

                        console.log(response);

                        Highcharts.chart('container', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                align: 'left',
                                text: 'Realtime Online User'
                            },
                            subtitle: {
                                align: 'left',
                                text: 'keep online for 2 min'
                            },
                            accessibility: {
                                announceNewData: {
                                    enabled: true
                                }
                            },
                            xAxis: {
                                type: 'category'
                            },
                            yAxis: {
                                title: {
                                    text: 'Total online user'
                                }

                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: true,
                                        format: '{point.y:.0f}'
                                    }
                                }
                            },

                            tooltip: {
                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f}</b> of total<br/>'
                            },

                            series: [{
                                name: 'Browsers',
                                colorByPoint: true,
                                data: [{
                                        name: 'Online',
                                        y: response.data,
                                    },
                                    {
                                        name: 'Offline',
                                        y: response.offline,
                                    },
                                ]
                            }],
                        });
                    }
                });
            }, 30 * 1000); // 60 * 1000 milsec
        }

        function last_4_online_user() {
            setInterval(function() {
                $.ajax({
                    type: 'GET',
                    url: '/last-4-online-user',
                    success: function(response) {
                        $.each(response.online, function(key, value) {
                            // $.each(response.online, function(key, value) {
                            //     $('.' + key).parents('a').remove();
                            // })

                            $("#tabel-user").append('<a id='+key+'><tr>'
                                +'<td class="w-10">'
                                    +'<img src="{{ asset('avatar.png') }}" alt="">'
                                +'</td>'
                                +'<td>'
                                    +'<h6'+value.username+'</h6>'
                                    +'<small class="text-muted">'+value.role+'</small>'
                                +'</td>'
                                    +'<td>'+response.last_seen[key]+'</td>'
                                +'<td>online</td>'
                            +'</tr></a>');
                        })
                    }
                });
            }, 6000 * 1000); // 60 * 1000 milsec
        }

    </script>
@endsection

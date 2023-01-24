@extends('admin.master',['menu'=>'dashboard'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <!--    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li class="active-item">{{__('Dashboard')}}</li>
                </ul>
            </div>
        </div>
    </div>-->
    <!-- /breadcrumb -->

    <!-- Status -->
    <div class="dashboard-status">
        @include('admin.dashboard.dashboard_status')
    </div>

    <!-- user chart -->
    <div class="user-chart mt-0">
        <div class="row">
            <div class="col-xl-8">
                <div id="chart" class="card crypto-chart h-auto mb-4">
                    <div class="card-header pb-0 border-0 flex-wrap">
                        <div>
                            <div class="chart-title mb-3">
                                <h2 class="heading">Project Statistic</h2>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="round weekly" id="dzOldSeries">
                                    <div>
                                        <input type="checkbox" id="checkbox1" name="radio" value="weekly">
                                        <label for="checkbox1" class="checkmark"></label>
                                    </div>
                                    <div>
                                        <span>This Month</span>
                                        <h4 class="mb-0">1.982</h4>
                                    </div>
                                </div>
                                <div class="round" id="dzNewSeries">
                                    <div>
                                        <input type="checkbox" id="checkbox" name="radio" value="monthly">
                                        <label for="checkbox" class="checkmark"></label>
                                    </div>
                                    <div>
                                        <span>This Week</span>
                                        <h4 class="mb-0">1.345</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-static">
                            <div class="d-flex align-items-center mb-3 " style="gap: 1em">
                                <div class="dropdown bootstrap-select image-select default-select dashboard-select"
                                >
                                    <select class="image-select default-select dashboard-select"
                                            aria-label="Default">
                                        <option value="month">This Month</option>
                                        <option value="week">This Weeks</option>
                                        <option value="today">Today</option>
                                    </select>
                                    <button type="button" tabindex="-1" class="btn dropdown-toggle btn-light"
                                            data-bs-toggle="dropdown" role="combobox" aria-owns="bs-select-1"
                                            aria-haspopup="listbox" aria-expanded="false" title="This Month">
                                        <div class="filter-option">
                                            <div class="filter-option-inner">
                                                <div class="filter-option-inner-inner">This Month
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="dropdown-menu ">
                                        <div class="inner show" role="listbox" id="bs-select-1" tabindex="-1"
                                        >
                                            <ul class="dropdown-menu inner show" role="presentation"></ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown custom-dropdown">
                                    <div class="btn sharp btn-primary tp-btn" data-bs-toggle="dropdown"
                                         aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24">
                                            <path d="M12 20.275q-.85 0-1.475-.612-.625-.613-.625-1.488 0-.85.625-1.463Q11.15 16.1 12 16.1q.875 0 1.488.612.612.613.612 1.463 0 .875-.612 1.488-.613.612-1.488.612Zm0-6.175q-.85 0-1.475-.625Q9.9 12.85 9.9 12q0-.875.625-1.488Q11.15 9.9 12 9.9q.875 0 1.488.612.612.613.612 1.488 0 .85-.612 1.475-.613.625-1.488.625Zm0-6.2q-.85 0-1.475-.613Q9.9 6.675 9.9 5.825q0-.875.625-1.488.625-.612 1.475-.612.875 0 1.488.612.612.613.612 1.488 0 .85-.612 1.462Q12.875 7.9 12 7.9Z"/>
                                        </svg>
                                    </div>
                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                        <a class="dropdown-item active selected" href="javascript:void(0);">Option 1</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Option 2</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Option 3</a>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-content">
                                <div class="d-flex justify-content-between">
                                    <h6>Total</h6>
                                    <span class="pull-end">3.982</span>
                                </div>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-primary" style="width: 80%; height:	100%;"
                                         role="progressbar">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-2 custome-tooltip pb-0" style="position: relative;">
                        <div id="activity"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card h-auto">
                    <div class="card-header border-0 pb-1 ">
                        <div>
                            <h4 class="mb-0 fs-20 font-w600">Weekly Summary</h4>
                        </div>
                    </div>
                    <div class="card-body pb-0 pt-3 px-3 d-flex align-items-center flex-wrap"
                         style="position: relative;">
                        <div id="pieChart2" style="min-height: 112.8px;"></div>
                        <div class="weeklydata">
                            <div class=" d-flex align-items-center mb-2">
                                <svg class="mr-2" width="14" height="14" viewBox="0 0 14 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.000488281" width="14" height="14" rx="3" fill="#FF9F00"></rect>
                                </svg>
                                <h6 class="mb-0 fs-14 font-w400">Total Transactions</h6>
                                <span class="text-primary font-w700 ml-auto">50%</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <svg class="mr-2" width="14" height="14" viewBox="0 0 14 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.000488281" width="14" height="14" rx="3" fill="#FD5353"></rect>
                                </svg>
                                <h6 class="mb-0 fs-14 font-w400">Total Earning</h6>
                                <span class="text-primary font-w700 ml-auto">50%</span>
                            </div>
<!--                            <div class="d-flex align-items-center">
                                <svg class="mr-2" width="14" height="14" viewBox="0 0 14 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.000488281" width="14" height="14" rx="3" fill="#d5dfe7"></rect>
                                </svg>
                                <h6 class="mb-0 fs-14 font-w400">Unknown</h6>
                                <span class="text-primary font-w700 ml-auto">10%</span>
                            </div>-->
                        </div>

                        <div class="card-body pt-0 pb-0 px-3" style="position: relative;">
                            <div id="columnChart1" class="chartjs" style="min-height: 165px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="card">
                    <div class="card-body">
                        <div class="card-top">
                            <h4>{{__('Deposit')}}</h4>
                        </div>
                        <p class="subtitle">{{__('Current Year')}}</p>
                        <canvas id="depositChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-top">
                            <h4>{{__('Withdrawal')}}</h4>
                        </div>
                        <p class="subtitle">{{__('Current Year')}}</p>
                        <canvas id="withdrawalChart"></canvas>
                    </div>
                </div>
            </div>
        </div>-->
            <!-- /user chart -->
            <div class="user-management user-chart card bg-secondary">
                <div class="card-body">
                    <div class="card-top">
                        <h4>{{__('Pending Withdrawal')}}</h4>
                    </div>
                    <div class="table-area">
                        <div>
                            <table id="pending_withdrwall" class="table table-borderless custom-table display text-left"
                            >
                                <thead>
                                <tr>
                                    <th class="all">{{__('Type')}}</th>
                                    <th>{{__('Sender')}}</th>
                                    <th>{{__('Address')}}</th>
                                    <th>{{__('Receiver')}}</th>
                                    <th>{{__('Amount')}}</th>
                                    <th class="all">{{__('Coin Type')}}</th>
                                    <th>{{__('Fees')}}</th>
                                    <th>{{__('Transaction Id')}}</th>
                                    <th>{{__('Update Date')}}</th>
                                    <th class="all">{{__('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /user chart -->

            @endsection

            @section('script')
                <script src="{{asset('assets/common/chart/chart.min.js')}}"></script>
                <script>
                    (function ($) {
                        "use strict";
                       /* var ctx = document.getElementById('depositChart').getContext("2d")
                        var depositChart = new Chart(ctx, {
                            type: 'line',
                            yaxisname: "Monthly Deposit",

                            data: {
                                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                datasets: [{
                                    label: "Monthly Deposit",
                                    borderColor: "#3C39AB",
                                    pointBorderColor: "#3C39AB",
                                    pointBackgroundColor: "#3C39AB",
                                    pointHoverBackgroundColor: "#3C39AB",
                                    pointHoverBorderColor: "#D1D1D1",
                                    pointBorderWidth: 4,
                                    pointHoverRadius: 2,
                                    pointHoverBorderWidth: 1,
                                    pointRadius: 3,
                                    fill: false,
                                    borderWidth: 3,
                                    data: {!! json_encode($monthly_deposit) !!}
                                }]
                            },
                            options: {
                                legend: {
                                    position: "bottom",
                                    display: true,
                                    labels: {
                                        fontColor: '#928F8F'
                                    }
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            fontColor: "#928F8F",
                                            fontStyle: "bold",
                                            beginAtZero: true,
                                            // maxTicksLimit: 5,
                                            padding: 20
                                        },
                                        gridLines: {
                                            drawTicks: false,
                                            display: false
                                        }
                                    }],
                                    xAxes: [{
                                        gridLines: {
                                            zeroLineColor: "transparent",
                                            drawTicks: false,
                                            display: false
                                        },
                                        ticks: {
                                            padding: 20,
                                            fontColor: "#928F8F",
                                            fontStyle: "bold"
                                        }
                                    }]
                                }
                            }
                        });

                        var ctx = document.getElementById('withdrawalChart').getContext("2d");
                        var withdrawalChart = new Chart(ctx, {
                            type: 'line',
                            yaxisname: "Monthly Withdrawal",

                            data: {
                                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                datasets: [{
                                    label: "Monthly Withdrawal",
                                    borderColor: "#2696FD",
                                    pointBorderColor: "#2696FD",
                                    pointBackgroundColor: "#2696FD",
                                    pointHoverBackgroundColor: "#2696FD",
                                    pointHoverBorderColor: "#D1D1D1",
                                    pointBorderWidth: 4,
                                    pointHoverRadius: 2,
                                    pointHoverBorderWidth: 1,
                                    pointRadius: 3,
                                    fill: false,
                                    borderWidth: 3,
                                    data: {!! json_encode($monthly_withdrawal) !!}
                                }]
                            },
                            options: {
                                legend: {
                                    position: "bottom",
                                    display: true,
                                    labels: {
                                        fontColor: '#928F8F'
                                    }
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            fontColor: "#928F8F",
                                            fontStyle: "bold",
                                            beginAtZero: true,
                                            // maxTicksLimit: 5,
                                            // padding: 20,
                                            // max: 1000
                                        },
                                        gridLines: {
                                            drawTicks: false,
                                            display: false
                                        }
                                    }],
                                    xAxes: [{
                                        gridLines: {
                                            zeroLineColor: "transparent",
                                            drawTicks: true,
                                            display: false
                                        },
                                        ticks: {
                                            // padding: 20,
                                            fontColor: "#928F8F",
                                            fontStyle: "bold",
                                            // max: 10000,
                                            autoSkip: false
                                        }
                                    }]
                                }
                            }
                        });*/

                        var chartList = function () {
                            var activity = function () {
                                var optionsArea = {
                                    series: [{
                                        name: "Withdraw",
                                        data: [60, 70, 80, 50, 60, 90]
                                    },
                                        {
                                            name: "Deposit",
                                            data: [40, 50, 40, 60, 90, 90]
                                        }
                                    ],
                                    chart: {
                                        height: 300,
                                        type: 'area',
                                        group: 'social',
                                        toolbar: {
                                            show: false
                                        },
                                        zoom: {
                                            enabled: false
                                        },
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        width: [3, 3, 3],
                                        colors: ['var(--secondary)', 'var(--primary)'],
                                        curve: 'straight'
                                    },
                                    legend: {
                                        show: false,
                                        tooltipHoverFormatter: function (val, opts) {
                                            return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
                                        },
                                        markers: {
                                            fillColors: ['var(--secondary)', 'var(--primary)'],
                                            width: 10,
                                            height: 10,
                                            strokeWidth: 0,
                                            radius: 16
                                        }
                                    },
                                    markers: {
                                        size: [8, 8],
                                        strokeWidth: [4, 4],
                                        strokeColors: ['var(--secondary)', 'var(--primary)'],
                                        border: 2,
                                        radius: 2,
                                        colors: ['#fff', '#fff', '#fff'],
                                        hover: {
                                            size: 10,
                                        }
                                    },
                                    xaxis: {
                                        categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                                        labels: {
                                            style: {
                                                colors: '#3E4954',
                                                fontSize: '14px',
                                                fontFamily: 'Poppins',
                                                fontWeight: 100,

                                            },
                                        },
                                        axisBorder: {
                                            show: false,
                                        }
                                    },
                                    yaxis: {
                                        labels: {
                                            minWidth: 20,
                                            offsetX: -16,
                                            style: {
                                                colors: '#3E4954',
                                                fontSize: '14px',
                                                fontFamily: 'Poppins',
                                                fontWeight: 100,

                                            },
                                        },
                                    },
                                    fill: {
                                        colors: ['#fff', '#fff'],
                                        type: 'gradient',
                                        opacity: 1,
                                        gradient: {
                                            shade: 'light',
                                            shadeIntensity: 1,
                                            colorStops: [
                                                [
                                                    {
                                                        offset: 0,
                                                        color: '#fff',
                                                        opacity: 0
                                                    },
                                                    {
                                                        offset: 0.6,
                                                        color: '#fff',
                                                        opacity: 0
                                                    },
                                                    {
                                                        offset: 100,
                                                        color: '#fff',
                                                        opacity: 0
                                                    }
                                                ],
                                                [
                                                    {
                                                        offset: 0,
                                                        color: '#fff',
                                                        opacity: .4
                                                    },
                                                    {
                                                        offset: 50,
                                                        color: '#fff',
                                                        opacity: 0.25
                                                    },
                                                    {
                                                        offset: 100,
                                                        color: '#fff',
                                                        opacity: 0
                                                    }
                                                ]
                                            ]

                                        },
                                    },
                                    // colors: ['#1EA7C5', '#FF9432'],
                                    colors: ['var(--primary)', 'var(--secondary)'],
                                    grid: {
                                        borderColor: '#f1f1f1',
                                        xaxis: {
                                            lines: {
                                                show: true
                                            }
                                        },
                                        yaxis: {
                                            lines: {
                                                show: false
                                            }
                                        },
                                    },

                                    responsive: [{
                                        breakpoint: 1602,
                                        options: {
                                            markers: {
                                                size: [6, 6, 4],
                                                hover: {
                                                    size: 7,
                                                }
                                            }, chart: {
                                                height: 230,
                                            },
                                        },

                                    }]


                                };


                                if (jQuery("#activity").length > 0) {
                                    var dzchart = new ApexCharts(document.querySelector("#activity"), optionsArea);
                                    dzchart.render();

                                    jQuery('.p-static select').on('change', function () {
                                        if (this.value == "month") {
                                            dzchart.updateSeries([{
                                                    name: "Withdraw",
                                                    data: [40, 20, 10, 50, 60, 90]
                                                },
                                                    {
                                                        name: "Deposit",
                                                        data: [40, 50, 10, 20, 50, 90]
                                                    }]
                                            )
                                        } else if (this.value == "week") {
                                            dzchart.updateSeries([{
                                                    name: "Withdraw",
                                                    data: [50, 30, 40, 30, 40, 70]
                                                },
                                                    {
                                                        name: "Deposit",
                                                        data: [30, 40, 30, 10, 60, 80]
                                                    }]
                                            )
                                        } else if (this.value == "today") {
                                            dzchart.updateSeries([{
                                                    name: "Withdraw",
                                                    data: [30, 20, 30, 40, 50, 60]
                                                },
                                                    {
                                                        name: "Deposit",
                                                        data: [20, 60, 40, 60, 10, 50]
                                                    }]
                                            )
                                        }
                                    })

                                    jQuery('#dzOldSeries').on('change', function () {
                                        jQuery(this).toggleClass('disabled');
                                        dzchart.toggleSeries('Withdraw');
                                    });

                                    jQuery('#dzNewSeries').on('change', function () {
                                        jQuery(this).toggleClass('disabled');
                                        dzchart.toggleSeries('Deposit');
                                    });

                                }

                            }

                            var pieChart2 = function () {
                                var options = {
                                    series: [500, 500],
                                    chart: {
                                        type: 'donut',
                                        width: 130,
                                        height: 130,
                                        innerRadius: 8,
                                    },
                                    dataLabels: {
                                        enabled: false
                                    },
                                    stroke: {
                                        width: 0,
                                    },
                                    plotOptions: {
                                        pie: {
                                            startAngle: 0,
                                            endAngle: 360,
                                            donut: {
                                                size: '80%',
                                                labels: {
                                                    show: true,
                                                    name: {},

                                                },
                                            },

                                        },
                                    },
                                    colors: ['#FF9F00', '#FD5353'],
                                    legend: {
                                        position: 'bottom',
                                        show: false
                                    },
                                    responsive: [{
                                        breakpoint: 1400,
                                        options: {
                                            chart: {
                                                width: 120,
                                                height: 120
                                            },
                                        },
                                        responsive: [{
                                            breakpoint: 1200,
                                            options: {
                                                chart: {
                                                    width: 90,
                                                    height: 90
                                                },
                                                legend: {
                                                    position: 'bottom'
                                                }
                                            }
                                        }]

                                    }]
                                };

                                var chart = new ApexCharts(document.querySelector("#pieChart2"), options);
                                chart.render();
                            }

                            var columnChart1 = function () {
                                var options = {
                                    series: [{
                                        name: 'Trades',
                                        data: [10, 15, 8, 7, 12, 5, 10]
                                    }],
                                    chart: {
                                        type: 'bar',
                                        height: 150,
                                        //stacked: true,
                                        toolbar: {
                                            show: false,
                                        }
                                    },
                                    plotOptions: {
                                        bar: {
                                            horizontal: false,
                                            columnWidth: '40%',
                                            borderRadius: 5,
                                            //backgroundRadius: 20,
                                            colors: {
                                                backgroundBarColors: ['#eee', '#eee', '#eee', '#eee', '#eee', '#eee'],
                                                backgroundBarOpacity: 1,
                                                backgroundBarRadius: 5,
                                            },
                                        },

                                    },
                                    colors: ['var(--primary)'],
                                    xaxis: {
                                        show: false,
                                        axisBorder: {
                                            show: false,
                                        },
                                        axisTicks: {
                                            show: false,
                                        },
                                        labels: {
                                            show: true,
                                            style: {
                                                colors: '#828282',
                                                fontSize: '14px',
                                                fontFamily: 'Poppins',
                                                fontWeight: 'light',
                                                cssClass: 'apexcharts-xaxis-label',
                                            },
                                        },

                                        crosshairs: {
                                            show: false,
                                        },

                                        categories: ['Sun', 'Mon', 'Tue', 'wed', 'Thu', 'Fri', 'Sat']
                                    },
                                    yaxis: {
                                        show: false
                                    },
                                    grid: {
                                        show: false,
                                    },
                                    toolbar: {
                                        enabled: false,
                                    },
                                    dataLabels: {
                                        enabled: false,
                                    },
                                    legend: {
                                        show: false
                                    },
                                    fill: {
                                        opacity: 1
                                    },
                                    responsive: [{
                                        breakpoint: 480,
                                        options: {
                                            legend: {
                                                position: 'bottom',
                                                offsetX: -10,
                                                offsetY: 0
                                            }
                                        }
                                    }],
                                };

                                var chart = new ApexCharts(document.querySelector("#columnChart1"), options);
                                chart.render();
                            }

                            return {
                                init: function () {
                                },

                                load: function () {
                                    activity();
                                    pieChart2();
                                    columnChart1()
                                }
                            }
                        }

                        jQuery(window).on('load', function () {
                            setTimeout(function () {
                                chartList().load();
                            }, 1000);
                        });

                        $('#pending_withdrwall').DataTable({
                            processing: true,
                            serverSide: true,
                            pageLength: 25,
                            responsive: true,
                            ajax: '{{route('adminPendingWithdrawals')}}',
                            order: [8, 'desc'],
                            autoWidth: false,
                            language: {
                                paginate: {
                                    next: 'Next &#8250;',
                                    previous: '&#8249; Previous'
                                }
                            },
                            columns: [
                                {"data": "address_type"},
                                {"data": "sender"},
                                {"data": "address"},
                                {"data": "receiver"},
                                {"data": "amount"},
                                {"data": "coin_type"},
                                {"data": "fees"},
                                {"data": "transaction_hash"},
                                {"data": "updated_at"},
                                {"data": "actions"}
                            ]
                        });
                    })(jQuery)
                </script>
@endsection

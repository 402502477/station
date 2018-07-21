@extends('layouts.layout')
@section('title','首页')
@section('content')
    <!-- OVERVIEW -->
    <div class="panel panel-headline">
        <div class="panel-heading">
            <h3 class="panel-title">周销售状况</h3>
            <p class="panel-subtitle"><span class="start"></span> - <span class="end"></span></p>
        </div>
        <div class="panel-body">
            <div class="row weekly-overview">
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-credit-card"></i></span>
                        <p>
                            <span class="number order_count">0</span>
                            <span class="title">订单数</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                        <p>
                            <span class="number order_total">0</span>
                            <span class="title">交易金额</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-eye"></i></span>
                        <p>
                            <span class="number"><span class="rate_count">0</span>%</span>
                            <span class="title">订单 vs LW</span>
                        </p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="metric">
                        <span class="icon"><i class="fa fa-bar-chart"></i></span>
                        <p>
                            <span class="number"><span class="rate_total">0</span>%</span>
                            <span class="title">金额 vs LW</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div id="headline-chart" class="ct-chart"></div>
                </div>
                <div class="col-md-3">
                    <div class="weekly-summary text-right">
                        <span class="number">￥<span class="today"></span></span>
                        <span class="info-label">今日销售</span>
                    </div>
                    <div class="weekly-summary text-right">
                        <span class="number">￥<span class="thisWeek"></span></span>
                        <span class="info-label">本周销售</span>
                    </div>
                    <div class="weekly-summary text-right">
                        <span class="number">￥<span class="thisMonth"></span></span>
                        <span class="info-label">本月销售</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OVERVIEW -->
    <div class="row">
        <div class="col-md-6">
            <!-- RECENT PURCHASES -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">订单记录</h3>
                    <div class="right">
                        <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                        <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                    </div>
                </div>
                <div class="panel-body no-padding">
                    <table class="table table-striped orders">
                        <thead>
                        <tr>
                            <th>Order No.</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Date &amp; Time</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><a href="/Manages/orders/info/[ID]">[ON]</a></td>
                            <td>[NAME]</td>
                            <td>￥[PRICE]</td>
                            <td>[DATE]</td>
                            <td>[STATUS]</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-6"><span class="panel-note"><i class="fa fa-clock-o"></i> 最近交易记录</span></div>
                        <div class="col-md-6 text-right"><a href="{{ asset('/Manages/orders/index') }}" class="btn btn-primary">查看全部订单</a></div>
                    </div>
                </div>
            </div>
            <!-- END RECENT PURCHASES -->
        </div>
        <div class="col-md-6">
            <!-- MULTI CHARTS -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">月度销售预览</h3>
                    <div class="right">
                        <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
                        <button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="visits-trends-chart" class="ct-chart"></div>
                </div>
            </div>
            <!-- END MULTI CHARTS -->
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{ asset('js/echarts.js') }}"></script>
    <script>
        let orders = $('.orders tbody').html();
        $.ajax({
            url : '/api/order/get',
            type : 'post',
            data : {take:5},
            dataType :'json',
            beforeSend()
            {
                app.showPreLoading();
            },
            success(r)
            {
                let html = '';
                let status = [
                    '','<span class="label label-danger">待付款</span>','<span class="label label-success">已付款</span>'
                ];
                for (let i in r.data)
                {
                    let data = r.data[i];
                    html += orders.replace('[ID]',data.id).replace('[ON]',data.order_id).replace('[NAME]',data.username).replace('[PRICE]',data.current_point).replace('[DATE]',data.create_at).replace('[STATUS]',status[data.status]);
                }
                $('.orders tbody').html(html);
                app.hidePreLoading();
            }
        });


        let data, options;

        $.ajax({
            url : '/api/order/keyPoint',
            type : 'post',
            dataType :'json',
            beforeSend()
            {
                app.showPreLoading();
            },
            success(r)
            {
                $('.start').text(r.weekly.time[0]);
                $('.end').text(r.weekly.time[1]);

                $('.weekly-overview .order_count').text(r.weekly.count);
                $('.weekly-overview .order_total').text(r.weekly.total);

                $('.weekly-overview .rate_count').text(r.comparison.count);
                $('.weekly-overview .rate_total').text(r.comparison.total);

                $('.today').text(r.this.today);
                $('.thisWeek').text(r.this.week);
                $('.thisMonth').text(r.this.month);


                data = {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    series: [
                        r.weekly.list,
                        r.comparison.list,
                    ]
                };
                options = {
                    height: 300,
                    showArea: true,
                    showLine: false,
                    showPoint: false,
                    fullWidth: true,
                    axisX: {
                        showGrid: false
                    },
                    lineSmooth: false,
                };

                new Chartist.Line('#headline-chart', data, options);


                // visits trend charts
                data = {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    series: [{
                        name: 'series-real',
                        data: r.years,
                    }]
                };

                options = {
                    fullWidth: true,
                    lineSmooth: false,
                    height: "270px",
                    low: 0,
                    high: 'auto',
                    series: {
                        'series-projection': {
                            showArea: true,
                            showPoint: false,
                            showLine: false
                        },
                    },
                    axisX: {
                        showGrid: false,

                    },
                    axisY: {
                        showGrid: false,
                        onlyInteger: true,
                        offset: 0,
                    },
                    chartPadding: {
                        left: 20,
                        right: 20
                    }
                };

                new Chartist.Line('#visits-trends-chart', data, options);
                app.hidePreLoading();
            }
        });
    </script>
    @endsection

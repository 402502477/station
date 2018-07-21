@extends('layouts.layout')
@section('title','用户信息')
@section('content')
    <div class="panel panel-profile">
        <div class="clearfix">
            <!-- LEFT COLUMN -->
            <div class="profile-left">
                <!-- PROFILE HEADER -->
                <div class="profile-header">
                    <div class="overlay"></div>
                    <div class="profile-main">
                        <img src="{{ $info['info']['headimgurl'] }}" class="img-circle" alt="Avatar">
                        <h3 class="name">{{ $info['username'] }}</h3>
                        {{--<span class="online-status status-available">Available</span>--}}
                    </div>
                    <div class="profile-stat">
                        <div class="row">
                            <div class="col-md-6 stat-item">
                                <span class="balance">{{ $info['balance'] }}</span> <span>余额</span>
                            </div>
                            <div class="col-md-6 stat-item">
                                {{ $info['order_count'] }} <span>交易数</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE HEADER -->
                <!-- PROFILE DETAIL -->
                <div class="profile-detail">
                    <div class="profile-info">
                        <h4 class="heading">基本信息</h4>
                        <ul class="list-unstyled list-justify">
                            <li>等级 <span>{{ $info['level_text'] }}</span></li>
                            <li>手机号 <span>{{ $info['contact'] }}</span></li>
                            <li>性别 <span>{{ $info['gender'] }}</span></li>
                            <li>加入时间 <span>{{ $info['create_at'] }}</span></li>
                        </ul>
                    </div>
                    @if($info['receipt_info'])
                        <div class="profile-info">
                            <h4 class="heading">发票信息</h4>
                            <div class="list-unstyled list-justify">
                                <div class="layui-collapse" >
                                    @foreach($info['receipt_info'] as $value)
                                        <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">{{ $value['title'] }}</h2>
                                            <div class="layui-colla-content {{ $value['is_default']? 'layui-show' :'' }}">{{ $value['content'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    {{--<div class="profile-info">
                        <h4 class="heading">About</h4>
                        <p>Interactively fashion excellent information after distinctive outsourcing.</p>
                    </div>
                    <div class="text-center"><a href="#" class="btn btn-primary">Edit Profile</a></div>--}}
                </div>
                <!-- END PROFILE DETAIL -->
            </div>
            <!-- END LEFT COLUMN -->
            <!-- RIGHT COLUMN -->
            <div class="profile-right">
                <h4 class="heading">基本功能</h4>
                <!-- AWARDS -->
                <div class="awards">
                    <div class="row">
                        <form class="layui-form" action="">
                            <div class="layui-form-item">
                                <label class="layui-form-label">余额</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="balance" lay-verify="required|number" placeholder="请输入调整的金额" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-input-inline">
                                    <button class="layui-btn" type="button" lay-filter="*" lay-submit name="plus">增加</button>
                                    <button class="layui-btn layui-btn-warm" type="button" lay-filter="*" lay-submit name="less">减少</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END AWARDS -->
                <!-- TABBED CONTENT -->
                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                    <ul class="nav" role="tablist">
                        <li class="active"><a href="#coupon" role="tab" data-toggle="tab" aria-expanded="" name="coupon">优惠券</a></li>
                        <li class=""><a href="#order" role="tab" data-toggle="tab" aria-expanded="" name="order">订单记录</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    {{--<div class="tab-pane fade in " id="step">
                        <ul class="list-unstyled activity-timeline">
                            <li>
                                <i class="fa fa-comment activity-icon"></i>
                                <p>Commented on post <a href="#">Prototyping</a> <span class="timestamp">2 minutes ago</span></p>
                            </li>
                            <li>
                                <i class="fa fa-cloud-upload activity-icon"></i>
                                <p>Uploaded new file <a href="#">Proposal.docx</a> to project <a href="#">New Year Campaign</a> <span class="timestamp">7 hours ago</span></p>
                            </li>
                            <li>
                                <i class="fa fa-plus activity-icon"></i>
                                <p>Added <a href="#">Martin</a> and <a href="#">3 others colleagues</a> to project repository <span class="timestamp">Yesterday</span></p>
                            </li>
                            <li>
                                <i class="fa fa-check activity-icon"></i>
                                <p>Finished 80% of all <a href="#">assigned tasks</a> <span class="timestamp">1 day ago</span></p>
                            </li>
                        </ul>
                        <div class="margin-top-30 text-center"><a href="#" class="btn btn-default">查看全部</a></div>
                    </div>--}}
                    <div class="tab-pane fade in active" id="coupon">
                        <div class="table-responsive">
                            <table class="table project-table">
                                <thead>
                                <tr>
                                    <th>优惠券ID</th>
                                    <th>优惠券编号</th>
                                    <th>发放时间</th>
                                    <th>状态</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <a href="/Manages/coupons/info/[ID]">[ID]</a>
                                    </td>
                                    <td>[NUMBER]</td>
                                    <td>[TIME]</td>
                                    <td>[STATUS]</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="margin-top-30 text-center">
                            <ul class="pagination" id="coupon_page"></ul>
                        </div>
                    </div>

                    <div class="tab-pane fade in" id="order">
                        <div class="table-responsive">
                            <table class="table project-table">
                                <thead>
                                <tr>
                                    <th>编号</th>
                                    <th>金额</th>
                                    <th>状态</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <a href="/Manages/orders/info/[ID]">[NUMBER]</a>
                                    </td>
                                    <td>￥[PRICE]</td>
                                    <td>[STATUS]</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="margin-top-30 text-center">
                            <ul class="pagination" id="order_page"></ul>
                        </div>
                    </div>
                </div>
                <!-- END TABBED CONTENT -->
            </div>
            <!-- END RIGHT COLUMN -->
        </div>
    </div>
@stop
@section('footer')
    <script>
        layui.use(['element','form'], function(){
            let element = layui.element;
            let form = layui.form;
            form.on('submit(*)',function(data){
                let point = data.field.balance;
                let mark = data.elem.name;
                $.ajax({
                    url : '/api/member/changeBalance',
                    type : 'post',
                    dataType : 'json',
                    data :{
                        point : point,
                        mark : mark,
                        mid : '{{ $mid }}'
                    },
                    beforeSend()
                    {
                        app.showPreLoading();
                    },
                    success(res)
                    {
                        if(res.status == 0)
                        {
                            app.alert({title:'提示',content:res.msg});
                            return app.hidePreLoading();
                        }
                        app.alert({title:'提示',content:res.msg});
                        $('.balance').text(res.balance);
                        app.hidePreLoading();
                    }
                });
                return false;
            });

        });

        let coupon_html = $('#coupon tbody').html();
        let order_html = $('#order tbody').html();
        let skip = 0;
        let take = 10;
        getData(coupon_html,'{{ url("api/coupon/collect/get") }}',function(html,r){
            let type = [
                '',
                '<span class="label label-success">未使用</span>',
                '<span class="label label-info">已使用</span>',
                '<span class="label label-danger">禁用</span>',
            ];

            let data = r.data;
            let content = '';
            if(data)
            {
                for(let i in data)
                {
                    content += html.replace('[ID]',data[i].cid).replace('[ID]',data[i].cid).replace('[NUMBER]',data[i].number).replace('[USER]',data[i].username).replace('[TIME]',data[i].create_at).replace('[STATUS]',type[data[i].status]);
                }
            }
            $('#coupon tbody').html(content);

        },'coupon_page');
        function getData(html,url,callback,elem)
        {

            $.ajax({
                url :  url,
                type : 'post',
                data : {
                    skip : skip|| null,
                    take : take|| null,
                    mid : '{{ $mid }}'
                },
                dataType : 'json',
                beforeSend()
                {
                    app.showPreLoading();
                },
                success(r)
                {
                    callback(html,r);

                    layui.use('laypage', function(){
                        let curr = parseInt(r.skip/r.limit)+1;
                        let page = layui.laypage;
                        page.render({
                            elem: elem,
                            count: r.count,
                            limit: r.limit,
                            theme:'#00AAFF',
                            curr:curr,
                            jump(obj,first)
                            {
                                if(!first)
                                {
                                    skip = (obj.curr-1) * r.limit;
                                    getData(html,url,callback,elem);
                                }
                            }
                        });
                    });

                    app.hidePreLoading();
                }
            });
        }

        $('.nav a[name=order]').click(function(){
            getData(order_html,'{{ url("api/order/get") }}',function(html,r){
                let type = [
                    '',
                    '<span class="label label-danger">未支付</span>',
                    '<span class="label label-success">已支付</span>'
                ];

                let data = r.data;
                let content = '';
                if(data)
                {
                    for(let i in data)
                    {
                        content += html.replace('[NUMBER]',data[i].order_id).replace('[ID]',data[i].id).replace('[PRICE]',data[i].current_point).replace('[STATUS]',type[data[i].status]);
                    }
                }
                $('#order tbody').html(content);

            },'order_page');
        });
        $('.nav a[name=coupon]').click(function(){
            getData(coupon_html,'{{ url("api/coupon/collect/get") }}',function(html,r){
                let type = [
                    '',
                    '<span class="label label-success">未使用</span>',
                    '<span class="label label-info">已使用</span>',
                    '<span class="label label-danger">禁用</span>',
                ];

                let data = r.data;
                let content = '';
                if(data)
                {
                    for(let i in data)
                    {
                        content += html.replace('[ID]',data[i].cid).replace('[ID]',data[i].cid).replace('[NUMBER]',data[i].number).replace('[USER]',data[i].username).replace('[TIME]',data[i].create_at).replace('[STATUS]',type[data[i].status]);
                    }
                }
                $('#coupon tbody').html(content);

            },'coupon_page');
        });
    </script>
@stop
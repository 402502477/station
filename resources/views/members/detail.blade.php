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
                            <div class="col-md-4 stat-item">
                                45 <span>余额</span>
                            </div>
                            <div class="col-md-4 stat-item">
                                15 <span>金币</span>
                            </div>
                            <div class="col-md-4 stat-item">
                                123 <span>交易数</span>
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
                            <ul class="list-unstyled list-justify">
                                <li>xx <span></span></li>
                                <li>发票信息 </li>
                            </ul>
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
                <h4 class="heading">会员信息</h4>
                <!-- AWARDS -->
                <div class="awards">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="award-item">
                                <div class="hexagon">
                                    <span class="lnr lnr-sun award-icon"></span>
                                </div>
                                <span>Most Bright Idea</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="award-item">
                                <div class="hexagon">
                                    <span class="lnr lnr-clock award-icon"></span>
                                </div>
                                <span>Most On-Time</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="award-item">
                                <div class="hexagon">
                                    <span class="lnr lnr-magic-wand award-icon"></span>
                                </div>
                                <span>Problem Solver</span>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="award-item">
                                <div class="hexagon">
                                    <span class="lnr lnr-heart award-icon"></span>
                                </div>
                                <span>Most Loved</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center"><a href="#" class="btn btn-default">See all awards</a></div>
                </div>
                <!-- END AWARDS -->
                <!-- TABBED CONTENT -->
                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                    <ul class="nav" role="tablist">
                        <li class="active"><a href="#coupon" role="tab" data-toggle="tab" aria-expanded="">优惠券</a></li>
                        <li class=""><a href="#order" role="tab" data-toggle="tab" aria-expanded="">订单记录</a></li>
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
                            <ul class="pagination" id="pagination"></ul>
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
                                        <a href="/Manage/order/info/[ID]">[NUMBER]</a>
                                    </td>
                                    <td>[PRICE]</td>
                                    <td>[STATUS]</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="margin-top-30 text-center">
                            <ul class="pagination" id="pagination"></ul>
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
        let coupon_html = $('#coupon tbody').html();
        let order_html = $('#order tbody').html();
        let skip = 0;
        let take = 10;
        getData(coupon_html);
        function getData(html)
        {
            let type = [
                '',
                '<span class="label label-success">未使用</span>',
                '<span class="label label-info">已使用</span>',
                '<span class="label label-danger">禁用</span>',
            ];
            $.ajax({
                url :  '{{ url("api/coupon/collect/get") }}',
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
                    layui.use('laypage', function(){
                        let curr = parseInt(r.skip)+1;
                        let page = layui.laypage;
                        page.render({
                            elem: 'pagination',
                            count: r.count,
                            limit: r.limit,
                            theme:'#00AAFF',
                            curr:curr,
                            jump(obj,first)
                            {
                                if(!first)
                                {
                                    skip = (obj.curr-1) * r.limit;
                                    getData(coupon_html);
                                }
                            }
                        });
                    });

                    app.hidePreLoading();
                }
            });
        }
    </script>
@stop
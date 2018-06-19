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
                        <img src="{{ asset('ui/img/user-medium.png') }}" class="img-circle" alt="Avatar">
                        <h3 class="name">Samuel Gold</h3>
                        {{--<span class="online-status status-available">Available</span>--}}
                    </div>
                    <div class="profile-stat">
                        <div class="row">
                            <div class="col-md-4 stat-item">
                                45 <span>Project 1</span>
                            </div>
                            <div class="col-md-4 stat-item">
                                15 <span>Project 2</span>
                            </div>
                            <div class="col-md-4 stat-item">
                                123 <span>Project 3</span>
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
                            <li>手机号 <span>18605518325</span></li>
                            <li>性别 <span>男</span></li>
                            <li>生日 <span>1993-8-22</span></li>
                            <li>加入时间 <span>2016-9-21</span></li>
                        </ul>
                    </div>
                    <div class="profile-info">
                        <h4 class="heading">发票信息</h4>
                        <ul class="list-unstyled list-justify">
                            <li>xx <span></span></li>
                            <li>发票信息 </li>
                        </ul>
                    </div>
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
                        <li class="active"><a href="#step" role="tab" data-toggle="tab" aria-expanded="">会员足迹</a></li>
                        <li class=""><a href="#coupon" role="tab" data-toggle="tab" aria-expanded="">优惠券 <span class="badge">7</span></a></li>
                        <li class=""><a href="#order" role="tab" data-toggle="tab" aria-expanded="">订单记录</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="step">
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
                    </div>
                    <div class="tab-pane fade in" id="coupon">
                        <div class="table-responsive">
                            <table class="table project-table">
                                <thead>
                                <tr>
                                    <th>优惠券编号</th>
                                    <th>发放时间</th>
                                    <th>状态</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="margin-top-30 text-center"><a href="#" class="btn btn-default">查看全部</a></div>
                    </div>

                    <div class="tab-pane fade in" id="order">
                        <div class="table-responsive">
                            <table class="table project-table">
                                <thead>
                                <tr>
                                    <th>编号</th>
                                    <th>金额</th>
                                    <th>状态</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><a href="#">Spot Media</a></td>
                                    <td>
                                    </td>
                                    <td></td>
                                    <td><span class="label label-success">ACTIVE</span></td>
                                </tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="margin-top-30 text-center"><a href="#" class="btn btn-default">查看全部</a></div>
                    </div>
                </div>
                <!-- END TABBED CONTENT -->
            </div>
            <!-- END RIGHT COLUMN -->
        </div>
    </div>
@stop
@section('footer')
@stop
@extends('layouts.layout')
@section('title','订单信息')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">订单信息</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">订单编号</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">{{ $row['order_id'] }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">产品</label>
                    <div class="col-sm-10">
                        <p class="form-control-static col-sm-2">
                            {{ $row['goods_info'] }}
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">订单金额</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">￥{{ $row['original_point'] }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">实付金额</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">￥{{ $row['current_point'] }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户信息</label>
                    <div class="col-sm-10">
                        <p class="form-control-static col-sm-2">
                            <a href="{{ url('/Manages/members/detail',['id'=>$member->id]) }}">
                                <span class="text-primary">{{ $member->username }}</span>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">优惠信息</label>
                    <div class="col-sm-10">
                        <table class="table table-hover">
                            <tr>
                                <th>优惠券ID</th>
                                <th>优惠券编号</th>
                                <th>优惠券名称</th>
                                <th>优惠金额</th>
                            </tr>
                            @if($row['promotion'])
                                <tr>
                                    <td>{{ $row['promotion']['id'] }}</td>
                                    <td>{{ $row['promotion']['number'] }}</td>
                                    <td>{{ $row['promotion']['title'] }}</td>
                                    <td>{{ $row['promotion']['account'] }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">订单状态</label>
                    <div class="col-sm-10">
                        <p class="form-control-static col-sm-2">
                            {!!$row['status_text']!!}
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">支付方式</label>
                    <div class="col-sm-10">
                        <p class="form-control-static col-sm-2">
                            {{ $row['payment_text'] }}
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
@section('footer')
@stop
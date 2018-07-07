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
                    <label class="col-sm-2 control-label">优惠信息</label>
                    <div class="col-sm-10">
                        <p class="form-control-static col-sm-2">123</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">订单状态</label>
                    <div class="col-sm-10">
                        <p class="form-control-static col-sm-2">123</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
@section('footer')
@stop
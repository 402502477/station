@extends('layouts.layout')
@section('title','订单管理')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">优惠券信息</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label">优惠券编号</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">xxxx</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <p class="form-control-static">测试标题</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2 control-label">库存</label>
                    <div class="col-sm-10">
                        <p class="form-control-static col-sm-2">123</p>
                        <div class="col-sm-10 form-inline">
                            <input type="text" class="form-control input-sm">
                            <button class="btn btn-xs btn-success" type="button">增加</button>
                            <button class="btn btn-xs btn-danger" type="button">减少</button>
                        </div>
                    </div>
                </div>
                <hr>
            </form>
        </div>
    </div>
@stop
@section('footer')
@stop
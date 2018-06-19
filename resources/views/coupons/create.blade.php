@extends('layouts.layout')
@section('title','添加优惠券')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">添加优惠券</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="title" placeholder="请输入优惠券标题">
                    </div>
                </div>
                <div class="form-group">
                    <label for="type" class="col-sm-2 control-label">优惠券类型</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="type" name="type">
                            <option>请选择优惠券类型</option>
                        </select>
                    </div>
                    <div class="col-sm-7"></div>
                </div>
                <div class="form-group">
                    <label for="deadlineType" class="col-sm-2 control-label">使用期限类型</label>
                    <div class="col-sm-3">
                        <select name="deadline-type" class="form-control" id="deadlineType">
                            <option value="">请选择使用期限类型</option>
                            <option value="range">按时间区间类型</option>
                            <option value="day">按发起后天数类型</option>
                        </select>
                    </div>
                    <div class="col-sm-7"></div>
                </div>
                <div class="form-group">
                    <label for="deadline" class="col-sm-2 control-label">使用时间</label>
                    <div class="col-sm-10">
                        <input type="text" name="deadline" id="deadline" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="discount" class="col-sm-2 control-label">优惠金额</label>
                    <div class="col-sm-10">
                        <input type="number" name="discount" id="discount" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="discount-type" class="col-sm-2 control-label">优惠单位</label>
                    <div class="col-sm-3">
                        <select name="discount-type" id="discount-type" class="form-control">
                            <option value="">请选择折扣单位</option>
                            <option value="">￥</option>
                            <option value="">%</option>
                        </select>
                    </div>
                    <div class="col-sm-7"></div>
                </div>
                <div class="form-group">
                    <label for="introduce" class="col-sm-2 control-label">优惠券介绍</label>
                    <div class="col-sm-10">
                        <textarea name="introduce" id="introduce" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="stock" class="col-sm-2 control-label">库存</label>
                    <div class="col-sm-10">
                        <input type="number" id="stock" name="stock"  class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">创建</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
@section('footer')
@stop
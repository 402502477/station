@extends('layouts.layout')
@section('title','用户列表')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">用户管理</h3>
        </div>
        <div class="panel-body">
            <div class="handler">
                <form action="" class="form-inline">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <select class="form-control input-sm" name="length">
                                <option value="10">显示10条</option>
                                <option value="20">显示20条</option>
                                <option value="50">显示50条</option>
                            </select>
                        </div>
                        <a href="{{ url('Manages/coupons/create') }}" class="btn btn-primary btn-sm" type="button">添加</a>
                        <button class="btn btn-danger btn-sm" type="button">批量删除</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <div class="form-group">
                            <select class="form-control input-sm" name="length">
                                <option value="10">请选择搜索类型</option>
                                <option value="20"></option>
                                <option value="50"></option>
                            </select>
                            <input type="text" class="form-control input-sm">
                            <button class="btn btn-default btn-sm">搜索</button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        <label class="fancy-checkbox full-switch">
                            <input type="checkbox">
                            <span></span>
                        </label>
                    </th>
                    <th>序号</th>
                    <th>姓名</th>
                    <th>手机号</th>
                    <th>会员等级</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <label class="fancy-checkbox">
                            <input type="checkbox" data-id="1">
                            <span></span>
                        </label>
                    </td>
                    <td>1</td>
                    <td>steven</td>
                    <td>1350569555</td>
                    <td>1</td>
                    <td>
                        <button class="btn btn-primary btn-xs">信息</button>
                        <button class="btn btn-success btn-xs">确认</button>
                        <button class="btn btn-danger btn-xs">删除</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="fancy-checkbox">
                            <input type="checkbox" data-id="2">
                            <span></span>
                        </label>
                    </td>
                    <td>1</td>
                    <td>steven</td>
                    <td>1350569555</td>
                    <td>1</td>
                    <td>
                        <button class="btn btn-primary btn-xs">信息</button>
                        <button class="btn btn-success btn-xs">确认</button>
                        <button class="btn btn-danger btn-xs">删除</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="fancy-checkbox">
                            <input type="checkbox" data-id="3">
                            <span></span>
                        </label>
                    </td>
                    <td>1</td>
                    <td>steven</td>
                    <td>1350569555</td>
                    <td>1</td>
                    <td>
                        <button class="btn btn-primary btn-xs">信息</button>
                        <button class="btn btn-success btn-xs">确认</button>
                        <button class="btn btn-danger btn-xs">删除</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <ul class="pagination">
                <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
            </ul>
        </div>
    </div>
@stop
@section('footer')
@stop
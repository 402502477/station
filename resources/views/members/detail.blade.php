@extends('layouts.layout')
@section('title','用户信息')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">详细信息</h3>
        </div>
        <div class="panel-body">
            <div class="handler">
                <form action="" class="form-inline">
                    <div class="form-group">
                        <select class="form-control" name="length">
                            <option value="10">显示10条</option>
                            <option value="20">显示20条</option>
                            <option value="50">显示50条</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="button" onclick="app.getCheckId()">操作</button>
                    <button class="btn btn-danger">批量删除</button>
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
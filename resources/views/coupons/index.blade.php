@extends('layouts.layout')
@section('title','优惠券管理')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">优惠券管理</h3>
        </div>
        <div class="panel-body">
            <div class="handler clearfix">
                <form action="" class="form-inline">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <select class="form-control input-sm" name="length" onchange="getList({take:$(this).val()})">
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
            <table class="table table-hover coupon_list">
                <thead>
                <tr>
                    <th>
                        <label class="fancy-checkbox full-switch">
                            <input type="checkbox">
                            <span></span>
                        </label>
                    </th>
                    <th>优惠券ID</th>
                    <th>标题</th>
                    <th>使用时间</th>
                    <th>折扣</th>
                    <th>库存</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>

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
    <script>
        getList({});
        function getList(data)
        {
            app.getLists({
                url : "{{ url('api/coupon/get') }}",
                data : data,
                success (r)
                {
                    let label_color = ['label-danger','label-success','label-warning'];
                    let html = '';
                    for(let i in r)
                    {
                        html += '<tr data-id="'+r[i].id+'"><td>' +
                            '<label class="fancy-checkbox" data-id="'+r[i].id+'">' +
                            '<input type="checkbox">' +
                            '<span></span>' +
                            '</label></td>' +
                            '<td>'+r[i].id+'</td>' +
                            '<td>'+r[i].title+'</td>' +
                            '<td>'+r[i].time_limit+'</td>' +
                            '<td>'+r[i].discount+'</td>' +
                            '<td>'+r[i].stock+'</td>' +
                            '<td><span class="label '+ label_color[r[i].status] +'" onclick="changeStatus(this)">'+r[i].status_text+'</span></td>' +
                            '<td><a class="btn btn-primary btn-xs" data-id="'+r[i].id+'">信息</a> '+
                            '<button class="btn btn-success btn-xs" data-id="'+r[i].id+'">确认</button> ' +
                            '<button class="btn btn-danger btn-xs" data-id="'+r[i].id+'">删除</button> ' +
                            '</td>' +
                            '</tr>';
                    }
                    $('.coupon_list tbody').html(html);
                }
            })
        }
    </script>
@stop
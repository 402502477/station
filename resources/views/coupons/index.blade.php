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
                            <select class="form-control input-sm" name="search">
                                <option value="">请选择搜索类型</option>
                                <option value="id">优惠券ID</option>
                                <option value="title">标题</option>
                            </select>
                            <input type="text" class="form-control input-sm"  name="keywords">
                            <button class="btn btn-default btn-sm" type="button" name="searching">搜索</button>
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
            <ul class="pagination" id="pagination">
            </ul>
        </div>
    </div>
@stop
@section('footer')
    <script>
        getList();
        let take = null; //全局化页面数据显示长度

        //切换页面数据长度
        $('select[name=length]').change(function(){
            take = $(this).val();
            getList({
                take:take
            });
        });

        //搜索操作
        $('button[name=searching]').click(function(){
            let search = $('select[name=search]').val();
            let keywords = $('input[name=keywords]').val();

            if(!search || !keywords)
            {
                app.layOpen('请先选择搜索类型并输入搜索内容！',2);
                return;
            }
            getList({
                take : take,
                search : search,
                keywords : keywords
            });
        });
        //删除信息
        function onDelete(obj)
        {
            app.alert({
                content:'确定要删除此条记录么？',
                showCancel : true,
                onSure()
                {
                    let id = $(obj).data('id');
                    $.ajax({
                        url : '{{url("api/coupon/delete")}}',
                        data : {
                            id : id
                        },
                        type : 'post',
                        dataType : 'json',
                        success(r)
                        {
                            if(r.code)
                            {
                                $(obj).parents('tr').remove()
                                app.layOpen(r.msg,1);
                                return;
                            }
                            app.layOpen(r.msg,2);
                        }
                    })
                }
            });

        }
        //获取列表方法
        function getList(dt,method)
        {
            app.getLists({
                url : "{{ url('api/coupon/get') }}",
                data : dt,
                method : method || 'post',
                success (r)
                {
                    let data = r.data;
                    let label_color = ['label-danger','label-success','label-warning'];
                    let html = '';
                    for(let i in data)
                    {
                        html += '<tr data-id="'+data[i].id+'"><td>' +
                            '<label class="fancy-checkbox" data-id="'+data[i].id+'">' +
                            '<input type="checkbox">' +
                            '<span></span>' +
                            '</label></td>' +
                            '<td>'+data[i].id+'</td>' +
                            '<td>'+data[i].title+'</td>' +
                            '<td>'+data[i].time_limit+'</td>' +
                            '<td>'+data[i].discount+'</td>' +
                            '<td>'+data[i].stock+'</td>' +
                            '<td><span class="label '+ label_color[data[i].status] +'">'+data[i].status_text+'</span></td>' +
                            '<td><button class="btn btn-primary btn-xs" onclick="navigateTo(this)">信息</button> '+
                            '<button class="btn btn-danger btn-xs" onclick="onDelete(this)" data-id="'+data[i].id+'">删除</button> ' +
                            '</td>' +
                            '</tr>';
                    }
                    $('.coupon_list tbody').html(html);


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
                                    let skip = (obj.curr-1) * r.limit;
                                    let take = $('select[name=length]').val();
                                    getList({skip:skip,take:take});
                                }
                            }
                        });
                    });
                }
            })
        }
        function navigateTo(obj)
        {
            let id = $(obj).parents('tr').data('id');
            window.location = "{{ url('Manages/coupons/info') }}/" + id;
        }
    </script>
@stop
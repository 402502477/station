@extends('layouts.layout')
@section('title','订单管理')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">订单管理</h3>
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
                        {{--<a href="{{ url('Manages/coupons/create') }}" class="btn btn-primary btn-sm" type="button">添加</a>--}}
                        {{--<button class="btn btn-danger btn-sm batchHandle" type="button" data-type="delete">批量删除</button>--}}
                    </div>
                    <div class="col-sm-6 text-right">
                        <div class="form-group">
                            <select class="form-control input-sm" name="search">
                                <option value="">请选择搜索类型</option>
                                <option value="order_id">订单编号</option>
                                <option value="id">ID</option>
                                <option value="mid">用户ID</option>
                            </select>
                            <input type="text" class="form-control input-sm"  name="keywords">
                            <button class="btn btn-default btn-sm" type="button" name="searching">搜索</button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-hover orders_list">
                <thead>
                    <tr>{{--
                        <th>
                            <label class="fancy-checkbox full-switch">
                                <input type="checkbox">
                                <span></span>
                            </label>
                        </th>--}}
                        <th>ID</th>
                        <th>订单编号</th>
                        <th>用户ID</th>
                        <th>用户姓名</th>
                        <th>总金额</th>
                        <th>支付金额</th>
                        <th>创建时间</th>
                        <th>订单状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[ID]</td>
                        <td>[NUMBER]</td>
                        <td>[MID]</td>
                        <td>[USERNAME]</td>
                        <td>￥[TOTAL]</td>
                        <td>￥[ACTUAL]</td>
                        <td>[TIME]</td>
                        <td>[STATUS]</td>
                        <td><a class="btn btn-info btn-sm" href="/Manages/orders/info/[ID]">信息</a></td>
                    </tr>
                </tbody>
            </table>
            <ul class="pagination" id="pagination">
            </ul>
        </div>
    </div>
@stop
@section('footer')
    <script>

        let skip = 0;
        let take = 10; //全局化页面数据显示长度
        let search = null;
        let keywords = null;

        let list_html = $('.orders_list tbody').html();

        getList({},list_html);
        //切换页面数据长度
        $('select[name=length]').change(function(){
            take = $(this).val();
            getList({skip:skip,take:take,search:search,keywords:keywords},list_html);
        });

        //搜索操作
        $('button[name=searching]').click(function(){
            search = $('select[name=search]').val();
            keywords = $('input[name=keywords]').val();
            if(!search || !keywords)
            {
                app.layOpen('请先选择搜索类型并输入搜索内容！',2);
                return null;
            }
            getList({skip:skip,take:take,search:search,keywords:keywords},list_html);
        });
        //获取列表方法
        function getList(dt,xml)
        {
            app.getLists({
                url : "{{ url('api/order/get') }}",
                data : dt,
                method : 'post',
                success (r)
                {
                    let data = r.data;
                    let label_color = ['','label-danger','label-success','label-warning'];
                    let html = '';
                    for(let i in data)
                    {
                        html += xml.replace('[ID]',data[i].id).replace('[NUMBER]',data[i].order_id).replace('[TOTAL]',data[i].original_point).replace('[ACTUAL]',data[i].current_point).replace('[TIME]',data[i].create_at).replace('[MID]',data[i].mid).replace('[USERNAME]',data[i].username).replace('[STATUS]','<label class="label '+label_color[data[i].status]+'">'+data[i].status_text+'</label>').replace('[ID]',data[i].id);
                    }
                    $('.orders_list tbody').html(html);


                    layui.use('laypage', function(){
                        let curr = parseInt(r.skip/r.limit)+1;
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
                                    getList({skip:skip,take:take},xml);
                                }
                            }
                        });
                    });
                }
            })
        }
    </script>
@stop
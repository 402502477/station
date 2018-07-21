@extends('layouts.layout')
@section('title','用户管理')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">用户管理</h3>
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
                    </div>
                    <div class="col-sm-6 text-right">
                        <div class="form-group">
                            <select class="form-control input-sm" name="search">
                                <option value="">请选择搜索类型</option>
                                <option value="id">用户编号</option>
                                <option value="username">姓名</option>
                                <option value="contact">手机号</option>
                            </select>
                            <input type="text" class="form-control input-sm"  name="keywords">
                            <button class="btn btn-default btn-sm" type="button" name="searching">搜索</button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-hover member_list">
                <thead>
                <tr>
                    <th>用户编号</th>
                    <th>姓名</th>
                    <th>联系方式</th>
                    <th>等级</th>
                    <th>加入时间</th>
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

        //全局化页面数据
        let take = 10;
        let search = null;
        let keywords = null;

        //切换页面数据长度
        $('select[name=length]').change(function(){
            take = $(this).val();
            getList({
                take:take,
                search:search,
                keywords:keywords
            });
        });

        //搜索操作
        $('button[name=searching]').click(function(){
            search = $('select[name=search]').val();
            keywords = $('input[name=keywords]').val();

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
        //获取列表方法
        function getList(dt,method)
        {
            app.getLists({
                url : "{{ url('api/member/get') }}",
                data : dt,
                method : method || 'post',
                success (r)
                {
                    let data = r.data;
                    let label_color = ['label-danger','label-success','label-warning'];
                    let html = '';
                    for(let i in data)
                    {
                        let url = "{{ url('Manages/members/detail') }}/"+data[i].id ;
                        html += '<tr>' +
                            '<td>'+data[i].id+'</td>' +
                            '<td>'+data[i].username+'</td>' +
                            '<td>'+data[i].contact+'</td>' +
                            '<td>'+data[i].create_at+'</td>' +
                            '<td><label class="label label-info">'+data[i].level_text+'</label></td>' +
                            '<td><label class="label '+label_color[data[i].status]+'">'+data[i].status_text+'</label></td>' +
                            '<td><a class="btn btn-info btn-sm" href="'+url+'">信息</a></td>' +
                            '</tr>';
                    }
                    $('.member_list tbody').html(html);


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
                                    getList({skip:skip,take:take});
                                }
                            }
                        });
                    });
                }
            })
        }
    </script>
@stop
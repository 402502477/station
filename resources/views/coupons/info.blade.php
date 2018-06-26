@extends('layouts.layout')
@section('title','优惠券信息')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">优惠券信息</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" id="info">

            </form>
        </div>
        <div class="panel-heading">
            <h3 class="panel-title">领取列表</h3>
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
                    <th>领取人ID</th>
                    <th>领取卷号</th>
                    <th>领取时间</th>
                    <th>状态</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>11</td>
                    <td>2015062471</td>
                    <td>2017-09-08</td>
                    <td>
                        <span class="label label-info">正常</span>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Simon</td>
                    <td>Philips</td>
                    <td>@simon</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Jane</td>
                    <td>Doe</td>
                    <td>@jane</td>
                </tr>
                </tbody>
            </table>
            <ul class="pagination">
                <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
            </ul>
        </div>
    </div>
@stop
@section('footer')
    <script>
        getInfo();
        function getInfo()
        {
            let html = '<div class="form-group"><label class="col-sm-2 control-label">优惠券编号</label><div class="col-sm-10"><p class="form-control-static">[id]</p></div></div><div class="form-group"><label class="col-sm-2 control-label">标题</label><div class="col-sm-10"><p class="form-control-static">[title]</p></div></div><div class="form-group"><label class="col-sm-2 control-label">使用期限</label><div class="col-sm-10"><p class="form-control-static">[time]</p></div></div><div class="form-group"><label class="col-sm-2 control-label">折扣</label><div class="col-sm-10"><p class="form-control-static">[discount]</p></div></div><div class="form-group"><label for="" class="col-sm-2 control-label">优惠券介绍</label><div class="col-sm-10"><textarea name="introduce" id="introduce" class="layui-textarea">[introduce]</textarea></div><div class="col-sm-10 col-sm-offset-2"><button class="btn btn-xs btn-info" type="button">修改</button></div></div><div class="form-group"><label for="" class="col-sm-2 control-label">库存</label><div class="col-sm-10"><p class="form-control-static col-sm-2">[stock]</p><div class="col-sm-10 form-inline"><input type="text" class="form-control input-sm"><button class="btn btn-xs btn-success" type="button">增加</button><button class="btn btn-xs btn-danger" type="button">减少</button></div></div></div>';

            $.ajax({
                url : '{{ url("api/coupon/info",$id) }}',
                type : 'get',
                dataType :'json',
                success(res)
                {
                    html = html.replace('[id]',res.id).replace('[title]',res.title).replace('[time]',res.time_limit).replace('[discount]',res.discount).replace('[introduce]',res.describes).replace('[stock]',res.stock);
                    $('#info').html(html);

                    layui.use(['layedit'],function(){
                        let introduce = layui.layedit ;
                        let content = introduce.build('introduce',{
                            hideTool:['face','image']
                        });
                    });
                }
            })
        }
    </script>
@stop
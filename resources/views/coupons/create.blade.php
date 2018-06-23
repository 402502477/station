@extends('layouts.layout')
@section('title','添加优惠券')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">添加优惠券</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" name="create_coupon" method="post" action="{{ url('api/coupon/create') }}">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="title" placeholder="请输入优惠券标题">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="type" class="col-sm-2 control-label">优惠券类型</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="type" name="type">
                            <option value="">请选择优惠券类型</option>
                            <option value="1">现金抵用券</option>
                        </select>
                        <p class="help-block"></p>
                    </div>
                    <div class="col-sm-7"></div>
                </div>
                <div class="form-group">
                    <label for="deadlineType" class="col-sm-2 control-label">使用期限类型</label>
                    <div class="col-sm-3">
                        <select name="deadline_type" class="form-control" id="deadlineType">
                            <option value="">请选择使用期限类型</option>
                            <option value="range_day">按时间区间类型</option>
                            <option value="use_day">按发起后天数类型</option>
                        </select>
                        <p class="help-block"></p>
                    </div>
                    <div class="col-sm-7"></div>
                </div>
                <div class="form-group use_day hidden">
                    <label for="deadline" class="col-sm-2 control-label">使用时间</label>
                    <div class="col-sm-3">
                        <input type="text" id="use_day" class="form-control" placeholder="请输入使用天数">
                        <p class="help-block"></p>
                    </div>
                </div>

                <div class="form-group range_day hidden">
                    <label for="range_day" class="col-sm-2 control-label">使用时间</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="range_day" placeholder="请选择时间区间">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="discount" class="col-sm-2 control-label">优惠点数</label>
                    <div class="col-sm-3">
                        <input type="number" name="discount" id="discount" class="form-control" placeholder="请输入折扣点数">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="discount_type" class="col-sm-2 control-label">优惠单位</label>
                    <div class="col-sm-3">
                        <select name="discount_type" id="discount_type" class="form-control">
                            <option value="">请选择折扣单位</option>
                            <option value="1">￥</option>
                            <option value="2">%</option>
                        </select>
                        <p class="help-block"></p>
                    </div>
                    <div class="col-sm-7"></div>
                </div>
                <div class="form-group">
                    <label for="introduce" class="col-sm-2 control-label">优惠券介绍</label>
                    <div class="col-sm-10">
                        <textarea name="introduce" id="introduce" cols="30" rows="10" class="form-control"></textarea>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="stock" class="col-sm-2 control-label">库存</label>
                    <div class="col-sm-4">
                        <input type="number" id="stock" name="stock"  class="form-control" placeholder="请输入库存总数">
                        <p class="help-block"></p>
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
    <script>
        app.onSubmit();
        $('#deadlineType').change(function(){
            let type = $('#deadlineType option:selected').val();
            if(type === 'use_day')
            {
                $('.use_day').removeClass('hidden');
                $('#use_day').attr('name','deadline');
                $('.range_day').addClass('hidden');
                $('#range_day').attr('name','');
                return;
            }
            if(type === 'range_day')
            {
                $('.use_day').addClass('hidden');
                $('#use_day').attr('name','');
                $('.range_day').removeClass('hidden');
                $('#range_day').attr('name','deadline');
                return;
            }
            $('.use_day').addClass('hidden');
            $('.range_day').addClass('hidden');
        });

        layui.use('layedit', function(){
            let introduce = layui.layedit ;

            let content = introduce.build('introduce',{
                hideTool:['face'],
                uploadImage:{
                    url:''
                },
            });
            console.log(introduce.getContent(content))
            introduce.sync(content)
        });
        layui.use('laydate', function(){
            let laydate = layui.laydate;
            laydate.render({
                elem: '#range_day',
                type:'datetime',
                range:true,
                calendar: true,
                done(value, date, endDate)
                {
                }
            });
        });
    </script>
@stop
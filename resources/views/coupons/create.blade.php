@extends('layouts.layout')
@section('title','添加优惠券')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">添加优惠券</h3>
        </div>
        <div class="panel-body">
            <form class="layui-form layui-form-pane" name="create_coupon" method="post" action="{{ url('api/coupon/create') }}">
                <div class="layui-form-item">
                    <span for="title" class="layui-form-label">标题</span>
                    <div class="layui-input-block">
                        <input type="text" name="title" autocomplete="off" class="layui-input" id="title" placeholder="请输入优惠券标题">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <span for="type" class="layui-form-label">优惠券类型</span>
                        <div class="layui-input-block">
                            <select id="type" name="type">
                                <option value="">请选择优惠券类型</option>
                                <option value="1">现金抵用券</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <span for="deadlineType" class="layui-form-label">期限类型</span>
                        <div class="layui-input-block">
                            <select name="deadline_type" id="deadlineType" lay-filter="deadlineType">
                                <option value="">请选择使用期限类型</option>
                                <option value="range_day">按时间区间类型</option>
                                <option value="use_day">按发起后天数类型</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline use_day hidden">
                        <span for="deadline" class="layui-form-label">使用时间</span>
                        <div class="layui-input-block">
                            <input type="text" id="use_day" class="layui-input" autocomplete="off" placeholder="请输入使用天数">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item range_day hidden">
                    <span for="range_day" class="layui-form-label">使用时间</span>
                    <div class="layui-input-block">
                        <input type="text" class="layui-input" id="range_day" autocomplete="off" placeholder="请选择时间区间">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-inline">
                        <span for="discount" class="layui-form-label">优惠点数</span>
                        <div class="layui-input-block">
                            <input type="number" name="discount" id="discount" class="layui-input" placeholder="请输入折扣点数" autocomplete="off">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <span for="discount_type" class="layui-form-label">优惠单位</span>
                        <div class="layui-input-block">
                            <select name="discount_type" id="discount_type">
                                <option value="">请选择折扣单位</option>
                                <option value="1">￥</option>
                                <option value="2">%</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <span for="introduce" class="layui-form-label">优惠券介绍</span>
                    <div class="layui-input-block">
                        <textarea name="introduce" id="introduce" class="layui-textarea" lay-verify="content" placeholder="请输入优惠券介绍"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <span for="stock" class="layui-form-label">库存</span>
                    <div class="layui-input-block">
                        <input type="number" id="stock" name="stock"  class="layui-input" placeholder="请输入库存总数">
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit lay-filter="*">创建</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
@section('footer')
    <script>
        layui.use(['form', 'layedit', 'laydate','layer'], function(){
            let layer = layui.layer;
            let introduce = layui.layedit ;
            let content = introduce.build('introduce',{
                hideTool:['face','image']
            });

            let laydate = layui.laydate;
            laydate.render({
                elem: '#range_day',
                type:'datetime',
                range:true,
                calendar: true
            });
            let form = layui.form;
            form.verify({
                content(){
                    introduce.sync(content);
                }
            });
            form.on('select(deadlineType)', function(data){
                let type = data.value;
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

            form.on('submit(*)', function(data){
                app.onSubmit('create_coupon',data.field,function(){
                    window.location = '{{ url('/Manages/coupons/index') }}'
                });
                return false;
            });
        });
    </script>
@stop
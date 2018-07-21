@extends('layouts.layout')
@section('title','用户信息')
@section('content')
    <div class="panel panel-profile" id="profile">
        <div class="clearfix">
            <!-- LEFT COLUMN -->
            <div class="profile-left">
                <!-- PROFILE HEADER -->
                <div class="profile-header">
                    <div class="overlay"></div>
                    <div class="profile-main">
                        <img src="{{ asset('imgs/1.jpg') }}" class="img-circle avatar" alt="Avatar">
                        <h3 class="name"></h3>
                    </div>
                </div>
                <div class="profile-detail">
                    <div class="profile-info">
                        <h4 class="heading">基本信息</h4>
                        <ul class="list-unstyled list-justify">
                            <li>用户名 <span class="name"></span></li>
                            <li>姓名 <span class="real_name"></span></li>
                            <li>性别 <span class="gender"></span></li>
                            <li>手机号 <span class="contact"></span></li>
                            <li>地址 <span class="address"></span></li>
                            <li>邮箱 <span class="email"></span></li>
                            <li>描述 <span class="desc"></span></li>
                            <li>注册时间 <span class="create_at"></span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- END LEFT COLUMN -->
            <!-- RIGHT COLUMN -->
            <div class="profile-right">
            <!-- END AWARDS -->
                <!-- TABBED CONTENT -->
                <div class="custom-tabs-line tabs-line-bottom left-aligned">
                    <ul class="nav" role="tablist">
                        <li class="active"><a href="#set" role="tab" data-toggle="tab" aria-expanded="" name="set">资料设置</a></li>
                        {{--<li class=""><a href="#log" role="tab" data-toggle="tab" aria-expanded="" name="log">操作记录</a></li>--}}
                    </ul>
                </div>
                <div class="tab-content" style="height: 682px;">
                    <div class="tab-pane fade in active" id="set">
                        <div class="table-responsive">
                            <form class="layui-form" action="">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">手机号</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="contact" placeholder="请输入手机号" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">姓名</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="real_name" placeholder="请输入真实姓名" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">性别</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="gender" value="0" title="未知">
                                        <input type="radio" name="gender" value="1" title="男">
                                        <input type="radio" name="gender" value="2" title="女">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">头像</label>
                                    <div class="layui-input-block">
                                        <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" id="up_avatar">
                                            <i class="layui-icon">&#xe67c;</i>上传
                                        </button>
                                        <input type="hidden" name="avatar" value="">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">地址</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="address" placeholder="请输入地址" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item layui-form-text">
                                    <label class="layui-form-label">描述</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="desc" placeholder="请输入账号描述" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <div class="layui-input-block">
                                        <button class="layui-btn" lay-submit lay-filter="formDemo">保存</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade in" id="log">
                        <div class="table-responsive">
                            <table class="table project-table">
                                <thead>
                                <tr>
                                    <th>编号</th>
                                    <th>金额</th>
                                    <th>状态</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <a href="/Manages/orders/info/[ID]">[NUMBER]</a>
                                    </td>
                                    <td>￥[PRICE]</td>
                                    <td>[STATUS]</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="margin-top-30 text-center">
                            <ul class="pagination" id=""></ul>
                        </div>
                    </div>
                </div>
                <!-- END TABBED CONTENT -->
            </div>
            <!-- END RIGHT COLUMN -->
        </div>
    </div>
@stop
@section('footer')
    <script>
        layui.use(['form','upload'], function(){
            let form = layui.form;
            let upload = layui.upload;
            getData();
            function getData()
            {
                $.ajax({
                    url : '/api/auth/get',
                    data : { uid : "{{ $uid }}"},
                    beforeSend()
                    {
                        app.showPreLoading();
                    },
                    success(r)
                    {
                        if(r.status == 0)
                        {
                            app.alert({
                                content: r.msg
                            });
                            return null;
                        }
                        if(r.data)
                        {
                            $('.name').text(r.data.name);
                            $('.contact').text(r.data.info.contact);
                            $('.desc').text(r.data.info.desc);
                            $('.gender').text(r.data.info.gender);
                            $('.address').text(r.data.info.address);
                            $('.real_name').text(r.data.info.real_name);
                            $('.address').text(r.data.info.address);
                            $('.email').text(r.data.email);
                            $('.create_at').text(r.data.created_at);
                            $('.avatar').attr('src',r.data.info.avatar);

                            $('input[name=contact]').val(r.data.info.contact);
                            $('input[name=desc]').val(r.data.info.desc);
                            $('input[name=gender][title='+r.data.info.gender+']').attr('checked','false');
                            $('input[name=address]').val(r.data.info.address);
                            $('input[name=real_name]').val(r.data.info.real_name);
                            $('input[name=avatar] ').val(r.data.info.avatar);
                        }
                        form.render();

                        app.hidePreLoading();
                    }
                });
            }



            form.on('submit(formDemo)',function(data){
                let dt = data.field;
                dt['uid'] = "{{$uid}}";

                $.ajax({
                    url : '/api/auth/set',
                    data : dt,
                    type : 'post',
                    dataType :'json',
                    beforeSend()
                    {
                        app.showPreLoading();
                    },
                    success(r)
                    {
                        app.alert({
                            content: r.msg
                        });
                        getData();
                        app.hidePreLoading();
                    }
                });
                return false;
            });

            upload.render({
                elem: '#up_avatar',
                url: '/api/upload',
                before()
                {
                    app.showPreLoading();
                },
                done(res)
                {
                    $('input[name=avatar]').val(res.path);
                    $('.avatar').attr('src',res.path);
                    app.hidePreLoading();
                }
            });
        });

        function get()
        {

        }
    </script>
@stop
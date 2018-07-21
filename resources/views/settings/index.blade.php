@extends('layouts.layout')
@section('title','基本设置')
@section('content')
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">公众号设置</h3>
        </div>
        <div class="panel-body">
            <form class="layui-form" action="" id="setting" enctype="multipart/form-data">
                <div class="layui-form-item">
                    <label class="layui-form-label">首页标题</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" placeholder="请输入标题" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <hr>
                <div class="layui-form-item line logo_block">
                    <label class="layui-form-label">LOGO</label>
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn layui-btn-sm" id="logo">
                            <i class="layui-icon">&#xe67c;</i>上传图片
                        </button>
                        <div class="line">
                            <img src="" alt="" class="img-rounded">
                            <input type="hidden" name="logo_img" value="">
                        </div>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux">显示在公众号底部的logo图片，留空将关闭该功能！</div>
                <hr>
                <div class="layui-form-item carousel_block">
                    <label class="layui-form-label">首页轮播图</label>
                    <div class="layui-input-block">
                        <div class="line">
                            <button type="button" class="layui-btn layui-btn-praimary layui-btn-sm add-line" data-type="carousel_html" data-overflow="5">
                                <i class="layui-icon">&#xe654;</i>增加行
                            </button>
                        </div>
                        <table class="layui-table">
                            <thead>
                            <tr>
                                <th class="col-sm-4">图片</th>
                                <th class="col-sm-5">跳转地址</th>
                                <th class="col-sm-3">
                                </th>
                            </tr>
                            </thead>
                            <tbody class="add_block"></tbody>
                        </table>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux">首页显示的轮播图及其跳转功能，无内容将关闭轮播图功能，最多添加五行轮播！</div>
                <hr>
                <div class="layui-form-item product_block">
                    <label class="layui-form-label">产品</label>
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn layui-btn-praimary layui-btn-sm add-line" data-type="product_html" data-overflow="10">
                            <i class="layui-icon">&#xe654;</i>增加行
                        </button>
                        <div class="add_block"></div>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux">产品选项，用于区分优惠券部分，最多添加十行记录！</div>
                <hr>
                <div class="layui-form-item">
                    <label class="layui-form-label">余额功能</label>
                    <div class="layui-input-block layui-form-pane">
                        <div class="line">
                            <input type="checkbox" name="balance" lay-skin="switch" lay-text="开启|关闭">
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">充值限制</label>
                            <div class="layui-input-block">
                                <input type="text" name="balance_limit" placeholder="请输入充值限制金额，为空时表示无限制" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">优惠点数</label>
                            <div class="layui-input-inline">
                                <input type="text" name="balance_point" placeholder="请输入优惠点数" autocomplete="off" class="layui-input">
                            </div>
                            <label class="layui-form-label">优惠类型</label>
                            <div class="layui-input-inline">
                                <select name="balance_type">
                                    <option value="">请选择优惠类型</option>
                                    <option value="%">%</option>
                                    <option value="￥">￥</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-form-mid layui-word-aux">开启或关闭余额支付、充值功能！</div>
                <hr>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">保存更改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="layui-hide">
        <table >
            <tbody id="carousel_line">
                <tr class="line">
                    <td class="text-center">
                        <img src="" alt="" class="img-rounded">
                        <input type="hidden" name="carousel[-id-][img]" value="-img-">
                    </td>
                    <td><input type="text" name="carousel[-id-][url]" placeholder="请输入完整的跳转地址，例如：http:// 、https:// 或 留空 " autocomplete="off" class="layui-input" value="-url-"></td>
                    <td class="text-center">
                        <button type="button" class="layui-btn layui-btn-sm" id="upload-id-">
                            <i class="layui-icon">&#xe67c;</i>上传图片
                        </button>

                        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm" onclick="remove(this)">
                            <i class="layui-icon">&#xe640;</i>删除行
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="product_line">
            <div class="line layui-clear">
                <div class="col-sm-10">
                    <input type="text" name="product[-id-]" placeholder="请输入产品名称" class="layui-input" value="[product]">
                </div>
                <div class="col-sm-2">
                    <button type="button" class="layui-btn layui-btn-danger" onclick="remove(this)">
                        <i class="layui-icon">&#xe640;</i>删除行
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
    <script>
        layui.use(['form','upload'], function(){
            let form = layui.form;
            let upload = layui.upload;
            let html = {
                'product_html' : $('#product_line').html(),
                'carousel_html' : $('#carousel_line').html()
            };
            get(form,html);

            //新增行
            $('.add-line').click(function(){
                let object = $(this);
                let type = object.data('type');
                let overflow = parseInt(object.data('overflow'));
                let lay = object.parents('.layui-form-item').find('.add_block');
                let over = lay.children().length;
                if(lay.find('.line').length >= overflow)
                {
                    app.alert({
                        content:'已达添加上限！'
                    });
                    return null;
                }
                let reg = new RegExp( '-id-' , "g" );
                let now = Date.now();
                if(over)
                {
                    lay.find('.line:last').after(html[type].replace(reg,now).replace('-img-','').replace('-url-','').replace('[product]',''));
                    upload_file('#upload'+now,upload);
                    return null;
                }
                lay.html(html[type].replace(reg,now).replace('-img-','').replace('-url-','').replace('[product]',''));

                upload_file('#upload'+now,upload);
            });


            form.on('submit(formDemo)', function(data){
                $.ajax({
                    url : '/api/setting/set',
                    data : data.field,
                    type : 'post',
                    dataType : 'json',
                    beforeSend()
                    {
                        app.showPreLoading();
                    },
                    complete(res)
                    {
                        let status = res.status;
                        let response = res.responseJSON;
                        if(status == 200)
                        {
                            app.alert({content:response.msg});
                        }
                        if(status == 422)
                        {
                            let content = '';
                            for (let i in response.errors)
                            {
                                content += response.errors[i];
                            }
                            app.alert({content:content});
                        }
                        app.hidePreLoading();
                    }
                });

                return false;
            });

            upload_file('#logo',upload);
        });


        function upload_file(object,upload)
        {
            upload.render({
                elem: object,
                url: '/api/upload',
                before()
                {
                    app.showPreLoading();
                },
                done(res)
                {
                    $(object).parents('.line').find('img').attr('src',res.path);
                    $(object).parents('.line').find('input[type=hidden]').val(res.path);
                    app.hidePreLoading();
                },
                error()
                {
                    app.hidePreLoading();
                }
            });
        }
        //删除行
        function remove(object)
        {
            app.alert({
                content:'确定要删除该行内容？',
                showCancel:true,
                onSure()
                {
                    $(object).parents('.line').remove();
                }
            });
        }
        //异步获取页面信息
        function get(form,html)
        {
            $.ajax({
                url : '/api/setting/get',
                dataType : 'json',
                beforeSend()
                {
                    app.showPreLoading();
                },
                success(r)
                {
                    if(r.length == 0)
                    {
                        app.hidePreLoading();
                        return null;
                    }
                    $('.logo_block img').attr('src',r.logo_img);
                    $('.logo_block input[type=hidden]').val(r.logo_img);
                    $('input[name=title]').val(r.title);
                    let carousel = '';
                    for(let i in r.carousel)
                    {
                        carousel += html['carousel_html'].replace('-id-',i).replace('-id-',i).replace('-img-',r.carousel[i].img).replace('-url-',r.carousel[i].url).replace('img src=""','img src="'+ r.carousel[i].img +'"');
                    }
                    $('.carousel_block .add_block').html(carousel);
                    let product = '';
                    for(let i in r.product)
                    {
                        product += html['product_html'].replace('-id-',i).replace('[product]',r.product[i]);
                    }
                    $('.product_block .add_block').html(product);
                    if(r.balance)
                    {
                        if(r.balance.switch) $('input[name=balance]').attr('checked','checked');
                        if(r.balance.point) $('input[name=balance_point]').val(r.balance.point);
                        if(r.balance.limit) $('input[name=balance_limit]').val(r.balance.limit);
                        if(r.balance.type) $('[name=balance_type] option[value="'+r.balance.type+'"]').attr('selected','selected');
                    }

                    app.hidePreLoading();
                    form.render();
                }
            });
        }
    </script>
@stop
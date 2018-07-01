<?php $__env->startSection('title','优惠券信息'); ?>
<?php $__env->startSection('content'); ?>
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
                            <select class="form-control input-sm" name="search">
                                <option value="">请选择搜索类型</option>
                                <option value="mid">用户ID</option>
                                <option value="number">卡券编号</option>
                            </select>
                            <input type="text" class="form-control input-sm" name="keywords">
                            <button class="btn btn-default btn-sm" type="button" name="searching">搜索</button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-hover coupon_collect_list">
                <thead>
                <tr>
                    <th>领取人ID</th>
                    <th>领取卷号</th>
                    <th>用户名称</th>
                    <th>状态</th>
                    <th>领取时间</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>[ID]</td>
                    <td>[NUMBER]</td>
                    <td>[USER]</td>
                    <td>[STATUS]</td>
                    <td>[TIME]</td>
                </tr>
                </tbody>
            </table>
            <ul class="pagination" id="pagination">
            </ul>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script>
        let skip = 0;
        let take = 10;
        let search;
        let keywords;

        let collect_html;
        collect_html = $('.coupon_collect_list tbody').html();
        getData(collect_html);
        function getData(html)
        {
            let type = [
                '',
                '<span class="label label-success">未使用</span>',
                '<span class="label label-info">已使用</span>',
                '<span class="label label-danger">禁用</span>',
            ];
            $.ajax({
                url :  '/api/coupon/collect/get/<?php echo e($id); ?>',
                type : 'post',
                data : {
                    search : search|| null,
                    skip : skip|| null,
                    take : take|| null,
                    keywords :keywords || null
                },
                dataType : 'json',
                beforeSend()
                {
                    app.showPreLoading();
                },
                success(r)
                {
                    let data = r.data;
                    let content = '';
                    if(data)
                    {
                        for(let i in data)
                        {
                            content += html.replace('[ID]',data[i].mid).replace('[NUMBER]',data[i].number).replace('[USER]',data[i].username).replace('[TIME]',data[i].create_at).replace('[STATUS]',type[data[i].status]);
                        }
                    }
                    $('.coupon_collect_list tbody').html(content);
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
                                    skip = (obj.curr-1) * r.limit;
                                    getData(collect_html);
                                }
                            }
                        });
                    });

                    app.hidePreLoading();
                }
            });
        }
        //改变显示长度
        $('select[name=length]').change(function(){
            take = $(this).val();
            getData(collect_html);
        });
        //搜索
        $('button[name=searching]').click(function(){
            search = $('select[name=search]').val();
            keywords = $('input[name=keywords]').val();
            getData(collect_html);
        });



        /* 获取卡券信息部分 */
        getInfo();
        function getInfo()
        {
            let html = '<div class="form-group"><label class="col-sm-2 control-label">优惠券编号</label><div class="col-sm-10"><p class="form-control-static">[id]</p></div></div><div class="form-group"><label class="col-sm-2 control-label">标题</label><div class="col-sm-10"><p class="form-control-static">[title]</p></div></div><div class="form-group"><label class="col-sm-2 control-label">发放时间</label><div class="col-sm-10"><p class="form-control-static">[send_type]</p></div></div><div class="form-group"><label class="col-sm-2 control-label">使用期限</label><div class="col-sm-10"><p class="form-control-static">[time]</p></div></div><div class="form-group"><label class="col-sm-2 control-label">折扣</label><div class="col-sm-10"><p class="form-control-static">[discount]</p></div></div><div class="form-group"><label for="" class="col-sm-2 control-label">优惠券介绍</label><div class="col-sm-10"><p class="form-control-static">[introduce]</p></div><div class="col-sm-10 col-sm-offset-2"></div></div><div class="form-group"><label for="" class="col-sm-2 control-label">库存</label><div class="col-sm-10"><p class="form-control-static col-sm-2">[stock]</p><div class="col-sm-10 form-inline"><input type="number" class="form-control input-sm" name="num"> <button class="btn btn-xs btn-success change_stock" type="button" data-type="plus">增加</button> <button class="btn btn-xs btn-danger change_stock" type="button" data-type="down">减少</button></div></div></div><div class="form-group"><label class="col-sm-2 control-label">状态切换</label><div class="col-sm-10"><p class="form-control-static">[button]</p></div></div>';

            $.ajax({
                url : '<?php echo e(url("api/coupon/info",$id)); ?>',
                type : 'get',
                dataType :'json',
                beforeSend()
                {
                    app.showPreLoading();
                },
                success(res)
                {
                    let button = '';
                    if(res.status === 1)
                    {
                        button = '<button type="button" class="btn btn-warning btn-sm change_status">关闭</button>'
                    }
                    if(res.status === 2)
                    {
                        button = '<button type="button" class="btn btn-success btn-sm change_status">开启</button>'
                    }
                    html = html.replace('[id]',res.id).replace('[title]',res.title).replace('[time]',res.time_limit).replace('[discount]',res.discount).replace('[introduce]',res.describes).replace('[stock]',res.stock).replace('[button]',button).replace('[send_type]',res.send_type_text);
                    $('#info').html(html);

                    app.hidePreLoading();

                    //改变库存
                    $('.change_stock').click(function(){
                        let num = $('input[name=num]').val();
                        let type = $(this).data('type');
                        $.ajax({
                            url : "<?php echo e(url('api/coupon/stock')); ?>",
                            type : 'post',
                            data:{
                                num:num ,
                                type:type,
                                id : res.id
                            },
                            dataType:'json',
                            success(r)
                            {
                                if(r.code)
                                {
                                    app.alert({
                                        content:r.msg,
                                        onSure(){
                                            getInfo()
                                        }
                                    });
                                    return;
                                }
                                return app.alert({content:r.msg});
                            }
                        });
                        return null;
                    });

                    //改变状态
                    $('.change_status').click(function(){
                        let obj = $(this);
                        $.ajax({
                            url : "<?php echo e(url('api/coupon/status')); ?>",
                            data:{
                                id : res.id
                            },
                            dataType:'json',
                            beforeSend(){
                                obj.html('<i class="fa fa-refresh fa-spin"></i> 稍等...').attr('disabled','disabled');
                            },
                            success(r)
                            {
                                if(r.code)
                                {
                                    app.alert({content:r.msg});
                                    let data = {
                                        1:{remove : 'btn-success',add:'btn-warning',html:'关闭'},
                                        2:{remove : 'btn-warning',add:'btn-success',html:'开启'},
                                    };
                                    obj.html(data[r.info.status].html).attr('disabled',false).addClass(data[r.info.status].add).removeClass(data[r.info.status].remove);
                                    return;
                                }
                                return app.alert({content:r.msg});
                            }
                        });
                    });
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
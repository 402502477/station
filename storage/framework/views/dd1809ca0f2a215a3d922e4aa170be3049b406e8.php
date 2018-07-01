<?php $__env->startSection('title','订单管理'); ?>
<?php $__env->startSection('content'); ?>
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
                        
                        <button class="btn btn-danger btn-sm batchHandle" type="button" data-type="delete">批量删除</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <div class="form-group">
                            <select class="form-control input-sm" name="search">
                                <option value="">请选择搜索类型</option>
                                <option value="id">订单编号</option>
                            </select>
                            <input type="text" class="form-control input-sm"  name="keywords">
                            <button class="btn btn-default btn-sm" type="button" name="searching">搜索</button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-hover orders_list">
                <thead>
                <tr>
                    <th>
                        <label class="fancy-checkbox full-switch">
                            <input type="checkbox">
                            <span></span>
                        </label>
                    </th>
                    <th>ID</th>
                    <th>订单编号</th>
                    <th>总金额</th>
                    <th>支付金额</th>
                    <th>创建时间</th>
                    <th>订单状态</th>
                    <th>用户姓名</th>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script>
        getList();
        let take = 10; //全局化页面数据显示长度
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
        //批量删除
        $('.batchHandle').click(function(){
            let data = app.getCheckId();
            if(data.length)
            {
                $.ajax({
                    url:'<?php echo e(url('api/order/delete')); ?>',
                    type :'post',
                    data:{
                        id : data
                    },
                    dataType:'json',
                    success(r)
                    {
                        if(r.code)
                        {
                            return app.alert({content:r.msg,onSure(){getList({take : take,search : search,keywords : keywords})}})
                        }
                        return app.alert({content:r.msg});
                    }
                });
                return;
            }
            return app.alert({content:'请先选择需要删除的项目！'})
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
                        url : '<?php echo e(url("api/order/delete")); ?>',
                        data : {
                            id : id
                        },
                        type : 'post',
                        dataType : 'json',
                        success(r)
                        {
                            if(r.code)
                            {
                                $(obj).parents('tr').remove();
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
                url : "<?php echo e(url('api/order/get')); ?>",
                data : dt,
                method : method || 'post',
                success (r)
                {
                    let data = r.data;
                    let label_color = ['label-danger','label-success','label-warning'];
                    let html = '';
                    for(let i in data)
                    {
                        html += '';
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
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
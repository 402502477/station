let app = {
    server_url: '',
    api_url: '',
    api_options : '',
    onFullSwitch() {
        $('.full-switch input[type=checkbox]').change(function () {
            let obj = $('input[type=checkbox]');
            for (let i = 1; i < obj.length; i++) {
                if (obj.eq(i).is(':checked')) {
                    obj.eq(i).prop('checked', false);
                    continue;
                }
                obj.eq(i).prop('checked', true);
            }
        });
    },
    getCheckId() {
        let obj = $('input[type=checkbox]');
        let data = [];
        for (let i = 1; i < obj.length; i++) {
            if (obj.eq(i).is(':checked')) {
                data.push(obj.eq(i).data('id'));
            }
        }
        return data;
    },
    showPreLoading() {
        $('body').css('overflow', 'hidden');
        $('.mask').show();

    },
    hidePreLoading() {
        $('.mask').hide();
        $('body').css('overflow', '');
    },
    onPreLoading() {
        app.showPreLoading();
        document.onreadystatechange = function () {
            if (document.readyState === 'complete') {
                app.hidePreLoading();
            }
        }
    },
    alert(options) {
        let modal = $('#modalBlock');
        modal.on('show.bs.modal',function(){
            modal.find('.modal-title').text(options.title || '提示');
            modal.find('.modal-body').text(options.content || '');
            if(options.showCancel){
                modal.find('.onCancel').show();
            }else{
                modal.find('.onCancel').hide()
            }
            modal.find('.onCancel').off("click");
            modal.find('.onSure').off("click");
            modal.find('.onCancel').click(options.onCancel || function(){});
            modal.find('.onSure').click(options.onSure || function(){});
        });
        modal.modal('toggle');
    },
    onSubmit(from_name,data,callback)
    {
        let form = $('form[name=' + from_name + ']');
        let method = form.attr('method');
        let action = form.attr('action');
        $.ajax({
            url : action,
            type : method || 'get',
            data : data,
            beforeSend()
            {
                app.showPreLoading();
            },
            complete(r)
            {
                console.log(r);
                if(r.status === 200)
                {
                    if(r.responseJSON.code === 1)
                    {
                        app.alert({
                            content : r.responseJSON.msg,
                        });
                        return app.hidePreLoading();
                    }
                    app.alert({
                        content : r.responseJSON.msg,
                    });
                    return app.hidePreLoading();
                }
                if(r.status === 422)
                {
                    let errors = r.responseJSON.errors;
                    let is_focus = false
                    for(let i in data)
                    {
                        if(errors[i])
                        {
                            if(!is_focus)
                            {
                                $('[name=' + i + ']').addClass('layui-form-danger');
                                $('[name=' + i + ']').focus();
                                is_focus = true;
                                app.alert({
                                    content : errors[i][0],
                                });
                                continue;
                            }
                        }
                        $('[name=' + i + ']').removeClass('layui-form-danger');
                    }
                    return app.hidePreLoading();

                }
                if(r.status === 500)
                {
                    app.alert({
                        content : r.responseJSON.message,
                    });
                    return app.hidePreLoading();
                }
            }
        });
    }
};
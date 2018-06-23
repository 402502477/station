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
    onSubmit(callback)
    {
        $('button[type=submit]').click(function(){
            let form = $(this).parents('form');
            let data = form.serializeArray();
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
                    let feedback = $('p.help-block');
                    for(let i = 0;i<feedback.length ; i++)
                    {
                        feedback.eq(i).html('');
                        feedback.parents('.form-group').removeClass('has-error').addClass('has-success');
                    }

                    if(r.status === 422)
                    {
                        let errors = r.responseJSON.errors;
                        for(let i in errors)
                        {
                            $('[name='+i+']').parents('.form-group').removeClass('has-success').addClass('has-error');
                            $('[name='+i+'] + .help-block').html();
                            $('[name='+i+'] + .help-block').html(errors[i]);
                        }
                    }
                    console.log(r);
                    app.hidePreLoading();
                }
            });
            return false;
        });
    }
};
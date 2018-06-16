let app = {
    server_url: '',
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
    alert() {

    }
};
let app ={
    buildUrl : '',
    navigateTo(url){
        window.location = url;
    },
    alert(layer,msg,anim,icon,time)
    {
        layer.open({
            shadeClose:true,
            closeBtn:false,
            shade:false,
            title: false,
            btn:false,
            time:time||1500,
            anim: anim||6,
            icon: icon||5,
            content:msg
        });
    },
    get()
    {
        let url = window.document.location.href.toString();
        let u = url.split("?");
        if(typeof(u[1]) == "string"){
            u = u[1].split("&");
            let get = {};
            for(let i in u){
                let j = u[i].split("=");
                get[j[0]] = j[1];
            }
            return get;
        } else {
            return {};
        }
    }
};
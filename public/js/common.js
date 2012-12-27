$.post_withck = function( url, data, callback, type, traditional) {
    if ($.isFunction(data)) {
        type = callback;
        callback = data;
        data = {};
    }
    return $.ajax({
        type: "POST",
        traditional: typeof traditional == 'undefined' ? true : traditional,
        url: url,
        data: $.extend(data,{ck:get_cookie('ck')}),
        success: callback,
        dataType: type || 'text'
    });
};
// 转移==> core/cookie.js
var set_cookie = function(dict, days, domain, path){
    var date = new Date();
    date.setTime(date.getTime()+((days || 30)*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
    for (var i in dict){
        document.cookie = i+"="+dict[i]+expires+"; domain=" + (domain || "12ik.com") + "; path=" + (path || "/");
    }
}
// 转移==> core/cookie.js
function get_cookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length,c.length).replace(/\"/g,'');
        }
    }
    return null;
}

function pop_win (htm, hide_close) {
    if (!window.__pop_win) {
        var pop_win_bg = document.createElement('div');
        pop_win_bg.className = 'pop_win_bg';
        document.body.appendChild(pop_win_bg);

        var pop_win_body = document.createElement('div');
        pop_win_body.className = 'pop_win';
        document.body.appendChild(pop_win_body);

        __pop_win = {
            bg: pop_win_bg,
            body: pop_win_body,
            body_j: $(pop_win_body),
            bg_j: $(pop_win_bg)
        };
    }
    var b = __pop_win.body,
        body_j = __pop_win.body_j,
        dom = js_parser(htm);

    if (hide_close !== true) {
        dom.htm = '<a onclick="pop_win.close()" href="javascript:;" class="pop_win_close">X</a>' + dom.htm;
    }
    b.innerHTML = dom.htm;
    var cr = {
        left: '50%',
        top: '50%',
        marginLeft: -(b.offsetWidth/2) + 'px',
        marginTop: -(b.offsetHeight/2) + 'px'
    };
    if(document.documentElement.clientHeight<b.offsetHeight){
        cr.top = '0';
        cr.marginTop = '0';
        cr.height = document.documentElement.clientHeight - 40 + 'px';
        cr.overflow = 'auto';
    }
    body_j.css({ display: 'block' }).css(cr).css({ visibility: 'visible', zIndex: 9999});
    dom.js();
    pop_win.fit();
    if(!window.XMLHttpRequest){
        __pop_win.bg.style.top = '';
        __pop_win.bg.style.marginTop = '';
    }
}

pop_win.fit = function () {
    if (window.__pop_win) {
        var b=__pop_win.body;
        var h = b.offsetHeight + 16;
        var w = b.offsetWidth + 16;
        __pop_win.bg_j.css({
            height: h + 'px',
            width: w + 'px',
            left: '50%',
            top: '50%',
            marginTop: -(h/2) + 'px',
            marginLeft: -(w/2) + 'px',
            zIndex: 8888
        }).show();
    }
}

pop_win.close=function(){
    $(__pop_win.bg).remove()
    $(__pop_win.body).remove();
    window.__pop_win = null;
}

pop_win.load=function(url,cache){
    pop_win("<div style=\"padding:20px 60px;\">加载中, 请稍等...</div>")
    $.ajax({url: url, success: pop_win, cache: cache||false, dataType: 'html'});
    return false
}
function js_parser(htm){
    var tag="script>",begin="<"+tag,end="</"+tag,pos=pos_pre=0,result=script="";
    while(
        (pos=htm.indexOf(begin,pos))+1
    ){
        result+=htm.substring(pos_pre,pos);
        pos+=8;
        pos_pre=htm.indexOf(end,pos);
        if(pos_pre<0){
            break;
        }
        script+=htm.substring(pos,pos_pre)+";";
        pos_pre+=9;
    }
    result+=htm.substring(pos_pre,htm.length);

    return {
        htm:result,
        js:function(){eval(script)}
    };
}
var paras = function(s){
    var o = {};
    if(s.indexOf('?') == -1) return {};
    var vs = s.split('?')[1].split('&');
    for(var i=0;i<vs.length;i++){
        if(vs[i].indexOf('=') != -1){
            var k = vs[i].split('=');
            o[k[0]+''] = k[1] + '';
        }
    }
    return o;
}
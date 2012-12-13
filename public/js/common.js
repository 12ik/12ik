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
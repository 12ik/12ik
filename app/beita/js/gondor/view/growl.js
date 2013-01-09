define("gondor/view/growl",["lib/jquery","mod/lang","mod/template","mod/mainloop","gondor/observer","mod/domready"],function(h,m,f,c,k){var l=f.format,d='<div class="growl-pop">{{0}}</div>',j='<div class="growl-pop growl-custom">{{0}}</div>',b=1,a={},i={"default":".growl-default",center:".growl-center"},e={drop:{show:function(r,q,o){var p=r[0].offsetHeight;r.css("marginTop",-p).show();c.animate("growl:show",-p,0,600,{easing:"easeInOutCubic",step:function(s){r[0].style.marginTop=s+"px"}}).animate("growl:show",r.css("opacity"),0.8,600,{easing:"easeInOutCubic",step:function(s){r.css("opacity",s)},callback:o})},hide:function(r,q,o){var p=r[0].offsetHeight;c.animate("growl:hide",parseFloat(r.css("margin-top")),-p,400,{easing:"swing",step:function(s){r[0].style.marginTop=s+"px"}}).animate("growl:hide",r.css("opacity"),0,400,{easing:"swing",step:function(s){r.css("opacity",s)},callback:o})}},fadeFocus:{show:function(s,q,o){var r=h(window),p=s[0].offsetHeight;s.css("margin-top",(r.height()-p)/2).show();c.animate("growl:fade",0,1,400,{step:function(t){s.css("opacity",t)},callback:o})},hide:function(q,p,o){c.animate("growl:fade",1,0,200,{step:function(r){q.css("opacity",r)},callback:function(){c.remove("growl:fade");o.apply(this,arguments)}})}},slideTopRight:{hide:function(r,q,p){var s=r.offset(),o=h(".userbar .myinfo").offset();r.css({marginTop:0,position:"absolute",top:s.top,left:s.left});c.animate("growl:slide",s.top,o.top+10,400,{easing:"easeInOutSine",step:function(t){r[0].style.top=t+"px"}}).animate("growl:slide",s.left,o.left+10,400,{easing:"easeInOutSine",step:function(t){r[0].style.left=t+"px"}}).animate("growl:slide",r[0].offsetWidth,0,400,{easing:"easeInOutSine",step:function(t){r[0].style.width=t+"px"}}).animate("growl:slide",r[0].offsetHeight,0,400,{easing:"easeInOutSine",step:function(t){r[0].style.height=t+"px"},callback:function(){c.remove("growl:slide");p.apply(this,arguments);k.fire("growl:slideover")}})}}},n={"badge:achieve":'<div class="badgebox badge-{{kind}}"><div class="bg"></div><div class="box"><div class="icon"></div><h6>{{title}}</h6><p>{{desc}}</p><input type="button" class="lnk-flat ok" value="我知道了"><span class="award-dou{{without_dou}}">奖励: <strong><span class="refer-price" title="阿尔法圆">{{n_dou}}</span></strong></span></div></div>',"badge:info":'<div class="badgebox badge-{{kind}}"><div class="bg"></div><div class="box"><div class="icon"></div><h6>{{name}}</h6><p>{{desc}}</p><input type="button" class="lnk-flat ok" value="关闭"></div></div>',"encounter:dou":'<div class="bd">{{msg}}<strong><span class="refer-price" title="阿尔法圆">{{num}}</span></strong>！</div>',"server:notice":'<div class="bd"><strong>{{title}}: </strong>{{msg}}</div>'};e.slideTopRight.show=e.fadeFocus.show;var g={setCorners:function(o,p){i[o]=p},send:function(q,r,p){p=p||{};if(!p.id){p.id="_auto_"+b++}else{if(a[p.id]){if(!p.isReplace){return}this.remove(p.id)}}if(r){p.msg=r}var o=l(n[q]||'<div class="bd">{{msg}}</div>',p);this.pop(o,h(i[p.corner||"default"]),p.age||p.age!==0&&10000||0,e[p.effect||"drop"],p)},pop:function(v,r,u,x,p){if(!u){if(p.after){p.after(p)}a[p.id]=[null,p,+new Date()]}else{if(r){var w=this;var t=r.lastChild;var q=function(){if(!s){return}x.hide(s,t,function(){w.remove(p.id)})};var s=h(l(p.customStyle?j:d,[v])).prependTo(r);var o=p.hasButton?s.find(".ok"):s;o.click(function(){q();if(p.onclick){p.onclick(p)}});x.show(s,t,function(){if(u>0){setTimeout(q,u)}if(p.area){k.bind("viewport:ready",function(y){if(p.area.indexOf(parseInt(y,10))===-1){p.age=1;q();k.unbind("viewport:ready",arguments.callee)}})}if(p.after){p.after(p)}});a[p.id]=[s,p,+new Date()]}}},remove:function(q){var r=a[q];if(!r){return}var p=r[0],o=r[1].hasButton?p.find(".ok"):p;o.unbind("click");p.remove();if(r[1].age>0&&+new Date()-r[2]>r[1].age){delete a[q]}}};return g});
define("gondor/view/widget",["lib/jquery","mod/lang","mod/network","mod/template","gondor/observer","gondor/view/dialog"],function(e,l,j,c,h,g){var d="/api",f=d+"/widget/{{wid}}/?source={{src}}",b=d+"/widget/{{wid}}/admin",k={init:function(){},activate:function(){},inactivate:function(){},destroy:function(){}},i={};var a={vision:0,reset:function(){this.inactivate();this.destroy();var m;for(var n in i){m=i[n];m.inactivate(m.id,m.wrapper);m.destroy(m.id,m.wrapper)}i={};this.vision=0},changeHost:function(m){this.host=m},load:function(q,m){var n=this,o=this.host.activity[this.host.vision],p=o.widget_id;if(!p){return}this.vision=p;if(i[p]){n.activate()}else{j.ajax({url:o.widgetAPI||c.format(f,{wid:p,src:o.kind<4?"street":""}),success:function(s){if(q!=n.host.vision){return}var r=i[p]=Object.create(k);r.id=p;h.wait("widget:run",function(){r.wrapper=e("#widget-"+p);n.init();n.activate()});if(m){m(s)}else{e(".widget-box",o.dom).html(s)}}})}},config:function(n){n.sandboxed=true;var m=i[this.vision];if(m){l.mix(m,n)}},init:function(){var m=i[this.vision];if(m){return m.init(m.id,m.wrapper)}},activate:function(){var m=i[this.vision];if(m){return m.activate(m.id,m.wrapper)}},inactivate:function(){h.reset("widget:nav");var m=i[this.vision];if(m){h.reset("widget:run");return m.inactivate(m.id,m.wrapper)}},destroy:function(){var m=i[this.vision];if(m){delete i[this.vision];return m.destroy(m.id,m.wrapper)}},nav:function(m){m.widget_id=this.vision;h.resolve("widget:nav",[m])},showAdmin:function(m){g.set({isHideTitle:true,iframeURL:c.format(b,{wid:m}),width:500,buttons:[]}).open()}};return a});
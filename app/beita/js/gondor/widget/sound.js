define("gondor/widget/sound",["lib/jquery","mod/lang","gondor/toolkit","mod/scrollbar","gondor/view","gondor/view/dialog","gondor/widget/common","gondor/observer","gondor/sandbox"],function(g,t,c,a,j,r,k,o,n){var s=r.node[0],l=r.body,d="tplSounds",f="tplSoundAdd",b="tplSoundList",p=".wgt-opt",i=".post-area",e=".comment-input",h=".comment-submit",m=".submit";var q=function(v){var E=v.pid,C=v.wid,y=v.userInfo,G={userInfo:y,widgetInfo:{pid:E,wid:C}},F=g("#widget-"+C+" .sound-topic-list"),M=g("ul",F),u=g(".list-wrap",F),L=g(".bn-post",F),H=E?"/api/place/"+E+"/widget/"+C:"/api/widget/"+C,N=H+"/discussion/",w=H+"/forum_add?needauth=1",D=H+"/forum_edit",J=H+"/forum_list";var A=new n({init:function(O,P){k.init();K();k.scrollLoad(u,{action:x});L.bind("click",function(Q){Q.preventDefault();r.set({isHideTitle:true,iframeURL:w,width:730,buttons:[]}).open()});F.delegate(".sound-item","click",function(R){R.preventDefault();var S=g(this).data("tid"),Q=g(this).data("nav-id");A.navigate({id:S,navId:Q})})},activate:function(O,P){o.bind("street:refresh",K);o.bind("street:opentopic",function(Q){K();A.navigate({id:Q.id,navId:Q.content_id})});o.wait("widget:nav",function(Q){A.navigate(Q)})},inactivate:function(O,P){o.unbind("street:refresh");o.unbind("street:opentopic")},destroy:function(O,P){u.remove();L.remove();F.remove()}});A.navigate=function(O){var Q=O.id,R=O.navId,P=O.index;r.loading({width:730,isHideTitle:true});B(Q,R)};function I(O,P){P=P||0;O.css("height",parseInt(g("#widget-"+C).parents(".folder-wrapper").css("height"),10)-P)}function B(P,O){k.render({url:N+P+"/view",data:G,wrapper:l,method:"html",tplname:d},"loaded");if(O){o.fire("app:query from widget",[{cid:O}])}k.evt.wait("loaded",function(Q){r.update();var R=l.find(".sound-detail");R.delegate(".wgt-opt","click",function(S){S.preventDefault();switch(S.target.className){case"del":r.confirm("确定删除此发言？",function(){c.post(N+P+"/delete",function(T){if(!T.r){o.fire("street:refresh");r.close()}},"json")});break;case"top":S.target.className="topping";c.post(H+"/top_disc",{disc:P,action:"top"},function(T){if(!T.r){S.target.className="untop";g(S.target).text("已置顶");o.fire("street:refresh")}else{S.target.className="top"}},"json");break;case"untop":S.target.className="untopping";c.post(H+"/top_disc",{disc:P,action:"untop"},function(T){if(!T.r){S.target.className="top";g(S.target).text("置顶");o.fire("street:refresh")}else{S.target.className="untop"}},"json");break;case"edit":r.set({isHideTitle:true,iframeURL:D+"?discussion_id="+P,width:730}).open();break;default:break}});k.commentEvt({base:g(s),wrap:l,url:N,id:P,commentDetail:Q,tmplExtra:G});o.wait("dialog:close",function(){o.fire("app:query from widget",[{cid:false}]);R.remove();l.empty()})})}function x(){var O=M.children().length;k.render({url:J,args:{start:O,limit:15,source:"street"},wrapper:M,method:"append",tplname:b},"topicsLoaded");k.evt.wait("topicsLoaded",function(){a.init(u[0])})}function K(){k.render({url:J,args:{limit:15,source:"street"},wrapper:M,method:"html",tplname:b},"listLoaded");k.evt.wait("listLoaded",function(){I(u,70);a.init(u[0])})}function z(O){g(m,s)[O?"addClass":"removeClass"]("active").prop("disabled",O?"":"disabled")}return A};return q});
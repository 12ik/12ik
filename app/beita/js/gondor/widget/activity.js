define("gondor/widget/activity",["lib/jquery","mod/lang","mod/template","mod/scrollbar","mod/event","gondor:domain","gondor/toolkit","gondor/view/dialog","gondor/widget/common","gondor/observer","gondor/sandbox"],function(d,i,a,l,j,c,h,g,b,f,e){var k=function(D){var w=0,T=(D.pid||0),ad=(D.wid||0),E=(D.aid||0),N=D.poster,ae,ai,O=false,u=d("#widget-"+ad),S=u.find(".activity-header"),ab=u.find(".vip-topic-list"),Z=u.find(".activity-topic-list"),p=u.find(".checkin"),x=u.find(".feed-list"),n=u.find(".activity-topic-ft .activity-pager"),W=u.find(".checkin-btn"),R=u.find(".add-topic"),K=u.find(".activity-vip-topic-hd"),z=c+"/api/place/"+T+"/widget/"+ad+"/activity/"+E,Q=z+"/add_action?needauth=1",A=z+"/disc_list_mod?disc_kind=vip",aa=z+"/disc_list_mod?disc_kind=normal",J=z+"/discussion/",ag=z+"/feed_mod",al=z+"/updates",H=z+"/check_in_mod",M=z+"/add_disc_vote?needauth=1",Y=z+"/top_disc",af=z+"/discussion/",B={APPROVE:3500,REJECT:3501,CHECKIN:3502,BECOMEVIP:3503},C=0,v,q,U,V,t=0,y=j(),s={checkin:{limit:10,url:H,wrapper:p,cb:function(am){I()}},topicList:{limit:function(){return q},url:aa,wrapper:Z,cb:function(am){if(!P.get("isParticipant")||!P.get("isAbleToSpeak")){Z.find(".no-topic div").text("空地上还没有人发言")}n.find(".bn-prev").addClass("nothing");if(am.n_ds<=q){n.find(".bn-next").addClass("nothing");n.css("visibility","hidden")}else{n.find(".bn-next").removeClass("nothing");n.css("visibility","visible")}}},feedList:{limit:function(){return U},url:ag,wrapper:x,cb:function(an){w=an.timestamp;var am=parseInt(x.css("height"),10);x.children().each(function(){am-=d(this).outerHeight();if(am<=0){d(this).remove()}})}},vipTopicList:{limit:function(){return v},url:A,wrapper:ab,cb:function(){l.init(ab[0],{hasShadow:true,scrollTop:V});V=ab[0].scrollTop}}},r=function(){var an=u.find(".update-bar"),am=an.find(".update"),ao=0;return{showUpdate:function(ap){var aq;if(ap===ao){return}else{ao=ap;an.slideUp();am.text("活动现场有"+ap+"条更新，点击查看").removeClass("update-loading");aq=an.outerWidth();an.css({"margin-left":-1*(aq/2+236/2)});an.slideDown()}},showLoading:function(){var ap;am.text("加载中").addClass("update-loading");ap=an.outerWidth();an.css({"margin-left":-1*(ap/2+236/2)})},hide:function(){ao=0;am.removeClass("update-loading").removeClass("nothing");an.slideUp()},showMsg:function(ar,ap){var aq;!an.is(":animated")&&an.slideUp();am.text(ar).removeClass("update-loading");aq=an.outerWidth();an.css({"margin-left":-1*(aq/2+236/2)});if(!ap){am.addClass("nothing")}an.slideDown();if(g.node.is(":visible")&&g.node.css("visibility")!=="hidden"&&!ap){g.confirm(ar)}}}}(),F={".add-topic":L,".add-vip-topic":function(){g.set({isHideTitle:true,iframeURL:this.href.replace(/.*#/,""),width:470,buttons:[]}).open()},".bn-prev.activity-topic-prev":function(){var am=(C-q)<0?0:C-q;n.find(".bn-prev").addClass("processing");X(am).then(function(){n.find(".bn-prev").removeClass("processing")})},".bn-next.activity-topic-next":function(){n.find(".bn-next").addClass("processing");X(C+q).then(function(){n.find(".bn-next").removeClass("processing")})},".checkin-btn.checking-in":function(){},".checkin-btn":function(){W.addClass("checking-in").text("签到中");h.post(Q,{action:B.CHECKIN},function(am){if(!am.r){m.configAuth({isParticipant:true,isAbleToSpeak:true,isAbleToReply:true});aj(s.checkin);aj(s.topicList);aj(s.feedList)}else{if(am.r==20){f.fire("citizen:submit-disabled",[am.reason])}}},"json")},".checkin-num":L,".update":function(){r.showLoading();m.updateContent().then(function(){r.hide()},function(){r.showMsg("加载出错，点击重试",true)})},".update.nothing":ac,".close-update-bar":function(){r.hide()},".topic-title":function(){var am=d(this).attr("data-topic-id");G(am,"normal")},".wg-vip-cover":function(){var am=d(this).attr("data-topic-id");G(am,"vip")},".wg-vote-up":function(){var am=d(".topic-detail").attr("data-tpc-id");h.post(M,{choice:"up",disc:am},function(ap){if(!ap.r){var ao=d("a.wg-vote-up"),an=parseInt(ao.text(),10)+1;ao.html("<em></em>"+an).addClass("voted");ak()}else{if(ap.r==20){f.fire("citizen:submit-disabled",[ap.reason])}else{if(ap.msg==="not_check_in"){g.confirm("请先签到")}else{g.confirm("你已经投过票了")}}}},"json")},".wg-vote-down":function(){var am=d(".topic-detail").attr("data-tpc-id");h.post(M,{choice:"down",disc:am},function(ap){if(!ap.r){var ao=d("a.wg-vote-down"),an=parseInt(ao.text(),10)+1;ao.html("<em></em>"+an).addClass("voted");ak()}else{if(ap.r==20){f.fire("citizen:submit-disabled",[ap.reason])}else{if(ap.msg==="not_check_in"){g.confirm("请先签到")}else{g.confirm("你已经投过票了")}}}},"json")},".wg-vote-down.voted":ac,".wg-vote-up.voted":ac,".wg-admin-delete":function(){var am=d(".topic-detail",g.node).attr("data-tpc-id"),an=z+"/discussion/"+am+"/delete";g.confirm("确定删除此发言? ",function(){h.post(an,function(ao){if(!ao.r){ak();g.close()}})})},".wg-admin-untop":function(ao){var an=d(".topic-detail",g.node).attr("data-tpc-id"),am=d(this);h.post(Y,{disc:an,action:"untop"},function(){am.html("置顶").attr("class","wg-admin-top");d(".top-by").css("visibility","hidden");ak()})},".wg-admin-top":function(ao){var an=d(".topic-detail",g.node).attr("data-tpc-id"),am=d(this);h.post(Y,{disc:an,action:"top"},function(){am.html("取消置顶").attr("class","wg-admin-untop");ak()})},".wg-admin-edit":function(an){var am=d(".topic-detail",g.node).attr("data-tpc-id");g.set({isHideTitle:true,iframeURL:z+"/forum_edit?discussion_id="+am,width:730,buttons:[]}).open()}};var ah=function(am){this._watcher=j();this.attr=am};ah.prototype={set:function(an,ao){if(this.attr[an]!==ao){var am=this.attr[an];this.attr[an]=ao;this._watcher.fire("action:"+an,[am,ao]);this._watcher.fire("state")}},get:function(am){return this.attr[am]},verify:function(aq){var ap=["isVip","isParticipant","isAdmin","isSysAdmin","isInterested","isKickedout","isOngoing","isRealtime","isAbleToReply","isAbleToSpeak","uid"],an=true;aq=aq.split("");for(var ao=0,am=aq.length;ao<am;ao++){if(aq[ao]==="x"){continue}if(this.attr[ap[ao]]===!parseInt(aq[ao],10)){an=false;break}}return an},bind:function(an,am){this._watcher.bind(an,am)},init:function(){this._watcher.fire("state")}};var P=new ah({isVip:D.isVip,isParticipant:D.isParticipant,isAdmin:D.isAdmin,isSysAdmin:D.isSysAdmin,isInterested:D.isInterested,isKickedout:D.isKickedout,isOngoing:D.isOngoing,isRealtime:D.isRealtime,isAbleToReply:D.isAbleToReply,isAbleToSpeak:D.isAbleToSpeak,uid:D.uid});var m=new e({hasEvent:true,init:function(am,an){N.domain=c;S.html(a.convertTpl("tplActivityPoster",N)).css("display","block");b.scrollLoad(ab,{action:o});d(".mod-activity").css("display","block");P.bind("state",function(){var ao=false;if(P.verify("11xxx01xx1x")||P.verify("x11xx01xx1x")){if(K.hasClass("inactive")){ao=true}K.removeClass("inactive");R.removeClass("inactive")}else{if(P.verify("x0xxx01xx1x")||P.verify("xxxxxxxxx0x")){if(!K.hasClass("inactive")){ao=true}K.addClass("inactive");R.addClass("inactive")}else{if(P.verify("0x0xx01xx1x")){if(K.hasClass("inactive")){ao=true}R.removeClass("inactive");K.addClass("inactive")}else{if(P.verify("xx0xx11xx1x")){if(!K.hasClass("inactive")){ao=true}K.addClass("inactive");R.addClass("inactive");aj(s.checkin)}}}}if(ao){I();l.init(ab[0],{hasShadow:true})}});P.bind("action:isVip",function(ap,ao){if(ap&&!ao){r.showMsg("您已经失去VIP身份！")}else{if(!ap&&ao){r.showMsg("您已经成为VIP")}}});P.bind("action:isRealtime",function(ap,ao){clearInterval(ae);if(!ap&&ao){ae=setInterval(m.updateUI,5000)}});P.init();I();aj(s.feedList);aj(s.topicList);aj(s.vipTopicList)},activate:function(am,an){if(P.get("isRealtime")){clearInterval(ae);ae=setInterval(m.updateUI,5000)}f.bind("activity:refresh",function(){m.updateContent()});f.bind("activity:fail",function(){m.updateUI()});f.bind("activity:opentopic",function(ao){m.updateContent();G(ao.id,"normal")})},inactivate:function(am,an){clearInterval(ae);t=0;y=j();f.unbind("activity:refresh");f.unbind("activity:fail");f.unbind("activity:opentopic")},destroy:function(am,an){}});ai=m.env().nid;m.uievent.clickProxy.bind(F);m.configAuth=function(an){for(var am in an){if(an.hasOwnProperty(am)){P.set(am,an[am])}}};m.updateUI=function(){if(m.env()==ai){clearInterval(ae);return}if(w){h.getJSON(al,{timestamp:w},function(ap){if(!ap.r){var ar=ap.role_map||{},aq=ap.left_time.split(":"),ao=parseInt(aq[0],10)*60+parseInt(aq[1],10),am=parseInt(aq[0],10)*60*60+parseInt(aq[1],10)*60+parseInt(aq[2],10);if(ap.update_num){r.showUpdate(ap.update_num)}else{r.hide()}P.set("isParticipant",ar.is_participant);P.set("isVip",ar.is_vip);if(ao<=5){if(am==0){r.showMsg("活动已经结束!");var an={".wg-vote-up":ac,".wg-vote-down":ac,".wg-vote-down.voted":ac,".wg-vote-up.voted":ac};m.uievent.clickProxy.bind(an);m.configAuth({isRealtime:false,isAbleToReply:false,isAbleToSpeak:false})}else{if(!O){r.showMsg("活动将在5分钟内结束");O=true}}}}})}};m.updateContent=function(){return j.when(aj(s.feedList),aj(s.topicList),aj(s.vipTopicList),aj(s.checkin))};function I(){var aA=parseInt(u.parents(".widget-box").css("height"),10),ap=140,av=p.find("li").length,at=(av>5?137:(av===0?69:103)),ar=20+5+50,aD=40,aC=50,an=ar+10*2,az=10,am=!K.hasClass("inactive")?41:0,ao=60,ay=ap+ar+aC+aD,au=ap+at+an+az,aw=am,aB=30,aq=150+10,ax=30;ab.css("height",aA-aw);Z.css("height",aA-ay);x.css("height",aA-au);v=Math.ceil((aA+ao-aw)/aq)||1;q=Math.floor((aA-ay)/aB)||1;U=Math.floor((aA-au)/ax)||1}function o(){var am=ab.children("li").length;h.getJSON(A,{start:am,limit:v},function(an){if(an.r){return}if(an.html.indexOf("no-topic")===-1){ab.append(an.html)}l.init(ab[0],{hasShadow:true})})}function X(an){var am=++t;h.getJSON(aa,{start:an,limit:q},function(ao){if(ao.r){return}C=an;if(an===0){n.find(".bn-prev").addClass("nothing")}else{n.find(".bn-prev").removeClass("nothing")}if((ao.n_ds-an)<=q){n.find(".bn-next").addClass("nothing")}else{n.find(".bn-next").removeClass("nothing")}if(an==0&&(ao.n_ds-an)<=q){n.css("visibility","hidden")}else{n.css("visibility","visible")}Z.html(ao.html);y.resolve(am,[ao])});return y.promise(am)}function G(ap,ao){g.loading({width:730,isHideTitle:true});var an=ap,am=J+an+"/activity_discussion_view";h.getJSON(am,{},function(au){var aw=g.node,at=af+au.id+"/add_comment",av=au.id,ar=d(".comment-submit",aw),aq;au=i.mix(au,P.attr);au=i.mix(au,{topic_type:ao});g.body.html(a.convertTpl("tplActivityTopicDetail",au));if(ao==="normal"){if(au.comments){aq={got:au.comments.length,n_comment:au.n_comment}}b.switchBnDisabled(ar,0);b.commentEvt({base:aw,wrap:g.body,url:af,id:av,commentDetail:aq,callback:ak,tmplExtra:{userInfo:{id:P.get("uid"),isSysAdmin:P.get("isSysAdmin"),isAdmin:P.get("isAdmin")}}})}g.set({isHideTitle:true,width:730,buttons:[]}).open()})}function aj(aq){var ap=aq.url,ao=typeof aq.limit=="function"?aq.limit():aq.limit,ar=aq.wrapper,an=++t,am=aq.cb;if(ar.length===0){return}h.getJSON(ap,{limit:ao},function(at){if(at.r){return}ar.html(at.html);am&&am(at);y.resolve(an,[at])});return y.promise(an)}function L(){g.set({isHideTitle:true,iframeURL:this.href.replace(/.*#/,""),width:730,buttons:[]}).open()}function ak(){P.get("isRealtime")&&m.updateContent();P.get("isRealtime")&&m.updateUI()}function ac(){}return m};return k});
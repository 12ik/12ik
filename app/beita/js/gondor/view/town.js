define("gondor/view/town",["lib/jquery","mod/lang","mod/template","mod/mainloop","mod/scrollbar","gondor/observer","gondor/view/node","gondor/view/widget"],function(j,H,k,m,c,y,u,h){var A=["N","S","W","E"],p={N:"S",S:"N",W:"E",E:"W"},r=170,f=380,G=436,E=108,i=136,o=108,z=150,F=0,b=42,d={width:200+30,height:155+31+9},D={width:239+45,height:184+30},n={width:225+45,height:155+30},s=200,B=450,w=50,C=5,I=400,v='<div class="folder-wrapper"><div class="loading"></div></div><div class="close-folder" title="关闭"></div>',t='<div class="folder-window"><div class="bg"></div><div class="box"><div class="bd"></div><div class="arrow"></div></div></div>';var a=H.mix(Object.create(u),{init:function(J){u.init.call(this,J);this.smallScreenWidth=J.smallScreenWidth;this.smallScreenHeight=J.smallScreenHeight;this.cover=J.cover},initStatus:function(){u.initStatus.call(this);this.steps={};this.folderView=null},clear:function(){if(this.folderView){this.closeFolder(0)}u.clear.call(this)},enable:function(){this.cover.addClass("disabled")},disable:function(){this.cover.removeClass("disabled")},changeMode:function(J){},moveToPlace:function(K,J){var L=this.activity[this.vision];if(!L){return}var M=j([".place",parseInt(this.vision,10),K].join("-"),L.dom)[0];if(!M){y.wait("viewport:ready",function(){a.moveToPlace(K,J)});this.move(L.neighbors.S&&"S"||"E","direct");return}if(J){J(K)}},openFolder:function(P,K,J){var X=this,T=this.folderView,S=this.folderViewVertical,L=this.canvas,Q=L.config,aa=L.viewport,ab=L.map[!S?"offsetHeight":"offsetWidth"],W=!S?P[3]:P[2],O=!S?P[1]:P[0],Z=S?B:s,V=W<Z?Z:W+w,Y=O+W-V,N,U="auto",R="auto",M="auto",ac="auto";J=typeof J==="undefined"?I:J;y.fire("folderWindow:open");if(!T){T=this.folderView=j(t)}T[0].className="folder-window "+K;T.appendTo(L.map);if(!S){if(this.folderViewMaxExpend){Y=0}if(Y<0){Y=0-(Q.height-V-O);R=ab-aa.scrollTop-O+C;T.find(".box")[0].className="box box-top"}else{U=aa.scrollTop+O+W+C;T.find(".box")[0].className="box"}this.folderPos=Y;N=T.find(".box").css({width:Q.width,height:"",top:U,bottom:R,left:aa.scrollLeft,right:ac}).find(".arrow").css({top:"",left:P[0]+P[2]/2-15}).end().end().show().find(".bd").css({marginLeft:0,width:""})[0];m.animate("folderView:open",this.folderViewAnimateOffset||0,0,J,{easing:"easeInOutQuad",step:function(ad){N.style.marginTop=ad+"px"}}).animate("folderView:open",this.folderViewInitSize||10,this.folderViewMaxExpend||Q.height-V-w-C,J,{easing:"easeInOutQuad",step:function(ad){N.style.height=ad+"px"},callback:function(){m.remove("folderView:open");X.viewport.bind("click",e);X.fillFolder(v);y.fire("folderWindow:enable")}});L.move(0,Y,J,"easeInOutQuad")}else{if(this.folderViewMaxExpend){Y=0}if(Y<0){Y=0-(Q.width-V-O);ac=ab-aa.scrollLeft-O+C;T.find(".box")[0].className="box box-vertical box-left"}else{M=aa.scrollLeft+O+W+C;T.find(".box")[0].className="box box-vertical"}this.folderPos=Y;N=T.find(".box").css({width:"",height:Q.height,top:aa.scrollTop,bottom:R,left:M,right:ac}).find(".arrow").css({left:"",top:P[1]+P[3]/2-15}).end().end().show().find(".bd").css({marginTop:0,height:Q.height})[0];m.animate("folderView:open",this.folderViewAnimateOffset||0,0,J,{easing:"easeInOutQuad",step:function(ad){N.style.marginLeft=ad+"px"}}).animate("folderView:open",this.folderViewInitSize||10,this.folderViewMaxExpend||Q.width-V-w-C,J,{easing:"easeInOutQuad",step:function(ad){N.style.width=ad+"px"},callback:function(){m.remove("folderView:open");X.viewport.bind("click",e);X.fillFolder(v);y.fire("folderWindow:enable")}});L.move(Y,0,J,"easeInOutQuad")}return y.promise("folderWindow:enable")},closeFolder:function(N){var J=this,M,L,O=this.folderViewVertical,K=this.folderView;N=typeof N==="undefined"?I:N;this.viewport.unbind("click",e);c.clear(K.find(".folder-wrapper")[0]);L=K.find(".bd").html("");if(!O){m.animate("folderView:close",parseFloat(L.css("marginTop")),this.folderViewAnimateOffset||0,N,{easing:"easeInOutQuad",step:function(P){L[0].style.marginTop=P+"px"}}).animate("folderView:close",parseFloat(L.css("height")),this.folderViewInitSize||10,N,{easing:"easeInOutQuad",step:function(P){L[0].style.height=P+"px"},callback:function(){K.hide()}});M=this.canvas.move(0,0-this.folderPos,N,"easeInOutQuad")}else{m.animate("folderView:close",parseFloat(L.css("marginLeft")),this.folderViewAnimateOffset||0,N,{easing:"easeInOutQuad",step:function(P){L[0].style.marginLeft=P+"px"}}).animate("folderView:close",parseFloat(L.css("width")),this.folderViewInitSize||10,N,{easing:"easeInOutQuad",step:function(P){L[0].style.width=P+"px"},callback:function(){K.hide()}});M=this.canvas.move(0-this.folderPos,0,N,"easeInOutQuad")}M.wait(function(){m.remove("folderView:close");J.resetFolder();y.fire("folderWindow:close")});return y.promise("folderWindow:close")},resetFolder:function(){this.folderViewVertical=false;this.folderViewInitSize=0;this.folderViewAnimateOffset=0;this.folderViewMaxExpend=0},fillFolder:function(M,J){if(this.folderView){var K=this;var O=this.folderView.find(".bd").html(M),L=O.find(".folder-wrapper"),N=L[0].offsetHeight;L.css("height",O[0].scrollHeight-N).click(function(){K.noClose=true});c.init(L[0],{scrollTop:0,fix:N/2});if(J){J()}}},openSounds:function(){if(!this.activity[this.vision]){return}var K=this,N=this.activity[this.vision],M=j(".path",N.dom),J=M[0].offsetWidth,L=M[0].offsetHeight,P=[M[0].offsetLeft-305,M[0].offsetTop-205,J,L];if(N.kind%2===0){this.folderViewVertical=true;this.folderViewInitSize=J;this.folderViewAnimateOffset=300-J;this.folderViewMaxExpend=500}else{this.folderViewVertical=false;this.folderViewInitSize=L;this.folderViewAnimateOffset=200-L;var O=L<s?s:L+w;if(P[1]+L-O<0){P[1]+=205-L-50;if(P[1]+L-O<0){this.folderViewMaxExpend=L*2;this.folderViewAnimateOffset=45}else{this.folderViewAnimateOffset=M[0].offsetTop-P[1]-L}}}this.openFolder(P,"sound-detail").wait(function(){var Q=K.vision;h.load(Q,function(R){if(K.vision==Q){K.fillFolder('<div class="folder-wrapper"><div class="widget-box">'+R+'</div></div><div class="close-folder" title="关闭"></div>');y.fire("soundDetail:ready")}});y.wait("folderWindow:close",function(){h.reset()});y.fire("soundDetail:open")})},render:function(W,ag){var aa=this,ab=ag.focus,J=ab.kind%2===0,af=p,S=W.toString().split(","),ad=this.steps[S[0]];if(S[1]){var Z=parseInt(S[1],10);ab.step=Z;var Q=Z>0,ac=Z+(Q?-1:1),ae=ab.id+(ac?","+ac:""),U=Q?(J&&"N"||"W"):(J&&"S"||"E");if(ac){ab[U]={id:ae,step:ac,uri:"/"+(ab.kind<2&&"street"||ab.kind<4&&"avenue")+"/"+S[0]+"/",neighbors:{}};ab.neighbors[U]=[ae,ab.kind]}ab.id+=","+Z;A.forEach(function(ah){if(this[ah]){this[ah].neighbors[af[ah]]=[W,this.kind]}},ab)}else{if(ab.kind>=4){A.forEach(function(aj){var ah=this[aj];if(ah){ah.step=0;var al=this.neighbors[aj][0];var ai=aa.steps[al];if(ai){if(ai.start==this.id){this.neighbors[aj][0]+=","+1;ah.id=this.neighbors[aj][0]}else{var ak=ai.pointer;this.neighbors[aj][0]+=","+ak;ah.step=this.id;ah.id=this.neighbors[aj][0]}}}},ab)}}ab.opposite=true;var L=this.activity,Y=this.canvas,R=Y.config,X=ab.id,K=ag.entities;if(L[X]){return}this.aligning(X,ab);ag.renderList=[];if(W=="0"){L[0]=L[X]}var P="",O;if(ab.kind>3){var V=ag.renderList,N=[];q(ab);A.forEach(x,ag);V=V.filter(function(ah){if(ah.kind<2){N.push(ah);return false}return true});V.push.apply(V,N);V.push(ab);ag.renderList=V}else{ag.renderList.push(ab);q(ab);if(ab.kind<2){O=o;l(ab,ab,E)}else{O=i;l(ab,ab,G)}g(ab,ab,K);var T=ab.neighbors;var M=ab.pos+(O-b)/2;if(ab.kind%2===0){P="vertical";if(T.N){ab.arrowN=[M,R.height-10-b]}if(T.S){ab.arrowS=[M,10]}}else{P="horizon";if(T.W){ab.arrowW=[R.width-10-b,M]}if(T.E){ab.arrowE=[10,M]}}}this.renderNode(X,ag,"tplBase","node "+P)}});function x(K){var O=this,M=a.canvas.config,L=O.focus,P=O.entities,N,J=L[K];if(!J){return}if(L.kind===6){N=E}else{N=G}O.renderList.push(J);switch(J.kind){case 0:l(J,L,N,K);L["arrow"+K]=[L.pos[0]+(N-b)/2,L.pos[1]+(K==="S"&&(L.kind===6&&(N-b)/2||(N-i)/2-b-20)||(N+i)/2+20),true];break;case 1:l(J,L,N,K);L["arrow"+K]=[L.pos[0]+(K==="E"&&(N-i)/2-20-b||(N+i)/2+20),L.pos[1]+(N-b)/2,true];break;case 2:l(J,L,N,K);L["arrow"+K]=[L.pos[0]+(N-b)/2,K==="S"&&10||M.height-10-b];break;case 3:l(J,L,N,K);L["arrow"+K]=[K==="E"&&10||M.width-10-b,L.pos[1]+(N-b)/2];break;default:break}g(J,L,P)}function q(L){var K=a.canvas.config,Q=L.kind>3&&L.kind<6,P=L.kind<2||L.kind==6,N=f,M=r,J=K.width-a.smallScreenWidth,O=K.height-a.smallScreenHeight;if(J>0){N+=J/2}if(O>0){M+=O/2}L.pos=[N-(Q&&G||P&&o||i)/2,M-(Q?(G-i)/2:(P&&(i-o)/-2||0))];L.shadowfix=A.filter(function(R){var S=this.neighbors[R];return S&&(this.kind==6&&true||S[1]>1)},L)[0];switch(L.isEnd){case"N":L.endStyle="top:-120px;left:-20px";break;case"S":L.endStyle="bottom:-120px;left:-20px";break;case"W":L.endStyle="top:10px;left:-240px";break;case"E":L.endStyle="top:10px;right:-240px";break}}function l(J,U,T,S){var M=a.canvas.config,O=J.kind<2,P=J.kind%2===0;if(S){var L=O&&U.kind>3&&U.kind!=6,R=O?o:i,N=O?F:z,K=J.shadowfix=J.id==U[U.shadowfix].id&&R||0,Q=L?((T-i)/2):0;J.opposite=S==="S"||S==="E";J.pos=U.pos[P?0:1]+(T-R)/2;if(P){J.length=J.opposite&&U.pos[1]+Q||M.height-U.pos[1]-T+Q}else{J.length=!J.opposite&&M.width-U.pos[0]-T+Q||U.pos[0]+Q}J.length+=N+K}else{J.pos=U.pos[P?0:1];J.length=P?M.height:M.width;J.shadowfix=0}J.length=Math.round(J.length);J.style=k.format(P?"height:{{length}}px;right:{{pos}}px":"width:{{length}}px;bottom:{{pos}}px;",J);J.className=["path ",O?"st-":"av-",P?(J.opposite?"s":"n"):(J.opposite?"e":"w")].join("");J.riverStyle=P?"height:"+(J.length-140*2)+"px;":"width:"+(J.length-140*2)+"px;"}function g(O,U,L){var T,X,M,W=parseInt(O.id,10),Z=a.steps[W],ab=O.length-O.shadowfix,aa=U.kind<4,ac=O.kind<2,K=O.kind%2===0,J=ac?(U.N||U.S):/[NS]/.test(U.shape),Y=false,Q=O.opposite;if(!K&&J&&O.opposite===false){ab-=(ac&&d||D).width+20}if(!Z){Z=a.steps[W]={pointer:0,buffer:{},is_reverse:Q};T=Z.queue=O.children.slice();if(Q){T.reverse()}if(aa){M=O.N||O.W;var S=4;if(M.kind==5&&O.kind<=1){S=0}Z.buffer[0]=P(S&&T.slice(0-S)||[],O,M);O.step=1;Z.pointer+=(Q?1:-1)}else{M=U}Z.start=M.id;X=Z.buffer[O.step]=P(T,O,U);if(aa){if(T.length>X.total*2){T.length=T.length-X.total}else{Z.isFinal=true}}}else{Q=Z.is_reverse;X=Z.buffer[O.step];Y=aa&&Z.isFinal;if(!X){if(!aa){T=O.children.slice();if(!Q){T.reverse()}}else{T=Z.queue}X=Z.buffer[O.step]=P(T,O,U,Y);if(aa){Z.pointer+=(Q?1:-1)}if(Y){T.length=0;Z.isFinal=false}else{if(T.length>X.total*2){T.length=T.length-X.total}else{Z.isFinal=true}}}}var R=O.opposite?(K&&"S"||"E"):(K&&"N"||"W");if(Z.queue.length||O.step<Z.pointer){var V=O.step+(Q?1:-1),N=W+(V?","+V:"");if(aa){U[R].uri="/"+(U.kind<2&&"street"||U.kind<4&&"avenue")+"/"+W+"/"}U[R].id=N;U.neighbors[R]=[W+","+V,O.kind]}X.forEach(function(ae){var ad=this.opposite;if(K&&!ad){if(!Y){ae.reverse()}}else{if(Y){ae.reverse()}}if(Y){ad=!ad}var af=K?(!ad&&"bottom:{{0}}px;"||"top:{{0}}px;"):(ad&&"left:{{0}}px;"||"right:{{0}}px;");ae.style=k.format(af,[this.length-ab])+(K?"height:"+ae.size+"px;":"width:"+ae.size+"px;");if(ae.name==-1){O.groundStyle=k.format(af,[this.length-ab])+k.format(K?"right:{{0}}px;":"bottom:{{0}}px;",[ac?o:i])}},O);O.rows=X;if(Y){O.finalLayout=true}O.hasWorkingRow=X.length<2&&(aa||!K||!U.E||U.E.kind<2);function P(ad,af,au,ap){var ai,ah,at,ao,ae,ar=[],al={},ak=0,an=L.lib,aj=ab,aq=au.neighbors.E,am=au.kind==5&&af.kind<=1;if(aq&&!ac){aq=aq[1]>=2}if(ap){ad.reverse()}if(!am){for(var ag=ad.length-1;ag>=0;ag--){ai=ad[ag];ah=an[ai];at=al[ah.row_id];ao=(ah.kind==11&&n||ac&&d||D)[K?"height":"width"];if(!at){at=al[ah.row_id]=[];at.name=ah.row_id;at.size=0;ar.push(at)}ae=aj-at.size;if(ae>ao*0.3){if(ah.row_id>0&&aq&&K){continue}at.size+=ao;at.push(ah);if(ae>ao){ak++}}}}ar.total=ak;return ar}}function e(J){if(!a.noClose){a.closeFolder();return false}a.noClose=false}return a});
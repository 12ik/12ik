define("gondor/view/sound",["lib/jquery","mod/lang","mod/template","mod/mainloop","gondor/observer"],function(e,n,c,a,k){var j=Math,d=290,f=28,b='<a class="hot-pop" href="#" title="正在举行活动：{{title}}"></a>',m='<a href="{{href}}" class="sound-bubble {{c}}" style="{{s}}"><span class="sound">{{html}}</span><span class="arrow"></span></a>';var h={popTimer:0,emitterTimer:[],fadeTimer:[],soundContainer:[],hotContainer:[],soundCache:{id:0,queue:[],record:[]},render:function(p,v){var A=this,q=v.soundlib,z=v.sound,y=v.hot,t=["N","S","W","E"],u=this.host,o=this.soundCache,w=parseInt(u.vision,10),B=q[w],r=B.sounds;this.soundContainer.length=0;this.hotContainer.length=0;y.forEach(function(E){var C=e([".place",p,E.nid].join("-"));if(C[0]){var D=e(c.format(b,{title:E.name})).appendTo(C).attr("href",C.find(".shop-overlap").attr("href"));A.hotContainer.push(D)}});if(r.length){var x=e("#sound_river_"+u.vision.toString().split(",").join("_"));this.soundContainer.push(x[0]);if(o.id==p){x[0].innerHTML=o.record.reduce(function(C,D){return C.concat(D)}).map(function(D,C){return this.format(m,{s:"left:"+D[0]+"px;bottom:"+D[1]+"px;",c:"layer"+D[2]+(r[C].top?" sound-top":""),href:"javascript:;",html:this.convertTpl("tplSound",r[C],"sd")})},c).join("")}else{o.queue=r.slice().reverse();o.record=[]}if(o.queue.length){var s={width:B.kind%2!==0?d+2:240,height:B.kind%2!==0?f+15:f*2+15,spaceWidth:x[0].offsetWidth,spaceHeight:x[0].offsetHeight,disperseLevel:100,record:o.record};(function(C){var E=C.pop();if(E){var D=arguments.callee,F=g(s);if(F[2]<4){i(x[0],{c:"layer"+F[2]+(E.top?" sound-top":""),s:"left:"+F[0]+"px;bottom:"+F[1]+"px;",href:"javascript:;",html:c.convertTpl("tplSound",E,"sd")})}A.popTimer=setTimeout(function(){D(C)},200+l(400))}})(o.queue)}}else{t.forEach(function(C){if(this[C]){(q[parseInt(this[C][0],10)]||{}).toward=C}},u.activity[u.vision].neighbors);z.forEach(function(F,L){var E=F.sounds,G=E.length;if(!G){return}var I=0,J=l,H=F.kind>6,D=A.emitterTimer,K=A.fadeTimer,C=e("#sound_emitter_"+w+"_"+F.id)[0];if(C){A.soundContainer.push(C);clearTimeout(D[L]);D[L]=setTimeout(function(){var N=arguments.callee,O,M;switch(F.toward){case"N":O="left:"+j.floor(j.random()*C.offsetWidth)+"px;top:"+j.floor(j.random()*C.offsetHeight)+"px;";break;case"S":O="left:"+j.floor(j.random()*C.offsetWidth)+"px;bottom:"+j.floor(j.random()*C.offsetHeight)+"px;";break;case"W":O="left:"+j.floor(j.random()*C.offsetWidth)+"px;bottom:"+j.floor(j.random()*C.offsetHeight)+"px;";break;case"E":O="right:"+j.floor(j.random()*C.offsetWidth)+"px;bottom:"+j.floor(j.random()*C.offsetHeight)+"px;";break;default:break}E[I].who.is_indoor=H;M=i(C,{c:(E[I].top?"sound-top-":"")+"type"+F.toward,s:O,href:"javascript:;",html:c.convertTpl("tplSound",E[I],"sd")});if(H){K.push(setTimeout(function(){a.animate("sounds:fadeout",1,0,400,{step:function(P){M.css("opacity",P)},callback:function(){M.remove()}})},5000))}I++;if(I>1||I>=G){return}D[L]=setTimeout(function(){N(I,G)},800+J(1000))},J(1000))}})}o.id=p},clear:function(){clearTimeout(this.popTimer);this.emitterTimer.forEach(function(p){clearTimeout(p)});this.emitterTimer.length=0;this.fadeTimer.forEach(function(p){clearTimeout(p)});this.fadeTimer.length=0;a.complete("sounds:pop").complete("sounds:fadeout");var o=this.host;if(!o||!o.vision){return}this.soundContainer.forEach(function(p){if(p){p.innerHTML=""}});this.soundContainer.length=0;this.hotContainer.forEach(function(p){p.remove()});this.hotContainer.length=0}};function l(o){return j.floor(j.random()*o)}function g(p,r,v){r=r||0;v=v||0;var A=j.floor(j.random()*(p.spaceWidth-p.width)),w=j.floor(j.random()*(p.spaceHeight-p.height)),u=p.record[v];if(!u){u=p.record[v]=[]}for(var t=0,q,s=u.length;t<s;t++){q=u[t];if((A>=q[0]-p.width&&A<=q[0]+p.width)&&(w>=q[1]-p.height&&w<=q[1]+p.height)){if(r>(p.disperseLevel||5)){r=0;v++}return g(p,++r,v)}}var B=[A,w,v];u.push(B);return B}function i(r,q){var p=e(c.format(m,q)).appendTo(r),s=e(".sound",p)[0],o=s.offsetWidth;if(o>d){o=d}a.animate("sounds:pop",0,f,500,{easing:"easeOutBack",step:function(t){s.style.height=t+"px"}}).animate("sounds:pop",0,o,400,{easing:"easeOutBack",step:function(t){s.style.width=t+"px"}});return p}return h});
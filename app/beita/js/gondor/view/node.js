define("gondor/view/node",["lib/jquery","mod/lang","mod/template","gondor/observer"],function(f,c,b,a){var e=["N","S","W","E"];var d={walkSpeed:600,needReset:false,rotate:0,init:function(g){this.initStatus();this.viewport=g.viewport;this.canvas=g.canvas;this.default_fill=this.canvas.map.innerHTML},initStatus:function(){this.vision=null;this.activity={};this.activelist=[]},info:function(g){return this.activity[g]},neighbors:function(g){return(this.activity[g]||{}).neighbors},locate:function(h){var g=this.activity[h];if(!g){return}this.canvas.locate.apply(this.canvas,g.pos);this.vision=h},reset:function(){var g=parseInt(this.vision,10);this.needReset=false;this.clear();a.fire("viewport:reset",[g]);return a.promise("viewport:init")},clear:function(){var h=parseInt(this.vision,10),g=this.canvas;a.fire("viewport:beforereset",[h]);this.initStatus();g.map.innerHTML=this.default_fill;g.locate.apply(g,g.config.origin)},exit:function(){this.clear()},move:function(o,p){var i=this.activity[this.vision];if(!i){return false}var m=i.neighbors[o];if(!m){return false}a.fire("walk:start",[i,o]);var n=this,k=this.canvas,h=k.config,g=m[0],j=o==="N"&&[0,0-h.height]||o==="S"&&[0,h.height]||o==="W"&&[0-h.width,0]||o==="E"&&[h.width,0];if(p!=="direct"){j.push(this.walkSpeed,p||"easeInOutQuart")}f(k.viewport).addClass("moving");k.event.wait("moveEnd",function(){f(k.viewport).removeClass("moving");if(m[1]==8){n.exit()}else{a.fire("walk:end",[g,m[1]])}});k.move.apply(k,j);if(!n.activity[g]){var l=k.locate();f(".node-loading",k.map).css({left:l[0]+j[0]-400/2,top:l[1]+j[1]-150/2})}this.vision=g;return o},aligning:function(h,t){var p=this.canvas,o=p.config,k=this.activity;if(!this.vision){this.vision=h}var q=p.locate();for(var n=0,s,j,g,m=e.length;n<m;n++){s=(t.neighbors[e[n]]||[])[0];if(s){j=k[s];if(!j&&s.toString().split(",")[1]==1){j=k[parseFloat(s)]}}if(j){g=k[h]={pos:j.pos.slice(),place_id:t.parentInfo.place_id,place_kind:t.parentInfo.kind,place_domain:t.parentInfo.place_domain,widget_id:t.widget_id,widget_kind:t.widget_kind,weather_type:t.weather_type,weather_level:t.weather_level,id:t.id,kind:t.kind,name:t.name||t.parentInfo.name,neighbors:t.neighbors};switch(e[n]){case"N":g.pos[1]+=o.height;break;case"S":g.pos[1]-=o.height;t.opposite=false;break;case"W":g.pos[0]+=o.width;break;case"E":g.pos[0]-=o.width;t.opposite=false;break}break}}if(!k[h]){k[h]={pos:[q[0]-o.width/2,q[1]-o.height/2],place_id:t.parentInfo.place_id,place_kind:t.parentInfo.kind,place_domain:t.parentInfo.place_domain,widget_id:t.widget_id,widget_kind:t.widget_kind,weather_type:t.weather_type,weather_level:t.weather_level,id:t.id,kind:t.kind,name:t.name||t.parentInfo.name,neighbors:t.neighbors}}this.activelist.push(h)},getNodeStr:function(h){var g=h.toString().split(",");if(/^\D*1$/.test(g[1])){g.pop()}return"node-"+g.join("_")},renderNode:function(g,k,o,j){var m=this.canvas,l=m.config,h=this.activity;var i=document.createElement("DIV"),n=i.style;i.className=j+" "+this.getNodeStr(g);h[g].dom=i;n.left=h[g].pos[0]+"px";n.top=h[g].pos[1]+"px";n.width=l.width+"px";n.height=l.height+"px";m.map.appendChild(i);i.innerHTML=b.convertTpl(o,k,"node")},render:function(){}};return d});
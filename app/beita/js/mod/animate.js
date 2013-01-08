define("mod/animate",["mod/lang","mod/mainloop"],function(J,n){var o=["Moz","webkit","ms","O"],g={Moz:"transitionend",webkit:"webkitTransitionEnd",ms:"MSTransitionEnd",O:"oTransitionEnd"},e,j={rotate:1,rotateX:1,rotateY:1,rotateZ:1,scale:2,scale3d:3,scaleX:1,scaleY:1,scaleZ:1,skew:2,skewX:1,skewY:1,translate:2,translate3d:3,translateX:1,translateY:1,translateZ:1},D,p=/(\w+)\(([^\)]+)/,B=/\)\s+/,t,H=false,f=0,m=[],q={},F={},K={},d={},k={linear:"linear",easeIn:"ease-in",easeOut:"ease-out",easeInOut:"ease-in-out"},c={linear:function(l,L,i,M){return i+M*l},easeIn:function(l,L,i,N,M){return N*(L/=M)*L+i},easeOut:function(l,L,i,N,M){return -N*(L/=M)*(L-2)+i},easeInOut:function(l,L,i,N,M){if((L/=M/2)<1){return N/2*L*L+i}return -N/2*((--L)*(L-2)-1)+i}},w=document.createElement("div");for(var E=0,A=o.length;E<A;E++){t=o[E];if((t+"Transform") in w.style){if((t+"Transition") in w.style){H=true}break}t=false}if(t){e="-"+t.toLowerCase()+"-transform";D=g[t]}var h={useCSS:H,config:function(i){if(i.easing){J.mix(k,i.easing.values);J.mix(c,i.easing.functions);n.config({easing:c})}return this},transform:r,addStage:function(M){var O=Array.prototype.slice.call(arguments,1);if(H){for(var N=0,L=O.length;N<L;N++){if(O[N].prop==="transform"){O.splice.apply(O,[N,1].concat(y(O[N])));return this.addStage.apply(this,[M].concat(O))}}q[M]=O;O.forEach(u)}else{O.forEach(function(i){s(M,i)})}if(!n.globalSignal){n.run()}return this},pause:function(i){if(H){var l=q[i];if(l){l.forEach(z)}}else{n.pause(i)}return this},run:function(i){if(H){var l=q[i];if(l){l.forEach(u)}}else{n.run(i)}return this},remove:function(i){if(H){var l=q[i];if(l){l.forEach(z);delete q[i];I()}}else{n.remove(i)}return this},complete:function(i){if(H){var l=q[i];if(l){l.forEach(v);delete q[i];I()}}else{n.complete(i)}return this}};function C(l){var i=l.getAttribute("_oz_fx");if(!i){i=m.pop()||++f;l.setAttribute("_oz_fx",i);l.removeEventListener(D,a);l.addEventListener(D,a)}if(!F[i]){F[i]={target:l}}return i}function a(O){var N=this.getAttribute("_oz_fx"),M=F[N];if(M){if(O.propertyName===e){for(var L in j){delete M[L]}var P=K[N];delete K[N];this.style[t+"Transition"]=G(N);if(P){P.call(this)}}else{var l=M[O.propertyName];if(l){delete M[l.prop];this.style[t+"Transition"]=G(N);if(l.callback){l.callback.call(this)}}}}}function I(){var M,L;for(var N in F){M=false;L=F[N];for(var l in L){if(L[l]&&L[l].prop){M=true;break}}if(!M){L.target.removeAttribute("_oz_fx");delete F[N];delete K[N];m.push(N)}}}function b(M,L,i){if(j[L]){if(t){r(M,L,i)}}else{var l=d[L];if(!l){l=d[L]=L.split("-").map(function(O,N){if(N){return O.replace(/^\w/,function(P){return P.toUpperCase()})}else{return O}}).join("")}M.style[l]=i}}function G(L){var l=F[L];if(l){var M=[],i;for(var N in l){i=l[N];if(i&&i.prop){M.push([j[i.prop]&&e||i.prop,(i.duration||0)+"ms",k[i.easing]||"linear",(i.delay||0)+"ms"].join(" "))}}return M.join(",")}else{return""}}function r(N,M,i){var l=false;var L=N.style[t+"Transform"].split(B).map(function(O){if(O){var P=p.exec(O)||[];if(M===P[1]){if(i){l=true;return M+"("+i+")"}else{l=P[2]}}else{if(i){return(/\)$/).test(O)?O:O+")"}}}});if(i){if(!l){L.push(M+"("+i+")")}N.style[t+"Transform"]=L.join(" ")}else{return l}}function z(l){var Q=l.target,N=C(Q),P=F[N],O=parseFloat(l.from),M=parseFloat(l.to),R=M-O,T=O==l.from?0:l.from.replace(/^[-\d\.]+/,""),L=+new Date()-l.startTime,i=L/(l.duration||1);if(P){delete P[l.prop]}if(i<1){if(c[l.easing]){i=c[l.easing](i,L,0,1,l.duration)}l.from=O+R*i+T}else{l.from=l.to}var S=G(N);Q.style[t+"Transition"]=S;b(Q,l.prop,l.from)}function v(i){var N=i.target,L=C(N),l=F[L];if(l){delete l[i.prop]}var M=G(L);N.style[t+"Transition"]=M;b(N,i.prop,i.to)}function u(i){if(!i.prop||i.from==i.to){return}var M=i.target,l=C(M);i.startTime=+new Date()+(i.delay||0);F[l][i.prop]=i;b(M,i.prop,i.from);var L=G(l);setTimeout(function(){M.style[t+"Transition"]=L;b(M,i.prop,i.to)},0)}function s(l,L){if(L.prop==="transform"){var N=false;x(L,function(Q){if(!N){N=true;Q.callback=L.callback}s(l,Q)})}else{var P=L.target,O=parseFloat(L.from),i=parseFloat(L.to),M=O==L.from?0:L.from.replace(/^[-\d\.]+/,"");n.animate(l,O,i,L.duration,{easing:L.easing,delay:L.delay,step:function(Q){b(P,L.prop,Q+M)},callback:function(){if(L.callback){L.callback.call(P)}}})}}function y(i){var l=C(i.target);K[l]=i.callback;return x(i)}function x(i,l){var M=[],L=i.from.split(B);i.to.split(B).forEach(function(S,Q){var V=p.exec(S),O=p.exec(L[Q])[2].split(/\,\s*/),U=V[2].split(/\,\s*/),P=j[V[1]],X=P===3,R=P===1||U.length<=1,T=R?[""]:["X","Y","Z"],W,N;if(!P){return}U.forEach(function(Y,Z){if(Y&&Z<=T.length&&X||R&&Z<1||!R&&Z<2){N=J.mix({},i,{prop:V[1].replace("3d","")+T[Z],from:O[Z],to:Y,callback:null});this.push(N);if(l){l(N)}}},this)},M);return M}return h});
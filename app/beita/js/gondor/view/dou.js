define("gondor/view/dou",["lib/jquery","mod/lang","mod/template","gondor/observer"],function(f,e,d,c){var b='<a href="javaScript:;" class="loot-dou" data-opt="num={{num}}&amp;para={{para}}&amp;url={{url}}"><span class="loot-dou"></span><span class="tips"><span>你看到地上有阿尔法圆！</span><em><b></b></em></span><span class="loot-tips">+<span class="refer-price">{{num}}</span></span></a>';var a={show:function(k,i){if(this.box){this.remove()}var h=k.width(),g=h*Math.random();if(g>h/2){g-=80}else{g+=80}var j=this.box=f(d.format(b,i)).css({left:g+"px"}).appendTo(k);c.fire("dou:show")},hide:function(){if(this.box){this.box.addClass("picking")}},remove:function(){if(this.box){this.box.remove();this.box=null}}};return a});
define("gondor/view/dialog",["lib/jquery","mod/lang","mod/dialog","gondor/observer"],function(d,c,a,b){var f='<div class="loading"></div>';var e=a({isHideTitle:true,title:"",isTrueShadow:true,isHideMask:false,autoupdate:true,buttons:[]});e.event.bind("open",function(g){b.fire("dialog:open",[g])});e.event.bind("close",function(g){b.fire("dialog:close",[g])});e.event.bind("setcontent",function(g){b.fire("dialog:setcontent",[g])});return e});
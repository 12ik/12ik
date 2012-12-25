<style type="text/css">
.captcha_image {height:40px; padding-left:20px;}
a.pop_win_close { top: 5px }
.pop_win { padding: 0 }
.pop_win h3 { font-size: 14px; padding: 12px 10px 8px 10px; margin: 0; color: #006600; background: #ebf5eb; *height: auto }
.dui-dialog .hd h3 { color: #006600 }
.pop_win h3 span, .dui-dialog .hd h3 span { color: #888; font-size: 12px }
.pop_win h3 a, .dui-dialog .hd h3 a { font-size: 12px }
#pop_win_login { width:280px; padding: 10px }
#pop_win_login form { width: 280px; border: none }
#pop_win_login fieldset { border: 0 none; padding: 0; margin: 0 }
#pop_win_login .item { margin: 15px 0 12px 0; overflow: visible }
#pop_win_login label { display: inline-block; float:left; margin-right: 15px; text-align: right; width: 30px; font-size: 14px; line-height: 30px; vertical-align: baseline }
#pop_win_login label.sub { font-size: 12px; display: inline; width: auto; text-align: left; float: none; margin: 0; color: #666 }
#pop_win_login input { vertical-align: middle }
#pop_win_login .text { width: 200px; padding: 5px; height: 18px; font-size: 14px; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; border: 1px solid #c9c9c9 }
#pop_win_login .text:focus { border: 1px solid #a9a9a9 }
.captcha_block { margin-top:1em; }


.device-mobile #pop_win_login { width:auto; }
.device-mobile #pop_win_login form { width:auto; }
.device-mobile #pop_win_login .item { margin:0 0 5px;overflow:hidden; }
.device-mobile #pop_win_login label { margin-right: 5px; width: 30px; }
.device-mobile #pop_win_login .text { width: 70%; padding: 2px; height: auto; font-size: 14px;  }
.device-mobile #captcha_field { padding:2px;width:30% }
.device-mobile #captcha_image { padding:0; }
.device-mobile .captcha_block { margin-top:5px; }
.device-mobile .recsubmit { padding-top:10px; }

/* BY RYAN KUNG */

.device-mobile .dui-dialog-content h3 {font-size:16px;}
.device-mobile .dui-dialog-content h3 span{font-size:14px;}
.device-mobile a.dui-dialog-close {font-size: 20px;}

/*
.device-mobile #pop_win_login {padding:0;}
.device-mobile #pop_win_login .item .text{width:65%; padding:8px;}
.device-mobile #pop_win_login .item {margin:10px 0;}
.device-mobile #pop_win_login .item label {float:none;display:inline-block;}
.device-mobile #pop_win_login .item #remember {height:30px;}
.device-mobile #pop_win_login .recsubmit label {display:none;}
.device-mobile #pop_win_login .recsubmit .bn-flat{margin:0;}
.device-mobile #pop_win_login .recsubmit .bn-flat input{font-size:16px; height:40px; padding:0 40%;}
.device-mobile #pop_win_login .remember {padding:10px 0;}
.device-mobile #pop_win_login label {height:30px; width:auto;}
.device-mobile #pop_win_login a{line-height:30px;display:inline-block;}
.device-mobile #captcha_field { padding:2px;width:30% }
.device-mobile #captcha_image { padding:0; }
.device-mobile .captcha_block { margin-top:5px; }
*/

</style>


<h3>会员登录<span> ( <a href="<?php echo SITE_URL;?><?php echo tsurl('user','register')?>" >还没有注册?</a> ) </span></h3>

<div id="pop_win_login" class="">
    <form class="pop_win_login_form" name="lzform" method="post" action="<?php echo SITE_URL;?><?php echo tsurl('user','login',array('ts'=>'do'))?>">
        <fieldset>
            <input type="hidden" name="jump" value="<?php echo $jump;?>" />
            <input type="hidden" name="cktime" value="2592000">
            <div class="item">
                <label for="form_email">帐号</label>
                <input tabindex="1" type="text" id="form_email" name="email" class="text pop_email" value="邮箱/手机号"/>
            </div>
            <div class="item">
                <label for="form_password">密码</label>
                <input tabindex="2" type="password" name="pwd" id="pop_password" class="text"/>
            </div>
            <div class="item remember">
                <label>&nbsp;</label>
                <input id="remember" type="checkbox" name="remember" tabindex="4"/>
                <label for="remember" class="sub">下次自动登录 |</label><a href="<?php echo SITE_URL;?><?php echo tsurl('user','forgetpwd')?>" style="margin-left: 0.8em;" >忘记密码了</a>
            </div>
            <div class="item recsubmit">
                <label>&nbsp;</label>
                <div><span class="bn-flat"><input type="submit" value="登录" tabindex="5"></span></div>
            </div>
        </fieldset>
    </form>
</div>
<script>

(function(){

    var email=unescape(get_cookie("ik_email")),pop_email=$(".pop_email");
    if(email&&email!=""){
        pop_email.attr({value:email});
        setTimeout( function() {
            $("#pop_password").focus();
        } , 500);
    }
    $('.pop_win_login_form').submit(function(){
        set_cookie({regfromurl:location.href,regfromtitle:encodeURIComponent(document.title)});
    });

var email_id='form_email';
var pwd_id='pop_password';
IK(function(){
	var a=$("#"+email_id);
	var b="邮箱/手机号";
	a.focus(function(){
		var c=$(this);
		if(c.val()===b)
		{
			c.val("").css("color","#000")
		}
	}).blur(function(){
		var c=$(this);
		if(!c.val())
		{
			c.val(b).css("color","#ccc")
		}
	});
	if(a.val()&&a.val()!=b)
	{
		$("#"+pwd_id).focus()
	}else{
		a.css("color","#ccc")
	}
   });
})();
</script>

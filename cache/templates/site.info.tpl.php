<!--头部-->
<?php include template('site_header'); ?>
<!--//头部-->
<!--导航-->
<?php include template('site_nav'); ?>
<!--//导航-->

<!--内容-->
<div id="content">
    <!--main-->
    <div class="main">           
        <h1>小站管理</h1>               
        <div class="mod" id="sp-setting">
            <div class="hd">
					<?php include template('setting_nav'); ?>
            </div>
        
	<div class="bd">
        <form method="post" id="sp-setting-form" tagName="form">
        <div style="display:none;"><input type="hidden" value="SO-j" name="ck"></div>
            <div class="item">
                <label>小站名称:</label>
                <?php echo $strSite['sitename'];?>
            </div>

            <div class="item">
                <label>小站房间数:</label>
                <?php echo $siteNumber;?>
                <a title="添加新房间" href="javascript:;" id="new-room">添加新房间</a>
            </div>

            <div class="item">
                <label>描述:</label>
                <textarea class="sp-desc" name="sitedesc"><?php echo $strSite['sitedesc'];?></textarea>
            </div>
            <div class="item">
                <label>标签:</label>
                <input value="<?php echo $arrSiteTags;?>" class="sp-input" name="tags">
            </div>
            <div class="item">
                <label>小站图标:</label>
                <img src="<?php echo $strSite['icon_180'];?>?v=<?php echo rand();?>" class="sp-icon-b">
                <img src="<?php echo $strSite['icon_48'];?>?v=<?php echo rand();?>" class="sp-icon-s">
                
                <a title="修改图标" href="<?php echo SITE_URL;?><?php echo ikurl('site','admins',array('ik'=>'icon','siteid'=>$siteid))?>">修改图标</a>
            </div>

            <div class="attn hide" id="error_msg"></div>
            <div class="item-submit">
                <span class="bn-flat-hot"><input type="submit" value="保存" hidefocus="1" name="pf_submit"></span>
                <a name="pf_cancel" href="<?php echo SITE_URL;?><?php echo ikurl('site','mine',array('siteid'=>$siteid))?>">取消</a>
            </div>
        </form>
    </div>


        </div>
    </div>
<script>
    IK.add('validate', {path: '<?php echo SITE_URL;?>public/js/lib/validate.js', type: 'js', requires:['dialog']});
	IK.ready('validate' , function(){
        var site_id = $('body').attr('id');
        var css_top_tips = '#top-tips',
            tmpl_top_tips = '<div id="top-tips">你的最新设置已经被成功保存.</div>',
            postUrl = '<?php echo SITE_URL;?><?php echo ikurl("site","admins",array("ik"=>"info","siteid"=>$siteid))?>',
            removeTips = function () {
                $(css_top_tips).slideUp(function () {
                    $(this).remove();
                })
            }
            _Form = $('#sp-setting-form');
		//回调函数
        var spSettingCallback = function (e) {
            hide_error();
            checks = _Form.data('checks');
            if (typeof checks === 'object' && checks.length) {
                var all_ok = true;
                for (var i=0; i<checks.length; i++) {
                    all_ok = all_ok && checks[i](this);
                }
                if (!all_ok) {
                    return false;
                }
            }

			//post data
            $.post(
				postUrl, 
				_Form.serialize(),
				function (ret) {
					if (ret.r==0){
							if (!$(css_top_tips).length) {
								$('body').append(tmpl_top_tips);
								$(css_top_tips).slideDown();
								setTimeout(removeTips, 5000); 
							}
						} else {
							show_error(ret.error);
						}
						
            });

        };

        hide_error = function () {
            $("#error_msg").text('');
            $("#error_msg").addClass('hide');
        }
        show_error = function (error){
            $("#error_msg").text(error);
            $("#error_msg").removeClass('hide');
        }

        function isNull(el){
            if($(el).val() === '') return true;
        }
        function realLength(str){
            return  unescape(escape(str).replace(/%u[A-F0-9]<?php echo 4;?>/g, 'xx')).length;
        }

        function max(num){
            return function(el){
                if(realLength($(el).val()) > num) return true;
            }
        }
        var validateRunles = {
            tags:{
                elems: 'input[name=tags]',
                isNull: isNull,
                singleMax:function(el){
                    var tags = $.trim($(el).val().replace(/\s+/g,' '));
                        tags = tags.split(' ');
                    for(var i = tags.length; i--;){
                    if(tags[i].length > 8){
                            return true;
                        }
                    }
                },
                maxTags:function(el){
                    var tags = $.trim($(el).val()).replace(/\s+/g,' ');
                        tags = tags.split(' ');
                    if(tags.length > 5){
                            return true;
                        }
                    } 
                }
            },
            validateError = {
                tags:{
                    isNull: '小站标签不为空',
                    singleMax:'每个标签最长8个汉字',
                    maxTags: '小站标签不能超过5个'
                }
            },
            optionMsg = {
                tags:"最多5个标签"
            };
            var validateConfig = {};

            // dirty trick
            validateConfig.callback =  spSettingCallback;
            validateConfig.errorTempl = '<span class="validate-wrap"><span class="validate-error"><?php echo msg;?></span></span>';
            validateConfig.optionTempl = '<span class="validate-wrap"><span class="validate-option"><?php echo msg;?></span></span>';

            $('form').validateForm(validateRunles, validateError, optionMsg, validateConfig );
    });
</script>	    
    <!--//main-->
    
     <!--aside-->    
    <div class="aside">
        <?php include template('admins_aside'); ?>
    </div>
    <!--//aside-->  
 

    <div class="extra">
            
    </div>
 
</div>
<!--//内容-->

<!--尾部-->
<?php include template('site_footer'); ?>
<!--//尾部-->

<?php include template('header'); ?>
<div class="midder">
<div class="mc">
	<h1><?php echo $title;?></h1>
    <div class="cleft">
        
        
    <form method="POST" action="<?php echo SITE_URL;?>index.php?app=site&ac=new_site&ik=create" onsubmit="return createSite(this);"  enctype="multipart/form-data">
    <table width="100%" cellpadding="0" cellspacing="0" class="table_1">
        <tr>
            <th>小站名称：</th>
            <td><input style="width:200px;" type="text" value=""  size="15" name="sitename" gtbfieldid="2" class="txt"   placeholder="请填写标题" maxlength="15"></td></tr>	
        <tr>
            <th>小站介绍：</th>
            <td>
            <textarea style="width:400px;height:150px;" id="editor_full" cols="55" rows="20" 
            name="sitedesc" class="txt"   placeholder="请填写内容" maxlength="250"></textarea>  <span class="tip">最多 250 个字</span>
            </td>
        </tr>
        <tr>
            <th>小站标签：</th>
            <td><input style="width:400px;" type="text" value=""  size="50" name="tag" gtbfieldid="2" class="txt" id="tag"  > <span class="tip">最多 5 个标签</span>
           </td>
        </tr>	
        <tr>
        	<th>&nbsp;</th>
            <td><div class="site-tags">
            	<dl class="tag-items" id="tag-items">
                    <dd onClick="tags(this)">生活</dd>
                    <dd onClick="tags(this)">同城</dd>
                    <dd onClick="tags(this)">影视</dd>
                    <dd onClick="tags(this)">工作室</dd>
                    <dd onClick="tags(this)">艺术</dd>
                    <dd onClick="tags(this)">音乐</dd>
                    <dd onClick="tags(this)">品牌</dd>
                    <dd onClick="tags(this)">手工</dd>
                    <dd onClick="tags(this)">闲聊</dd>
                    <dd onClick="tags(this)">设计</dd>
                    <dd onClick="tags(this)">服饰</dd>
                    <dd onClick="tags(this)">摄影</dd>
                    <dd onClick="tags(this)">媒体</dd>
                    <dd onClick="tags(this)">美食</dd>
                    <dd onClick="tags(this)">读书</dd>
                    <dd onClick="tags(this)">公益</dd>
                    <dd onClick="tags(this)">互联网</dd>
                    <dd onClick="tags(this)">动漫</dd>
                    <dd onClick="tags(this)">旅行</dd>
                    <dd onClick="tags(this)">绘画</dd>
                    <dd onClick="tags(this)">美容</dd>
                    <dd onClick="tags(this)">购物</dd>
                    <dd onClick="tags(this)">电影</dd>
                    <dd onClick="tags(this)">教育公益</dd>
                    <dd onClick="tags(this)">游戏</dd>
                </dl>
            </div></td>
        </tr>
        <tr>
            <th>&nbsp;</th>
            <td>
            <input class="submit" type="submit" value="创建小站">
            </td>
        </tr>
    </table>
    </form>

         
    </div>

    <div class="cright">
        <div class="setting-tips">                                                       
            <h2>小站创建 &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;· </h2>
            <p>小站需要审核通过后才能完成创建, 管理员会在 3 日内审核申请,审核结果会用豆邮通知你, 请耐心等待。</p>
            <br>
			<p class="pl">考虑到中国法律法规和相关政策的要求,本站不欢迎色情、激进话题、意识形态方面的讨论, 并保留解散这类主题小站的权利。 </p>
            <br>
            <br>
            <h2>小站标签 &nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;· </h2>
            <p>小站标签用来描述小站的内容。标签作为关键词可以被用户搜索到。 多个标签之间用<u style="color:#ff6600">空格</u>分隔开。 </p>
            <p>小站名称本身可以被搜索,就不用再加在标签里了。小站的名称、介绍、标签在创建后都可以随时更改。</p>
        </div>
    </div>
    
</div>
</div>
<?php include template('footer'); ?>
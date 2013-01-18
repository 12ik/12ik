<?php include pubTemplate('header');?>
<!--main-->
<div class="midder">
    <h1>申请创建小组</h1>
    <div class="mc">

        <div class="cleft">
        <form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=create&ik=do"  enctype="multipart/form-data" onsubmit="return createGroup(this);">
        <table width="100%" cellpadding="0" cellspacing="0" class="table_1">
            <tr>
                <th>小组名称：</th>
                <td><input type="text" value="" maxlength="63" size="31" name="groupname" tabindex="1" class="txt"    placeholder="请填写小组名称"></td>
            </tr>
            <tr>
                <th>小组介绍：</th>
                <td><textarea style="width:500px;height:200px;" name="groupdesc" tabindex="2" id="editor_mini" class="txt"   placeholder="请填写小组介绍"></textarea></td>
            </tr>
            <tr>
                <th>小组标签：</th>
                <td>
                	<input style="width:300px;" onKeyDown="checkTag(this)" onKeyUp="checkTag(this)"  onBlur="checkTag(this)" type="text" value=""  name="tag" id="tag" tabindex="3" class="txt" placeholder="请填写小组标签"> <span class="tip">最多 5 个标签</span>
                </td>
            </tr> 
            <tr>
                <th>&nbsp;</th>
                <td style="padding-top:0px ">
                	<p class="tips">标签作为关键词可以被用户搜索到，多个标签之间用空格分隔开。</p>
                </td>
            </tr>                        
            <tr>
                <th>小组图标：</th>
                <td><input type="file" name="picfile" class="txt" tabindex="4"><span class="tip">(仅支持jpg，gif，png格式图片)</span></td>
            </tr>           
            <tr>
                <th>&nbsp;</th>
                <td>
                <label><input type="checkbox" checked  name="grp_agreement" id="grp_agreement" value="1" tabindex="5">&nbsp;我已认真阅读并同意《社区指导原则》和《免责声明》</label>
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td><input class="submit" type="submit" value="创建小组" tabindex="6"/></td>
            </tr>
        </table>
        </form>
        </div>
    
        <div class="cright"></div>

	</div>

</div>
<?php include template('footer'); ?>
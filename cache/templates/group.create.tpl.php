<?php include pubTemplate('header');?>
<!--main-->
<div class="midder">
    <h1>申请创建小组</h1>
    <div class="mc">

        <div class="cleft">
        <form method="POST" action="<?php echo SITE_URL;?>index.php?app=group&ac=create&ik=do"  enctype="multipart/form-data">
        <table width="100%" cellpadding="0" cellspacing="0" class="table_1">
            <tr>
                <th>小组名称：</th>
                <td><input type="text" value="" maxlength="63" size="31" name="groupname" gtbfieldid="10" class="txt"    placeholder="请填写小组名称"></td>
            </tr>
            <tr>
                <th>小组介绍：</th>
                <td><textarea style="width:500px;height:200px;" name="groupdesc" id="editor_mini" class="txt"   placeholder="请填写小组介绍"></textarea></td>
            </tr>
            <tr>
                <th>小组图标：</th>
                <td><input type="file" name="picfile" class="txt"> <span class="tip">(仅支持jpg，gif，png格式图片)</span></td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td>
                <label><input type="checkbox" checked  name="grp_agreement" id="grp_agreement" value="1">&nbsp;我已认真阅读并同意《社区指导原则》和《免责声明》</label>
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td><input class="submit" type="submit" value="创建小组" /></td>
            </tr>
        </table>
        </form>
        </div>
    
        <div class="cright"></div>

	</div>

</div>
<?php include template('footer'); ?>
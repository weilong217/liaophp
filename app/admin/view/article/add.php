<?php include dirname(dirname(__FILE__))."/common/head.php"?>
<div class="container clearfix">
    <?php include dirname(dirname(__FILE__))."/common/sdidebar.php"?>
    <div class="main-wrap">

        <?php include dirname(dirname(__FILE__))."/common/crumb.php"?>
        <div class="result-wrap">
            <div class="result-content">
                <form action="" method="post" id="myform" name="myform" enctype="multipart/form-data">
                    <table class="insert-tab" width="100%">
                        <tbody>
                            <tr>
                                <th width="120"><i class="require-red">*</i>分类：</th>
                                <td>
                                    <select name="category_cid" id="catid" class="required">
                                        <?php foreach ($cateDate as $k=>$v):?>
                                            <?php echo "<option value=".$v['cid'].">".$v['cname']."</option>"?>
                                        <?php endforeach;?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <th><i class="require-red">*</i>标题：</th>
                                <td>
                                    <input class="common-text required" id="title" name="title" size="50" value="" type="text">
                                </td>
                            </tr>

                            <tr>
                                <th>摘要：</th>
                                <td><textarea name="digest" class="common-textarea" id="content" cols="30" style="width: 98%;" rows="10"></textarea></td>
                            </tr>

                            <tr>
                                <th><i class="require-red">*</i>缩略图：</th>
                                <td><input name="thumb" id="" type="file"></td>
                            </tr>

                            <tr>
                                <th>内容：</th>
                                <td><textarea name="content" class="common-textarea" id="content" cols="30" style="width: 98%;" rows="10"></textarea></td>
                            </tr>

                            <tr>
                                <th></th>
                                <td>
                                    <input class="btn btn-primary btn6 mr10" value="提交" type="submit">
                                    <input class="btn btn6" onclick="history.go(-1)" value="返回" type="button">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->
</div>
</body>
</html>
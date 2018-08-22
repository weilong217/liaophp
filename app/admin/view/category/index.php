<?php include dirname(dirname(__FILE__))."/common/head.php"?>
<div class="container clearfix">
    <?php include dirname(dirname(__FILE__))."/common/sdidebar.php"?>
    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="/jscss/admin">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">作品管理</span></div>
        </div>
        <div class="search-wrap">
            <div class="search-content">
                <form action="/jscss/admin/design/index" method="post">
                    <table class="search-tab">
                        <tr>
                            <th width="70">关键字:</th>
                            <td><input class="common-text" placeholder="关键字" name="keywords" value="" id="" type="text"></td>
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-title">
                    <div class="result-list">
                        <a href="?c=category&a=add"><i class="icon-font"></i>新增栏目</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th>ID</th>
                            <th>标题</th>
                            <th>操作</th>
                        </tr>
                        <?php foreach ($data as $k=>$v):?>
                        <tr>
                            <td><?php echo $v['cid']?></td>
                            <td><?php echo $v['cname']?></td>
                            <td>
                                <a class="link-update" href="javascript:;" onclick="cate_update(<?php echo $v['cid']?>)">修改</a>
                                <a class="link-del" href="javascript:;" onclick="cate_del(<?php echo $v['cid']?>)">删除</a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                    <div class="list-page"> 2 条 1/1 页</div>
                </div>
            </form>
        </div>
    </div>
    <!--/main-->
</div>
<script type="text/javascript">
    function cate_del(cid) {
        if(confirm('确定删除吗？')){
            location.href = "?c=category&a=del&cid="+cid;
        }
    }
</script>
</body>
</html>
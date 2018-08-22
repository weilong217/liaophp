<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>后台管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__?>/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__?>/css/main.css"/>
    <script type="text/javascript" src="<?php echo __PUBLIC__?>/js/libs/modernizr.min.js"></script>
</head>
<body>
<div class="topbar-wrap white">
    <div class="topbar-inner clearfix">
        <div class="topbar-logo-wrap clearfix">
            <h1 class="topbar-logo none"><a href="index.html" class="navbar-brand">后台管理</a></h1>
            <ul class="navbar-list clearfix">
                <li><a class="on" href="index.html">首页</a></li>
                <li><a href="#" target="_blank">网站首页</a></li>
            </ul>
        </div>
        <div class="top-info-wrap">
            <ul class="top-info-list clearfix">
                <li><a href="#">管理员</a></li>
                <li><a href="#">修改密码</a></li>
                <li><a href="javascript:;" onclick="cate_out()">退出</a></li>
            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    function cate_out() {
        if(confirm('确定退出吗？')){
            location.href = "?c=login&a=out";
        }
    }
</script>
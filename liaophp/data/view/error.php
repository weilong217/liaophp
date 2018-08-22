<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>操作失败！</title>
    <script>
        window.setTimeout("<?php echo $url ?>",<?php echo $time ?>*1000);
    </script>
</head>
<body>
<h1>操作失败 <span id="_time"><?php echo $time; ?></span> 秒钟之后进行 <a href="javascript:<?php echo $url ?>;">跳转</a>，您也可以返回 <a href="<?php __ROOT__?>">返回首页</a> </h1>
</body>

<script>
    var time = document.getElementById('_time').innerHTML;
    function revTime(){
        time --;
        if(time>0){
            document.getElementById('_time').innerHTML = time;
        }
        setInterval("revTime()",1000);
    }
</script>
</html>
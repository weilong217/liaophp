<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>错误提示</title>
</head>
<body>
    <h1>＞﹏＜</h1>
    <p><?php echo $e['message']?></>

    <?php if (DEBUG && isset($e['file'])): ?>
        <p><span>错误位置：</span>in "<?php echo $e['file'] .'"  line '. $e['line']?></>
    <?php endif; ?>

    <?php if (isset($e['trace'])): ?>
    <p><span>Trace</span><br><?php echo nl2br($e['trace'])?></p>
    <?php endif; ?>
</body>
</html>
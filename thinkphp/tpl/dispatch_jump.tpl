{__NOLAYOUT__}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>跳转提示</title>
    <link rel="stylesheet" href="__STATIC__/style/sui/sui.min.css">
    <link rel="stylesheet" href="__STATIC__/style/sui/sui-append.min.css">
    <link rel="stylesheet" href="__STATIC__/style/init/init.css">
    <link rel="stylesheet" href="__STATIC__/style/pure/grids-responsive.css">
    <link rel="stylesheet" href="__STATIC__/style/main/main.css">
    <script src="__STATIC__/scripts/jquery/jquery.min.js"></script>
    <script src="__STATIC__/scripts/sui/sui.min.js"></script>
    <script src="__STATIC__/scripts/banner/banner.js"></script>
    <style>
        .msg-box{
            position:relative;
            width:400px;
            padding-top:500px;
            margin:auto;
            text-align:center;
        }
        .msg-box h1{
            font-size:36px;
        }
        .msg-box h4{
            margin-top:25px;
            text-indent:110px;
            text-align:left;
        }
        .msg-box .e-message h4{
            text-indent:98px;
        }
        .msg-box .s-shadow{
            position:absolute;
            top:74%;
            left:36%;
            width:100px;
            height:20px;
            border-radius:50%;
            background:#333;
            opacity:0.5;
        }
        .msg-box .e-shadow{
            position:absolute;
            top:78%;
            left:21%;
            width:200px;
            height:20px;
            border-radius:50%;
            background:#333;
            opacity:0.5;
        }
        .msg-box .e-message{
            width:370px;
        }
        .msg-box .s-pic-box{
            position:absolute;
            top:130px;
            left:50px;
        }
        .msg-box .e-pic-box{
            position:absolute;
            top:155px;
            left:37px;
        }
    </style>
</head>
<body>
    <div class="computer">
        {include file="banner:banner" /}
        <div class="main-content">
            <div class="show-content">
                <div class="msg-box">
                    <?php switch ($code) {?>
                    <?php case 1:?>
                        <div class="s-pic-box">
                            <img src="__STATIC__/images/jump/success.png" alt="" width="400" height="400" />
                        </div>
                        <div class="s-message">
                            <h1>
                            <?php echo(strip_tags($msg)); ?>
                            </h1>
                            <h4>页面将在3秒后自动<a id="jump" href="<?php echo ($url); ?>">跳转</a>返回</h4>
                        </div>
                        <div class="s-shadow">
                        </div>
                    <?php break;?>
                    <?php case 0:?>
                        <div class="e-pic-box">
                            <img src="__STATIC__/images/jump/error.png" alt="" width="300" height="300" />
                        </div>
                        <div class="e-message">
                            <h1>
                            <?php echo(strip_tags($msg)); ?>
                            </h1>
                            <h4>页面将在3秒后自动<a id="jump" href="<?php echo ($url); ?>">跳转</a>返回</h4>
                        </div>
                        <div class="e-shadow">
                        </div>
                    <?php break;?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            setTimeout(function(){
                var href = $("#jump").attr("href");
                window.location.href = href;
            },3000);
        });
    </script>
</body>
</html>

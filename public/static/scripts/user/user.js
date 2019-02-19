$(function(){
    //修改密码确定提交事件
    $(".input-area .alter").click(function(){
        var swit = false;
        var p1 = $(".input-area .ori_pwd").val();
        var p2 = $(".input-area .new_pwd").val();
        var p3 = $(".input-area .new_pwd2").val();
        if(p1 && p2 && p3){
            swit = true;
        }
        if(p2 !== p3){
            swit = false;
        }
        if(swit){
            $("#show").show();
            $.ajax({
                url : "/user/psw",
                type : "post",
                data : {old : p1, new : p2, repeat : p3},
                success : function(data){
                    if(data.status === 200){
                        succ(data.msg,"/login");
                    }
                }
            });
        }else{
            $.alert("请填补好标红部分的内容!");
            return false;
        }
    });
    //收款码提交事件
    $(".input-area .img-up").click(function(){
        //认证是否至少上传了一种收款码
        var swit = false;
        var pics = $(".pics .pic-box input[type=file]");
        for(var i = 0; i < pics.length; i++){
            if(pics[i].value){
                swit = true;
                break;
            }
        }
        if(swit){
            $(this).parents("form").submit();
        }else{
            $.alert("请至少上传一种平台的收款码!");
        }
    });
    //模拟上传文件按钮的点击
    $(".dashed-box").click(function(ev){
        var that = $(this);
        if(that.find(".upload").is(":hidden")) {
            ev = ev || window.event;
            var menu = that.siblings(".hide-menu");
            menu.css("top",ev.pageY).css("left",ev.pageX);
            if(menu.is(":hidden")){
                menu.show();
            }else{
                menu.hide();
            }
            ev.stopPropagation ? ev.stopPropagation() : ev.cancelBubble = true;
        }else{
            that.find("input[type=file]")[0].click();
        }
    });
    document.onclick = function(){
        $(".pic-box .hide-menu").hide();
    };
    //文件上传框值发生改变时进行处理
    $(".dashed-box input[type=file]").change(function(){
        //文件上传浏览器兼容问题
        var FileReader = window.FileReader;
        var that = $(this);
        if(FileReader){
            //chrome谷歌浏览器
            var reader = new FileReader();
            var file = this.files[0];
            reader.onload = function(ev){
                //上传的文件加载完毕后显示预览
                that.siblings(".upload").hide();
                that.siblings(".card").removeClass("hidden").attr("src",ev.target.result);
            };
            reader.readAsDataURL(file);
        }else{
            //其他浏览器
            var path = $(this).val();
            if(/"\w\W"/.test(path)){
                path = path.slice(1,-1);
            }
            //上传的文件加载完毕后显示预览
            that.siblings(".upload").hide();
            that.siblings(".card").removeClass("hidden").attr("src",path);
        }
    });
    //返回
    $(".input-area .back").click(function(){
        swit($(this).parents("form"));
    });
    //修改密码点击
    $(".btn-area .show-pwd").click(function(){
        $(".btn-area").hide();
        $(".pwd-form").show();
    });
    //房东收款码点击
    $(".btn-area .show-qrcode").click(function(){
        $(".btn-area").hide();
        $(".qr-form").show();
    });
    function swit(hide){
        hide.hide();
        $(".btn-area").show();
    }
    //隐藏菜单下
    // 查看图片的点击事件
    $(".qr-form .hide-menu .look-img").click(function(){
        var that = $(this).parent();
        that.hide();
        $("#img .img-box img").attr("src",that.siblings(".dashed-box").find(".card").attr("src"));
        $("#img").show(function(){
            centerImg.call($("#img .img-box"));
        });
    });
    //重新上传图片点击事件
    $(".qr-form .hide-menu .reupload").click(function(){
        var that = $(this).parent();
        that.hide();
        that.siblings(".dashed-box").find("input[type=file]")[0].click();
    });
});
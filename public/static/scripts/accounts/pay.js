$(function(){
    $(".qr-box .btn-area .wx").click(function(){
        var that = $(this);
        var src = that.siblings(".wx-img").attr("src");
        if(!src){
            $("#show").show();
            fail("房东未上传该收款码");
            return;
        }
        $("#img .img-box img").attr("src",src);
        $("#img").show(centerImg.bind($("#img .img-box")));
    });
    $(".qr-box .btn-area .zfb").click(function(){
        var that = $(this);
        var src = that.siblings(".zfb-img").attr("src");
        if(!src){
            $("#show").show();
            fail("房东未上传该收款码");
            return;
        }
        $("#img .img-box img").attr("src",src);
        $("#img").show(centerImg.bind($("#img .img-box")));
    });
    $(".qr-box .btn-area .pay-btn .back").click(function(){
        window.history.go(-1);
    });
});
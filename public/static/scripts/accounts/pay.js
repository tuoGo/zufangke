$(function(){
    $(".qr-box .btn-area .wx").click(function(){
        var that = $(this);
        $("#img .img-box img").attr("src",that.siblings(".wx-img").attr("src"));
        $("#img").show(centerImg.bind($("#img .img-box")));
    });
    $(".qr-box .btn-area .zfb").click(function(){
        var that = $(this);
        $("#img .img-box img").attr("src",that.siblings(".zfb-img").attr("src"));
        $("#img").show(centerImg.bind($("#img .img-box")));
    });
    $(".qr-box .btn-area .pay-btn .back").click(function(){
        window.history.go(-1);
    });
});
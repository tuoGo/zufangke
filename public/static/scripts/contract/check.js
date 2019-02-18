$(function(){
    function inputResize(input){
        var len = input.val().length;
        var wid = parseInt(len)*20;
        input.css("width",wid + "px");
        console.log(len);
    }
    inputResize($(".address"));
    //模拟上传文件按钮的点击
    $(".dashed-box").click(function(){
        var that = $(this);
        if(that.find(".upload").is(":hidden")) {
            $("#img .img-box img").attr("src",that.find(".card").attr("src"));
            $("#img").show(function(){
                centerImg.call($("#img .img-box"));
            });
        }else{
            that.find("input[type=file]")[0].click();
        }
    });
});
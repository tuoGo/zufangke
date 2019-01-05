$(function(){
    $(".pack").click(function(){
        var pack = $(this);
        var mid = $(this).parent().parent().find(".mid-content");
        pack.toggleClass("zero");
        if(pack.hasClass("zero")){
            mid.innerHeight(0);
        }else{
            mid.innerHeight(310);
        }
    });
    $(".room-pack").click(function(){
        var pack = $(this);
        var mid = $(this).parent().parent().find(".m-mid-content-content");
        pack.toggleClass("zero");
        if(pack.hasClass("zero")){
            mid.height(0);
        }else{
            mid.height(220);
        }
    });
});
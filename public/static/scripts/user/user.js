$(function(){
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
            $(this).parents("form").submit();
        }else{
            $.alert("请填补好标红部分的内容!");
            return false;
        }
    });
});
$(function(){
    //合同删除按钮点击
    $(".con_del").click(function(){
        var that = $(this);
        $.confirm({
            body : "确定要删除吗!",
            okHidden : function(){
                $("#show").show();
                $.ajax({
                    url : "/contract/del",
                    type : "post",
                    data : {"contid" : that.parents("tr").find("input[name=contid]").val()},
                    success : function(data){
                        if(data.status === 200){
                            $("#show .loading").hide();
                            $("#show .success-animal .tip-msg").html(data.msg);
                            $("#show .success-animal").show();
                            setTimeout(function(){
                                window.history.go(0);
                            },2000);
                        }
                    }
                });
            }
        });
    });
    //搜索按钮点击
    $(".search-area .search-btn").click(function(){
        var phone = $(this).parent().find("input[name=cont_phone]").val();
        if(phone){
            if(isNaN(phone)){
                $.alert("请输入数字查询");
            }else{
                $(this).parent().submit();
            }
        }else{
            return false;
        }
    });
});
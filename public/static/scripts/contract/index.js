$(function(){
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
});
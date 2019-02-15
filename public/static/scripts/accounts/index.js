$(function(){
    $(".table-area .add .payoff").click(function(){
        var we = $("#we-input");
        we.find(".modal-body .input-box input[name=fid]").val($(this).parents("tr").attr("data-fid"));
        we.find(".modal-body .input-box input[name=contid]").val($(this).parents("tr").attr("data-contid"));
        we.modal("show");
    });
    $(".table-area .add .checkPay").click(function(){
        var fid = $(this).parents("tr").attr("data-fid");
        $.confirm({
            body : "是否已收到租客的租金!!",
            okHidden : function(){
                $("#show").show();
                $.ajax({
                    url : "/accounts/confirm",
                    type : "post",
                    data : {fid : fid},
                    success : function(data){
                        if(data.status === 200){
                            succ(data.msg);
                        }
                    }
                });
            }
        });
    });
    $(".table-area .add .check_con").click(function(){
        var that = $(this);
        var contid = that.parents("tr").attr("data-contid");
        that.siblings("input[name=contid]").val(contid);
        that.parent().submit();
    });
    $("#we-input").on("okHidden",function(){
        $("#show").show();
        var we = $("#we-input");
        var fid = we.find(".modal-body .input-box input[name=fid]").val();
        var contid = we.find(".modal-body .input-box input[name=contid]").val();
        var water = we.find(".modal-body .input-box input[name=water]").val();
        var elec = we.find(".modal-body .input-box input[name=elec]").val();
        $.ajax({
            url : "/accounts/init",
            type : "post",
            data : {fid : fid, water : water, elec : elec , contid : contid},
            success : function(data){
                if(data.status === 200){
                    succ(data.msg);
                }
            }
        });
    });
});
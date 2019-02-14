$(function(){
    $(".table-area .add .payoff").click(function(){
        $("#we-input").find(".modal-body .input-box input[name=fid]").val($(this).parents("tr").attr("data-id"));
        $("#we-input").modal("show");
    });
    $("#we-input").on("okHidden",function(){
        var we = $("#we-input");
        var id = we.find(".modal-body .input-box input[name=fid]").val();
        var water = we.find(".modal-body .input-box input[name=water]").val();
        var elec = we.find(".modal-body .input-box input[name=elec]").val();
        $.ajax({
            url : "/accounts/init",
            type : "post",
            data : {fid : id, water : water, elec : elec},
            success : function(data){
                if(data.status === 200){
                    $("#show .loading").hide();
                    $("#show .success-animal .tip-msg").html(data.msg);
                    $("#show .success-animal").show();
                    setTimeout(function(){
                        window.location.href = "/accounts";
                    },2000);
                }
            }
        });
    });
});
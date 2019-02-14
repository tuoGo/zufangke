$(function(){
    $(".table-area .add .payoff").click(function(){
        $("#we-input").modal("show");
    });
    $("#we-input").on("okHidden",function(){

        // $.ajax({
        //     url : "/accounts/init",
        //     type : "post",
        //     data : {},
        //     success : function(data){
        //         if(data.status === 200){
        //
        //         }
        //     }
        // });
    });
});
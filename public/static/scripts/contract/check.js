$(function(){
    function inputResize(input){
        var len = input.val().length;
        var wid = parseInt(len)*20;
        input.css("width",wid + "px");
        console.log(len);
    }
    inputResize($(".address"));
});
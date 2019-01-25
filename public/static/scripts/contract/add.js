$(function(){
    $(".dashed-box").click(function(){
        $(this).find("input[type=file]")[0].click();
    });
    $(".dashed-box input[type=file]").change(function(){
        var name = $(this).val();
        var fileName = name.substring(name.lastIndexOf(".")+1).toLowerCase();
        console.log(name + "\n");
        console.log(fileName);
    });
    //添加合同页面的小区选择事件
    $(".house-id ul li").click(tree);
    //楼栋单元的点击事件
    $(".unit-id ul").on("click","li",tree);
    //房间或者楼栋选择点击事件，逐层显示下级
    function tree(){
        var isHouse = true;
        var param = {};
        var $a = $(this).find("a");
        if($(this).parents(".dropdown-inner").hasClass("house-id")){
            var unit_ul = $(".unit-id ul");
            unit_ul.html("");
            $(".unit-id a input[type=hidden]").val();
            $(".unit-id a input[type=hidden]").siblings("span").html("请选择楼栋");
            $(".room-id ul").html("");
            $(".room-id a input[type=hidden]").val();
            $(".room-id a input[type=hidden]").siblings("span").html("请选择房间");
            param.hid = $a.attr("data-hid");
        }else{
            isHouse = false;
            var room_ul = $(".room-id ul");
            room_ul.html("");
            $(".room-id a input[type=hidden]").val();
            $(".room-id a input[type=hidden]").siblings("span").html("请选择房间");
            param.roomid = $a.attr("data-uid");
        }
        $.ajax({
            url:"/contract/addpage",
            data:param,
            type:"post",
            dataType:"json",
            success:function (data){
                if(data.status === 200){
                    showLi(data.data,isHouse);
                }
            }
        });
    }
    //渲染页面的下拉列表下级
    function showLi(data,isHouse){
        if(isHouse){
            var unit_ul = $(".unit-id ul");
            //循环渲染对应小区下的楼栋单元
            for(var i = 0; i < data.length; i++) {
                unit_ul.append('<li role="presentation">' +
                    '<a role="menuitem" tabindex="-1" href="javascript:void(0);" ' +
                    'data-uid="' + data[i].roomid + '" value="' + data[i].room + '">' + data[i].room + '</a>' + '</li>');
            }
        }else{
            var room_ul = $(".room-id ul");
            //循环渲染对应小区下的楼栋单元的房间列表
            for(var i = 0; i < data.length; i++) {
                room_ul.append('<li role="presentation">' +
                    '<a role="menuitem" tabindex="-1" href="javascript:void(0);" ' +
                    'data-roomid="' + data[i].underid + '" value="' + data[i].tag + '">' + data[i].tag + '</a>' + '</li>');
            }
        }
    }
});
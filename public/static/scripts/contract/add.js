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
    $(".house-id ul li").click(function(){
        var $a = $(this).find("a");
        var hid = $a.attr("data-hid");
        var unit_ul = $(".unit-id ul");
        unit_ul.html("");
        $(".unit-id a input[type=hidden]").val();
        $(".unit-id a input[type=hidden]").siblings("span").html("请选择楼栋");
        $(".room-id ul").html("");
        $(".room-id a input[type=hidden]").val();
        $(".room-id a input[type=hidden]").siblings("span").html("请选择房间");
        $.ajax({
            url:"/contract/addpage",
            data:{'hid':hid},
            type:"post",
            dataType:"json",
            success:function (data){
                if(data.status === 200){
                    for(var i = 0; i < data.data.length; i++){
                        //循环渲染对应小区下的楼栋单元
                        unit_ul.append('<li role="presentation">' +
                            '<a role="menuitem" tabindex="-1" href="javascript:void(0);" ' +
                            'data-uid="'+data.data[i].roomid+'" value="'+data.data[i].room+'">'+data.data[i].room+'</a>' + '</li>');
                    }
                }
            }
        });
    });
    //楼栋单元的点击事件
    $(".unit-id ul").on("click","li",function(){
        var $a = $(this).find("a");
        var hid = $(".house-id ul li.active a").attr("data-hid");
        var uid = $a.attr("data-uid");
        var room_ul = $(".room-id ul");
        room_ul.html("");
        $(".room-id a input[type=hidden]").val();
        $(".room-id a input[type=hidden]").siblings("span").html("请选择房间");
        $.ajax({
            url:"/contract/addpage",
            data:{'hid':hid,'uid':uid},
            type:"post",
            dataType:"json",
            success:function (data){
                if(data.status === 200){
                    for(var i = 0; i < data.data.length; i++){
                        //循环渲染对应小区下的楼栋单元下的房间列表
                        room_ul.append('<li role="presentation">' +
                            '<a role="menuitem" tabindex="-1" href="javascript:void(0);" ' +
                            'data-uid="'+data.data[i].roomid+'" value="'+data.data[i].room+'">'+data.data[i].room+'</a>' + '</li>');
                    }
                }
            }
        });
    });
});
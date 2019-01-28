$(function(){
    //模拟上传文件按钮的点击
    $(".dashed-box").click(function(){
        $(this).find("input[type=file]")[0].click();
    });
    //文件上传框值发生改变时进行处理
    $(".dashed-box input[type=file]").change(function(){
        //文件上传浏览器兼容问题
        var FileReader = window.FileReader;
        var that = $(this);
        if(FileReader){
            //chrome谷歌浏览器
            var reader = new FileReader();
            var file = this.files[0];
            reader.onload = function(ev){
                //上传的文件加载完毕后显示预览
                that.siblings(".upload").hide();
                that.siblings(".card").removeClass("hidden").attr("src",ev.target.result);
            };
            reader.readAsDataURL(file);
        }else{
            //其他浏览器
            var path = $(this).val();
            if(/"\w\W"/.test(path)){
                path = path.slice(1,-1);
            }
            //上传的文件加载完毕后显示预览
            $(".card_f").attr("src",path);
        }
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
    //签约时间按钮的点击
    $(".sui-btn-group").on("click",".sui-btn",function(){
        var text = $(this).html();
        var length = text.length;
        text = text.substring(0,length-2);
        $(".less-time input[name=less_month]").val(text);
    });
    //确定提交
    $(".btn-area .btn-upload").click(function(){
        //时间变量调整时间戳上传
        var start = $(".less-time input[name=start_time]").val();
        var month = parseInt($(".less-time input[name=less_month]").val());
        if(month){
            start = start.replace(/-/g,"/");
            var d = new Date(start);
            start = d.getTime();
            d.setMonth(d.getMonth()+ month);
            var end = d.getTime();
            $(".less-time input[name=start_time]").val(start);
            $(".less-time input[name=end_time]").val(end);
        }
        //押金与付款变量调整
        var bet = $(".pay-type .dropdown-inner input[name=bet]");
        var pay = $(".pay-type .dropdown-inner input[name=pay]");
        bet.val(bet.val().replace("押",""));
        pay.val(pay.val().replace("付",""));
        //hid 与 underid的赋值
        var hid = $(".house-id li.active a").attr("data-hid");
        var underid = $(".room-id li.active a").attr("data-roomid");
        if(hid && underid){
            $(".house-id input[name=hid]").val(hid);
            $(".room-id input[name=underid]").val(underid);
        }
        $(this).parents("form").submit();
    });
});
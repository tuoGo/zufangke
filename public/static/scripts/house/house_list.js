$(function(){
    //隐藏小区动画
    $(".pack").click(function(){
        var pack = $(this);
        var mid = $(this).parent().parent().find(".mid-content");
        pack.toggleClass("zero");
        if(pack.hasClass("zero")){
            mid.css("max-height","0");
        }else{
            mid.css("max-height","290px");
        }
    });
    //隐藏房间动画
    $(".room-pack").click(function(){
        var pack = $(this);
        var m_mid = $(this).parent().parent().find(".m-mid-content");
        var mid = "";
        pack.toggleClass("zero");
        if(pack.hasClass("zero")){
            m_mid.innerHeight(0);
            m_mid.css("padding","0");
        }else{
            m_mid.css("height","");
            m_mid.css("padding","10px");
        }
    });
    //显示小区单元操作区
    $(".area-menu").click(function(){
        var list = $(this).find(".c-list");
        list.show();
        $(this).mouseleave(function(){
            list.hide();
        });
    });
    //显示房间详细信息
    $(".house-room").click(function(){
        var that = $(this);
        that.find(".handle-area").height(that.find(".house-handle").innerHeight());
        that.find(".house-handle").width(that.find(".all-msg").actual("width") + that.find(".handle-area").actual("width")+2);
        that.parent().css("overflow","visible");
        that.parent().parent().css("overflow","visible");
        that.find(".house-handle").show();
        that.mouseleave(function(){
            that.find(".house-handle").hide();
            that.parent().css("overflow","hidden");
            that.parent().parent().css("overflow","hidden");
        });
    });
    //添加房源按钮事件
    $(".big-add").click(function(){
        $("#housing .plot").hide();
        $("#housing .add-plot").show();
        $("#housing .house-number").show();
    });
    //小区区域的添加房源按钮(自动选择小区)
    $(".plot-add").click(function(){
        var title = $(this).parents(".top-title").find(".area-title").html();
        $("#housing .plot input[name=plot]").val(title);
        $("#housing .plot").show();
        $("#housing .add-plot").hide();
        $("#housing .house-number").show();
    });
    //房源数目更换事件
    $("#housing .house-number input[name=plot_number]").change(trChange);
    //房间数目更换事件
    $("#rooming .house-number input[name=room_number]").change(trChange);
    function trChange(){
        var number = parseInt($(this).val());
        var add = $(this).parents(".sui-form").find(".add");
        var trs = add.find("tr").length;
        if(number === trs){
            return;
        }
        if(number > trs){
            var name = $(this).attr("name");
            if(name === "plot_number"){
                addPlotTr(number - trs);
            }else{
                addRoomTr(number - trs);
            }
        }else if(number < trs){
            for(var i = 0; i < trs - number; i++){
                add.find("tr:last-child").remove();
            }
        }
    }
    //添加房源小区模板
    function addPlotTr(num){
        var inner = '';
        inner += '<tr>';
        inner += '<td>';
        inner += '<div>';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="整租" name="house_type"><i class="caret"></i><span>整租</span>';
        inner += '<ul role="menu" aria-labelledby="drop2" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="整租">整租</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="合租">合租</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += '</div>';
        inner += '</td>';
        inner += '<td><input type="text" placeholder="请填写数字" name="build" class="needCheck"></td>';
        inner += '<td><input type="text" placeholder="请填写数字" name="unit" class="needCheck"></td>';
        inner += '<td><input type="text" placeholder="请填写数字" name="room_name" class="needCheck"></td>';
        inner += '<td>';
        inner += '<div>';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="1" name="room_number"><i class="caret"></i><span>1</span>';
        inner += '</a>';
        inner += '<ul role="menu" aria-labelledby="drop7" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="1">1</a>';
        inner += '</li>';
        inner += '<li role="presentation">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="2">2</a>';
        inner += '</li>';
        inner += '<li role="presentation">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="3">3</a>';
        inner += '</li>';
        inner += '<li role="presentation">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="4">4</a>';
        inner += '</li>';
        inner += '<li role="presentation">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="5">5</a>';
        inner += '</li>';
        inner += '<li role="presentation">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="6">6</a>';
        inner += '</li>';
        inner += '<li role="presentation">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="7">7</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += '</div>';
        inner += '</td>';
        inner += '<td>';
        inner += '<div>';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="1" name="lobby_number"><i class="caret"></i><span>1</span>';
        inner += '</a>';
        inner += '<ul role="menu" aria-labelledby="drop7" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="1">1</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="2">2</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="3">3</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="4">4</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="5">5</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="6">6</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="7">7</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += '</div>';
        inner += '</td>';
        inner += '<td>';
        inner += '<div>';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="1" name="toilet_number"><i class="caret"></i><span>1</span>';
        inner += '</a>';
        inner += '<ul role="menu" aria-labelledby="drop7" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="1">1</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="2">2</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="3">3</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="4">4</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="5">5</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="6">6</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="7">7</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += '</div>';
        inner += '</td>';
        inner += '<td class="fitment">';
        inner += '<div>';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="精装修" name="fitment_status"><i class="caret"></i><span>精装修</span>';
        inner += '<ul role="menu" aria-labelledby="drop5" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="精装修">精装修</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="中等装修">中等装修</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="简单装修">简单装修</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="豪华装修">豪华装修</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += '</div>';
        inner += '</td>';
        inner += '</tr>';
        for(var i = 0; i < num; i++){
            $("#housing .add").append(inner);
        }
    }
    //添加房源房间模板
    function addRoomTr(num){
        var text = $("#rooming .add tr:first-child .room-t input").val();
        var inner = '';
        inner += '<tr>';
        inner += '<td class="room-t"><input type="text" readonly="readonly" value="'+text+'" name="build_name"></td>';
        inner += '<td><input type="text" placeholder="请填写" name="room_name" class="needCheck"></td>';
        inner += '<td class="room-type">';
        inner += '<div>';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="主卧" name="room_type"><i class="caret"></i><span>主卧</span>';
        inner += '</a>';
        inner += '<ul role="menu" aria-labelledby="drop4" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="主卧">主卧</a>';
        inner += '</li>';
        inner += '<li role="presentation">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="次卧">次卧</a>';
        inner += '</li>';
        inner += '<li role="presentation">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="床位">床位</a>';
        inner += '</li>';
        inner += '<li role="presentation">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="主卧(带独卫)">主卧(带独卫)</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += '</div>';
        inner += '</td>';
        inner += '<td class="room-status">';
        inner += '<div style="width:65px;">';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="未租" name="lease_status"><i class="caret"></i><span>未租</span>';
        inner += '</a>';
        inner += '<ul role="menu" aria-labelledby="drop2" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="未租">未租</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="已租">已租</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += '</div>';
        inner += '</td>';
        inner += '<td style="width:140px;" class="room-bp">';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="押0" name="cash"><i class="caret"></i><span>押0</span>';
        inner += '</a>';
        inner += '<ul role="menu" aria-labelledby="drop4" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="押0">押0</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="押1">押1</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="押2">押2</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="押3">押3</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += ' ';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="付1" name="pay"><i class="caret"></i><span>付1</span>';
        inner += '</a>';
        inner += '<ul role="menu" aria-labelledby="drop24" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付1">付1</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付2">付2</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付3">付3</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付4">付4</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付5">付5</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付6">付6</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付7">付7</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付8">付8</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付9">付9</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付10">付10</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付11">付11</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付12">付12</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付13">付13</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付14">付14</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付15">付15</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付16">付16</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付17">付17</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付18">付18</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付19">付19</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付20">付20</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付21">付21</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付22">付22</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付23">付23</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="付24">付24</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += '</td>';
        inner += '<td class="room-price"><input type="text" placeholder="请填写" name="lease_price" class="needCheck"></td>';
        inner += '</tr>';
        for(var i = 0; i < num; i++){
            $("#rooming .add").append(inner);
        }
    }
    //房源小区编辑事件
    $(".room-edit").click(function(){
        var house = $("#housing");
        var input = $("#housing .plot input[name=plot]");
        $("#housing .plot").show();
        $("#housing .add-plot").hide();
        $("#housing .house-number ul li:first-child a").click();
        trChange.call($("#housing .house-number input[name=plot_number]"));
        input.val($(this).parents(".house-box").find(".top-title .area-title").html());
        input.bind("input propertychange change",inputResize(input));
        house.find(".house-number").hide();
        /*
        *  ajax 请求获取小区下该单元各类参数并显示到表格上
        * */

        house.modal("show");
    });
    //房源房间编辑事件
    $(".house-room .edit").click(function(){
        var room = $("#rooming");
        $("#rooming .house-number ul li:first-child a").click();
        room.find(".house-number").hide();
        room.find(".plot").hide();
        var text = trim($(this).parents(".mid-content").find(".room-title p").html());
        room.find(".add .room-t input").val(text);
        /*
        *  ajax 发起请求获取房间数据渲染页面
        * */

        room.modal("show");
    });
    //房间添加事件
    $(".room-plus").click(function(){
        var roomid = $(this).siblings(".room-title").attr("data-id");
        $("#rooming .add").attr("data-id",roomid);
        var input = $("#rooming .plot input");
        $("#rooming .house-number").show();
        $("#rooming .plot").show();
        $("#rooming").modal("show");
        input.val($(this).parents(".house-box").find(".top-title .area-title").html());
        $("#rooming .add .room-t input").val(trim($(this).parent().find(".room-title").text()));
        input.bind("input propertychange change",inputResize(input));
    });
    //input自适应宽度
    function inputResize(input){
        var len = input.val().length;
        var wid = parseInt(len)*12;
        input.css("width",wid + "px");
    }
    //添加房间页面的层上层房间描述显示
    // $("#rooming").on("click",".room-comment",houseComment);
    // function houseComment(){
    //     var a = $(this).find("a");
    //     var input = $(this).find(".r-comment");
    //     var text = input.val();
    //     $("#rooming").modal("shadeIn");
    //     return $.confirm({
    //         title : "房间描述",
    //         body : "<form action='' class='sui-form'>" +
    //             "<textarea class='h-comment' style='width:400px;height:200px;font-size:18px;'>" + text +
    //             "</textarea>" +
    //             "</form>",
    //         backdrop : false,
    //         okHide : function(){
    //             text = $(".h-comment").val();
    //             a.html("已配置");
    //             input.val(text);
    //         },
    //         hide : function(){
    //             return $("#rooming").modal("shadeOut");
    //         }
    //     });
    // }
    //删除操作
    $(".del-plot").click(popup.bind(null));
    $(".del-unit").click(popup.bind(null));
    $(".del-room").click(popup.bind(null));
    //弹窗确认
    function popup(ev){
        var that = $(ev.target);
        var rank = that.attr("data-rank");
        var delId = {
            room : [],
            unit : [],
        };
        switch(rank){
            case 1:
                delId.room[0] = that.parents(".house-room").find(".cap").attr("data-id");
                break;
            case 2:

                break;
            case 3:
                delId.house = that
                break;
        }
        console.log(delId);
        // return $.confirm({
        //     title : "请确认您的操作",
        //     body : "确定要执行删除的操作吗！？",
        //     okHide : del.bind(null,id)
        // });
    }
    function del(rank){
        //rank代表要删除的级别
        /*
        *  发起ajax请求后台删除指定数据
        * */
        console.log(rank);
    }
    //显示该小区下房间总数
    $.each($(".house-box"),function(index,el){
        $(el).find(".house-msg .house-all").html(($(el).find(".house-room").length));
        $(el).find(".house-msg .empty-all").html($(el).find(".house-room .cap .null").length);
    });
    //退房操作
    $(".house-box .house-room .handle-area .exit").click(function(){
        var that = $(this);
        var title = '';
        title += trim(that.parents(".house-room").find(".cap p:first-child").html());
        title = trim(that.parents(".mid-content").find(".m-top-title .room-title p").html()) + title;
        title = that.parents(".house-box").find(".top-title .area-title").html() + title;
        var room = that.parents(".house-room");
        var con = room.find(".all-msg-contract .contract-time").html();
        var user = room.find(".all-msg-contract .user-name").html();
        var phone = room.find(".all-msg-contract .user-phone").html();
        var pay = room.find(".house-handle .all-msg-house .house-price").html();
        var cash = room.find(".house-handle .all-msg-house .house-cash").html();
        $("#checkOut .msg-box .house-msg").html(title);
        $("#checkOut .msg-box .house-contract").html(con);
        $("#checkOut .msg-box .user").html(user);
        $("#checkOut .msg-box .user-contact").html(phone);
        $("#checkOut .msg-box .house-pay").html(pay);
        $("#checkOut .msg-box .house-cash").html(cash);
        $("#checkOut").modal("show");
    });
    //添加房源的提交事件
    $("#housing").on("okHide",function(){
        //先进行表单检验
        var swit = true;
        var validates = $("#housing .needCheck");
        for(var j = 0; j < validates.length; j++){
            $(validates[j]).removeClass("input-error");
            if(!$(validates[j]).val()){
                $(validates[j]).addClass("input-error");
                swit = false;
            }
            if(isNaN($(validates[j]).val())){
                $(validates[j]).addClass("input-error");
                $(validates[j]).val("请填写纯数字");
                swit = false;
            }
        }
        if(swit){
            var trs = $("#housing .add tr");
            var length = trs.length;
            var param = {};
            if($("#housing .add-plot").is(":hidden")){
                param.hid = $("#housing .plot input[name=plot]").attr("data-id");
            }else{
                console.log(111);
                param.plot_name =  $("#housing .plot input[name=plot_name]").val();
                if(!param.plot_name){
                    $.alert("请填写小区名");
                    return false;
                }
            }
            param.datas = [];
            for(var i = 0; i < length; i++){
                param.datas[i] = {
                    //出租方式
                    type : $(trs[i]).find("input[name=house_type]").val() === "整租" ? 1:2,
                    //楼栋单元房间号
                    room : $(trs[i]).find("input[name=build]").val() + "栋" + $(trs[i]).find("input[name=unit]").val() + "单元" + $(trs[i]).find("input[name=room_name]").val() + "室",
                    //有几个房间
                    num_room : $(trs[i]).find("input[name=room_number]").val(),
                    //有几个大厅
                    num_hall : $(trs[i]).find("input[name=lobby_number]").val(),
                    //有几个厕所
                    num_toilet : $(trs[i]).find("input[name=toilet_number]").val(),
                    //装修状态
                    decorate : $(trs[i]).find("input[name=fitment_status]").val()
                };
            }
            $.ajax({
                url:"/house/add",
                data:param,
                type:"post",
                success:function (data){

                }
            });
        }else{
            $.alert("请填补好标红部分的内容!");
            return false;
        }
    });
    $(".show-content").on("click",".plot-add",function(){
        $("#housing .plot input[name=plot]").attr("data-id",$(this).attr("data-id"));
    });
    //添加房间的提交事件
    $("#rooming").on("okHide",function(){
        //先进行表单检验
        var swit = true;
        var validates = $("#rooming .needCheck");
        for(var j = 0; j < validates.length; j++){
            $(validates[j]).removeClass("input-error");
            if(!$(validates[j]).val()){
                $(validates[j]).addClass("input-error");
                swit = false;
            }
            if(isNaN($(validates[j]).val())){
                $(validates[j]).addClass("input-error");
                $(validates[j]).val("请填写纯数字");
                swit = false;
            }
        }
        if(swit){
            var trs = $("#rooming .add tr");
            var length = trs.length;
            var param = {};
            param.roomid = $("#rooming .add").attr("data-id");
            param.datas = [];
            for(var i = 0; i < length; i++){
                param.datas[i] = {
                    //tag 房间名称
                    tag : $("#rooming .add input[name=room_name]").val(),
                    //bedroom 主卧 次卧 独卫
                    bedroom : $("#rooming .add .room-type .dropdown-inner input[name=room_type]").val(),
                    //status 房间出租状态
                    status : $("#rooming .add .room-status .dropdown-inner input[name=lease_status]").val() === "未租" ? 0 : 1,
                    //bet 押金方式
                    bet : $("#rooming .add .room-bp .dropdown-inner input[name=cash]").val().replace("押",""),
                    //pay 付款方式
                    pay : $("#rooming .add .room-bp .dropdown-inner input[name=pay]").val().replace("付",""),
                    //amount 租金
                    amount : $("#rooming .add .room-price input[name=lease_price]").val()
                }
            }
            $.ajax({
                url:"/house/add",
                data : param,
                type : "post",
                success : function(data){

                }
            });
        }else{
            $.alert("请填补好标红部分的内容!");
            return false;
        }
    });
    //检测单元下是否有房间
    var house = $(".house-box");
    for(var h = 0; h < house.length; h++){
        var rooms = $(house[h]).find(".m-mid-content .house-room");
        if(!rooms.length){
            $(house[h]).find(".mid-content .m-top-title .room-pack").click();
        }
    }
});
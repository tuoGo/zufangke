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
    //小区区域的添加房源按钮(自动选择小区)
    $(".plot-add").click(function(){
        var title = $(this).parents(".top-title").find(".area-title").html();
        var lis = $("#housing .plot ul li");
        var liTitle = "";
        var el = "";
        $.each(lis,function(index,value){
            el = $(value);
            liTitle = trim(el.find("a").html());
            if(liTitle === title){
                el.find("a").click();
                return false;
            }
        });
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
    function addPlotTr(num){
        var inner = '';
        inner += '<tr>';
        inner += '<td><input type="text" placeholder="请填写" name="build"></td>';
        inner += '<td><input type="text" placeholder="请填写" name="unit"></td>';
        inner += '<td><input type="text" placeholder="请填写" name="room_name"></td>';
        inner += '<td>';
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
        inner += '</td>';
        inner += '<td>';
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
        inner += '</td>';
        inner += '<td>';
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
        inner += '</td>';
        inner += '<td><input type="text" placeholder="请填写" name="acreage"></td>';
        inner += '<td><input type="text" placeholder="请填写" name="floors"></td>';
        inner += '<td><input type="text" placeholder="请填写" name="now_floor"></td>';
        inner += '<td>';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="无" name="has_elevator"><i class="caret"></i><span>无</span>';
        inner += '</a>';
        inner += '<ul role="menu" aria-labelledby="drop5" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="无">无</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="有">有</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += '</td>';
        inner += '<td class="fitment">';
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
        inner += '</td>';
        inner += '</tr>';
        for(var i = 0; i < num; i++){
            $("#housing .add").append(inner);
        }
    }
    function addRoomTr(num){

        var inner = '';
        inner += '<tr>';
        inner += '<td class="room-t"><input type="text" readonly="readonly" value="" name="build_name"></td>';
        inner += '<td><input type="text" placeholder="请填写" name="room_name"></td>';
        inner += '<td class="room-type">';
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
        inner += '</td>';
        inner += '<td class="room-size"><input type="text" placeholder="请填写"></td>';
        inner += '<td>';
        inner += '<span class="sui-dropdown dropdown-bordered select">';
        inner += '<span class="dropdown-inner">';
        inner += '<a role="button" href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle">';
        inner += '<input type="hidden" value="东" name="direction"><i class="caret"></i><span>东</span>';
        inner += '</a>';
        inner += '<ul role="menu" aria-labelledby="drop10" class="sui-dropdown-menu">';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="东">东</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="南">南</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="西">西</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="北">北</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="东南">东南</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="东西">东西</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="东北">东北</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="西南">西南</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="西北">西北</a>';
        inner += '</li>';
        inner += '<li role="presentation" class="active">';
        inner += '<a role="menuitem" tabindex="-1" href="javascript:void(0);" value="南北">南北</a>';
        inner += '</li>';
        inner += '</ul>';
        inner += '</span>';
        inner += '</span>';
        inner += '</td>';
        inner += '<td>';
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
        inner += '</td>';
        inner += '<td>';
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
        inner += '<td class="room-price"><input type="text" placeholder="请填写" name="lease_price"></td>';
        inner += '<td class="room-price"><input type="text" placeholder="请填写" name="pay_price"></td>';
        inner += '<td class="room-comment">';
        inner += '<input type="hidden" class="r-comment" name="comment">';
        inner += '<a href="javascript:void(0);"><i class="sui-icon icon-pc-plus-circle"></i></a>';
        inner += '</td>';
        inner += '</tr>';
        for(var i = 0; i < num; i++){
            $("#rooming .add").append(inner);
        }
    }
    //房间添加事件
    $(".room-plus").click(function(){
        var input = $("#rooming .plot input");
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
    $("#rooming").on("click",".room-comment",houseComment);
    function houseComment(){
        var a = $(this).find("a");
        var input = $(this).find(".r-comment");
        var text = input.val();
        $("#rooming").modal("shadeIn");
        return $.confirm({
            title : "房间描述",
            body : "<form action='' class='sui-form'>" +
                "<textarea class='h-comment' style='width:400px;height:200px;font-size:18px;'>" + text +
                "</textarea>" +
                "</form>",
            backdrop : false,
            okHide : function(){
                text = $(".h-comment").val();
                a.html("已配置");
                input.val(text);
            },
            hide : function(){
                return $("#rooming").modal("shadeOut");
            }
        });
    }
});
$(function(){
    function browserRedirect() {
        var sUserAgent = navigator.userAgent.toLowerCase();
        var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
        var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
        var bIsMidp = sUserAgent.match(/midp/i) == "midp";
        var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
        var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
        var bIsAndroid = sUserAgent.match(/android/i) == "android";
        var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
        var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
        // console.log("您的浏览设备为：");
        if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
            // console.log("phone");
            //移动端样式
            $(".arrow_b").click(function(){
                var arrow = $(this);
                var left = $(".left-banner");
                arrow.toggleClass("ar");
                arrow.toggleClass("al");
                if(arrow.hasClass("ar")){
                    left.css("left","-85%");
                    arrow.css("left","0");
                    return;
                }
                if(arrow.hasClass("al")){
                    left.css("left","0px");
                    arrow.css("left","85%");
                }
            });
        } else {
            // console.log("pc");
            //PC端样式
            var tb = $(".tb");
            tb.mouseenter(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/tb_blue.png")
            });
            tb.mouseleave(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/tb.png")
            });
            var wh = $(".wareHouse");
            wh.mouseenter(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/icons_warehouse_blue.png")
            });
            wh.mouseleave(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/icons_warehouse.png")
            });
            var ct = $(".contract");
            ct.mouseenter(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/contract_blue.png")
            });
            ct.mouseleave(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/contract.png")
            });
            var post = $(".post");
            post.mouseenter(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/post_blue.png")
            });
            post.mouseleave(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/post.png")
            });
            var sl = $(".sleep");
            sl.mouseenter(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/sleep_blue.png")
            });
            sl.mouseleave(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/sleep.png")
            });
            var ct_con = $(".ct_con");
            ct_con.mouseenter(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/ct_con_blue.png")
            });
            ct_con.mouseleave(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/ct_con.png")
            });
            var system = $(".system");
            system.mouseenter(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/system_blue.png")
            });
            system.mouseleave(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/system.png")
            });
            var our = $(".our");
            our.mouseenter(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/contact_blue.png")
            });
            our.mouseleave(function(){
                $(this).find("img").attr("src","/static/images/main-banner/banner-icon/contact.png")
            });
            window.onresize = function(){
                handleWheel(0,true);
            };
            if(window.addEventListener){
                window.addEventListener("DOMMouseScroll",wheel,false);
            }
            window.onmousewheel = wheel;
            function wheel(ev){
                var delta = 0;
                if(!ev){
                    ev = window.event;
                }
                if(ev.wheelDelta){
                    delta = ev.wheelDelta / 120;
                    if(window.opera){
                        delta = -delta;
                    }
                }else if(ev.detail){
                    delta = -ev.detail / 3;
                }
                if(delta){
                    handleWheel(delta,false);
                }
            }
            function handleWheel(delta,reset){
                var show = $(".computer .show-content");
                if(reset){
                    show.css("top","0px");
                }else{
                    var scroll = 50;
                    var top = parseInt(show.css("top"));
                    var big = parseInt($(".computer .main-content").css("height"));
                    var small = parseInt(show.css("height"));
                    if(big >= small){
                        return;
                    }
                    if(delta < 0){//向下滚动
                        top -= scroll;
                        show.css("top",top+"px");
                        if(top <= (big - small)){
                            show.css("top",(big - small)+"px");
                        }
                    }else{//向上滚动
                        top += scroll;
                        show.css("top",top+"px");
                        if(top >= 0){
                            show.css("top","0px");
                        }
                    }
                }
            }
        }
    }
    browserRedirect();
    function init(){
        var adId = $(".adId").html();
        var adName = $(".adName").html();
        $(".top-banner .slide .text").html(adName);
    }
    init();
    $(".left-banner .sleep").click(function(){
        $.alert("该功能尚未开放");
    });
});
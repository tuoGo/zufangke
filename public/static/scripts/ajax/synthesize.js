function adlogin() {
    var phone = $("input[name = 'adminphone']").val();
    var pwd   = $("input[name = 'adminpwd']").val();
    if (phone == '' && pwd == ''){
        alert('不输入手机号和密码你还想进？');
        return;
    } else if (phone == ''){
        alert('请输入手机号!');
        return;
    } else if (pwd == ''){
        alert('请输入密码!');
        return;
    }
    checkPhone(phone);
    $.ajax({
        url:"/login/adlogin",
        data:{'phone':phone ,'pwd':pwd},
        type:"post",
        dataType:'json',
        success:function (data) {
            if (data.status == 200){
                window.location.href="/index";
            }
        }
    });
}

function uselogin() {
    var phone = $("input[name='userphone']").val();
    if (phone == ''){
        alert('输入手机号来登录,记得要先让房东开通你的账号.');
        return;
    }
    checkPhone(phone);
    $.ajax({
        url:"/login/uselogin",
        data:{'phone':phone},
        type:"post",
        dataType:'json',
        success:function (data) {
            if (data.status == 200){
                window.location.href="/index";
            }
        }
    });
}

function checkPhone(phone){
    var phone = phone;
    if(!(/^1(3|4|5|7|8)\d{9}$/.test(phone))){
        alert("手机号码有误，请重填");
        return false;
    }
}


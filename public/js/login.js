$(function() {
    $(".btn").click(sub);
    $("input[name='captcha']").keyup(function(e) {
        if (e.which == 13) {
            sub();
        }
    })
})
window.onload = function() {
    document.onkeydown = function(e) {
        var ev = document.all ? window.event : e;
        if (ev.keyCode == 13) {
            sub();
        }
    }
}
var submiting = false;

function sub() {
    if (submiting) {
        return;
    }
    var username = $("input[name='username']").val().replace(/\s/g, '');
    var preg = /^[\w|_]{4,16}$/;
    if (!preg.test(username)) {
        $.warn("请输入正确的登录名");
        return;
    }
    var pwd = $("input[name='password']").val().replace(/\s/g, '');
    if (!preg.test(pwd)) {
        $.warn("请输入正确的密码");
        return;
    }
    var captcha = $("input[name='captcha']").val().replace(/\s/g, '');
    var preg_cap = /^[\w]{4}/;
    if (!preg_cap.test(captcha)) {
        $.warn('请填写验证码');
        return;
    }
    var data = $(".login-form").serialize();
    submiting = true;
    $.ajax({
        url: '/login/sub',
        data: data,
        type: 'post',
        error: function(res) {
            submiting = false;
            $.warn("服务器忙，请重试");
        },
        success: function(res) {
            if (res.result == 'SUCCESS') {
                $.suc(res.msg, function() {
                    window.location = res.url;
                });
            } else {
                submiting = false;
                $.warn(res.msg);
            }
        }
    })
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include APPPATH . "views/public/header.php";?>
<style>
    #login-container {
        min-height: 700px;
        padding-top: 250px;
        background-color: #fff;
    }
    .main-footer.fixed {
        position: fixed;
        width: 100%;
        bottom: 0;
    }
    .title {
        font-size: 30px;
    }
    #login-form {
        width: 320px;
        margin: 34px auto 0;
    }
    #login-form .panel {
        border-top: 0;
    }
    #login-form .form-group {
        display: table;
        width: 100%;
    }
    #login-form .form-group>* {
        display: table-cell;
    }
    #login-form .form-group>*:last-child {
        padding-left: 16px;
    }
    button#login,
    button#login:hover,
    button#login:active,
    button#login:focus {
        padding: 5px 33px;
        background-color: #ff5733;
        border-color: #ff5733;
        color: #fff;
    }
    .bottom-container {
        margin-top: 12px;
    }
</style>
<?php include APPPATH . "views/public/main_header.php";?>
<div id="login-container">
    <div class="box-body no-padding">
        <div class="text-center title">欢迎使用最公会&nbsp;•&nbsp;运营支撑管理平台</div>
        <form class="form-horizontal" id="login-form" action="/login" method="post">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">帐号</label>
                        <div class="">
                            <input type="text" id="username" name="username" class="form-control" placeholder="帐号" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">密码</label>
                        <div class="">
                            <input type="password" id="password" name="password" class="form-control" placeholder="密码" value=""/>
                        </div>
                    </div>
                    <div class="hidden">
                    </div>
                </div>
            </div>

            <div class="row bottom-container">
                <div class="text-center">
                    <button type="submit" id="login" class="btn btn-primary btn-flat">登录</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include APPPATH . "views/public/main_footer.php";?>
<?php include APPPATH . "views/public/footer.php";?>
<script>
    $(document).ready(function () {
        if ($(window).height() == document.body.scrollHeight) {
            $('.main-footer').addClass('fixed');
        }

        $('#username').focus();
    });

    var loginForm = $("#login-form");
    var valid = loginForm.validate({
        rules: {
            username: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            username: {
                required: "请输入用户名",
                minlength: "用户名长度不能少于2个字符"
            },
            password: {
                required: "请输入密码",
                minlength: "密码长度不能少于6个字符"
            }
        }
    });

    loginForm.find('#login').on('click', function (e) {
        var form, ajaxForm = $('#ajax-form');

        if (valid.checkForm()) {
            e.preventDefault();

            try {
                modifyAjaxForm(loginForm);
                setFormValue(ajaxForm, {
                    'username': getFormItemValue(loginForm, 'username'),
                    'password': md5(getFormItemValue(loginForm, 'password'))
                });

                ajaxSubmitForm(ajaxForm, function (data) {
                    if (data && data.code == 0) {
                        if (getParameterByName('redirect')) {
                            window.location.href = decodeURIComponent(getParameterByName('redirect'));
                        } else {
                            window.location.href = data.next_url;
                        }
                    } else if (data && data.code) {
                        showAlert(data.msg);
                    }
                });
            } catch (e) {

            }

            return false;
        }
    });
</script>

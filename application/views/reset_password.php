<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include APPPATH . "views/public/header.php";?>
<style>
    #reset-container {
        min-height: 700px;
        padding-top: 120px;
        background-color: #fff;
    }
    .title {
        font-size: 30px;
    }
    #reset-form {
        width: 320px;
        margin: 24px auto 0;
    }
    #reset-form .panel {
        border-top: 0;
    }
    #reset-form .form-group {
        display: table;
        width: 100%;
    }
    #reset-form .form-group>* {
        display: table-cell;
    }
    #reset-form .form-group>*:last-child {
        padding-left: 16px;
    }
    button#reset,
    button#reset:hover,
    button#reset:active,
    button#reset:focus {
        padding: 6px 35px;
        background-color: #ff5733;
        border-color: #ff5733;
        color: #fff;
    }
</style>
<?php include APPPATH . "views/public/main_header.php";?>
<div id="reset-container">
    <div class="box-body no-padding">
        <form class="form-horizontal" id="reset-form" action="/login/reset_password" method="post">
            <div class="panel panel-default">
                <div class="panel-body">
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

            <div class="row margin-top-24">
                <div class="text-center">
                    <button type="submit" id="reset" class="btn btn-primary btn-flat">保存</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php include APPPATH . "views/public/main_footer.php";?>
<?php include APPPATH . "views/public/footer.php";?>
<script>
    var resetForm = $("#reset-form");
    var valid = resetForm.validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            password: {
                required: "请输入密码",
                minlength: "密码长度不能少于6个字符"
            }
        }
    });

    resetForm.find('#reset').on('click', function (e) {
        var form, ajaxForm = $('#ajax-form');

        if (valid.checkForm()) {
            e.preventDefault();

            try {
                modifyAjaxForm(resetForm);
                setFormValue(ajaxForm, {
                    'password': md5(getFormItemValue(resetForm, 'password'))
                });

                ajaxSubmitForm(ajaxForm, function (data) {
                    if (data && data.code == 0) {
                        window.location.href = '/';
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

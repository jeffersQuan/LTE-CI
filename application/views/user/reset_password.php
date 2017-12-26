<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include APPPATH . "views/public/header.php";?>
<style>
</style>
<?php include APPPATH . "views/public/main_header.php";?>
<?php include APPPATH . "views/public/sidebar_menu.php";?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box zgh-box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $name; ?></h3>
                    </div>
                    <?php
                    $roles = get_cache(ROLES_MODEL_CACHE);
                    ?>
                    <div class="box zgh-box back-fff min-height-700">
                        <form class="form-horizontal" id="update-form" action="update" method="post">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label">密码</label>
                                        <div class="">
                                            <input type="password" id="password" name="password" class="form-control" placeholder="请输入密码" value=""/>
                                        </div>
                                    </div>
                                    <div class="hidden">
                                        <input id="user_id" name="user_id" value="<?php echo $data['user_id']; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row margin-top-24">
                                <div class="text-center">
                                    <button type="submit" id="save" class="btn btn-primary btn-flat">保存</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include APPPATH . "views/public/main_footer.php";?>
<?php include APPPATH . "views/public/footer.php";?>
<script>
    $(function () {
        var updateForm = $('#update-form');
        var valid = updateForm.validate({
            rules: {
                password: {
                    required: true
                }
            },
            messages: {
                password: {
                    required: "请输入密码"
                }
            }
        });

        updateForm.find('#save').on('click', function (e) {
            var ajaxForm = $('#ajax-form');

            if (valid.checkForm()) {
                try {
                    e.preventDefault();

                    modifyAjaxForm(updateForm);
                    setFormValue(ajaxForm, {
                        password: md5(updateForm.find('#password').val()),
                        user_id: updateForm.find('#user_id').val()
                    });

                    ajaxSubmitForm(ajaxForm, function (data) {
                        console.log(data);
                        if (data && data.code == 0) {
                            go_back('manage');
                        } else if (data && data.msg) {
                            showAlert(data.msg);
                        } else {
                            showAlert('保存失败!');
                        }
                        hideLoading();
                    });
                } catch (e) {

                }

                return false;
            }
        });
    });
</script>

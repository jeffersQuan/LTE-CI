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
                        <form class="form-horizontal" id="add-form" action="add" method="post">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label">昵称</label>
                                        <div class="">
                                            <input type="text" id="nickname" name="nickname" class="form-control" placeholder="请输入昵称" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">用户名</label>
                                        <div class="">
                                            <input type="text" id="username" name="username" class="form-control" placeholder="请输入用户名" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">密码</label>
                                        <div class="">
                                            <input type="password" id="password" name="password" class="form-control" placeholder="请输入密码" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">角色</label>
                                        <div class="">
                                            <select class="form-control" id="role_id" name="role_id">
                                                <?php foreach ($roles as $index=>$role): ?>
                                                    <option value="<?php echo $role['role_id']; ?>" <?php if($index==0){echo "selected='selected'";} ?>><?php echo $role['name']; ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="hidden">
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
        var addForm = $('#add-form');
        var valid = addForm.validate({
            rules: {
                nickname: {
                    required: true
                },
                username: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                nickname: {
                    required: "请输入用户昵称"
                },
                username: {
                    required: "请输入用户名"
                },
                password: {
                    required: "请输入密码"
                }
            }
        });

        addForm.find('#save').on('click', function (e) {
            var ajaxForm = $('#ajax-form');

            if (valid.checkForm()) {
                try {
                    e.preventDefault();

                    modifyAjaxForm(addForm);
                    setFormValue(ajaxForm, {
                        username: addForm.find('#username').val(),
                        password: md5(addForm.find('#password').val()),
                        nickname: addForm.find('#nickname').val(),
                        role_id: addForm.find('#role_id').val()
                    });

                    ajaxSubmitForm(ajaxForm, function (data) {
                        console.log(data);
                        if (data && data.code == 0) {
                            window.location.href = 'manage';
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

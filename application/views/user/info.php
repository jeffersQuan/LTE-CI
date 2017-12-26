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
                                        <label class="control-label">昵称</label>
                                        <div class="">
                                            <input type="text" id="nickname" name="nickname" class="form-control" placeholder="请输入昵称" value="<?php echo $data['nickname']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">角色</label>
                                        <div class="">
                                            <select class="form-control" id="role_id" name="role_id">
                                                <?php foreach ($roles as $index=>$role): ?>
                                                    <option value="<?php echo $role['role_id']; ?>" <?php if($role['role_id']==$data['role_id']){echo "selected='selected'";} ?>><?php echo $role['name']; ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">禁用</label>
                                        <div class="">
                                            <label class=" control-label">
                                                <input type="radio" name="is_locked" value=0 <?php if($data['is_locked'] < 1){echo 'checked="checked"';}?>>
                                                否
                                            </label>
                                            &nbsp;&nbsp;
                                            <label class="control-label">
                                                <input type="radio" name="is_locked" value=1 <?php if($data['is_locked'] > 0){echo 'checked="checked"';}?>>
                                                是
                                            </label>
                                        </div>
                                    </div>
                                    <div class="hidden">
                                        <input name="user_id" value="<?php echo $data['user_id']; ?>" />
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
                nickname: {
                    required: true
                }
            },
            messages: {
                nickname: {
                    required: "请输入用户昵称"
                }
            }
        });

        updateForm.find('#save').on('click', function (e) {
            if (valid.checkForm()) {
                try {
                    e.preventDefault();

                    ajaxSubmitForm(updateForm, function (data) {
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

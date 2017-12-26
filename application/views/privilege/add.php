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
                    <div class="box zgh-box back-fff min-height-700">
                        <form class="form-horizontal" id="add-form" action="add" method="post">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label">名称</label>
                                        <div class="">
                                            <input type="text" id="name" name="name" class="form-control" placeholder="请输入权限名称" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">路由</label>
                                        <div class="">
                                            <input type="text" id="url" name="url" class="form-control" placeholder="请输入路由" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">权限组</label>
                                        <div class="">
                                            <input type="text" id="group_name" name="group_name" class="form-control" placeholder="请输入权限组" value=""/>
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
                name: {
                    required: true
                },
                url: {
                    required: true
                },
                group_name: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "请输入权限名称"
                },
                url: {
                    required: "请输入路由"
                },
                group_name: {
                    required: "请输入权限组"
                }
            }
        });

        addForm.find('#save').on('click', function (e) {
            if (valid.checkForm()) {
                try {
                    e.preventDefault();

                    ajaxSubmitForm(addForm, function (data) {
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

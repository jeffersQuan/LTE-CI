<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include APPPATH . "views/public/header.php";?>
<style>
    table {
        border-left: 1px solid #f0f0f0;
        border-right: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
    }
    #add-form {
        width: 480px;
    }
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
                                            <input type="text" id="name" name="name" class="form-control" placeholder="请输入角色名称" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">描述</label>
                                        <div class="">
                                            <input type="text" id="description" name="description" class="form-control" placeholder="请输入角色描述" maxlength="100" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label vertical-top">权限</label>
                                        <div class="">
                                            <?php
                                            $privileges = get_cache(PRIVILEGES_MODEL_CACHE);
                                            $group_names = array();
                                            $privilege_arr = array();

                                            foreach ($privileges as $privilege) {
                                                if (!in_array($privilege['group_name'], $group_names)) {
                                                    array_push($group_names, $privilege['group_name']);
                                                    $privilege_arr[$privilege['group_name']] = array();
                                                    array_push($privilege_arr[$privilege['group_name']], $privilege);
                                                } else {
                                                    array_push($privilege_arr[$privilege['group_name']], $privilege);
                                                }
                                            }

                                            ?>
                                            <table class="table table-fixed">
                                                <tbody>
                                                <tr>
                                                    <th>权限租</th>
                                                    <th>权限</th>
                                                </tr>
                                                <?php foreach ($group_names as $group_name):?>
                                                    <tr>
                                                        <td><?php echo $group_name?></td>
                                                        <td>
                                                            <div><input type="checkbox" class="privilege_all">&nbsp;&nbsp;全选</div>
                                                            <?php foreach ($privilege_arr[$group_name] as $privilege):?>
                                                                <div><input type="checkbox" class="privilege" value="<?php echo $privilege['privilege_id'];?>"
                                                                    >&nbsp;&nbsp;<?php echo $privilege['name'];?></div>
                                                            <?php endforeach;?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="hidden">
                                        <input name="privileges"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="text-center margin-bottom-24">
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
                description: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "请输入角色名称"
                },
                description: {
                    required: "请输入角色描述"
                }
            }
        });

        $('.privilege_all').on('change', function () {
            var $this = $(this), $tr = $this.parents('tr');
            var checked = this.checked;

            $tr.find('.privilege').each(function () {
                this.checked = checked;
            });
        });

        $('.privilege').on('change', function () {
            var $this = $(this), $tr = $this.parents('tr');
            var checked = this.checked;

            if (checked) {
                if ($tr.find('.privilege:checked').length == $tr.find('.privilege').length) {
                    $tr.find('.privilege_all')[0].checked = true;
                }
            } else {
                if ($tr.find('.privilege_all')[0].checked) {
                    $tr.find('.privilege_all')[0].checked = false;
                }
            }
        });

        addForm.find('#save').on('click', function (e) {
            if (valid.checkForm()) {
                try {
                    e.preventDefault();

                    var privileges = [];

                    $('.privilege:checked').each(function () {
                        privileges.push($(this).val());
                    });

                    setFormItemValue(addForm, 'privileges', JSON.stringify(privileges));

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

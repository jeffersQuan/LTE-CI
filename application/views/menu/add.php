<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include APPPATH . "views/public/header.php";?>
<style>
    .content-wrapper .menu-icon-container {
        margin-right: 16px;
    }
</style>
<?php include APPPATH . "views/public/main_header.php";?>
<?php include APPPATH . "views/public/sidebar_menu.php";?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box zgh-box back-fff min-height-700">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $name; ?></h3>
                    </div>
                    <div class="box-body no-padding">
                        <form class="form-horizontal" id="add-form" action="add" method="post">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label">上级菜单</label>
                                        <div class="">
                                            <select name="pid" class="pid form-control">
                                                <option value=1>作为一级菜单</option>
                                                <?php foreach ($menus_tree as $index=>$menu): ?>
                                                    <?php if ($menu['id'] > 1) : ?>
                                                        <option value="<?php echo $menu['id'] ?>">
                                                            <?php
                                                            for ($i = 1; $i < $menu['level']; $i++) {
                                                                echo '&nbsp;&nbsp;&nbsp;';
                                                                for ($j = 2; $j < $menu['level']; $j++) {
                                                                    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                                    for ($k = 3; $k < $menu['level']; $k++) {
                                                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <?php if ($menu['level'] > 1) {echo '└─';} ?>
                                                            <?php echo $menu['name'] ?>
                                                        </option>
                                                    <?php endif;?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">名称</label>
                                        <div class="">
                                            <input type="text" id="name" name="name" class="form-control" placeholder="请输入菜单名称" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label vertical-top">图标</label>
                                        <div class="">
                                            <div class="file-upload child-inline-block">
                                                <div class="">
                                                    <input class="file-name form-control hidden" id="icon" name="icon" value="" />
                                                    <span class="menu-icon-container">
                                                        <img class="menu-icon file-image" />
                                                    </span>
                                                    <label class="tip"></label>
                                                </div>
                                                <div class="padding-right-0 padding-left-0 upload-container">
                                                    <div class="upload-btn-container">
                                                        <a class="btn btn-default" href="#">
                                                            <span>浏览</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="margin-top-8 info-color">请上传宽高比1:1,宽度最小为20px,最大为40px,格式为png的图片</div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">路由</label>
                                        <div class="">
                                            <input type="text" id="url" name="url" class="form-control" placeholder="请输入菜单路由" value=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">显示菜单</label>
                                        <div class="">
                                            <label class=" control-label">
                                                <input type="radio" name="not_display" value=0 checked="checked">
                                                是
                                            </label>
                                            &nbsp;&nbsp;
                                            <label class="control-label">
                                                <input type="radio" name="not_display" value=1>
                                                否
                                            </label>
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
                pid: {
                    required: true
                },
                name: {
                    required: true
                },
                url: {
                    required: true
                }
            },
            messages: {
                pid: {
                    required: "请选择上级菜单"
                },
                name: {
                    required: "请输入菜单名称"
                },
                url: {
                    required: "请输入菜单路由"
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

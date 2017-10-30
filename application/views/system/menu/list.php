<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php include APPPATH . "views/public/header.php";?>
<?php include APPPATH . "views/public/main_header.php";?>
<?php include APPPATH . "views/public/sidebar_menu.php";?>
<div class="content-wrapper">
    <section class="content-header">
        <?php include APPPATH . "views/public/breadcrumb.php";?>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">菜单管理</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>菜单名称</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($menus_model as $index=>$menu): ?>
                                <?php if ($menu['id'] > 1) : ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td>
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
                                </td>
                                <td></td>
                            </tr>
                                <?php endif;?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include APPPATH . "views/public/main_footer.php";?>
<?php include APPPATH . "views/public/footer.php";?>

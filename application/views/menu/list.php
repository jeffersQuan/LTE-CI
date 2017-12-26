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
                    <div class="box-header no-border-bottom">
                        <h3 class="box-title"><?php echo $name; ?></h3>
                    </div>
                    <div class="box-body no-padding with-table">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>名称</th>
                                <th class="text-center">图标</th>
                                <th>路由</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($menus_tree as $index=>$menu): ?>
                                <?php if ($menu['id'] > 1) : ?>
                            <tr id="<?php echo $menu['id'];?>">
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
                                    <a href="info?id=<?php echo $menu['id'] ?>"><?php echo $menu['name'] ?></a>
                                </td>
                                <td class="text-center">
                                    <span class="menu-icon-container">
                                        <?php if($menu['icon']): ?>
                                            <img class="icon menu-icon" src="<?php echo RES_HOST . $menu['icon']; ?>"/>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td><?php echo $menu['url'] ?></td>
                                <td class="operation">
                                    <button type="button" class="btn btn-flat up">上移</button>
                                    <button type="button" class="btn btn-flat down">下移</button>
                                </td>
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
<script>
    $('.operation button').on('click', function (e) {
        var $this = $(this);
        var $tr = $this.parents('tr');

        showLoading();
        setTimeout(function () {
            $.ajax({
                url: 'update_position',
                type: 'POST',
                cache: false,
                dataType: 'json',
                data: {
                    menu_id: $tr.attr('id'),
                    type: $this.hasClass('up')? 'up' : 'down'
                },
                success: function (data) {
                    if (data && data.code == 0) {
                        window.location.reload();
                    } else if (data && data.msg) {
                        showAlert(data.msg);
                    } else {
                        showAlert('操作失败!');
                    }
                    hideLoading();
                },
                error: function (err) {
                    showAlert('操作失败!');
                    hideLoading();
                }
            });
        }, AJAX_DELAY);
    });
</script>

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
        <form class="row form-horizontal" id="query-form" action="" method="get">
            <div class="col-xs-12">
                <div class="box zgh-box">
                    <div class="box-header">
                        <div class="box-title">查询</div>
                    </div>
                    <div class="box-body child-inline-block">
                        <div class="child-inline-block">
                            <label class="control-label">权限</label>
                            <div class="text-input-container">
                                <input type="text" id="name" name="name" class="form-control" placeholder="权限" value="<?php if ($params['name']) {echo $params['name'];} ?>"/>
                            </div>
                        </div>
                        <div class="child-inline-block">
                            <label class="control-label">权限组</label>
                            <div class="text-input-container">
                                <input type="text" id="group_name" name="group_name" class="form-control" placeholder="权限组" value="<?php if ($params['group_name']) {echo $params['group_name'];} ?>"/>
                            </div>
                        </div>
                        <div class="hidden">
                        </div>
                        <button type="submit" id="query" class="btn btn-flat margin-left-24">查询</button>
                    </div>
                </div>
            </div>
        </form>
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
                                <th>ID</th>
                                <th>名称</th>
                                <th>路由</th>
                                <th>权限组</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($data['list'] as $index=>$privilege): ?>
                            <tr id="<?php echo $privilege['privilege_id'];?>">
                                <td><?php echo $privilege['privilege_id']; ?></td>
                                <td><?php echo $privilege['name'] ?></td>
                                <td><?php echo $privilege['url'] ?></td>
                                <td><?php echo $privilege['group_name'] ?></td>
                                <td class="operation">
                                    <button type="button" class="btn btn-flat edit">编辑</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php $colspan=5; $total_rows = $data['sum']['total'];?>
                            <?php include APPPATH . "views/public/pagination.php";?>
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


    $('button.edit').on('click', function (e) {
        var $this = $(this);
        var $tr = $this.parents('tr');

        window.location.href = 'info?privilege_id=' + $tr.attr('id');
    });
</script>

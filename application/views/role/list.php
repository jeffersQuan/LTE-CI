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
                                <th>ID</th>
                                <th>名称</th>
                                <th>描述</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($data as $index=>$role): ?>
                            <tr id="<?php echo $role['role_id'];?>">
                                <td><?php echo $role['role_id']; ?></td>
                                <td><?php echo $role['name'] ?></td>
                                <td><?php echo $role['description'] ?></td>
                                <td class="operation">
                                    <button type="button" class="btn btn-flat edit">编辑</button>
                                </td>
                            </tr>
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


    $('button.edit').on('click', function (e) {
        var $this = $(this);
        var $tr = $this.parents('tr');

        window.location.href = 'info?role_id=' + $tr.attr('id');
    });
</script>

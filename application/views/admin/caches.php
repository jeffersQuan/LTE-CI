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
                        <h3 class="box-title">缓存文件列表</h3>
                    </div>
                    <div class="box-body no-padding with-table">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>名称</th>
                                <th>操作</th>
                            </tr>
                            <?php foreach ($data as $index=>$file): ?>
                                <td class="name"><?php echo $file['name'] ?></td>
                                <td class="operation">
                                    <button type="button" class="btn btn-flat delete">删除</button>
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
    $('button.delete').on('click', function (e) {
        var $this = $(this);
        var $tr = $this.parents('tr');

        $('button.delete').on('click', function (e) {
            var $this = $(this);
            var $tr = $this.parents('tr');

            showLoading();
            setTimeout(function () {
                $.ajax({
                    url: 'delete_cache',
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: {
                        cache_name: $tr.find('.name').text()
                    },
                    success: function (data) {
                        if (data && data.code == 0) {
                            showAlert('删除成功!');
                            $tr.remove();
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
    });
</script>

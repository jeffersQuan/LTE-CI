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
                            <label class="control-label">用户名</label>
                            <div class="text-input-container">
                                <input type="text" id="username" name="username" class="form-control" placeholder="用户名" value="<?php if ($params['username']) {echo $params['username'];} ?>"/>
                            </div>
                        </div>
                        <div class="child-inline-block">
                            <label class="control-label">昵称</label>
                            <div class="text-input-container">
                                <input type="text" id="nickname" name="nickname" class="form-control" placeholder="昵称" value="<?php if ($params['nickname']) {echo $params['nickname'];} ?>"/>
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
                                <th>昵称</th>
                                <th>用户名</th>
                                <th>角色</th>
                                <th>禁用</th>
                                <th class="datetime">创建人/创建时间</th>
                                <th>操作</th>
                            </tr>
                            <?php
                            $roles = array2map(get_cache(ROLES_MODEL_CACHE), 'role_id');
                            $users = array2map(get_cache(BOSS_USERS_MODEL_CACHE), 'user_id');
                            ?>
                            <?php foreach ($data['list'] as $index=>$user): ?>
                            <tr id="<?php echo $user['user_id'];?>">
                                <td><?php echo $user['user_id']; ?></td>
                                <td><?php echo $user['nickname']; ?></td>
                                <td><?php echo $user['username'] ?></td>
                                <td><?php echo $roles[$user['role_id']]['name'] ?></td>
                                <td><?php if($user['is_locked'] > 0){echo '是';}else{echo '否';} ?></td>
                                <td><?php echo $users[$user['created_by']]['nickname']; ?></br><?php echo get_datetime($user['created_at']) ?></td>
                                <td class="operation">
                                    <button type="button" class="btn btn-flat edit">编辑</button>
                                    <button type="button" class="btn btn-flat reset-password">重置密码</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php $colspan=7; $total_rows = $data['sum']['total'];?>
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

        window.location.href = 'info?user_id=' + $tr.attr('id');
    });

    $('button.reset-password').on('click', function (e) {
        var $this = $(this);
        var $tr = $this.parents('tr');

        window.location.href = 'reset_password?user_id=' + $tr.attr('id');
    });
</script>

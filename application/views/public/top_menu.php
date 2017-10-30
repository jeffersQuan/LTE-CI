<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
    <ul class="nav navbar-nav">
        <?php foreach ($menus as $id => $menu): ?><!-- $menu为一级菜单 -->
        <?php $menu_children_1st = $menu['children'] ?><!-- $menu_children_1st为二级菜单数组 -->
        <li class="<?php if((count($current_menu_tree) > 0) && ($menu['id'] == $current_menu_tree[0]['id'])){echo 'active';};if(count($menu_children_1st)){echo ' dropdown';};?>">
            <?php if(count($menu_children_1st)): ?><!-- 判断是否有二级菜单需要显示 -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu['name']; ?><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <?php foreach ($menu_children_1st as $id_1st => $menu_1st): ?><!-- $menu_1st为二级菜单 -->
                <?php $menu_children_2st = $menu_1st['children'] ?><!-- $menu_children_2st为三级菜单数组 -->
                <li class="<?php if((count($current_menu_tree) > 1) && ($menu['id'] == $current_menu_tree[1]['id'])){echo 'active';};if(count($menu_children_2st)){echo ' dropdown';};?>">
                    <?php if(count($menu_children_2st)): ?><!-- 判断是否有三级菜单需要显示 -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu_1st['name']; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <?php foreach ($menu_children_2st as $id_2st => $menu_2st): ?><!-- $menu_2st为三级菜单 -->
                        <?php $menu_children_3st = $menu_2st['children'] ?><!-- $menu_children_3st为四级菜单数组 -->
                        <li class="<?php if((count($current_menu_tree) > 2) && ($menu['id'] == $current_menu_tree[2]['id'])){echo 'active';};if(count($menu_children_3st)){echo ' dropdown';};?>">
                            <?php if(count($menu_children_3st)): ?><!-- 判断是否有四级菜单需要显示 -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $menu_2st['name']; ?><span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <?php foreach ($menu_children_3st as $id_3st => $menu_3st): ?><!-- $menu_3st为四级菜单,默认最多显示四级菜单,如有需要,自行修改 -->
                                <li class="<?php if((count($current_menu_tree) > 2) && ($menu['id'] == $current_menu_tree[2]['id'])){echo 'active';};?>">
                                    <a href="<?php echo $menu_3st['url']; ?>"><?php echo $menu_3st['name']; ?></a>
                                </li>
                                <?php endforeach;?>
                            </ul>
                            <?php else: ?>
                                <a href="<?php echo $menu_2st['url']; ?>"><?php echo $menu_2st['name']; ?></a>
                            <?php endif;?>
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <?php else: ?>
                        <a href="<?php echo $menu_1st['url']; ?>"><?php echo $menu_1st['name']; ?></a>
                    <?php endif;?>
                </li>
                <?php endforeach;?>
            </ul>
            <?php else: ?>
                <a href="<?php echo $menu['url']; ?>"><?php echo $menu['name']; ?></a>
            <?php endif;?>
        </li>
        <?php endforeach;?>
    </ul>
</div>
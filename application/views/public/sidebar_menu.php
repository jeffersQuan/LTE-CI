<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <?php foreach ($menus as $id => $menu): ?><!-- $menu为一级菜单 -->
                <li class="treeview <?php if((count($current_menu_tree) > 0) && ($menu['id'] == $current_menu_tree[0]['id'])){echo 'menu-open';}; ?>">
                    <a href="#">
                        <i class="fa fa-share"></i> <span><?php echo $menu['menu_name']; ?></span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <?php $menu_children_1st = $menu['children'] ?><!-- $menu_children_1st为二级菜单数组 -->
                    <?php if(count($menu_children_1st)): ?><!-- 判断是否有二级菜单需要显示 -->
                    <ul class="treeview-menu" style="<?php if($menu['id'] == $current_menu_tree[0]['id']){echo 'display:block;';}; ?>">
                        <?php foreach ($menu_children_1st as $id_1st => $menu_1st): ?><!-- $menu_1st为二级菜单,$id_1st为对应二级菜单位置 -->
                            <?php $menu_children_2st = $menu_1st['children'] ?><!-- $menu_children_2st为三级菜单数组 -->
                            <li class="<?php if(count($menu_children_2st)){echo 'treeview';if((count($current_menu_tree) > 1) && ($menu_1st['id'] == $current_menu_tree[1]['id'])){echo ' menu-open';};}; ?>"><!-- 判断该二级菜单下是否有子菜单,有子菜单则需要显示右侧菜单展开与关闭图标 -->
                                <a href="<?php if(count($menu_children_2st)){echo '#';}else {echo $menu_1st['url'];} ?>"><i class="fa fa-circle-o"></i><?php echo $menu_1st['menu_name']; ?>
                                    <?php if(count($menu_children_2st)): ?>
                                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                    <?php endif; ?>
                                </a>
                                <?php if(count($menu_children_2st)): ?><!-- 判断该二级菜单下是否有子菜单,有子菜单则显示子菜单 -->
                                    <ul class="treeview-menu" style="<?php if((count($current_menu_tree) > 1) && ($menu_1st['id'] == $current_menu_tree[1]['id'])){echo 'display:block;';}; ?>">
                                        <?php foreach ($menu_children_2st as $id_2st => $menu_2st): ?><!-- $menu_2st为三级菜单,$id_2st为对应三级菜单位置 -->
                                            <?php $menu_children_3st = $menu_2st['children'] ?><!-- $menu_children_3st为四级菜单数组 -->
                                            <li class="<?php if(count($menu_children_3st)){echo 'treeview';if((count($current_menu_tree) > 2) && ($menu_2st['id'] == $current_menu_tree[2]['id'])){echo ' menu-open';};}; ?>"><!-- 判断该三级菜单下是否有子菜单,有子菜单则需要显示右侧菜单展开与关闭图标 -->
                                                <a href="<?php if(count($menu_children_3st)){echo '#';}else {echo $menu_2st['url'];} ?>"><i class="fa fa-circle-o"></i> <?php echo $menu_2st['menu_name']; ?>
                                                    <?php if(count($menu_children_3st)): ?>
                                                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                                    <?php endif; ?>
                                                </a>
                                                <?php if(count($menu_children_3st)): ?><!-- 判断该三级菜单下是否有子菜单,有子菜单则显示子菜单 -->
                                                    <ul class="treeview-menu"><!-- 默认最多只有四级菜单,如需添加更多级菜单,请修改下面代码 -->
                                                        <?php foreach ($menu_children_3st as $id_3st => $menu_3st): ?>
                                                            <li>
                                                                <a href="<?php echo $menu_3st['url']; ?>"><i class="fa fa-circle-o"></i> <?php echo $menu_3st['menu_name']; ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</aside>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if(0): ?>
<ol class="breadcrumb">
    <?php foreach ($current_menu_tree as $index=>$menu): ?>
        <?php if ($index < count($current_menu_tree) - 1): ?>
            <li><a href="<?php echo $menu['url'] ?>"><?php echo $menu['name'] ?></a></li>
        <?php else: ?>
            <li class="active"><?php echo $menu['name'] ?></li>
        <?php endif;?>
    <?php endforeach;?>
</ol>
<?php endif;?>
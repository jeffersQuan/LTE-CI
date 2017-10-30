<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
$current_menu_tree = array();
$menu_pid = $current_menu['pid'];
array_unshift($current_menu_tree, $current_menu);

while ($menu_pid > 1) {
    foreach ($menus_model as $menu) {
        if ($menu['id'] == $menu_pid) {
            array_unshift($current_menu_tree, $menu);
            $menu_pid = $menu['pid'];
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <link rel="icon" href="/assets/images/favicon.ico">
    <title><?php if($title){echo $title;}else{echo 'LTE-CI';}; ?></title>
    <link rel="stylesheet" href="/assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/libs/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/libs/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/css/alt.min.css">
    <link rel="stylesheet" href="/assets/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <script src="/assets/libs/jquery/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/common.js"></script>
    <?php if($has_form):?>
        <script src="/assets/libs/jquery-validate/jquery.validate.min.js"></script>
    <?php endif;?>
</head>
<body class="wysihtml5-supported skin-blue-light sidebar-mini <?php echo $body_class; ?>">
<div class="wrapper">
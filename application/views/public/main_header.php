<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<header class="main-header">
    <div class="header-content">
        <a href="#" class="logo">
            <span class="logo-mini"><b>B</b></span>
            <span class="logo-lg"><img class="logo-icon" src="/assets/images/logo.png"/><span>LTE-CI</span></span>
        </a>
        <a href="#" class="sidebar-toggle lg-hide" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <nav class="navbar navbar-static-top child-inline-block text-right sm-hide">
            <?php if(current_user_id()):?>
            <div class="user-nickname"><?php echo $this->session->userdata('nickname')?></div>
            <a href="/login/reset_password">修改密码</a>
            <a href="/login/logout">退出</a>
            <?php endif;?>
        </nav>
    </div>
</header>
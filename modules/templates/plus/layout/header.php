<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="CONTENT-LANGUAGE" content="EN-US">
    <meta name="Distribution" content="Global">
    <meta name="Rating" content="General">
    <meta name="generator" content="tdblog">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/publics/images/favicon.ico">
    <title><?php echo $meta['title']; ?></title>
    <meta name="description" content="<?php echo $meta['description']; ?>">
    <meta name="keywords" content="<?php echo $meta['keyword']; ?>">
    <meta name="copyright" content="Copyright (c) TDBlog">
    <meta name="revisit-after" content="1 days">
    <meta content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/publics/css/main.css" media="all,handheld">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/publics/css/style.css" media="all,handheld">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/modules/templates/plus/publics/css/style.css" media="all,handheld">
    <script type="text/javascript" src="<?php echo base_url(); ?>/publics/javascript/jquery.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
         $(".alert-close").click(function() {
         $(this).closest(".alert").fadeOut();
         });
        });
    </script>
</head>
<body>
    <div id="header">
        <div class="logo">
            <a href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url(); ?>/publics/images/logo.png" alt="loho">
            </a>

        </div> 
        <div class="menu1">
            <a href="<?php echo base_url(); ?>" title="trang chủ"><img src="<?php echo base_url(); ?>/publics/images/home.png" alt="home"> <b>Home</b></a>   |    
            <a href="<?php echo base_url(); ?>/chat" title="chat box"><b>Chat</b></a> 
            <form action="<?php echo base_url().'/search' ?>" method="post" class="frm_search">
                <span>
                    <input type="text" name="keyword"
                    value="Nhập từ khóa tìm kiếm..."
                    onfocus="if(this.value=='Nhập từ khóa tìm kiếm...')this.value='';"><input type="submit"
                    name="search" value="Tìm Kiếm">
                </span>
                
            </form>
        </div>
        
        <div class="menu2">
        <?php
            if(isLogin()){
                $menu   = 'Chào <a href="'.base_url().'/user/info/'.$_SESSION['name'].'">'. $_SESSION['full_name'].'</a> ! | <a href="'.base_url().'/admin" title="admin panel"><b>Admin Panel</b></a> | <a href="'.base_url().'/user/logout"><b>Đăng Xuất</b></a>';
            }else{
                $menu   = 'Chào Khách ! | <a href="'.base_url().'/user/login" title="đăng nhập"><b>Đăng Nhập</b></a>';
            }
            echo $menu;
        ?>
        </div>	
    </div>
    
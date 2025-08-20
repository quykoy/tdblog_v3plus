<?php
    include __ROOT . '/modules/templates/'.$configs['more']['template_pc'].'/function.php'; 
    $menu = '<li class="active"><a href="'.base_url().'" title="tdblog, trang chủ tdblog"><b>Home</b></a></li>';
    if(isLogin()){
        $menu   .= '<li><a href="'.base_url().'/admin" title="admin panel"><b>Admin Panel</b></a> </li>
                    <li><a href="'.base_url().'/chat" title="phòng chát tdblog"><b>Chat</b></a></li>
                    <li><a href="'.base_url().'/search" title="tìm kiếm"><b>Tìm Kiếm</b></a></li>
                    <li> <a href="'.base_url().'/user/logout"><b>Đăng Xuất</b></a></li>';
    }else{
        $menu   .= '<li><a href="'.base_url().'/chat" title="phòng chát tdblog"><b>Chat</b></a></li>
                    <li><a href="'.base_url().'/search" title="tìm kiếm"><b>Tìm Kiếm</b></a></li>
                    <li><a href="'.base_url().'/user/login" title="đăng nhập"><b>Đăng Nhập</b></a></li>';
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="CONTENT-LANGUAGE" content="EN-US" />
    <meta name="Distribution" content="Global" />
    <meta name="Rating" content="General" />
    <meta name="generator" content="tdblog" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/publics/images/favicon.ico" />
    <title><?php echo $meta['title']; ?></title>
    <meta name="description" content="<?php echo $meta['description']; ?>" />
    <meta name="keywords" content="<?php echo $meta['keyword']; ?>" />
    <meta name="copyright" content="Copyright (c) TDBlog" />
    <meta name="revisit-after" content="1 days" />
    <meta content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'/modules/templates/'.$configs['more']['template_pc']; ?>/publics/css/main.css" media="all,handheld" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'/modules/templates/'.$configs['more']['template_pc']; ?>/publics/css/style.css" media="all,handheld" />

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
    <div style="width: 100%; position: fixed; top: 0px;height: 54px;" id="header">
        <div class="container">
            <div id="logo"><a href="<?php echo base_url() ?>" title="tdblog"><img alt="tdblog" src="<?php echo base_url() ?>/publics/images/logo.png"></a>
                <h1><span>Blog Tiến Định</span></h1>
            </div>
            <div class="topview">   
                <ul id="menu">
                    <?php echo $menu; ?>
                </ul>
            </div>      
        </div>
    </div>
<div class="body-wrapper container">
    <div class="sidebar">
        <div class="topview">
            <div class="title_menu">Bài Viết Hot</div>
            <div style="background:#fff">
                <?php getBlogHot(); ?>
            </div>

            <div class="title_menu">Xem Nhiều</div>
            <div style="background:#fff">
                <?php getBlogByView(5); ?>
            </div>
        </div>
        <div style="background:#fff"> 
            <?php getCategories(); ?> 
        </div>
    </div>
<div class="main">

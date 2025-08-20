<?php $data_configs = parse_ini_file(__SYSTEMS_PATH . '/ini/main-config.ini', true); ?>
<div class="title_menu">Cài Đặt Blog</div>
<div class="wraper">
    <form action="<?php echo base_url(); ?>/admin/blog" method="post" name="main-form">
    <div class="table">
        <span class="row1">Số Bài Viết 1 Trang</span>
        <label class="row2">
            <input type="text" name="limit_blog" value="<?php echo $data_configs['blog']['limit_blog']; ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Số Bài Viết Hot</span>
        <label class="row2">
            <input type="text" name="limit_blog_hot" value="<?php echo $data_configs['blog']['limit_blog_hot']; ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Kiểu Hiển thị Chính</span>
        <label class="row2">
            <select name="type_view_blog">
                <option value="1"<?php if($data_configs['blog']['type_view_blog'] == 1) echo ' selected="selected"'?>>Kiểu Danh sách</option>
                <option value="2"<?php if($data_configs['blog']['type_view_blog'] == 2) echo ' selected="selected"'?>>Kiểu Wap Game</option>
                <option value="4"<?php if($data_configs['blog']['type_view_blog'] == 3) echo ' selected="selected"'?>>Kiểu Wap Truyện</option>
                <option value="4"<?php if($data_configs['blog']['type_view_blog'] == 4) echo ' selected="selected"'?>>Kiểu Smartphone</option>
            </select>
        </label>
    </div>
    <div class="table">
        <span class="row1">Kiểu Hiển thị Blog Hot</span>
        <label class="row2">
            <select name="type_view_blog_hot">
                <option value="1"<?php if($data_configs['blog']['type_view_blog_hot'] == 1) echo ' selected="selected"' ?>>Kiểu Danh sách</option>
                <option value="2"<?php if($data_configs['blog']['type_view_blog_hot'] == 2) echo ' selected="selected"' ?>>Kiểu Wap Game</option>
                <option value="3"<?php if($data_configs['blog']['type_view_blog_hot'] == 3) echo ' selected="selected"' ?>>Kiểu Wap Truyện</option>
                <option value="4"<?php if($data_configs['blog']['type_view_blog_hot'] == 4) echo ' selected="selected"' ?>>Kiểu Smartphone</option>
            </select>
        </label>
    </div>
    <div class="table">
        <span class="row1">Số Ký Tự Phân Trang</span>
        <label class="row2">
            <input type="text" name="limit_word" value="<?php echo $data_configs['blog']['limit_word']; ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Hiển Thị Blog Hot </span>
        <span class="row2">
            <input type="radio" name="view_blog_hot" <?php if($data_configs['blog']['view_blog_hot']== true) echo ' checked="checked" '?>value="1"> Bật
            <input type="radio" name="view_blog_hot" <?php if($data_configs['blog']['view_blog_hot']== false) echo ' checked="checked" '?>value="0" style="margin-left: 20px;"> Tắt
        </span>
    </div>
    <div class="table">
        <span class="row1">Kích thước resize thumb</span>
        <span class="row2">
            <input type="text" name="thumb_width" value="<?php echo $data_configs['blog']['thumb_width'] ?>" style="width:50px"> X 
            <input type="text" name="thumb_height" value="<?php echo $data_configs['blog']['thumb_height'] ?>" style="width:50px">
        </span>
    </div>
    <div class="table">
        <span class="row1"> </span>
        <span class="row2"><input type="submit" name="save" value="Lưu cấu hình"></span>
    </div>
    </form>
</div>
<?php $data_configs = parse_ini_file(__SYSTEMS_PATH . '/ini/main-config.ini', true); ?>
<div class="title_menu">Cài Đặt Chung</div>
<div class="wraper">
	<form action="<?php echo base_url(); ?>/admin/general" method="post" name="main-form">
    <div class="table">
        <span class="row1">Tiêu Đề Trang</span>
        <label class="row2">
            <input type="text" name="title" value="<?php echo stripslashes($data_configs['meta']['title']); ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Miêu Tả Trang</span>
        <label class="row2">
            <textarea name="description"><?php echo stripslashes($data_configs['meta']['description']); ?></textarea>
        </label>
    </div>
    <div class="table">
        <span class="row1">Từ Khóa Trang</span>
        <label class="row2">
            <textarea name="keyword"><?php echo stripslashes($data_configs['meta']['keyword']); ?></textarea>
        </label>
    </div>
    <div class="table">
        <span class="row1">Theme cho máy java</span>
        <label class="row2">
            <input type="text" name="template_java" value="<?php echo stripslashes($data_configs['more']['template_java']); ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Theme cho smartphone</span>
        <label class="row2">
            <input type="text" name="template_smart" value="<?php echo stripslashes($data_configs['more']['template_smart']); ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Theme cho pc</span>
        <label class="row2">
            <input type="text" name="template_pc" value="<?php echo stripslashes($data_configs['more']['template_pc']); ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Nội Dung Đóng Dấu Ảnh</span>
        <label class="row2">
            <input type="text" name="watermark_text" value="<?php echo $data_configs['more']['watermark_text']; ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Tên Nick Admin <br>(Chống giả mạo trong chat, comment)</span>
        <label class="row2">
            <input type="text" name="admin" value="<?php echo $data_configs['more']['admin']; ?>">
        </label>
    </div>
	<div class="table">
        <span class="row1">Trạng Thái Chat </span>
        <span class="row2">
            <input type="radio" name="chat" <?php if($data_configs['more']['chat']== true) echo ' checked="checked" '?>value="1"> Bật
            <input type="radio" name="chat" <?php if($data_configs['more']['chat']== false) echo ' checked="checked" '?>value="0" style="margin-left: 20px;"> Tắt
        </span>
    </div>
    <div class="table">
        <span class="row1">Comment bài viết</span>
        <span class="row2">
            <input type="radio" name="comment" <?php if($data_configs['more']['comment']== true) echo ' checked="checked" '?>value="1"> Bật
            <input type="radio" name="comment" <?php if($data_configs['more']['comment']== false) echo ' checked="checked" '?>value="0" style="margin-left: 20px;"> Tắt
        </span>
    </div>
    <div class="table">
        <span class="row1">Comment facebook</span>
        <span class="row2">
            <input type="radio" name="comment_facebook" <?php if($data_configs['more']['comment_facebook']== true) echo ' checked="checked" '?>value="1"> Bật
            <input type="radio" name="comment_facebook" <?php if($data_configs['more']['comment_facebook']== false) echo ' checked="checked" '?>value="0" style="margin-left: 20px;"> Tắt
        </span>
    </div>
    <div class="table">
        <span class="row1">Đăng kí</span>
        <span class="row2">
            <input type="radio" name="register" <?php if($data_configs['more']['register']== true) echo ' checked="checked" '?>value="1"> Bật
            <input type="radio" name="register" <?php if($data_configs['more']['register']== false) echo ' checked="checked" '?>value="0" style="margin-left: 20px;"> Tắt
        </span>
    </div>
    <div class="table">
        <span class="row1">Tự lưu ảnh vào host</span>
        <span class="row2">
            <input type="radio" name="import_image" <?php if($data_configs['more']['import_image']== true) echo ' checked="checked" '?>value="1"> Bật
            <input type="radio" name="import_image" <?php if($data_configs['more']['import_image']== false) echo ' checked="checked" '?>value="0" style="margin-left: 20px;"> Tắt
        </span>
    </div>
    <div class="table">
        <span class="row1">Đóng dấu ảnh</span>
        <span class="row2">
            <input type="radio" name="watermark" <?php if($data_configs['more']['watermark']== true) echo ' checked="checked" '?>value="1"> Bật
            <input type="radio" name="watermark" <?php if($data_configs['more']['watermark']== false) echo ' checked="checked" '?>value="0" style="margin-left: 20px;"> Tắt
        </span>
    </div>
    <div class="table">
        <span class="row1">Tình trạng site</span>
        <span class="row2">
            <input type="radio" name="off_site" <?php if($data_configs['more']['off_site']== true) echo ' checked="checked" '?>value="1"> Bật
            <input type="radio" name="off_site" <?php if($data_configs['more']['off_site']== false) echo ' checked="checked" '?>value="0" style="margin-left: 20px;"> Tắt
        </span>
    </div>
    <div class="table">
        <span class="row1"></span>
        <span class="row2">
            <input type="submit" name="save" value="Lưu cấu hình">
        </span>
    </div>
	</form>
</div>
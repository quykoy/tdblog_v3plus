<?php $cache = parse_ini_file(__SYSTEMS_PATH . '/ini/cache-config.ini'); ?>
<div class="title_menu">Quản lý cache</div>
<div class="wraper">
	<form action="<?php echo base_url(); ?>/admin/cache" method="post" name="main-form">
	<div class="table">
        <span class="row1">Thời gian cache(giây) </span>
        <label class="row2"><input type="text" name="time" value="<?php echo $cache['time'] ?>"></label>
    </div>
    <div class="table">
        <span class="row1">site cần cache <br>(không nên thay đổi)</span>
        <label class="row2"><input type="text" name="site" value="<?php echo str_replace('|', ',',  $cache['site']) ?>"></label>
    </div>
    <div class="table">
        <span class="row1">Trạng thái cache </span>
        <label class="row2">
            <input type="radio" name="status" <?php if($cache['status']== true) echo ' checked="checked" '?>value="1"> Bật
            <input type="radio" name="status" <?php if($cache['status']== false) echo ' checked="checked" '?>value="0" style="margin-left: 20px;"> Tắt
        </label>
    </div>
    <div class="table">
        <span class="row1">Xóa file cache cũ</span>
        <label class="row2">
            <input type="radio" name="delete" value="1"> Xóa
            <input type="radio" name="delete" checked="checked" value="0" style="margin-left: 20px;"> Không
        </label>
    </div>
    <div class="table">
        <span class="row1"></span>
        <label class="row2"><input type="submit" name="addFile" value="Lưu cấu hình"></label>
    </div>
	</form>
</div>
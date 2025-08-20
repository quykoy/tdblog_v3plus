<?php $data_configs = parse_ini_file(__SYSTEMS_PATH . '/ini/java.ini', true); ?>
<div class="title_menu">Cấu Hình Java</div>
<div class="wraper">
    <form action="" method="post" name="main-form">
    <div class="table">
        <span class="row1">Vendor</span>
        <label class="row2">
            <input type="text" name="Vendor" value="<?php echo $data_configs['Vendor']; ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Description</span>
        <label class="row2">
            <input type="text" name="Description" value="<?php echo $data_configs['Description']; ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Info-URL</span>
        <label class="row2">
            <input type="text" name="Info-URL" value="<?php echo $data_configs['Info-URL']; ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1">Delete-Confirm</span>
        <label class="row2">
            <input type="text" name="Delete-Confirm" value="<?php echo $data_configs['Delete-Confirm']; ?>">
        </label>
    </div>
    <div class="table">
        <span class="row1"> </span>
        <span class="row2"><input type="submit" name="save" value="Lưu cấu hình"></span>
    </div>
    </form>
</div>
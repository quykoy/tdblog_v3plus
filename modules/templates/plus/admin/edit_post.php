<div class="title_menu">Chỉnh Sửa Bài Viết</div>
<div class="wraper">
    <form action="" enctype="multipart/form-data" method="post" name="main-form">
    <div class="table">
        <span class="row1">Tiêu Đề </span>
        <span class="row2"><input type="text" name="name" value="<?php echo stripslashes($data["name"]['value']); ?>"></span>
    </div>
    <div class="table">
        <span class="row1">Url Bài Viết </span>
        <span class="row2"><input type="text" name="alias" value="<?php echo $data["alias"]['value']; ?>"></span>
    </div>
    <div class="table">
        <span class="row1">Chuyên Mục </span>
        <span class="row2">
        <select name="category">
        <?php
        $selected = '';
        foreach($data['listCategory'] as $category){
            if($category['parent'] == 0){
                echo '<option value="false">----------------</option>';
                if($category['id'] == $data["id_category"]['value']){
                    $selected = 'selected="selected"';
                }
                echo '<option value="'.$category['id'].'" '.$selected.'><span class="main-cate"> +  '.$category['name'].'</span></option>';
                $selected = '';
                foreach ($data['listCategory'] as $scategory) {
                    if($category['id'] == $scategory["parent"]){
                        if($scategory['id'] == $data["id_category"]['value']){
                            $selected = 'selected="selected"';
                        }
                        echo '<option value="'.$scategory['id'].'" '.$selected.'><span class="sub-cate"> -    '.$scategory['name'].'</span></option>';
                    }
                }
            }
        }
        ?>
        </select></span>
    </div>
    <div class="table">
        <span class="row1">Nội Dung </span>
        <span class="row2"><textarea name="content" style="height:110px;"><?php echo stripcslashes($data["content"]['value']); ?></textarea></span>
    </div>
    <div class="table">
        <span class="row1">Miêu Tả </span>
        <span class="row2"><textarea name="description"><?php echo stripslashes($data["description"]['value']); ?></textarea></span>
    </div>
    <div class="table">
        <span class="row1">Từ Khóa </span>
        <span class="row2"><textarea name="keyword"><?php echo stripslashes($data["keyword"]['value']); ?></textarea></span>
    </div>
    <div class="table">
        <span class="row1">ID bài viết chủ </span>
        <span class="row2">
            <input type="text" name="id_parent" value="<?php echo $data['id_parent']['value'] ?>">
        </span>
    </div>
    <div class="table">
        <span class="row1">Tags Tags (tag cách nhau bằng dâu ,)</span>
        <span class="row2"><input type="text" name="tags" value="<?php echo $data["tags"]['value']; ?>"></span>
    </div>
    <div class="table">
        <span class="row1">Hỗ trợ </span>
        <span class="row2">
            <?php $checked = ($data["java"]['value'] == 1) ? 'checked="checked"' : ''; ?>
            <input type="checkbox" name="java" <?php echo $checked ?>>java <br>
            <?php $checked = ($data["android"]['value'] == 1) ? 'checked="checked"' : ''; ?>
            <input type="checkbox" name="android"<?php echo $checked ?>>android<br>
            <?php $checked = ($data["ios"]['value'] == 1) ? 'checked="checked"' : ''; ?>
            <input type="checkbox" name="ios"<?php echo $checked ?>>ios<br>
            <?php $checked = ($data["wdp"]['value'] == 1) ? 'checked="checked"' : ''; ?>
            <input type="checkbox" name="wdp"<?php echo $checked ?>>windown<br>
        </span>
    </div>
    <div class="table">
        <span class="row1">Hiển thị ra trang chủ </span>
        <span class="row2">
            <?php $checked = ($data["index"]['value'] == 1) ? 'checked="checked"' : ''; ?>
            <input type="checkbox" name="index"<?php echo $checked ?>>Có <br>
        </span>
    </div>
    <div class="table">
        <span class="row1">Hình Đại Diện </span>
        <span class="row2"><input type="text" name="image" value="<?php echo $data["image"]['value']; ?>"></span>
    </div>
    <div class="table">
        <span class="row1">Tải Lên Đại Diện </span>
        <span class="row2"><input type="file" name="image"></span>
    </div>
   <div class="table">
        <span class="row1"><input type="hidden" name="author" value="<?php echo $_SESSION['id_name'] ?>"></span>
        <span class="row2"><input type="submit" name="save" value="Chỉnh Sửa"></span>
    </div>
    </form>
</div>
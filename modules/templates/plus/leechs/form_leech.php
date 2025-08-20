<div class="title_menu">Leech Bài Từ <?php echo $data['site']['name'] ?></div>
<div class="submenu"><a href="<?php echo $data['site']['url'] ?>">vào đây để link bài viết</a></div>
<div class="wraper">
    <form action="<?php echo base_url() .'/leech/'. $data['urlPost'] ?>" enctype="multipart/form-data" method="post" name="main-form">
    <div class="table">
        <span class="row1">Link bài viết </span>
        <span class="row2"><input type="text" name="url" value=""></span>
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
        </select>
    </div>
   <div class="table">
        <span class="row1"><input type="hidden" name="author" value="<?php echo $_SESSION['id_name'] ?>"></span>
        <span class="row2"><input type="submit" name="save" value="Đăng Bài"></span>
    </div>
    </form>
</div>
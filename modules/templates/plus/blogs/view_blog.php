<?php
include __SYSTEMS_PATH . '/includes/plugin_facebook.php';
if(empty($data['content'])){
    show_alert(3,array('Bài viết không tồn tại'));
}else{
    $arrBreadcrumb = array(
                        array(
                            'link'  => base_url().'/category/'.$data['url_cate'],
                            'title' => $data['category']
                        )
                    );
    echo breadcrumb($arrBreadcrumb);
?>
<ul class="blog_info">
    <li class="thumb_blog">
        <img src="<?php echo $data['image']; ?>" alt="ảnh minh họa" width="60px" height="60px">
    </li>
    <li class="more_info">
        <span class="row tit">
            <a href="<?php echo base_url().'/'.$data['alias']; ?>.html" title="<?php echo $data['title']; ?>">
                <h1><?php echo $data['title']; ?></h1>
            </a>
        </span>
        <span class="row more">
            <img src="<?php echo base_url(); ?>/publics/images/icon-category.png" alt="view" class="icon"  style="vertical-align: text-bottom;">  
            <a href="<?php echo base_url().'/category/'.$data['url_cate']; ?>" title="<?php echo $data['category']; ?>"><?php echo $data['category']; ?></a>
        </span>
        <span class="row more">
            <img src="<?php echo base_url();?>/publics/images/icon_author.png" alt="view" class="icon"  style="vertical-align: text-bottom;">
            <a href="<?php echo base_url().'/user/info/'.$data['url_author']; ?>" title="<?php echo $data['author']; ?>">
                <?php echo $data['author']; ?>
            </a>
        </span>
        <span class="row more">
            <label><?php share($data['alias'].'.html'); ?></label>  
        </span>
        <li style="clear: both;margin-left: 5px;font-size: 11px;color: gray;">
            <label>
            <?php 
            $str_support = '';
                if($value['java'] != 0 || $value['android'] != 0 || $value['ios'] != 0 || $value['wdp'] != 0) {
                    $str_support ='| Hỗ trợ : ';
                    if  ($value['java'] == 1)
                    { $str_support .='<img class="ico_support" src="'.base_url().'/modules/templates/plus/publics/images/java.gif" title="tai game java" alt ="tai game java">'; }
                    if ($value['android'] == 1)
                    { $str_support .='<img class="ico_support" src="'.base_url().'/modules/templates/plus/publics/images/android.gif" title="tai game android" alt ="tai game android">'; }
                    if ($value['ios'] == 1)
                    { $str_support .='<img class="ico_support" src="'.base_url().'/modules/templates/plus/publics/images/ios.png" title="tai game java" alt ="tai game java">'; } 
                    if ($value['wdp'] == 1)
                    { $str_support .='<img class="ico_support" src="'.base_url().'/modules/templates/plus/publics/images/wdp.png" title="tai game windownphone" alt ="tai game win">'; } 
                }

                ?>
                Lượt xem : <?php echo $data['views']; ?> | Ngày đăng: <?php echo convertTimeToString($data['times']).$str_support; ?>
            </label>
        </li>
    </li>
</ul>
<?php 
$id_parent = $data['id_parent'] == 0 ? $data['id'] : $data['id_parent'];
if(isLogin() ==  true){
?>
<div class="panel">
<label>
    <img src="<?php echo base_url(); ?>/publics/images/icon-edit.png">
    <a href="<?php echo base_url(); ?>/admin/post/<?php echo $id_parent; ?>" title="thêm chapter"><span>Add Chapter</span></a>
</label>
<label>
    <img src="<?php echo base_url(); ?>/publics/images/icon-edit.png">
    <a href="<?php echo base_url(); ?>/admin/editpost/<?php echo $data['alias']; ?>" title="Chỉnh sửa bài bài viết"><span>Edit</span></a>
</label>
<label>
    <img src="<?php echo base_url(); ?>/publics/images/icon-delete-post.png">
    <a href="<?php echo base_url(); ?>/admin/deletepost/<?php echo $data['alias']; ?>" title="Xóa bài viết"><span>Delete</span></a>
</label>
<label>
    <img src="<?php echo base_url(); ?>/publics/images/icon-addfile.png">
    <a href="<?php echo base_url(); ?>/admin/addfile/<?php echo $data['alias']; ?>" title="Thêm tệp tin đính kèm"><span>Add File</span></a>
</label>
<label>
<?php if($data['hot'] == 0){ ?>
    <img src="<?php echo base_url(); ?>/publics/images/icon-tick-hot.png">
    <a href="<?php echo base_url(); ?>/admin/tickhot/<?php echo $data['id']; ?>" title="đánh dấu thành chử đề hot"><span>Tick Hot</span></a>
<?php }else{ ?>
    <img src="<?php echo base_url(); ?>/publics/images/icon-untick-hot.png.png">
    <a href="<?php echo base_url(); ?>/admin/untickhot/<?php echo $data['id']; ?>" title="đánh dấu thành chử đề hot"><span>Untick Hot</span></a>
<?php } ?>
</label>
</div>
<?php
}
?>
<div class="content_blog">
   <?php if(!empty($data['files'])): ?>
        <div class="nav_menu multi-download">
            <ul>
                <li class="green-title center">Tải Về Máy</li> 
                <?php foreach ($data['files'] as $file): ?>
                    <li>
                        <p> 
                            <a rel="nofollow" href="<?php echo $file['file_url'] ?>" class="file">
                            <b><?php echo $file['file_name'] ?></b></a> 
                            <?php createJad($file['file_url']) ?>
                            <?php
                                if(isLogin() ==  true){
                                    echo '<span>
                                            <a href="'.base_url().'/admin/deletefile/'.$file['id'].'" title="Chỉnh sửa file">
                                                [X]
                                            </a>
                                            <a href="'.base_url().'/admin/editfile/'.$file['id'].'" title="Chỉnh sửa file">
                                                [E]
                                            </a>
                                        </span>';
                                }
                            ?>
                        </p>
                <?php endforeach; ?>
                </li> 
              
            </ul> 
        </div> 
    <?php endif;?>
    <h2><?php echo $data['content']['content'] ?></h2>
</div>
<?php echo $data['content']['page'] ?>
<?php if (count($data['chapters']) != 0) {
    echo '<div class="chapter"><span>Danh Sách Chapter</span>';
    echo '<ul>';
    foreach ($data['chapters'] as $chapter) {
        if($chapter['id'] == $data['id'])
            echo '<li># <span class="chap_item chap_current">'.$chapter['title'].'</span></li>';
        else
            echo '<li># <span class="chap_item"><a href="'.base_url().'/'.$chapter['alias'].'.html" title="'.$chapter['title'].'">'.$chapter['title'].'</a><span></li>';
    }   
    echo '</ul></div>';
} ?>
<?php echo $data['tags']; ?>
<!--kết thúc show nội dung bài viết-->

<div class="like"><?php likeFacebook($data['alias'].'.html'); ?></div>
<?php } ?>

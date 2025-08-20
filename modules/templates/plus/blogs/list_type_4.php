<div class="title_menu">
    <a href="<?php echo base_url() . '/'.$data['info']['alias'] ?>" title="<?php echo $data['info']['name'] ?>"><?php echo $data['info']['name'] ?>
    </a>
</div>
<?php
$page = '';
if(isset($data['page']))
{
    $page = $data['page'];
    unset($data['page']);
}
if(!empty($data['listblog']))
{
    echo '<ul class="wraper_list">';
    foreach($data['listblog'] as $value)
    {
?>
<?php 
    $sql = "select file_url from files where id_blog = {$value['id']}";
    $query = mysql_query($sql);
    $arr = mysql_fetch_assoc($query);
?>
<li>
    <div class="blog_item">
        <a href="<?php echo base_url().'/'.$value['alias']; ?>.html" class="link" title="<?php echo $value['title']; ?>">
            <img src="<?php echo $value['image']; ?>" class="thumb" alt="ảnh minh họa"> 
            <span class="title"><?php echo $value['title']; ?></span>
        </a>
        <?php echo isset($arr['file_url']) ? '<a href="'.$arr['file_url'].'" class="btn_download" title="tai game '.$value['title'].' miễn phí"><span class=" flaticon-tab3"></span></a> ' : '' ?>
    </div>
</li>
<?php
    }
    echo '</ul> <div class="clear"></div>';
}
else
{
    show_alert(4, array('không có bài viết nào'));
}
echo $page;
?>



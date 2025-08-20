<div class="title_menu">
    <a href="<?php echo base_url() .'/'. $data['info']['alias'] ?>" title="<?php echo $data['info']['name'] ?>"><?php echo $data['info']['name'] ?>
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
    $bbcode = new BBCode;
    
    foreach($data['listblog'] as $value)
    {
?>
<ul class="blog">
    <li class="thumb_blog">
        <img src="<?php echo $value['image']; ?>" alt="ảnh minh họa " width="40px" height="40px">
    </li>
    <li class="info_blog">
        <span class="title_blog">
            <a href="<?php echo base_url().'/'.$value['alias']; ?>.html" title="<?php echo $value['title']; ?>">
                <?php echo $value['title']; ?>
            </a>
        </span>
        <span class="time">
            đăng lúc: <?php echo convertTimeToString($value['times']); ?>
        </span>
        <span class="view_blog">
            lượt xem: <?php echo $value['views']; ?>
        </span>
        <span style="display: block;">
            <?php echo subWords($bbcode->notags($value['content']), 50) . '...' ?>
        </span>
    </li>
</ul>
<?php
    }
}
else
{
    show_alert(4, array('không có bài viết nào'));
}
echo $page;
?>
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
    foreach($data['listblog'] as $value)
    {
?>
<ul class="blog">
    <?php 
        $sql = "select file_url from files where id_blog = {$value['id']}";
        $query = mysql_query($sql);
        $arr = mysql_fetch_assoc($query);
    ?>
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
            <?php echo isset($arr['file_url']) ? '<span class="right link_download"><a href="'.$arr['file_url'].'">Tải Về</a></span>' : '' ?>
            
        </span>
        <span class="view_blog">
            lượt xem: <?php echo $value['views']; ?> 
            <?php 
                if($value['java'] != 0 || $value['android'] != 0 || $value['ios'] != 0 || $value['wdp'] != 0) 
                {
                    echo '| Hỗ trợ : ';
                    if  ($value['java'] == 1)
                    { echo '<img class="ico_support" src="'.base_url().'/modules/templates/plus/publics/images/java.gif" title="tai game java" alt ="tai game java">'; }
                    if ($value['android'] == 1)
                    { echo '<img class="ico_support" src="'.base_url().'/modules/templates/plus/publics/images/android.gif" title="tai game android" alt ="tai game android">'; }
                    if ($value['ios'] == 1)
                    { echo '<img class="ico_support" src="'.base_url().'/modules/templates/plus/publics/images/ios.png" title="tai game java" alt ="tai game java">'; } 
                    if ($value['wdp'] == 1)
                    { echo '<img class="ico_support" src="'.base_url().'/modules/templates/plus/publics/images/wdp.png" title="tai game windownphone" alt ="tai game win">'; } 
                }
            ?>
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
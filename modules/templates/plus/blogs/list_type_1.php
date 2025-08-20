<div class="title_menu">
	<a href="<?php echo base_url() .'/'. $data['info']['alias'] ?>"
		title="<?php echo $data['info']['name'] ?>"><?php echo $data['info']['name']?>
    </a>
</div>
<?php
$page = '';
if (isset ( $data ['page'] )) {
	$page = $data ['page'];
	unset ( $data ['page'] );
}
if (! empty ( $data ['listblog'] )) {
	foreach ( $data ['listblog'] as $value ) {
		?>
<div class="list">
<img src="<?php echo base_url(); ?>/publics/images/item.png" alt="item">
<?php 
	echo isset($value['category']) ? '<span class="category_'.rand(1,8).'">'.$value['category'].'</span>' : '';
?>
	<a href="<?php echo base_url().'/'.$value['alias']; ?>.html"
		title="<?php echo $value['title']; ?>">
        <?php echo $value['title']; ?>
    </a>
</div>
<?php
	}
} else {
	show_alert ( 4, array (
			'không có bài viết nào' 
	) );
}
echo $page;
?>
<div class="title_menu">Danh Sách Chuyên Mục</div>
<?php
foreach ( $data as $key => $category ) {
	?>
<div class="list">
	<img src="<?php echo base_url();?>/publics/images/cat.png"
		alt="ảnh cm" title="ảnh cm"> <a
		href="<?php echo base_url().'/category/'.$category['alias']; ?>"
		title="<?php echo $category['name']; ?>"> <b><?php echo $category['name']; ?></b>
	</a>
</div>
<?php
}
if (empty ( $data )) {
	show_alert ( 4, array (
			'Chuyên mục rỗng' 
	) );
}
?>

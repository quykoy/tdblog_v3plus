<div class="title_menu">Danh Sách Chuyên Mục</div>
<?php
if (empty ( $data )) {
	show_alert ( 4, array (
			'chuyên mục rỗng' 
	) );
}
foreach ( $data as $key => $category ) :
	if ($category ['parent'] == 0) :
		?>
<ul class="list">
	<img src="<?php echo base_url();?>/publics/images/cat.png" alt="ảnh cm">
	<a href="<?php echo base_url().'/category/'.$category['alias']; ?>"
		title="<?php echo $category['name']; ?>"> <b><?php echo $category['name']; ?></b>
	</a>
	<span class="float_right"> <a
		href="<?php echo base_url() . '/admin/category/delete/'.$category['alias'] ?>"
		title="loại bỏ bài viết ra khỏi danh sách hot">[X]</a>
	</span>
	<span class="float_right"> <a
		href="<?php echo base_url() .'/admin/category/edit/'.$category['alias'] ?>"
		title="Chỉnh sửa bài viết">[E]</a>
	</span>
    <?php
		foreach ( $data as $skey => $sub_category ) :
			if ($category ['id'] == $sub_category ['parent']) :
				?>
        <li
		style="margin: 5px 0px 5px 20px; border-left: 2px solid #d9d9d9; padding-left: 5px;">
		<a
		href="<?php echo base_url().'/category/'.$sub_category['alias']; ?>"
		title="<?php echo $sub_category['name']; ?>"><?php echo $sub_category['name']; ?></a>
		<span class="float_right"> <a
			href="<?php echo base_url().'/admin/category/delete/'.$sub_category['alias'] ?>"
			title="loại bỏ bài viết ra khỏi danh sách hot"> [X] </a>
	</span> <span class="float_right"> <a
			href="<?php echo base_url() .'/admin/category/edit/'. $sub_category['alias'] ?>"
			title="Chỉnh sửa bài viết"> [E] </a>
	</span>

	</li>
    
			<?php
        endif;
			// unset($sub_category[$skey]);
		endforeach
		;
		?>
</ul>

	<?php
    endif;
endforeach
;

?>
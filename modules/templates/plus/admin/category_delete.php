<?php
show_alert ( 4, array (
		'Bạn muốn xóa ' . $data ['name'] . ' ???' 
) );
?>
<div class="item">
	<form
		action="<?php echo base_url(); ?>/admin/category/delete/<?php echo $data['alias'] ?>"
		method="post">
		<input type="submit" value="Xác Nhận Xóa" name="delete"
			style="display: inline; margin-left: 41px; margin-right: 10px;"> <input
			type="button" value="Hủy"
			style="display: inline; margin-left: 5px; width: 100px;">
	</form>
</div>
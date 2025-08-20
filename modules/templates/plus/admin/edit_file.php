<div class="title_menu">Edit File</div>
<div class="wraper">
	<form
		action="<?php echo base_url(); ?>/admin/editfile/<?php echo $data['id'];?>"
		enctype="multipart/form-data" method="post" name="main-form">
		<div class="table">
			<span class="row1" style="width: 15%">Tên File </span> <span
				class="row2" style="width: 85%"><input type="text" name="file_name"
				value="<?php echo $data['file_name'] ?>"></span>
		</div>
		<div class="table">
			<span class="row1" style="width: 15%">link </span> <span class="row2"
				style="width: 85%"><input type="text" name="file"
				value="<?php echo $data['file_url'] ?>"></span>
		</div>
		<div class="table">
			<span class="row1" style="width: 15%">Upload </span> <span
				class="row2" style="width: 85%"><input type="file" name="file"></span>
		</div>
		<div class="table">
			<span class="row1" style="width: 15%"><input type="hidden"
				name="id_blog" value="<?php echo $data['id_blog'] ?>"></span> <span
				class="row2" style="width: 85%"><input type="submit" name="editFile"
				value="Chỉnh Sửa"></span>
		</div>
	</form>
</div>
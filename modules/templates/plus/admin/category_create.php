<div class="title_menu">Tạo Chuyên Mục Mới</div>
<div class="wraper">
	<form action="<?php echo base_url(); ?>/admin/category/create"
		method="post" name="main-form">
		<div class="table">
			<span class="row1" style="width: 20%">Tên Chuyên Mục </span> <span
				class="row2"><input type="text" id="title" name="name"
				value="<?php echo stripslashes($data["name"]['value']); ?>"></span>
		</div>
		<div class="table">
			<span class="row1" style="width: 20%">Url Chuyên Mục </span> <span
				class="row2"><input type="text" id="alias" name="alias"
				value="<?php echo $data["alias"]['value']; ?>"></span>

		</div>
		<div class="table">
			<span class="row1" style="width: 20%">Chuyên Mục </span> <span
				class="row2"> <select name="parent">
					<option value="0">Chuyên Mục Gốc</option>
        <?php
								foreach ( $data ['listcategories'] as $category ) {
									if ($category ['parent'] == 0) {
										echo '<option value="' . $category ['id'] . '"><span class="main-cate">' . $category ['name'] . '</span></option>';
									}
								}
								?>
            </select>
			</span>
		</div>
		<div class="table">
			<span class="row1" style="width: 20%">Miêu Tả </span> <span
				class="row2"><textarea name="description"><?php echo stripslashes($data["description"]['value']); ?></textarea></span>
		</div>
		<div class="table">
			<span class="row1" style="width: 20%">Từ Khóa </span> <span
				class="row2"><textarea name="keyword"><?php echo stripslashes($data["keyword"]['value']); ?></textarea></span>
		</div>
		<div class="table">
			<span class="row1" style="width: 20%">Kiểu hiển thị</span>
			<span class="row2">
				<select name="type_view">
					<option value="1">Kiểu Danh sách</option>
					<option value="2">Kiểu Wap Game</option>
					<option value="3">Kiểu Wap Truyện</option>
					<option value="4">Kiểu Smartphone</option>
			</select>
			</span>
		</div>
		<div class="table">
			<span class="row1" style="width: 20%"></span> <span class="row2"><input
				type="submit" name="save" value="Tạo Chuyên Mục"></span>
		</div>
	</form>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>/modules/templates/plus/publics/js/td_auto_alias.js"></script>

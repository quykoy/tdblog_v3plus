<div class="title_menu">Tạo Chuyên Mục Mới</div>
<div class="wraper">
	<form
		action="<?php echo base_url(); ?>/admin/category/edit/<?php echo $data["main_alias"]['value']; ?>"
		method="post" name="main-form">
		<div class="table">
			<span class="row1" style="width: 20%">Tên Chuyên Mục </span> <span
				class="row2"><input type="text" name="name"
				value="<?php echo stripslashes($data["name"]['value']); ?>"></span>
		</div>
		<div class="table">
			<span class="row1" style="width: 20%">Url Chuyên Mục </span> <span
				class="row2"><input type="text" name="alias"
				value="<?php echo $data["alias"]['value']; ?>"></span>

		</div>
		<div class="table">
			<span class="row1" style="width: 20%">Chuyên Mục </span> <span
				class="row2"> <select name="parent">
					<option value="0">Chuyên Mục Gốc</option>
        <?php
								$selected = '';
								if ($data ["parent"] ['value'] != 0) {
									foreach ( $data ['listcategories'] as $category ) {
										if ($category ['parent'] == 0) {
											if ($data ['parent'] ['value'] == $category ['id'])
												$selected = 'selected="selected"';
											echo '<option value="' . $category ['id'] . '" ' . $selected . '><span class="main-cate">' . $category ['name'] . '</span></option>';
											$selected = '';
										}
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
					<option value="1"<?php if($data['type_view']['value'] == 1) echo ' selected="selected"' ?>>Kiểu Danh sách</option>
	                <option value="2"<?php if($data['type_view']['value'] == 2) echo ' selected="selected"' ?>>Kiểu Wap Game</option>
	                <option value="3"<?php if($data['type_view']['value'] == 3) echo ' selected="selected"' ?>>Kiểu Wap Truyện</option>
	                <option value="4"<?php if($data['type_view']['value'] == 4) echo ' selected="selected"' ?>>Kiểu Smartphone</option>
				</select>
			</span>
		</div>
		<div class="table">
			<span class="row1" style="width: 20%"></span> <span class="row2"><input
				type="submit" name="save" value="Tạo Chuyên Mục"></span>
		</div>
	</form>
</div>
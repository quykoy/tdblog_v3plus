<div class="title_menu">Thêm Khối Hiển Thị</div>
<div class="clean"></div>
<div class="wraper">
	<form action="<?php echo base_url(); ?>/admin/block_view/add"
		method="post" name="main-form">
		<div class="table2">
			<label class="row1"><input type="text" value="Tên chuyên Mục"
				disabled="disabled" style="font-weight: bold; color: #0E7096;"></label>
			<label class="row2"><input type="text" value="Kiểu Hiển Thị"
				disabled="disabled" style="font-weight: bold; color: #0E7096;"></label>
			<label class="row3"><input type="text" value="Số Bài Viết"
				disabled="disabled" style="font-weight: bold; color: #0E7096;"></label>
		</div>
		<div class="table2">
			<label class="row1"> <select name="id_category" style="width: 100%;">
		    <?php
						foreach ( $data as $key2 => $value2 ) {
							?>
		                <option value="<?php echo $value2['id'] ?>"><?php echo $value2['name'] ?></option>
		    <?php } ?>
		    		</select>
			</label> <label class="row2"> <select name="type_view"
				style="width: 100%;">
					<option value="1">Kiểu Danh sách</option>
					<option value="2">Kiểu Wap Game</option>
					<option value="3">Kiểu Wap Truyện</option>
					<option value="4">Kiểu Smartphone</option>
			</select>
			</label> <label class="row3"> <input type="text" name="limit"
				value="3" style="width: 100%;">
			</label>
		</div>
		<div class="table2">
			<label class="row1"> <input type="submit" name="add"
				value="Thêm Khối"
				style="width: 105px; margin-top: 27px; margin-left: 37%; margin-bottom: 27px;">
			</label>
		</div>
	</form>
</div>

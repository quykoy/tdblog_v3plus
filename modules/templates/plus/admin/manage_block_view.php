<div class="clean"></div>
<div class="title_menu">Danh Sách Khối Hiển Thị</div>
<div class="clean"></div>
	<div class="wraper">
	    <form action="<?php echo base_url(); ?>/admin/block_view" method="post" name="main-form">
<?php 
if(!empty($data['block_view'])){
	echo '<div class="table2">
		        <label class="row1"><input type="text" value="Tên chuyên Mục"disabled="disabled" style="font-weight: bold;color: #0E7096;"></label>
		        <label class="row2"><input type="text" value="Kiểu Hiển Thị" disabled="disabled" style="font-weight: bold;color: #0E7096;"></label>
		        <label class="row3" style="width: 15%;"><input type="text" value="Số Bài Viết" disabled="disabled" style="font-weight: bold;color: #0E7096;"></label>
		        <label class="row3" style="width: 10%;"><input type="text" value="Edit" disabled="disabled" style="font-weight: bold;color: #0E7096;"></label>
		    </div>';
	foreach ($data['block_view'] as $key1 => $value1) {
?>
	    	<div class="table2">
		        <label class="row1">
		        	<input type="hidden" name="id[]" value="<?php echo  $value1['id'] ?>">
		        	<select name="id_category[]" style="width: 100%;">
		    <?php
		        foreach ($data['list_category'] as $key2 => $value2) {
			?>
		                <option value="<?php echo $value2['id'] ?>"<?php if($value1['id_category'] == $value2['id']) echo ' selected="selected"' ?>><?php echo $value2['name'] ?></option>
		    <?php } ?>
		    		</select>
		    	</label>
		        <label class="row2">
		            <select name="type_view[]" style="width: 100%;">
		                <option value="1"<?php if($value1['type_view'] == 1) echo ' selected="selected"' ?>>Kiểu Danh sách</option>
		                <option value="2"<?php if($value1['type_view'] == 2) echo ' selected="selected"' ?>>Kiểu Wap Game</option>
		                <option value="3"<?php if($value1['type_view'] == 3) echo ' selected="selected"' ?>>Kiểu Wap Truyện</option>
		                <option value="4"<?php if($value1['type_view'] == 4) echo ' selected="selected"' ?>>Kiểu Smartphone</option>
		            </select>
		        </label>
		        <label class="row3" style="width: 15%;">
		        	<input type="text" name="limit[]" value="<?php echo $value1['limit'] ?>"  style="width: 100%;">
		        </label>
		        <label class="row3" style="width: 10%; text-align: center;">
		        	[<a href="<?php echo base_url() ?>/admin/block_view/delete/<?php echo $value1['id'] ?>" title="">X</a>]
		        </label>
		    </div>
<?php
	}
	echo '
			<div class="table2">
		        <label class="row1" style="text-align: center;">
		        	<input type="submit" name="save" value="Lưu Thay Đổi"  style="width: 105px;/* margin-top: 27px; margin-left: 30%; margin-bottom: 27px; */">
		        	<a href="'.base_url().'/admin/block_view/add">
		        		<input type="button" name="save" value="Thêm Khối Hiển Thị"  style="width: 140px;margin-top: 27px;/* margin-left: 37%; */margin-bottom: 27px;">
		        	</a>
		        </label>
		    </div>
		</form>
	</div>';
}else{
	show_alert(2, array('Chưa có Khối Hiển Thị Nào'));
	echo 	'<div class="table2">
		        <label class="row1" style="text-align: center;">
		        	<a href="'.base_url().'/admin/block_view/add">
		        		<input type="button" name="save" value="Thêm Khối Hiển Thị"  style="width: 140px;margin-top: 27px;margin-bottom: 27px;">
		        	</a>
		        </label>
		    </div>
	</div>';
}
?>
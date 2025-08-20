<div class="title_menu">Thêm File Đính Kèm</div>
<div class="wraper">
	<form action="<?php echo base_url(); ?>/admin/addfile/<?php echo $data['alias'];?>" enctype="multipart/form-data" method="post" name="main-form">
	<div class="table">
        <span class="row1" style="width: 15%">Tên File </span>
        <span class="row2" style="width: 85%"><input type="text" name="file_name"></span>
    </div>
	<div class="table">
        <span class="row1" style="width: 15%">link </span>
        <span class="row2" style="width: 85%"><input type="text" name="file" value="http://"></span>
    </div>
    <div class="table">
        <span class="row1" style="width: 15%">Upload </span>
        <span class="row2" style="width: 85%"><input type="file" name="file">
    </div>
    <div class="table">
        <span class="row1" style="width: 15%"><input type="hidden" name="id_blog" value="<?php echo $data['id'] ?>"></span>
        <span class="row2" style="width: 85%"><input type="submit" name="addFile" value="Thêm File"></span>
    </div>
	</form>
</div>

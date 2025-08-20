<div class="title_menu">Thông Tin Thành Viên</div>
<div class="wraper">
    <div class="table">
        <label class="row1" style="width:12%">user: </label>
        <span class="row2"><?php echo $data['name'] ?></span>
    </div>
    <div class="table">
        <label class="row1" style="width:12%">Họ tên: </label>
        <span class="row2"><?php echo $data['full_name'] ?></span>
    </div>
    <div class="table">
        <label class="row1" style="width:12%">Chức vụ: </label>
        <span class="row2">Admin</span>
    </div>
    <div class="table">
        <label class="row1" style="width:12%">Email: </label>
        <span class="row2"><?php echo $data['email'] ?></span>
    </div>
</div>
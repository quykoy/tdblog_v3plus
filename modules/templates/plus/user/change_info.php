<div class="wraper">
    <form action="<?php echo base_url(); ?>/user/change_info" method="post">
        <div class="table">
          <span class="row1" style="width:20%">Họ Và Tên</span> 
          <span class="row2"><input type="text" name="fullName" value="<?php echo $data['full_name'] ?>"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Tên Đăng Nhập</span> 
          <span class="row2"><input type="text" name="username" value="<?php echo $data['name'] ?>"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Mật Khẩu Cũ</span>
          <span class="row2"><input type="password" name="password_old"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Email </span> 
          <span class="row2"><input type="text" name="email" value="<?php echo $data['email'] ?>"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Giới Tính</span>
          <span class="row2">
            <input type="radio" name="sex" <?php echo ($data['sex'] == 0) ? 'checked="checked"' : ''; ?> value="0"> Nữ
            <input type="radio" name="sex" <?php echo ($data['sex'] == 1) ? 'checked="checked"' : ''; ?> value="1" style="margin-left: 4px;"> Nam
          </span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Mật Khẩu Mới</span>
          <span class="row2"><input type="password" name="password_new"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Nhập Lại Mật Khẩu mới</span>
          <span class="row2"><input type="password" name="rePassword_new"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%"></span>
          <span class="row2"><input type="submit" name="change_info" value="Lưu Thay Đổi" style="width: 100px;"></span>
        </div>
    </form>
</div>
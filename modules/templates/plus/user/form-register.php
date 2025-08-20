<div class="wraper">
    <form action="<?php echo base_url(); ?>/user/register" method="post">
        <div class="table">
          <span class="row1" style="width:20%">Họ Và Tên</span> 
          <span class="row2"><input type="text" name="fullName" value=""></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Tên Đăng Nhập</span> 
          <span class="row2"><input type="text" name="username" value=""></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Mật Khẩu</span>
          <span class="row2"><input type="password" name="password"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Nhập Lại Mật Khẩu</span>
          <span class="row2"><input type="password" name="rePassword"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Email </span> 
          <span class="row2"><input type="text" name="email" value=""></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Giới Tính</span>
          <span class="row2">
            <input type="radio" name="sex" checked="checked" value="0"> Nữ
            <input type="radio" name="sex" value="1" style="margin-left: 4px;"> Nam
          </span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%">Mã Xác Nhận</span>
          <span class="row2">
            <img src="<?php echo base_url();?>/systems/includes/captcha.php">
          </span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%"></span>
          <span class="row2"><input type="text" name="captcha" class="captcha" value="Nhập Mã Xác Nhận..." onfocus="if(this.value=='Nhập Mã Xác Nhận...')this.value='';"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:20%"></span>
          <span class="row2"><input type="submit" name="login" value="Đăng Ký" style="width: 100px;"></span>
        </div>
    </form>
</div>
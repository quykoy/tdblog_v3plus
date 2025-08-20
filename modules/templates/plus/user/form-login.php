<div class="wraper">
    <form action="<?php echo base_url(); ?>/user/login" method="post">
        <div class="table">
          <span class="row1" style="width:25%"><img src="<?php echo base_url();?>/publics/images/login_username.png"> Username</span> 
          <span class="row2"><input type="text" name="username"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:25%"><img src="<?php echo base_url();?>/publics/images/login_password.png"> Password</span>
          <span class="row2"><input type="password" name="password"></span>
        </div>
        <div class="table">
          <span class="row1" style="width:25%"></span>
          <span class="row2"><input type="checkbox" name="saveLogin" value="1"> Nhớ đăng nhập</span>
        </div>
        <div class="table">
          <span class="row1" style="width:25%"></span>
          <span class="row2"><input type="submit" name="login" value="Đăng Nhập" style="width: 100px;"></span>
        </div>
    </form>
</div>
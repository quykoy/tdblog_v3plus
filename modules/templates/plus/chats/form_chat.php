<div class="title_menu">Chat Box</div>
<div class="wraper">
	<form action="" method="post">
		<div class="table" style="padding-top: 5px;">
			<span class="row1" style="width: 50%">Tên bạn <input type="text"
				name="author"
				value="<?php echo (isset($_SESSION['name'])) ? $_SESSION['name'] : ''?>"
				style="width: 100%">
			</span> <span class="row2"></span>
		</div>
		<div class="table" style="padding-top: 5px;">
			<span class="row1" style="width: 50%">Nội dung <textarea
					name="content" style="width: 100%"></textarea>
			</span> <span class="row2"></span>
		</div>
		<div class="table" style="padding-top: 5px;">
			<span class="row1" style="width: 50%"> <img
				src="<?php echo base_url();?>/systems/includes/captcha.php"
				class="icon"><br> <input type="text" name="captcha"
				class="captcha" value="Nhập Mã Xác Nhận..."
				onfocus="if(this.value=='Nhập Mã Xác Nhận...')this.value='';"
				style="width: 100%; margin-top: 10px;"><br>
			</span> <span class="row2"></span>
		</div>
		<input type="submit" name="post_comment" value="Chat"
			style="width: 100px; margin-top: 5px;">
	</form>
</div>
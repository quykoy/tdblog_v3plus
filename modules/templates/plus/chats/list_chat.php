<?php
$arrNickAdmin = explode ( ',', $configs ['more'] ['admin'] );
$flag = (isLogin ()) ? true : false;
foreach ( $data ['list_chat'] as $key => $value ) {
	$class = (in_array ( stripcslashes ( $value ['author'] ), $arrNickAdmin )) ? 'red' : 'green';
	echo '<div class="item">
			<img src="' . base_url () . '/publics/images/icon-user.png" class="icon" alt="user">  
			<span class="' . $class . '">' . ucwords ( stripcslashes ( $value ['author'] ) ) . '</span>
			<span class="small gray">(' . date ( '\n\g\à\y d/m/y \l\ú\c h:s', $value ['times'] ) . ')</span> : 
			' . stripcslashes ( $value ['content'] );
	echo ($flag == true) ? '<span class="float_right"><a href="' . base_url () . '/chat/delete/' . $value ['id'] . '">[X]</a></span>' : '';
	echo '</div>';
}
if (empty ( $data ['list_chat'] )) {
	show_alert ( 4, array (
			'Bình luận rỗng' 
	) );
}
echo (isset ( $data ['page'] )) ? $data ['page'] : '';
?>
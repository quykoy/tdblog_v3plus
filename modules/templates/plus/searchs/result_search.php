<?php
$total = count ( $data );
if ($total == 0) {
	show_alert ( 2, array (
			'Không tìm thấy kết quả nào' 
	) );
} else {
	show_alert ( 1, array (
			'Tìm được ' . $total . ' kết quả' 
	) );
}
<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vu Ti?n Ð?nh
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */
if (! defined ( '__TD_ACCESS' ))
	exit ( 'No direct script access allowed' );
class TD_startProccess extends TD_Controller {
	function __construct($configs) {
		if ($configs ['more'] ['off_site'] == false && ! isLogin ()) {
			include __ROOT . '/modules/views/layout/off_site.php';
			exit ();
		}
		include __ROOT . '/libraries/Lib.cache.php';
		$cache = new Cache ( $configs );
		$cache->startCache ();
	}
}

new TD_startProccess ( $configs );

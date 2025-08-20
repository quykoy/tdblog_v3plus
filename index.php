<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */
session_start();

ob_start();

date_default_timezone_set("Asia/Ho_Chi_Minh");

$path	= str_replace('\\', '/', realpath(dirname(__FILE__)));
/**
**define __ROOT path
*/
define('__ROOT',$path);
/**
 ** define the key access for all file
 */
define('__TD_ACCESS', rand());
/**
 ** define the site path 
 */
define('__SITE_PATH', realpath(dirname(__FILE__)));
/**
 ** define the modules path
 */
define('__MODULES_PATH', __ROOT . '/modules');
/**
 ** define the templates path
 */
define('__LIBRARY_PATH', __ROOT . '/libraries');
/**
 ** define the systems path
 */
define('__SYSTEMS_PATH', __ROOT . '/systems');
/**
 * include file config
 */
include __SYSTEMS_PATH.'/core/TD_Configs.php';
/**
 * include file TD_Common
 */
include __SYSTEMS_PATH . '/includes/TD_Functions.php';
/**
 * include file TD_Controller
 */
include __SYSTEMS_PATH . '/core/TD_Controller.php';
/**
 * include file config
 */
include __SYSTEMS_PATH.'/core/TD_Template.php';
/**
 * include file TD_Model
 */
include __SYSTEMS_PATH . '/core/TD_Model.php';
/**
 * include file TD_StartProccess
 */
include __SYSTEMS_PATH.'/core/TD_StartProccess.php';
/**
 * include file TD_Router
 */
include __SYSTEMS_PATH . '/core/TD_Router.php';

/**
 * include file TD_EndProccess
 */
include __SYSTEMS_PATH.'/core/TD_EndProccess.php';
=======

<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');
/**
 *define hostname ex :localhost 
 */
define('__DB_HOST','localhost');
/**
 *define username ex :root 
 */
define('__DB_USER','root');
/**
 *define password ex : 1234 
 */
define('__DB_PASSWORD','1234');
/**
 *define name database ex :tdblog 
 */
define('__DB_NAME','tdblog_plus');

/**
 *define url site ex : http://nam.name.vn 
 */
define('__SITE_URL','http://nam.name.vn');



/**
 *define module default
 */
define('DEFAULT_MODULE','blog');

/**
*load file config 
*/
$general_configs = parse_ini_file(__SYSTEMS_PATH . '/ini/main-config.ini', true);
/**
*meta
*/
$configs['meta'] = $general_configs['meta'];
/**
*blog
*/
$configs['blog'] = $general_configs['blog'];
/**
*more
*/
$configs['more'] = $general_configs['more'];
/**
*load file config cache
*/
$cache = parse_ini_file(__SYSTEMS_PATH . '/ini/cache-config.ini');
/**
 * Chức năng cache
 * true: bật
 * false: tắt
 */
$configs['cache']['status'] = $cache['status'];
/**
 * thời gian cache ( số giây)
 */
$configs['cache']['time'] = $cache['time'];
/**
 * trang muốn cache
 * blog : cache blog
 * index: cache index
 * category: cache chuyên muc
 * thay băng array('') nếu muốn cache tất cả các trang
 */
$configs['cache']['site'] = explode(',', $cache['site']);

/**
*load file config java
*/
$java = parse_ini_file(__SYSTEMS_PATH . '/ini/java.ini');
$configs['java'] = $java;

global $configs;
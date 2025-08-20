<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */
 
if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');
 
class TD_endProccess extends TD_Controller {
    
    function __construct($configs)
    {
        $cache2 = new Cache($configs);
        
        if($cache2->_status == false)
        {
            $cache2->endCache();
        }
    }
}

new TD_endProccess($configs);
ob_end_flush();
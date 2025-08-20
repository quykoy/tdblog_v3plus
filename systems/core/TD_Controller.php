<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */
 
if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class TD_Controller{
    
    public $config = array();
    
    public $load;
    
    public $data = array();
    
    public function __construct()
    {
        $this->_load();
    }
    
    public function __destruct()
    {
        
    }
   
    //method connect to database
    public function database($fileName = '/Lib.db.php')
    {
        require_once __LIBRARY_PATH.$fileName;
        $this->db    = new Database();
    }
    
    //method load
    public function _load()
    {
        require_once __SYSTEMS_PATH.'/core/TD_Loader.php';
        $this->load   = new Loader;
    }
    
}
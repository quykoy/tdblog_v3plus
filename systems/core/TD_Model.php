<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class TD_Model {
    
    //thuộc tính lưu trữ các phương thức truy vấn csdl
    public $db;
    
    public function __construct(){
        $this->database();
    }
    
    //phuong thước kết nối csdl
    public function database($fileName = '/Lib.db.php'){
        require_once __LIBRARY_PATH.$fileName;
        $this->db    = new Database();
    }
    
}
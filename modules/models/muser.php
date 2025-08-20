<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Muser extends TD_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    function login($data){
        
    }
    
    function register($data){
        $sql    = 'INSERT INTO users SET name =\''.$data['username'].'\', password =\''.$data['password'].'\', full_name =\''.$data['full_name'].'\', sex =\''.$data['sex'].'\', email =\''.$data['email'].'\'';
        $this->db->query($sql);
    }
    
    function updateInfo($data){
        $sql    = 'UPDATE users SET name =\''.$data['username'].'\', password =\''.$data['password_new'].'\', full_name =\''.$data['full_name'].'\', sex =\''.$data['sex'].'\', email =\''.$data['email'].'\' WHERE id =\''.$data['id'].'\'';
        $this->db->query($sql);
    }
}
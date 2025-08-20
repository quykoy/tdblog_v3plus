<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Mleech extends TD_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    function insertBlog($data){
        return $this->db->query("INSERT INTO blogs SET id_author = {$data['author']},   id_category = {$data['category']}, title ='{$data['title']}', content ='{$data['content']}', description ='{$data['description']}', keyword ='{$data['keyword']}', alias ='{$data['alias']}',times ='{$data['time']}',likes = 1,dislikes = 0,views = 1,image ='{$data['thumb']}'");
    }
    
    function getListCategory(){
        $sql            = 'SELECT id, name, parent FROM categories';
        $query          = $this->db->query($sql);
        $result         = array();
        while($data     = $this->db->fetch_assoc($query)){
            $result[]   = $data;
        }
        return $result;
    }
    
    function addFile($data){
    	$sql = "INSERT INTO files SET id_blog = {$data['id_blog']}, file_name = '{$data['file_name']}', file_url = '{$data['file_url']}', download = 1, times = {$data['times']}";
    	return $this->db->query($sql);
    }
    
    function maxID()
    {
    	return mysql_insert_id();
    }
}
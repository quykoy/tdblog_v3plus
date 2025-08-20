<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

 class Mcategory extends TD_Model {
    
    private $_total;
    
    function __construct(){
        parent::__construct();
    }
    
    public function getListCategory($where = null){
        $sql    = 'SELECT * FROM categories';
        if($where != null){
            $sql    = "SELECT * FROM categories WHERE $where";
        }
        $query  = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query)){
            $result[] = $data;
            $totlBlog[] = $this->getTotalBlog($data['id']);
        }
        $this->_total = count($result);
        for($i = 0; $i < $this->_total ; $i++ ){
            $result[$i]['blog'] = $totlBlog[$i];
        }
        return $result;
    }
    
    public function getTotalBlog($idCategory){
        $sql    = 'SELECT id FROM blogs WHERE id_category = '.$idCategory;
        $query  = $this->db->query($sql);
        return  $this->db->num_rows($query);
    }
    
    public function countAll($id_category){
        $query = $this->db->query("SELECT id FROM categories WHERE parent = {$id_category}");
        $listID = array();
        while ($data = $this->db->fetch_assoc($query)){
            $listID[] = "'{$data['id']}'";
        }
        $listID = rtrim("'$id_category',".implode(',', $listID), ',');
        $sql = "SELECT b.id FROM blogs AS b, categories AS c WHERE b.id_category = c.id AND id_category IN ({$listID})";
        $query  = $this->db->query($sql);
        return  $this->db->num_rows($query);
    }
    
    function getInfo($url){
        $sql    = 'SELECT * FROM categories WHERE alias = \''.$url.'\'';
        $query  = $this->db->query($sql);
        return  $this->db->fetch_assoc($query);
    }
 }
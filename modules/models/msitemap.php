<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Msitemap extends TD_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    public function listBlog()
    {
        $sql  = "SELECT alias, times FROM blogs";
        $query = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }
    
    public function listCategory()
    {
        $sql  = "SELECT alias FROM categories";
        $query = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }
}
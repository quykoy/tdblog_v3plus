<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Msearch extends TD_Model {
    
    function __construct()
    {
        parent::__construct();
    }
    
    public function serach($keyword, $start = 0, $limit = 10)
    {
        $sql  = "SELECT * FROM blogs WHERE tags LIKE '%$keyword%' OR title LIKE '%$keyword%' OR content LIKE '%$keyword%' OR description LIKE '%$keyword%' OR tags LIKE '%$keyword%' ORDER BY times desc LIMIT $start, $limit";
        $query = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }
    
    public function countAll($keyword){
        $sql  = "SELECT * FROM blogs WHERE tags LIKE '%$keyword%' OR title LIKE '%$keyword%' OR content LIKE '%$keyword%' OR description LIKE '%$keyword%' OR tags LIKE '%$keyword%' ORDER BY times desc";
        $query  = $this->db->query($sql);
        $result = $this->db->num_rows($query);
        return $result;
    }
}
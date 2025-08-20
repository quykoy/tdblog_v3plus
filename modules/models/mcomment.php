<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Mcomment extends TD_Model {
    
    function __construct(){
        parent::__construct();
    }

    public function getListComment($id_blog, $start, $limit)
    {
		$sql    = "SELECT * FROM comments WHERE id_blog = '{$id_blog}' ORDER BY times DESC LIMIT $start, $limit";
		$query  = $this->db->query($sql);
		$result = array();
    	while ( $row = $this->db->fetch_assoc($query)) 
    	{
    		$result[] = $row;
    	}
    	return $result;
    }

    public function countAllComment($id_blog)
    {
    	$sql    = "SELECT id FROM comments WHERE id_blog = '{$id_blog}'";
		$query  = $this->db->query($sql);
		return $this->db->num_rows($query);
    }

    public function addComment($data)
    {
        return $this->db->query("INSERT INTO comments SET author = '{$data['author']['value']}', id_blog = '{$data['id_blog']['value']}', comment ='{$data['comment']['value']}', times ='{$data['times']['value']}'");
    }
    
    public function deleteComment($id)
    {
        return $this->db->query("DELETE FROM comments WHERE id = '{$id}'");
    }

}
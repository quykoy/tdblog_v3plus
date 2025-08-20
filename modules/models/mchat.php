<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Mchat extends TD_Model {
    
    function __construct(){
        parent::__construct();
    }

    public function getListChat($start, $limit)
    {
		$sql    = "SELECT * FROM chats ORDER BY times DESC LIMIT $start, $limit";
		$query  = $this->db->query($sql);
		$result = array();
    	while ( $row = $this->db->fetch_assoc($query)) 
    	{
    		$result[] = $row;
    	}
    	return $result;
    }

    public function countAllChat()
    {
    	$sql    = "SELECT id FROM chats";
		$query  = $this->db->query($sql);
		return $this->db->num_rows($query);
    }

    public function addChat($data)
    {
        return $this->db->query("INSERT INTO chats SET author = '{$data['author']['value']}', content ='{$data['content']['value']}', times ='{$data['times']['value']}'");
    }
    
    public function deleteChat($id)
    {
        return $this->db->query("DELETE FROM chats WHERE id = '{$id}'");
    }

}
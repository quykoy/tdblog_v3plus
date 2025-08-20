<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Mblog extends TD_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    //phuong thức lấy danh sách bài viết
    public function getListBlog($where ='',$oder = 'times', $start, $limit)
    {
        $sql      = 'SELECT java, android, wdp, ios,b.id, b.title, b.image, b.content, b.views, b.alias, b.times , c.name AS category, c.alias AS url_cat
                     FROM blogs AS b, categories AS c WHERE b.index = 1 and b.id_category = c.id '.$where.' ORDER BY '.$oder.' DESC LIMIT '.$start.','.$limit;
                     
        if($where != null){
            $sql   = 'SELECT java, android, wdp, ios,b.id, b.title, b.image,b.content, b.times, b.views, b.alias ,b.id_category , c.name AS category, c.alias AS url_cate
                        FROM blogs AS b, categories AS c 
                        WHERE b.index = 1 and b.id_category = c.id AND b.id_category = 
                        (
                        	select c.id from categories as c where c.alias = \''.$where.'\'
                        ) ORDER BY '.$oder.' DESC LIMIT '.$start.','.$limit;
        }
        $query    = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }
    
    //phương thức lấy danh sách bài viết hot
    public function getBlogHot($start = 0, $limit = 3){
        $sql      = 'SELECT java, android, wdp, ios,b.id, b.title, b.content, b.image, b.times, b.views, b.alias, c.name AS category, c.alias AS url_cate
                     FROM blogs AS b, categories AS c WHERE b.id_category = c.id AND b.id IN (SELECT id_blog FROM blogs_hot) ORDER BY times DESC LIMIT '.$start.','.$limit;
        $query    = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }

    //phuong thức lấy thông tin 1 bài viết
    function getDetailBlog($url){
        $sql        = 'SELECT tags, b.id_parent,java, android, wdp, ios,b.id, b.alias, b.views,b.times, b.content, b.title, b.description, b.keyword, b.image, b.id_category, u.full_name AS author, u.name AS url_author, c.id as id_category, c.name AS category, c.alias AS url_cate  
                        FROM blogs AS b,  categories AS c, users AS u  
                        WHERE b.id_category = c.id AND b.alias = \''.$url.'\'';
        $query      = $this->db->query($sql);
        $result     = $this->db->fetch_assoc($query);
        return $result;
    }
    
    function getBlogByCategory($id_category,$start, $limit, $full = false)
    {
        $sql = "SELECT java, android, wdp, ios,b.id, title,image, times, views, b.alias, id_category, content , c.name AS category, c.alias AS url_cate FROM blogs as b, categories as c WHERE b.index = 1 and (id_category IN (SELECT id FROM categories WHERE parent = {$id_category}) OR id_category = {$id_category}) and b.id_category = c.id ORDER BY times DESC LIMIT $start, $limit";
        if($full == true)
        {
            $query = $this->db->query("SELECT id FROM categories WHERE parent = {$id_category}");
            $listID = array();
            while ($data = $this->db->fetch_assoc($query)){
                $listID[] = "'{$data['id']}'";
            }
            $listID = rtrim("'$id_category',".implode(',', $listID), ',');
            $sql = "SELECT java, android, wdp, ios,b.id, b.title, b.content, b.times, b.image, b.views, b.alias, b.id_category, c.name AS category, c.alias AS url_cate 
                       FROM blogs AS b, categories AS c WHERE b.index = 1 and  b.id_category = c.id AND id_category IN ({$listID}) ORDER BY times DESC LIMIT $start, $limit";
        }
        $query    = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }

    function getInfoViewMore()
    {
        $sql      = "SELECT * FROM blogs_by_categories";
        $query    = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }

    /**
     * countAll
     * param
     * $where is string 
     * ex id_category = 1
     *return total record
     */
    public function countAll($where = null){
        $where  = (isset($where)) ? "WHERE b.index = 1 and  $where and b.id_category = c.id" : "WHERE b.index = 1 and  b.id_category = c.id";
        $sql    = "SELECT b.id FROM blogs b, categories c $where";
        $query  = $this->db->query($sql);
        $result = $this->db->num_rows($query);
        return $result;
    }
    
    public function getListFile($id_blog)
    {
        $sql        = "SELECT * FROM files WHERE  id_blog = {$id_blog}";
        $query    = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }

    function checkHot($id_blog){
        $sql            = 'SELECT id, id_blog FROM blogs_hot WHERE id_blog = \''.$id_blog.'\'';
        $query          = $this->db->query($sql);
        return          $this->db->num_rows($query);
    }

    function updateView($id_blog)
    {
        return $this->db->query("UPDATE blogs SET `views` = views + 1 WHERE id = {$id_blog}");
    }

    function getInfoCategory($id_category)
    {
        $query = $this->db->query("SELECT id, name, alias, parent FROM categories WHERE id = {$id_category}");
        return $this->db->fetch_assoc($query);
    }

    public function get_all_chapters($where)
    {
        $sql      = 'SELECT b.id, b.title, b.image, b.times, b.alias, c.name AS category, c.alias AS url_cate 
                     FROM blogs AS b, categories AS c WHERE b.id_category = c.id AND '.$where.' ORDER BY b.id ASC';
        $query    = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }
}
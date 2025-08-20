<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vu Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Madmin extends TD_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    function insertBlog($data){
        return $this->db->query("INSERT INTO blogs SET `index` = {$data['index']['value']}, tags = '{$data['tags']['value']}', id_parent = {$data['id_parent']['value']}, android = {$data['android']['value']}, java = {$data['java']['value']}, wdp = {$data['wdp']['value']},ios = {$data['ios']['value']}, id_author = {$data['id_author']['value']},   id_category = {$data['id_category']['value']}, title ='{$data['name']['value']}', content ='{$data['content']['value']}', description ='{$data['description']['value']}', keyword ='{$data['keyword']['value']}', alias ='{$data['alias']['value']}',times ='{$data['time']['value']}',likes = 1,dislikes = 0,views = 1,image ='{$data['image']['value']}'");
    }

    function updateBlog($data){
        return $this->db->query("UPDATE blogs SET `index` = {$data['index']['value']}, tags = '{$data['tags']['value']}',id_parent = {$data['id_parent']['value']}, android = {$data['android']['value']}, java = {$data['java']['value']}, wdp = {$data['wdp']['value']},ios = {$data['ios']['value']}, id_author = {$data['id_author']['value']},   id_category = {$data['id_category']['value']}, title ='{$data['name']['value']}', content ='{$data['content']['value']}', description ='{$data['description']['value']}', keyword ='{$data['keyword']['value']}', alias ='{$data['alias']['value']}',times ='{$data['time']['value']}', image ='{$data['image']['value']}' WHERE id={$data['id']['value']}");
    }

    function deletePost($alias){
        $sql  = 'DELETE FROM blogs WHERE alias = \''.$alias.'\'';
        return $this->db->query($sql);
    }
    
    function insertCategory($data){
        return $this->db->query("INSERT INTO categories SET  type_view ='{$data['type_view']['value']}',name ='{$data['name']['value']}', description ='{$data['description']['value']}', keyword ='{$data['keyword']['value']}', alias ='{$data['alias']['value']}', parent ='{$data['parent']['value']}'");
    }

    function updateCategory($data){
        return $this->db->query("UPDATE categories SET  type_view ='{$data['type_view']['value']}', name ='{$data['name']['value']}', description ='{$data['description']['value']}', keyword ='{$data['keyword']['value']}', alias ='{$data['alias']['value']}', parent ='{$data['parent']['value']}' WHERE id ='{$data['id']['value']}'");
    }

    function deleteCategory($alias){
        $sql  = 'DELETE FROM categories WHERE alias = \''.$alias.'\'';
        return $this->db->query($sql);
    }

    public function getInfoCategory($alias){
        $sql    = "SELECT * FROM categories WHERE alias = '$alias'";
        $query  =  $this->db->query($sql);
        return $this->db->fetch_assoc($query);
    }

    function getInfoBlog($alias){
        $sql            = 'SELECT b.id, b.alias, b.views, b.content, b.title, b.description, b.keyword, b.image, u.full_name AS author, u.name AS url_author, c.name AS category, c.id AS id_cate  
                        FROM blogs AS b,  categories AS c, users AS u  
                        WHERE b.alias = \''.$alias.'\' AND id_author = u.id AND id_category = c.id';
        $query          = $this->db->query($sql);
        $result         = array();
        while($data     = $this->db->fetch_assoc($query)){
            $result[]   = $data;
        }
        return $result;
    }
    
    function getInfoBlog2($alias){
        $sql            = 'SELECT * FROM blogs WHERE alias = \''.$alias.'\'';
        $query          = $this->db->query($sql);
        $result         = array();
        while($data     = $this->db->fetch_assoc($query)){
            $result[]   = $data;
        }
        return $result;
    }
    
    function getListCategory(){
        $sql            = 'SELECT id, name, parent, alias FROM categories';
        $query          = $this->db->query($sql);
        $result         = array();
        while($data     = $this->db->fetch_assoc($query)){
            $result[]   = $data;
        }
        return $result;
    }
    
    function checkAlias($alias){
        $sql            = 'SELECT id FROM blogs WHERE alias = \''.$alias.'\'';
        $query          = $this->db->query($sql);
        return          $this->db->num_rows($query);
    }

    function checkID($id){
        $sql            = 'SELECT id FROM blogs WHERE id = \''.$id.'\'';
        $query          = $this->db->query($sql);
        return          $this->db->num_rows($query);
    }

    function checkCategory($alias){
        $sql            = 'SELECT id FROM categories WHERE alias = \''.$alias.'\'';
        $query          = $this->db->query($sql);
        return          $this->db->num_rows($query);
    }

    function addFile($data){
        $sql            = "INSERT INTO files SET id_blog = {$data['id_blog']}, file_name = '{$data['file_name']}', file_url = '{$data['file_url']}', download = {$data['download']}, times = {$data['times']}";
        return $this->db->query($sql);
    }
    
    function editFile($data){
        $sql            = "UPDATE files SET id_blog = {$data['id_blog']}, file_name = '{$data['file_name']}', file_url = '{$data['file_url']}', download = {$data['download']}, times = {$data['times']} WHERE id = {$data['id']}";
        return $this->db->query($sql);
    }

    function deleteFile($id){
        $sql            = "DELETE FROM files WHERE id = $id";
        return $this->db->query($sql);
    }

    public function getDetailFile($id_file)
    {
        $sql   = "SELECT * FROM files WHERE  id = {$id_file}";
        $query = $this->db->query($sql);
        return   $this->db->fetch_assoc($query);
    }

    public function tickHot($id_blog){
        return $this->db->query("INSERT INTO blogs_hot SET id_blog = $id_blog");
    }

    public function unTickHot($id_blog){
        return $this->db->query("DELETE FROM blogs_hot WHERE id_blog = $id_blog ");
    }
    
    public function checkHot($id_blog){
        $sql   = 'SELECT id, id_blog FROM blogs_hot WHERE id_blog = \''.$id_blog.'\'';
        $query = $this->db->query($sql);
        return $this->db->fetch_assoc($query);
    }

    public function getBlogHotHiden($start = 0, $limit = 3)
    {
        $sql      = 'SELECT b.id, b.title, b.image, b.views, b.alias AS url, c.name AS category, c.alias AS url_cate 
                     FROM blogs AS b, categories AS c WHERE b.id_category = c.id AND b.id IN (SELECT id_blog FROM blogs_hot WHERE view = 0) ORDER BY times DESC LIMIT '.$start.','.$limit;
        $query    = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }

    public function deleteAllHot(){
        return $this->db->query("DELETE FROM blogs_hot");
    }

    public function getListBlockView()
    {
        $sql = "SELECT b.id, b.id_category, b.type_view, b.limit, c.name FROM blogs_by_categories as b, categories as c WHERE b.id_category = c.id";
        $query = $this->db->query($sql);
        $result   = array();
        while($data  = $this->db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        return $result;
    }

    public function updateBlockView($data)
    {
        $sql = "UPDATE `blogs_by_categories` SET `id_category` = {$data['id_category']}, `type_view` = {$data['type_view']}, `limit` = {$data['limit']} WHERE id = {$data['id']}";
        return $this->db->query($sql); 
    }

    public function addBlockView($data)
    {
        $sql = "INSERT INTO  `blogs_by_categories` SET `id_category` = {$data['id_category']}, `type_view` = {$data['type_view']}, `limit` = {$data['limit']}";
        return $this->db->query($sql); 
    }

    public function deleteBlockView($id)
    {
        $sql = "DELETE FROM blogs_by_categories WHERE id = $id";
        return $this->db->query($sql); 
    }

    public function checkExistsBlog($data, $type = 'id'){
        if($type == 'id')
            $sql = 'SELECT id from blogs where id = '.$data;
        else
            $sql = 'SELECT id from blogs where alias = '.$data;
        $query          = $this->db->query($sql);
        $result         = array();
        while($data     = $this->db->fetch_assoc($query)){
            $result[]   = $data;
        }
        return $result;
    }
}
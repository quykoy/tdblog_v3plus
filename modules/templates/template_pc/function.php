<?php 

	require_once __LIBRARY_PATH.'/Lib.db.php';
	global $db;
	$db = new Database();

	function getCategories($where = NULL)
	{
		global $db;
		$sql    = 'SELECT * FROM categories';
        if($where != null){
            $sql    = "SELECT * FROM categories WHERE $where";
        }
        $query  = $db->query($sql);
        $result   = array();
        while($data  = $db->fetch_assoc($query)){
            $result[] = $data;
            $totlBlog[] = getTotalBlog($data['id']);
        }
        $_total = count($result);
        for($i = 0; $i < $_total ; $i++ ){
            $result[$i]['blog'] = $totlBlog[$i];
        }
        echo'<div class="title_menu">Danh mục</div>';
        if(count($result)){
        	foreach ($result as $key => $value) {
        		echo '<div class="list">
		                <img src="http://tiendinh.name.vn/publics/images/cat.png" alt="ảnh chuyên mục" />
                        <a href="'.base_url().'/category/'.$value["alias"].'" title="'.$value["name"].'">'.$value["name"].'</a>
		              </div>';
        	}
        }else{
        	echo '<div class="vvip">chưa có chuyên mục nào</div>';
        }
	}

	function getTotalBlog($idCategory)
	{
		global $db;
        $sql    = 'SELECT id FROM blogs WHERE id_category = '.$idCategory;
        $query  = $db->query($sql);
        return  $db->num_rows($query);
    }

    function showBlog($data)
    {
        if(count($data)){
            foreach ($data as $key => $value) {
                echo '<div class="labelpost">
                        <a href="'.base_url().'/'.$value["alias"].'.html" title="'.$value["title"].'">
                        <img width="40" height="40" src="'.$value["image"].'" class="thumb_view wp-post-image" alt="'.$value["title"].'" title="'.$value["title"].'" />                 </a>
                        <div class="tenbaiviet"><a href="'.base_url().'/'.$value["alias"].'.html" title="'.$value["title"].'">'.$value["title"].'</a></div>
                        <div class="clear"></div>
                    </div>';
            }
        }else{
            echo 'chưa có bài viết';
        }
    }

    function getBlogByView($limit)
    {
    	global $db;
    	$sql ="select b.id, b.title, b.image,b.content, b.times, b.views, b.alias ,b.id_category , c.name AS category, c.alias AS url_cate 
                        FROM blogs AS b, categories AS c where b.id_category = c.id ORDER BY b.views DESC LIMIT {$limit}";
        $query      = $db->query($sql);
        $result     = array();
        while($data = $db->fetch_assoc($query))
        {
            $result[] = $data;
        }

        showBlog($result);
   
    }

    function getBlogHot($limit = 5){
        global $db;
        $sql ="select b.id, b.title, b.image,b.content, b.times, b.views, b.alias ,b.id_category , c.name AS category, c.alias AS url_cate 
                        FROM blogs AS b, categories AS c where b.id_category = c.id and b.id IN (SELECT id_blog FROM blogs_hot) ORDER BY times DESC LIMIT {$limit}";
        $query      = $db->query($sql);
        $result     = array();
        while($data = $db->fetch_assoc($query))
        {
            $result[] = $data;
        }
        
        showBlog($result);
    }

?>
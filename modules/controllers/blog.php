<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class blog extends TD_Controller{
    
    private $_limit,
            $_total,
            $_page_current,
            $_total_page,
            $_record_current = 0,
            $Mblog;
    
    function __construct(){
        parent::__construct();
        global $configs;
        $this->_limit = $configs['blog']['limit_blog'];
        $this->load->model('mblog');
        $this->load->library('Lib.pagination');
        $this->load->library('Lib.BBCode');
        $this->Mblog      = new Mblog;
        $this->_total_page = ceil($this->Mblog->countAll()/$this->_limit);
    }

    /**
     * phương thức chạy mặc định
     */
    function index($param = null)
    {
        $this->showListBlog();
    }
 
    /**
     * phương thức hiển thị danh sách bài viết
     */
    function showListBlog($param=null){
        global $configs;
        $this->load->library('Lib.detect_devices');
        
        $detect     = new Detect_devices;

        $page       = new Pagination;
        $this->_total = $this->Mblog->countAll();
        $data                 = array();
        $prefix_title ='';
        if($this->_page_current != 1 && $this->_page_current != null) $prefix_title = 'Trang '.$this->_page_current .' - ';
        $data['meta']         = array(
                                    'title'         => $prefix_title .$configs['meta']['title'],
                                    'description'   => $configs['meta']['description'],
                                    'keyword'       => $configs['meta']['keyword'],
                                );
        $data['info'] = array(
                            'name' => 'Bài Viết Mới',
                            'alias'=> ''
                        );
        $data['listblog']     = $this->Mblog->getListBlog('','times', $this->_record_current, $this->_limit);
        if($this->_total > $this->_limit){
            $pagination = array(
                'limit'           => $this->_limit,
                'total_record'    =>$this->_total,
                'current_page'    => $this->_page_current,
                'link'            => '/page/',
                'endlink'         => ''
            );
            $data['page'] = $page->createPage($pagination);
        }

        $this->load->header($data['meta']);

        if($configs['blog']['view_blog_hot'] ==  true)
        {
            $blog_hot['listblog'] = $this->Mblog->getBlogHot(0, $configs['blog']['limit_blog_hot']);
            $blog_hot['info'] = array(
                            'name' => 'Bài Viết Hot',
                            'alias'=> '/blog/hot'
                        );
            $this->load->view('blogs/list_type_'.$configs['blog']['type_view_blog_hot'], $blog_hot);
        }

        $this->load->view('blogs/list_type_'.$configs['blog']['type_view_blog'], $data);

        $this->getBlogByCategory();

        //if($detect->isTablet() || $detect->isMobile())
            $this->showCategory();

        $this->load->footer();
    }
    
    /**
     * phương thức sắp xếp bài viết
     */
    public function order($param = null, $p = null){
        global $configs;
        $page           = new Pagination;
        $this->_total   = $this->Mblog->countAll();
        $data['meta']         = array(
                                    'description'   => $configs['meta']['description'],
                                    'keyword'       => $configs['meta']['keyword'],
                                );
        if($p == null){
            $this->_page_current   = 1;
        }else{
            $this->_page_current   = abs($p);
        }
        if($this->_page_current <= 0 || $this->_page_current > $this->_total_page )
            $this->_page_current = 1 ;
        $this->_record_current = ($this->_page_current - 1) * $this->_limit;

        $prefix_title ='';
        if($this->_page_current != 1 && $this->_page_current != null) $prefix_title = 'Trang '.$this->_page_current .' - ';

        switch($param){

            case 'view': 
                $data['meta']['title']  =  $prefix_title.'Bài Viết Xem Nhiều | ' . $configs['meta']['title'];
                $data['listblog']       = $this->Mblog->getListBlog('','views', $this->_record_current, $this->_limit);
                $data['info']           = array(
                                            'name' => 'Bài Viết Xem Nhiều',
                                            'alias'=> '/blog/xem-nhieu.html'
                                        );
                $link                   = '/blog/xem-nhieu_trang-';
                break;
            case 'new': 
                $data['meta']['title']  =  $prefix_title.'Bài Viết Mới | ' . $configs['meta']['title'];
                $data['listblog']       = $this->Mblog->getListBlog('','times', $this->_record_current, $this->_limit);
                $data['info']           = array(
                                            'name' => 'Bài Viết Mới',
                                            'alias'=> '/blog/moi.html'
                                        );
                $link                   = '/blog/moi.html_trang-';
                break;
            case 'likes': 
                $data['meta']['title']  =  $prefix_title.'Bài Viết Hot | ' . $configs['meta']['title'];
                $data['listblog']       = $this->Mblog->getListBlog('','likes', $this->_record_current, $this->_limit);
                $data['info']           = array(
                                            'name' => 'Bài Viết Hot',
                                            'alias'=> '/blog/top-like.html'
                                        );
                $link                   = '/blog/top-like_trang-';
                break;
            
        }
         if($this->_total > $this->_limit){
            $pagination = array(
                'limit'             => $this->_limit,
                'total_record'      => $this->_total,
                'current_page'      => $this->_page_current,
                'link'              => $link,
                'endlink'           => '.html'
            );
            //$data['listblog']['page'] = $page->createPage($pagination);
            $data['page'] = $page->createPage($pagination);
        }

        $this->load->header($data['meta']);

        if($configs['blog']['view_blog_hot'] ==  true)
        {
            $blog_hot['listblog'] = $this->Mblog->getBlogHot(0, $configs['blog']['limit_blog_hot']);
            $blog_hot['info'] = array(
                                    'name' => 'Bài Viết Hot',
                                    'alias'=> '/blog/hot'
                                );
            $this->load->view('blogs/list_type_'.$configs['blog']['type_view_blog_hot'], $blog_hot);
        }

        $this->load->view('blogs/list_type_'.$configs['blog']['type_view_blog'], $data);

        $this->getBlogByCategory();

        $this->showCategory();

        $this->load->footer($data['meta']);
    }
    
    /**
     * phương thức phân trang
     */
    function page($page = 1)
    {
        if($page == null || $page <= 0){
            $page = 1;
        }
        $this->_page_current = abs((int)$page);
        if($this->_page_current <= 0 || $this->_page_current > $this->_total_page )
            $this->_page_current = 1 ;
        $this->_record_current = ($this->_page_current - 1) * $this->_limit ;
        $this->showListBlog($this->_record_current);
    }
    
    /**
     * phương hiển thi bài viết theo url
     */
    public function viewBlog($param = null, $p = 1)
    {
        global $configs;
        $this->load->controller('comment');
        $comment            =  new Comment;
        $data               = array();
        $data['detailBlog'] = $this->Mblog->getDetailBlog($param);
        $data['meta']       = array(
                                    'title'         => $data['detailBlog']['title'],
                                    'description'   => $data['detailBlog']['description'],
                                    'keyword'       => $data['detailBlog']['keyword'],
                                );
        //bài viết cùng chuyên mục
        if(!empty($data['detailBlog']['title']))
        {
            if($configs['more']['comment'] == true)
            {
                preg_match('#^c([0-9]*)$#', $p, $detect_comment);
                if(!empty($detect_comment))
                {
                    $page_comment = $detect_comment[1];
                    $p = 1;
                }
                else
                {
                    $page_comment = 1;
                }
            }
            $sub_title = ($p != 1) ? ' - Trang '.$p : '';
            $data['meta']['title'] .= $sub_title;
            $this->Mblog->updateView($data['detailBlog']['id']);

            if($data['detailBlog']['id_parent'] != 0) 
                $where = "b.id_parent = {$data['detailBlog']['id_parent']}";
            else
                $where = "b.id_parent = {$data['detailBlog']['id']}";

            $data['detailBlog']['chapters'] = $this->Mblog->get_all_chapters($where);
            $data['detailBlog']['hot']     = $this->Mblog->checkHot($data['detailBlog']['id']);
            $relate['listblog']            = $this->Mblog->getListBlog($data['detailBlog']['url_cate'],'times', 0, 3);
            $data['detailBlog']['files']   = $this->Mblog->getListFile($data['detailBlog']['id']);
            $data['detailBlog']['content'] = $this->showContent($data['detailBlog']['content'], $data['detailBlog']['alias'], $p);
            $data['detailBlog']['tags'] = $this->TagsPro($data['detailBlog']['tags']);
            $relate['info'] = array(
                                    'name' => 'Cùng Chuyên Mục',
                                    'alias'=> '/category/'.$data['detailBlog']['url_cate']
                                );
            $relate['page'] = '<div class="item" style="text-align: center"><a href="'.base_url().'/category/'.$data['detailBlog']['url_cate'].'" title="'.$data['detailBlog']['category'].'">Xem thêm</a></div>';
        
            $this->load->header($data['meta']);
            
            $this->load->view('blogs/view_blog', $data['detailBlog']);
            
            if(isset($relate))
                $this->load->view('blogs/list_type_2',$relate);
            
            if($configs['more']['comment'] == true  && isset($data['detailBlog']['content']))
            {
                if(isset($_POST['post_comment']))
                {
                    $comment->addComment($_POST, $data['detailBlog']['id']);
                }
                $comment->listComment($data['detailBlog']['id'], $data['detailBlog']['alias'], $page_comment);
            }
            if($configs['more']['comment_facebook'] == true  && isset($data['detailBlog']['content']))
            {
                commentFacebook($data['detailBlog']['alias'].'.html');
            }
            $this->load->footer($data['meta']);           
        }
        else 
        {
            $this->load->header($data['meta']);
            show_alert(3, array('bài viết không tồn tại'));
            $this->load->footer($data['meta']);
        }


    }
    
    /**
     * phương thức lấy bài viết cùng chuyên mục
     */
    function showCategory()
    {
        $this->load->model('mcategory');
        $Mcategory      = new Mcategory;
        $where          = 'parent = 0';
        $this->data['listcategories']   = $Mcategory->getListCategory($where);
        $this->load->view('categories/list_category', $this->data['listcategories']);
    }
    
    function hot($page = 1)
    {
        global $configs;

        $this->Mblog        = new Mblog;
        $this->_limit = $configs['blog']['limit_blog'];
        //phân trang

        if($page == null || $page <= 0){ $page = 1; }

        $this->_total = $this->Mblog->countAll("blogs.id IN (SELECT id_blog FROM blogs_hot WHERE view = 1)");
        $total_page = ceil( $this->_total/$this->_limit);

        $this->_page_current = abs((int)$page);
        if($this->_page_current <= 0 || $this->_page_current > $this->Mblog->countAll() || $this->_page_current > $total_page )
            $this->_page_current = 1 ;
        $this->_record_current = ($this->_page_current - 1) * $this->_limit ;

        //end phân trang
        
        $data         = array();
        $data['meta'] = array(
                            'title'         => 'Bài Viết Hot | ' . $configs['meta']['title'],
                            'description'   => 'Bài Viết Hot | ' . $configs['meta']['description'],
                            'keyword'       => 'Bài Viết Hot | ' . $configs['meta']['keyword']
                        );
        $data['info']           = array(
                                            'name' => 'Bài Viết Hot',
                                            'alias'=> '/blog/xem-nhieu.html'
                                        );

        if($this->_total > $this->_limit){
            $pagination = array(
                'limit'           => $this->_limit,
                'total_record'    => $this->_total,
                'current_page'    => $this->_page_current,
                'link'            => '/blog/hot/',
                'endlink'         => '.html'
            );
            $page       = new Pagination;
            $data['page'] = $page->createPage($pagination);
        }
        $this->load->header($data['meta']);

        $data['listblog'] = $this->Mblog->getBlogHot($this->_record_current, $this->_limit);

        $this->load->view('blogs/list_type_'.$configs['blog']['type_view_blog_hot'], $data);

        $this->getBlogByCategory();

        $this->showCategory();
        
        $this->load->footer($data['meta']);
    }

    private function getBlogByCategory()
    {
        global $configs;

        $list_category = $this->Mblog->getInfoViewMore();
        if(!empty($list_category))
        {
            foreach ($list_category as $key => $value) 
            {
                $list_blog[$key]['info'] = $this->Mblog->getInfoCategory($value['id_category']);
                $list_blog[$key]['info'] = array_merge($list_blog[$key]['info'],$list_category[$key]);
                $list_blog[$key]['listblog'] = $this->Mblog->getBlogByCategory($value['id_category'], 0,  $value['limit']);
            }
            if(!empty($list_blog))
            {
                foreach ($list_blog as $key => $value) {
                    if($value['info']['type_view'] == 1 ){
                        $fileView = 'list_type_1';
                    }elseif($value['info']['type_view'] == 2 ){
                        $fileView = 'list_type_2';
                    }elseif($value['info']['type_view'] == 3 ){
                        $fileView = 'list_type_3';
                    } else {
                         $fileView = 'list_type_4';
                    }
                    $value['info']['alias'] = 'category/'.$value['info']['alias'];

                    $value['page'] = '<div class="item" style="text-align: center"><a href="'.base_url().'/'.$value['info']['alias'].'" title="'.$value['info']['name'].'">Xem tất cả</a></div>';

                    $this->load->view('blogs/'.$fileView, $value);
                }
            }
        }
    }

    private function showContent($contentBlog, $link, $p)
    {
        global $configs;
        $page        = new Pagination;
        $result      = array();
        $data        = array();
        $bbcode = new BBCode;

        $contentBlog = $bbcode->parse($contentBlog);

        $length      = mb_strlen($contentBlog, 'UTF-8');

        $numPage = ceil($length/$configs['blog']['limit_word']);
        if($numPage <= 1)
        {
            $result['content'] = $contentBlog;
            $result['page']    = '';
            return $result;
        }
        else
        {
            for($i = 1; $i <= $numPage; $i++ ){
                $start    = ($i - 1) * $configs['blog']['limit_word'];
                $data[] = subStrings($contentBlog, $start, $configs['blog']['limit_word']);
            }
        }

        if($p > $numPage || $p <=0){
            $p = 1;
        }
        $pagination = array(
                'limit'           => $configs['blog']['limit_word'],
                'total_record'    => $length,
                'current_page'    => $p,
                'link'            => '/'.$link.'/trang-',
                'endlink'            => '.html'
            );
        $result['content']  = $data[$p-1];
        $result['page']     = $page->createPage($pagination);
        return $result;
    }

    private function TagsPro($content) {
        $str_tag = '';
        if(trim($content) == '')
            return $str_tag;
        $arr = explode(',', $content);
        foreach ($arr as $tag) {
            $tag = trim($tag);
            $str_tag .=  ' <a href="'.base_url().'/tags/'.$tag.'.html" title="'.$tag.'">'.$tag.'</a> ,';
        }
        $str_tag = rtrim($str_tag,',');
        $str_tag = '<div class="tags_pro">'.$str_tag.'</div>';
        return rtrim($str_tag,',');
    }
}

<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Category extends TD_Controller {
    
    private     $_limit,
                $_total,
                $_page_current   = 1,
                $_record_current = 0,
                $Mcategory;
    
    function __construct()
    {
        global $configs;
        
        parent::__construct();
        
        $this->load->model('mcategory');
        
        $this->load->model('mblog');
        
        $this->load->library('Lib.pagination');
        
        $this->load->library('Lib.BBCode');
        
        $this->load->controller('blog');
        
        $this->_limit = $configs['blog']['limit_blog'];
        
        $this->Mcategory = new Mcategory;
    }
    

    function __destruct()
    {
        $this->load->footer($this->data['meta']);  
    }
    /**
     * phương thức chạy mặc định
     */
    function index($param = null)
    {
        $this->data['listcategories'] = $this->showListCategory(); 
        
        $this->data['meta']           = array(
                                            'title'         => 'Danh Sách Chuyên Mục | Demo TDBlog V3',
                                            'description'   => 'Danh Sách Chuyên Mục | Demo TDBlog V3',
                                            'keyword'       => 'Danh Sách Chuyên Mục | Demo TDBlog V3',
                                        );
        $this->load->header($this->data['meta']);
        
        $this->load->view('categories/list_category', $this->data['listcategories']);
    }
    
    /**
     * phương thức load danh sách category
     */
    function showListCategory($param=null)
    {
        $where      = 'parent = 0';
        return $this->Mcategory->getListCategory($where);
    }
    
    /**
     * phương thức load danh sách blog theo url của category
     */
    function listBlog($url)
    {
        global $configs;
        
        $mblog          = new Mblog;
        
        $page           = new Pagination;  
        
        $infoCategory   = $this->Mcategory->getInfo($url);

        $this->data['meta']         = array(
                                        'title'         => $infoCategory['name'],
                                        'description'   => $infoCategory['description'],
                                        'keyword'       => $infoCategory['keyword']
                                    );
        
        $this->data['listblog']     = $mblog->getBlogByCategory($infoCategory['id'], $this->_record_current, $this->_limit, true);
        
        $this->_total = $this->Mcategory->countAll($infoCategory['id']);
        
        $this->data['info'] = array(
                                    'name' => $infoCategory['name'],
                                    'alias'=> '/category/'.$infoCategory['alias']
                                );
                            
        if($this->_total > $this->_limit)
        {
            $pagination = array(
                'limit'        => $this->_limit,
                'total_record' => $this->_total,
                'current_page' => $this->_page_current,
                'link'         => '/category/'.$url.'/',
                'endlink'      => ''

            );
            
            $this->data['page'] = $page->createPage($pagination);
        }
        
        $this->load->header($this->data['meta']);

        $this->load->view('blogs/list_type_'.$infoCategory['type_view'], $this->data);
        
        if($infoCategory['parent'] == 0 )
        {
            $where      =" parent = {$infoCategory['id']}";
            
            $this->data['listcategories']   = $this->Mcategory->getListCategory($where);
            
            $this->load->view('categories/list_category', $this->data['listcategories']);
        }
    }
    
    /**
     * phương thức phân trang
     */
    function page($url,$p = 1)
    {
        $infoCategory   = $this->Mcategory->getInfo($url);
        
        if($p == null || $p <= 0)
        {
            $p = 1;
        }
        
        $this->Mcategory  = new Mcategory;
        
        $total_page = ceil($this->Mcategory->countAll($infoCategory['id'])/$this->_limit);
        
        $this->_page_current = abs((int)$p);
        
        if($this->_page_current <= 0 || $this->_page_current > $total_page )
            $this->_page_current = 1 ;
            
        $this->_record_current = ($this->_page_current - 1) * $this->_limit ;
        
        $this->listBlog($url);
    }
}
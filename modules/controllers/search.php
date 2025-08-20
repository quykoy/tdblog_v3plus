<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Search extends TD_Controller{

    private $_listError,
            $_model,
            $_dataValidate;

    function __construct()
    {
        parent::__construct();
        $this->load->library('Lib.validate');
        $this->load->model('msearch');
        $this->load->model('mblog');
        $this->load->library('Lib.pagination');
        $this->_model = new Msearch;
        
        $this->data['info'] = array(
                            'name' => 'Kết quả tìm kiếm',
                            'alias'=> ''
                        );
        
    }
    
    public function index()
    {
        $this->data['meta'] = array(
                                        'title' => 'Tìm Kiếm',
                                        'keyword' => 'Tìm Kiếm',
                                        'description' => 'Tìm Kiếm',
                                    );
                                    
        $this->load->header($this->data['meta']);
        
        if(!empty($_POST) && isset($_POST['keyword']) && $_POST['keyword'])
        {
            echo $keyword  = urlencode(addslashes(strip_tags(trim($_POST['keyword']))));

            redirect(base_url().'/tags/'.$keyword.'.html');
        }
        
        $this->load->view('searchs/form_search');
        
        
        $this->load->footer($this->data['meta']);
    }
    
    public function tag($keyword)
    {
        $arrUrl     = explode('/', $keyword);
        $keyword    =  $arrUrl[0];
        $p          =  isset($arrUrl[1]) ? $arrUrl[1] : 1;
        global $configs;

        $mblog        = new Mblog;
        
        $limit = 10;
        
        $this->data['meta'] = array(
                                        'title' => 'Tìm Kiếm '.$keyword,
                                        'keyword' => $keyword .', Tìm Kiếm '.$keyword .','. $keyword .', keyword '.$keyword. ',search '.$keyword.','. $keyword,
                                        'description' => $keyword .', Tìm Kiếm với từ khóa '.$keyword .', kết quả Tìm Kiếm với từ khóa '.$keyword
                                                            . ', từ khóa '.$keyword .','. $keyword .', tìm '.$keyword
                                    );
                                    
        $this->load->header($this->data['meta']);
        
        $flag = false;
        
        $data['keyword'] = urldecode($keyword);
        
        if(!empty($data))
        {
            if($this->valiadateInput($data) ==  true)
            {
                $this->data['listblog'] = $this->_model->serach($this->_dataValidate['keyword']['value']);
                $flag = true;
            }
        }
        
        $this->load->view('searchs/form_search', $data);
        
        if($flag == true)
        {

            $total          = $this->_model->countAll($this->_dataValidate['keyword']['value']);;
            $total_page     = ceil( $total/$limit);
            $page_current   = abs((int)$p);
            if($page_current <= 0 || $page_current > $total || $page_current > $total_page )
                $page_current = 1 ;
            $record_current = ($page_current - 1) * $limit ;
            
            if($total > $limit){
                $pagination = array(
                    'limit'           => $limit,
                    'total_record'    => $total,
                    'current_page'    => $page_current,
                    'link'            => '/tags/'.$keyword.'/',
                    'endlink'         => '.html'
                );
                $page       = new Pagination;
                $this->data['page'] = $page->createPage($pagination);
            }
            
            $this->data['listblog'] = $this->_model->serach($this->_dataValidate['keyword']['value'], $record_current, $limit);
            
            $this->load->view('blogs/list_type_2', $this->data);
        }
        
        unset($this->_listError);
        
        $this->load->footer($this->data['meta']);
    }
    
    private function valiadateInput($data)
    {
        $this->_dataValidate['keyword']['value'] = trim(strip_tags($data['keyword']));
        
        $this->_dataValidate['keyword']['title'] = 'từ khóa tìm kiếm';
        
        $validate = new Validate($this->_dataValidate);
        
        $validate->addRule('keyword', 'string', 2, 255);
                 
        $validate->run();
        
        $this->_listError = $validate->getErrors();
        
        if(count($this->_listError))
        {
            show_alert(2, $this->_listError);
            return false;
        }
        
        return true;
    }
    
}
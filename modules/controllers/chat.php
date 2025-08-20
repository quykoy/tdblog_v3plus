<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Chat extends TD_Controller{
 
    private $Mcomment,
            $admin,
            $limit = 10;

    public $_listError = array();
     
    function __construct()
    {
        parent::__construct();
        global $configs;
        $this->load->model('mchat');
        $this->load->library('Lib.validate');
        $this->load->library('Lib.pagination');
        $this->Mchat = new Mchat;
        
        if($configs['more']['chat'] == false)
        {
            $this->load->header();
            show_alert(4, array('Phòng chát đóng cửa, vui lòng quay lại sau !'));
            $this->load->footer();
            exit();
        }
    }
    public function index($p = null)
    {
        global $configs;

        $page   = new Pagination;
        
        if(!empty($_POST))
        {
            $this->addChat($_POST);
        }
        
        if($p == null || $p <= 0 || !is_numeric($p))
            $p = 1;

        $total_chat        =  $this->Mchat->countAllChat();
        
        $total_page           = ceil($total_chat / $this->limit);
        
        if($p > $total_page)
            $p = 1;
            
        $startRecord          = ($p - 1) * $this->limit;
        
        $data['list_chat'] = $this->Mchat->getListChat($startRecord, $this->limit);

        if($total_page > 1)
        {
            $pagination = array(
                                    'limit'        => $this->limit,
                                    'total_record' => $total_chat,
                                    'current_page' => $p,
                                    'link'         => '/chat/page/',
                                    'endlink'      => ''
                                );

            $data['page']     = $page->createPage($pagination);
        }
        
        $prefix_title = ($p != 1 && $p != null) ? 'Trang '.$p .' - ' : '';
        
        $data['meta']         = array(
                                    'title'         => $prefix_title .'Phòng Chat | '.$configs['meta']['title'],
                                    'description'   => 'phòng chat '.$configs['meta']['description'],
                                    'keyword'       => 'phòng chat '.$configs['meta']['keyword'],
                                );
                                
        $this->load->header($data['meta']);
        show_alert(2, $this->_listError);
        $this->load->view('chats/form_chat');
        $this->load->view('chats/list_chat', $data);
        $this->load->footer($data['meta']);
    }

    public function page($p)
    {
    	$this->index($p);
    }
    
    public function addChat($data)
    {
        
        global $configs;
        $data_chat['author']['value']  = isset($data['author']) ? addslashes(strip_tags(trim($data['author']))) : '';
        $data_chat['content']['value'] = isset($data['content']) ? addslashes(strip_tags(trim($data['content']))) : '';
        $data_chat['times']['value']   = time();
        $data_chat['captcha']['value'] = addslashes(strip_tags(trim($data['captcha'])));
        $data_chat['author']['title']  = 'Tên';
        $data_chat['content']['title'] = 'Nội dung';
    
        $validate   = new Validate($data_chat);
        $validate->addRule('author', 'string', 4, 100)
                 ->addRule('content', 'string', 3, 500);
        $validate->run();
        $this->_listError = $validate->getErrors();

        if($data_chat['captcha']['value'] != $_SESSION['captcha']){
            $this->_listError[] = 'Nhập mã xác nhận không hợp lệ';
        }
        
        $arrNickAdmin = explode(',', $configs['more']['admin']);
        if(in_array($data_chat['author']['value'], $arrNickAdmin) && empty($_SESSION['name'])){
            $this->_listError[] = 'bạn không được sử dụng tên nick này';
        }
        
        if(!count($this->_listError))
        {
            $this->Mchat->addChat($data_chat);
        }
    }
    
    public function delete($id)
    {
        if(!isLogin()){
            redirect(base_url().'/user/login');
        }else{
            $this->Mchat->deleteChat($id);
            redirect(base_url().'/chat');
        }
    }

}
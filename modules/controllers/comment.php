<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Comment extends TD_Controller{
 
    private $Mcomment,
            $admin,
            $limit = 4;

    public $_listError = array();
     
    function __construct()
    {
        parent::__construct();
        $this->load->model('mcomment');
        $this->load->library('Lib.validate');
        $this->load->library('Lib.pagination');
        $this->Mcomment = new Mcomment;
    }
    
    public function index()
    {
        redirect();
    }

    public function listComment($id_blog, $url, $p = 1)
    {
        global $configs;

        $page   = new Pagination;

        if($p == null || $p <= 0 || !is_numeric($p))
            $p = 1;

        $total_comment        =  $this->Mcomment->countAllComment($id_blog);
        $total_page           = ceil($total_comment / $this->limit);
        if($p > $total_page)
            $p = 1;
        $startRecord          = ($p - 1) * $this->limit;
        $data['list_comment'] = $this->Mcomment->getListComment($id_blog, $startRecord, $this->limit);

        if($total_page > 1)
        {
            $pagination = array(
                                    'limit'        => $this->limit,
                                    'total_record' => $total_comment,
                                    'current_page' => $p,
                                    'link'         => '/'.$url.'/c',
                                    'endlink'      => '.html'
                                );

            $data['page']     = $page->createPage($pagination);
        }
        $this->load->view('comments/form_comment');
        $this->load->view('comments/list_comment', $data);
    }

    public function addComment($data, $id_blog)
    {
        
        global $configs;
        $data_comment['author']['value']  = isset($data['author']) ? addslashes(strip_tags(trim($data['author']))) : '';
        $data_comment['comment']['value'] = isset($data['comment']) ? addslashes(strip_tags(trim($data['comment']))) : '';
        $data_comment['id_blog']['value'] = $id_blog;
        $data_comment['times']['value']   = time();
        $data_comment['captcha']['value'] = addslashes(strip_tags(trim($data['captcha'])));
        $data_comment['author']['title']  = 'Tên';
        $data_comment['comment']['title'] = 'Nội dung';
    
        $validate   = new Validate($data_comment);
        $validate->addRule('author', 'string', 4, 100)
                 ->addRule('comment', 'string', 3, 500);
        $validate->run();
        $this->_listError = $validate->getErrors();

        if($data_comment['captcha']['value'] != $_SESSION['captcha']){
            $this->_listError[] = 'Nhập mã xác nhận không hợp lệ';
        }
        
        $arrNickAdmin = explode(',', $configs['more']['admin']);
        if(in_array($data_comment['author']['value'], $arrNickAdmin) && empty($_SESSION['name'])){
            $this->_listError[] = 'bạn không được sử dụng tên nick này';
        }
        if(!count($this->_listError))
        {
            $this->Mcomment->addComment($data_comment);
        }
        else
        {
            show_alert(2, $this->_listError);
        }
    }
    
    public function delete($id)
    {
        if(!isLogin()){
            redirect(base_url().'/user/login');
        }else{
            $this->Mcomment->deleteComment($id);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}
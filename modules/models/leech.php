<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Leech extends TD_Controller{
    
    private $model,
    
            $url,
    
            $pattren,
            
            $dataLeech,
            
            $source,
            
            $flag = true;
    
    function __construct()
    {
        parent::__construct();
        
        if(!isLogin())
        {
            redirect(base_url().'/user/login');
            exit();
        }
        
        $this->load->library('Lib.watermark');
        
        $this->load->model('mleech');
        
        $this->model = new Mleech;
        
        $this->data['meta'] = array(
        
                                    'title'         => 'tool leech',
                                    'description'   => 'tool leech',
                                    'keyword'       => 'tool leech',
                                );
                                
        $this->data['listCategory'] = $this->model->getListCategory();
        
        $this->load->header($this->data['meta']);
    }
    
    function __destruct()
    {
        $this->load->footer($this->data['meta']);
    }
    
    public function index()
    {
        
        $this->load->view('leechs/main');
        
    }
    
    private function validate($data)
    {
        $this->url     = $data['url'];
        
        $this->dataLeech['category'] = $data['category'];
        
        if($this->url == '')
        {
            show_alert(2, array('Url không được để trống'));
            $this->flag = false;
        }else
        {
            $this->url     = preg_replace('#^https?://#is', '', $this->url); 
            $this->url     = 'http://'.$this->url;
        }
        
        if($this->dataLeech['category'] == 'false')
        {
            show_alert(2, array('Chưa chọn chuyên mục'));
            $this->flag = false;
        }
    }
    
    private function process()
    {
        $this->dataLeech['description'] = addslashes(subWords(trim(strip_tags($this->dataLeech['content'])), 80));
        $this->dataLeech['keyword']     = str_replace(' ', ',', $this->dataLeech['description']);
        $this->dataLeech['content']     = addslashes(trim(watermark::searchLinkImg($this->dataLeech['content'])));
        $this->dataLeech['thumb']       = getThumb(stripcslashes($this->dataLeech['content']));
        $this->dataLeech['alias']       = convertString($this->dataLeech['title']);
        $this->dataLeech['time']        = time();
        $this->dataLeech['author']      = $_SESSION['id_name'];
        
        if($this->model->insertBlog($this->dataLeech) && $this->dataLeech['content'] != null)
        {
            show_alert(1, array('Leech bài thành công'));
        }
        else
        {
            show_alert(3, array('Leech bài thất bại'));
        }
    }
    
    private function getSource()
    {
        $this->source = @file_get_contents($this->url);
        
        if($this->source == null)
            return false;
        return true;
    }
    public function truyen360()
    {
        $this->data['urlPost'] = end(explode('::', __METHOD__));
        
        $this->data['site'] = array(
                                    //tên của site
                                    'name' => 'Doctruyen360.com',
                                    //url để lấy link bài viết
                                    'url'  => 'http://www.doctruyen360.com/danh-sach-truyen-ngan-hay-truyen-ngan-tinh-yeu/'
                                    );
        
        if(!empty($_POST))
        {
            $this->validate($_POST);
            
            if($this->flag == true)
            {
                if($this->getSource() == true)
                {
                    $this->pattren['title'] = '#<title>(.+?)</title>#is';
                    preg_match($this->pattren['title'], $this->source, $arrMatches);
                    $this->dataLeech['title'] = array_shift(explode('|', $arrMatches[1]));
                    
                    $this->pattren['content'] = '#<div class="dtct1072">(.+?)<div id="fcbk_share">#is';
                    preg_match($this->pattren['content'], $this->source, $arrMatches);
                    $this->dataLeech['content'] = isset($arrMatches[1]) ? $arrMatches[1] : '';
                    
                    $this->process();
                }
                else
                {
                    show_alert(3, array('Link bài viết không hợp lệ'));
                }
            }
        }
        
        $this->load->view('leechs/form_leech', $this->data);
    }
}
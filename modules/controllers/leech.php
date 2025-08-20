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
    	$data_configs = parse_ini_file(__SYSTEMS_PATH . '/ini/main-config.ini', true);
    	$this->load->library('Lib.image');
        $this->dataLeech['description'] = addslashes(subWords(trim(strip_tags($this->dataLeech['content'])), 80));
        $this->dataLeech['keyword']     = str_replace(' ', ',', $this->dataLeech['description']);
        $this->dataLeech['content']     = addslashes(trim(watermark::searchLinkImg($this->dataLeech['content'])));
        $this->dataLeech['thumb']       = isset($this->dataLeech['thumb']) ? $this->dataLeech['thumb'] : getThumb(stripcslashes($this->dataLeech['content']));
        $this->dataLeech['alias']       = convertString($this->dataLeech['title']);
        $this->dataLeech['time']        = time();
        $this->dataLeech['author']      = $_SESSION['id_name'];
        
        $fileName = end(explode('/', $this->dataLeech['thumb']));     
        if($fileName != 'noimg.png') {
            if(!strpos(base_url(), $this->dataLeech['thumb'])) {
            	$this->dataLeech['thumb'] = str_replace(base_url(), __SITE_PATH, $this->dataLeech['thumb']);
                copy($this->dataLeech['thumb'], __ROOT.'/publics/files/thumbnails/'.$fileName);
                $this->dataLeech['thumb'] = __ROOT.'/publics/files/thumbnails/'.$fileName;
            }
            $img = str_replace(base_url(), __SITE_PATH, $this->dataLeech['thumb']);
            $imagethumbnails = new Image($img);
            $this->dataLeech['thumb'] = $imagethumbnails->createThumb($img,200,200,'fit');
            $this->dataLeech['thumb'] = str_replace(__SITE_PATH, base_url(), $this->dataLeech['thumb']);
        }

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
		$curl = curl_init();
	    $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
	    $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	    $header[] = "Cache-Control: max-age=0";
	    $header[] = "Connection: keep-alive";
	    $header[] = "Keep-Alive: 300";
	    $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	    $header[] = "Accept-Language: en-us,en;q=0.5";
	    $header[] = "Pragma: ";    
	    $referers = array("google.com", "yahoo.com", "msn.com", "ask.com", "live.com");
	    $choice = array_rand($referers);
	    $referer = "http://" . $referers[$choice] . "";
	    $browsers = array("Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.3) Gecko/2008092510 Ubuntu/8.04 (hardy) Firefox/3.0.3", "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20060918 Firefox/2.0", "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3", "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.0.04506)");
	    $choice2 = array_rand($browsers);
	    $browser = $browsers[$choice2];
	    curl_setopt($curl, CURLOPT_URL, $this->url);
	    curl_setopt($curl, CURLOPT_USERAGENT, $browser);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($curl, CURLOPT_REFERER, $referer);
	    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	    curl_setopt($curl, CURLOPT_MAXREDIRS, 7);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	    $this->source = curl_exec($curl);
	    if ($this->source === false) {
	        $this->source = curl_error($curl);
	    }
	    curl_close($curl);
        if($this->source == null)
            return false;
        return true;
    }
    
    private function addFile($arrInfo)
    {
    	
    }
    
    public function truyen360()
    {
       	$param = explode('::', __METHOD__);
		$this->data['urlPost'] = end($param);
        
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
                    $this->pattren['content'] = '#<div class="dtct1072">(.+?)<div class="cleaner">&nbsp;<\/div>#is';
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

	public function trasua()
    {
       	$param = explode('::', __METHOD__);
		$this->data['urlPost'] = end($param);
        $this->data['site'] = array(
                                    //tên của site
                                    'name' => 'TraSua',
                                    //url để lấy link bài viết
                                    'url'  => 'http://trasua.mobi/'
                                    );
        
        if(!empty($_POST))
        {
            $this->validate($_POST);
            
            if($this->flag == true)
            {
                if($this->getSource() == true)
                {
                    $this->pattren['title'] = '#<h3 class="panel-title">(.+?)<\/h3>#isu';
                    preg_match($this->pattren['title'], $this->source, $arrMatches);
                    $this->dataLeech['title'] = $arrMatches['1'];

                    $pattern = '#page=([0-9]+?)"#isu';
					preg_match_all($pattern, $this->source, $matches);
					$total_page = (isset($matches[1])) ? max($matches[1]) : 1;
					$url_tmp = $this->url;
					$this->dataLeech['content'] = '';

					for($i = 1; $i <= $total_page; $i++) {
						$this->url = $url_tmp.'?page='.$i;
						$this->getSource();
						$pattern = '#<div class="panel-body">(.+?)<\/div><div class="panel-footer">#isu';
						preg_match_all($pattern, $this->source, $matches);
						$this->dataLeech['content'] .= $matches['1']['0'];
					}
                    
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
	
	public function apphd()
	{
		$this->data['urlPost'] = end(explode('::', __METHOD__));
		
		$this->data['site'] = array(
				//tên của site
				'name' => 'Apphd.vn',
				//url để lấy link bài viết
				'url'  => 'http://apphd.vn'
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
					
					$this->pattren['content'] = '#<div class="item">.*class="center-block" src="(.+?)">#is';
					preg_match($this->pattren['content'], $this->source, $arrMatches);
					$this->dataLeech['content'] = isset($arrMatches[1]) ? '[img]'.$arrMatches[1].'[/img]' : '';
					
					$this->pattren['content'] = '#<div class="app_intro" style="position:relative;max-height:150px;overflow:hidden;">(.+?)<div#is';
					preg_match($this->pattren['content'], $this->source, $arrMatches);
					$this->dataLeech['content'] .= isset($arrMatches[1]) ? $arrMatches[1] : '';
					
					$this->pattren['thumb'] = '#<td width="52" style="padding:0">.*?<img src="(.+?)"\/>#is';
					preg_match($this->pattren['thumb'], $this->source, $arrMatches);
					$this->dataLeech['thumb'] = isset($arrMatches[1]) ? $arrMatches[1] : '';
					
					$this->process();
					
					$this->pattren['link'] = '#color:\#fff;\" href="(.+?)"#is';
					preg_match($this->pattren['link'], $this->source, $arrMatches);
					$this->dataLeech['link'] = isset($arrMatches[1]) ? 'http://apphd.vn'.$arrMatches[1] : '';
					
					if($this->dataLeech['link'] != null)
					{
						$infoFile = array(
								'file_name' => 'Tải Về Miễn Phí',
								'id_blog' 	=> $this->model->maxID(),
								'file_url'	=> $this->dataLeech['link'],
								'times'		=> time()
						);
						$this->model->addFile($infoFile);
					}
				}
				else
				{
					show_alert(3, array('Link bài viết không hợp lệ'));
				}
			}
		}
		
		$this->load->view('leechs/form_leech', $this->data);
	}
	
	public function apk()
	{
		$param = explode('::', __METHOD__);
		$this->data['urlPost'] = end($param);
	
		$this->data['site'] = array(
				//tên của site
				'name' => 'user.apk.vn',
				//url để lấy link bài viết
				'url'  => 'http://djnhdaik.apk.vn'
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
					$this->dataLeech['title'] = $arrMatches[1];

					$this->pattren['content'] = '#data-loading="(.+?)"#is';
					preg_match($this->pattren['content'], $this->source, $arrMatches);
					$this->dataLeech['content'] = isset($arrMatches[1]) ? '[img]'.$arrMatches[1].'[/img]' : '';

					$this->pattren['content'] = '#<div class="desc_app">(.+?)</div>.*<div class="btn_view_all"#is';
					preg_match($this->pattren['content'], $this->source, $arrMatches);
					$this->dataLeech['content'] .= isset($arrMatches[1]) ? $arrMatches[1] : '';

					$this->pattren['thumb'] = '#<section class="detail_baseinfo clearfix"><img src="(.+?)".*class="img_baseinfo">#is';
					preg_match($this->pattren['thumb'], $this->source, $arrMatches);
					$this->dataLeech['thumb'] = isset($arrMatches[1]) ? $arrMatches[1] : '';

					$this->process();
					$this->pattren['link'] = '#<a class="btn_like_share " href="(.+?)"#is';
					preg_match($this->pattren['link'], $this->source, $arrMatches);
					$this->dataLeech['link'] = isset($arrMatches[1]) ? $arrMatches[1] : '';
						
					if($this->dataLeech['link'] != null)
					{
						$infoFile = array(
								'file_name' => 'Tải Về Miễn Phí',
								'id_blog' 	=> $this->model->maxID(),
								'file_url'	=> $this->dataLeech['link'],
								'times'		=> time()
						);
						$this->model->addFile($infoFile);
					}
				}
				else
				{
					show_alert(3, array('Link bài viết không hợp lệ'));
				}
			}
		}
	
		$this->load->view('leechs/form_leech', $this->data);
	}
	public function cucdinh()
	{
		$param = explode('::', __METHOD__);
		$this->data['urlPost'] = end($param);
	
		$this->data['site'] = array(
				//tên của site
				'name' => 'cucdinh.mobi',
				//url để lấy link bài viết
				'url'  => 'http://cucdinh.mobi'
		);
	
		if(!empty($_POST))
		{
			$this->validate($_POST);
	
			if($this->flag == true)
			{
				if($this->getSource() == true)
				{
					$this->pattren['title'] = '#<strong style="font-size: 18px;">(.+?)</strong>#is';
					preg_match($this->pattren['title'], $this->source, $arrMatches);
					$this->dataLeech['title'] = $arrMatches[1];

					$this->pattren['content'] = '#<div class="box-detail">(.+?)</div>#is';
					preg_match($this->pattren['content'], $this->source, $arrMatches);
					$this->dataLeech['content'] = isset($arrMatches[1]) ? $arrMatches[1] : '';
	
					$this->process();
	
					$this->pattren['link'] = '#<span class="bt-downfree"><a href="(.+?)"#is';
					preg_match($this->pattren['link'], $this->source, $arrMatches);
					$this->dataLeech['link'] = isset($arrMatches[1]) ? $arrMatches[1] : '';

					if($this->dataLeech['link'] != null)
					{
						$infoFile = array(
								'file_name' => 'Tải Về Miễn Phí',
								'id_blog' 	=> $this->model->maxID(),
								'file_url'	=> $this->dataLeech['link'],
								'times'		=> time()
						);
						$this->model->addFile($infoFile);
					}
				}
				else
				{
					show_alert(3, array('Link bài viết không hợp lệ'));
				}
			}
		}
	
		$this->load->view('leechs/form_leech', $this->data);
	}
	public function hayday()
	{
		$param = explode('::', __METHOD__);
		$this->data['urlPost'] = end($param);
	
		$this->data['site'] = array(
				//tên của site
				'name' => 'hayday.mobi',
				//url để lấy link bài viết
				'url'  => 'http://hayday.mobi'
		);
	
		if(!empty($_POST))
		{
			$this->validate($_POST);
	
			if($this->flag == true)
			{
				if($this->getSource() == true)
				{
					$this->pattren['title'] = '#<h2 class="h2service2">(.+?)<img#is';
					preg_match($this->pattren['title'], $this->source, $arrMatches);
					$this->dataLeech['title'] = array_shift(explode('|', $arrMatches[1]));

					$this->pattren['content'] = '#<div class="content-news">(.+?)</div><div class="multi-link">#is';
					preg_match($this->pattren['content'], $this->source, $arrMatches);
					$this->dataLeech['content'] = isset($arrMatches[0]) ? $arrMatches[0] : '';
					$this->process();
						
					$this->pattren['link'] = '#<a class="Gdownload" href="(.+?)"#is';
					preg_match($this->pattren['link'], $this->source, $arrMatches);
					$this->dataLeech['link'] = isset($arrMatches[1]) ? $arrMatches[1] : '';
						
					if($this->dataLeech['link'] != null)
					{
						$infoFile = array(
								'file_name' => 'Tải Về Miễn Phí',
								'id_blog' 	=> $this->model->maxID(),
								'file_url'	=> $this->dataLeech['link'],
								'times'		=> time()
						);
						$this->model->addFile($infoFile);
					}
	
				}
				else
				{
					show_alert(3, array('Link bài viết không hợp lệ'));
				}
			}
		}
	
		$this->load->view('leechs/form_leech', $this->data);
	}

	public function phuthobay()
    {
       	$param = explode('::', __METHOD__);
		$this->data['urlPost'] = end($param);
        
        $this->data['site'] = array(
                                    //tên của site
                                    'name' => 'Thủ thuật phuthobay',
                                    //url để lấy link bài viết
                                    'url'  => 'http://phuthobay.pro/kinhnghiem/'
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
                    $this->dataLeech['title'] = $arrMatches[1];
                    $this->pattren['content'] = '#<\/script>.*<\/div>.*<br \/>.*<p>(.+?)<\/p>.*<br \/>.*<div style="text-align:center">#is';
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
	public function wapvip()
    {
       	$param = explode('::', __METHOD__);
		$this->data['urlPost'] = end($param);
        
        $this->data['site'] = array(
                                    //tên của site
                                    'name' => 'Thủ thuật wapvip',
                                    //url để lấy link bài viết
                                    'url'  => 'http://wapvip.pro/page/THU-THUAT-MOI-NHAT-27934.htm#new'
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
                    $this->dataLeech['title'] = $arrMatches[1];
                    $this->pattren['content'] = '#<div class="forumtxt">(.+?)<\/div>.#is';
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

	public function ohdep()
    {
       	$param = explode('::', __METHOD__);
		$this->data['urlPost'] = end($param);
        
        $this->data['site'] = array(
                                    //tên của site
                                    'name' => 'ảnh ohdep.net',
                                    //url để lấy link bài viết
                                    'url'  => 'http://ohdep.net/'
                                    );
        
        if(!empty($_POST))
        {
            $this->validate($_POST);
            
            if($this->flag == true)
            {
                if($this->getSource() == true)
                {
                    $this->pattren['title'] = '#<h1>(.+?)</h1>#is';
                    preg_match_all($this->pattren['title'], $this->source, $arrMatches);
                    $this->dataLeech['title'] = $arrMatches[1][1];
                    $this->pattren['content'] = '#src="(.+?)"#is';
                    $this->dataLeech['content'] = '<center>';
                    preg_match('#<div class="post_pcontent">(.+?)</div>#isu', $this->source, $content);
                    preg_match_all($this->pattren['content'], $content[1], $arrMatches);
                   	foreach ($arrMatches[1] as $img) {
                   		$this->dataLeech['content'] .= '<a href="'.$img.'" title="'.$this->dataLeech['title'].'"><img src="'.$img.'" alt="'.$this->dataLeech['title'].'"></a><br/><br/>';
                   	}
                   	$this->dataLeech['content'] .= '</center>'; 
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
<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */
 
if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

/**
*thu vi?n phân trang $this->load->library('page');
*s? d?ng $this->page->createPage($limit,$total,$current,$link)
*tham sô $limit (s? record trên 1 trang) , $total (t?ng s? record) , $current (trang hi?n t?i) , $link (link phân trang)
*/
/**

$page = array(
	'limit'      	=> 5,
	'total_page' 	=> ,
	'current_page' 	=> ,
	'link'			=>
	);

*/

class Pagination {

    public $page = '<div class="pagination">';
    /**
     * phuong thúc t?o link phân trang
     * $config = array(
                    'limit'             => $this->_limit,                       số bài viết trên 1 trang
                    'total_record'      => $this->_total,                       tổng số record
                    'current_page'      => $this->_page_current,                trang hiện tại 
                    'link'              => '/page/'                             đường dẫn phân trang
                    'endlink'            => '.html'                             định dạng link
                );
     * 
     * 
     */
    public function createPage($config)
    {
        $num_page   = ceil($config['total_record']/$config['limit']);
        $start      = $config['current_page'] - 2 ;
        $stop       = (int)($config['current_page'] + 2) ;
        $start      = ( $start < 1 ) ? 1 : $start ; 
        $stop       = ( $stop > $num_page ) ? $num_page : $stop ;

        if( $config['current_page'] > 1 )
        {
        	if($config['current_page']>=4){
        		$this->page .= '<a href="'.base_url().$config['link'].'1'.$config['endlink'].'" title="trang 1" class="first">first</a>';
        	}
        }
        
                
        for( $i = $start ; $i <= $stop ; $i++ )
        {
            if( $i == $config['current_page'] || ( empty($config['current_page']) && $i == 1 ) )
                $this->page .= '<a class="current">'.$i.'</a>';
            else
                $this->page .= '<a href="'.base_url().$config['link'].$i.$config['endlink'].'" title="trang '.$i.'">'.$i.'</a>';
        }

        if( $config['current_page'] < $num_page )
        {
        	//$this->page .= '<li><a href="'.__SITE_URL.$config['link'].($config['current_page']+1).'" title="trang '.($config['current_page']+1).'">next</a></li>';
        	if($config['current_page'] < ($num_page - 2)){
        		$this->page .= '<a href="'.base_url().$config['link'].$num_page.$config['endlink'].'" title="trang '.$num_page.'" class="last">last</a>';
        	}
        }

        return $this->page.'</div>';
    }

}

?>
<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vu Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Sitemap extends TD_Controller{
 
    private $strXml = '';
 
    function __construct()
    {
        parent::__construct();
        $this->load->model('msitemap');
    }
    
    function index()
    {
        $this->createXml();
        $this->show();
    }
    
    private function createXml()
    {
        $Msitemap       = new Msitemap;
        $lisBlog        = $Msitemap->listBlog();
        $listCategory   = $Msitemap->listCategory();
        $this->strXml   .= '<?xml version="1.0" encoding="UTF-8"?>';
        $this->strXml   .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        
        $this->strXml .= '<url>
                                <loc>'.base_url().'</loc>
                                <lastmod>'.date("Y-m-d", time()).'</lastmod>
                                <changefreq>daily</changefreq>
                                <priority>1</priority>
                            </url>';
        
        foreach($lisBlog as $blog)
        {
            $this->strXml .= '<url>
                                <loc>'.base_url().'/'.$blog['alias'].'.html</loc>
                                <lastmod>'.date("Y-m-d", $blog['times']).'</lastmod>
                                <changefreq>daily</changefreq>
                                <priority>1</priority>
                            </url>';
        }
        
        foreach($listCategory as $category)
        {
            $this->strXml .= '<url>
                                <loc>'.base_url().'/category/'.$category['alias'].'</loc>
                                <lastmod>'.date("Y-m-d", time()).'</lastmod>
                                <changefreq>daily</changefreq>
                                <priority>1</priority>
                            </url>';
        }
        $this->strXml   .= '</urlset>';
    }
    
    private function show()
    {
        header("content-type:text/xml;charset=utf-8");
        echo trim($this->strXml);
    }
    
}
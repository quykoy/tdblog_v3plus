<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class jad extends TD_Controller{
 
    //thuộc tính lưu trữ danh sách lỗi
    private $_listError = array(),
            $Madmin; 
     
    function __construct()
    {
        parent::__construct();
    }

    public function index() {
    	redirect();
    }
    public function create() {
    	$this->load->library('Lib.PclZip');
    	$url = cleanXSS($_GET['url']);
		$file = file_get_contents($url);
		$handle = fopen("temp.jar","w+");
		fputs($handle, $file);
		fclose($handle);
		$name = strtok(basename($url),".");
		$size = filesize("temp.jar");
		$jar = new PclZip("temp.jar");
		$manifest = $jar->extract(PCLZIP_OPT_BY_NAME, "META-INF/MANIFEST.MF", PCLZIP_OPT_EXTRACT_AS_STRING);
		echo $manifest[0]["content"];
		echo "MIDlet-Jar-Size: ".$size."\n"."MIDlet-Jar-URL: ".$url;
		unlink("temp.jar");
		header("Cache-Control: no-cache, must-revalidate,no-transform" );
		header("Pragma: no-cache" );
		header("Content-type: text/vnd.sun.j2me.app-descriptor");
		header("Content-Disposition: attachment; filename=".$name.".jad");
    }
}

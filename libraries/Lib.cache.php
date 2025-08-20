<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Cache {
    
    public   $_fileName,
             $_fileCache,
             $_timeCache,
             $_flagCache,
             $_isCache = false,
             $_status = false;
    
    function __construct($configs)
    {        
        $part1  = (isset($_GET['controller'])) ? '_'.$_GET['controller'] : '';

        $part3  = (isset($_GET['param'])) ? '_'.$_GET['param'] : '';

        $part4  = (isset($_GET['param2'])) ? '_'.$_GET['param2'] : '';

        $part2  = (isset($_GET['action'])) ? '_'.$_GET['action'] : '';
        
        $this->_fileCache   = __MODULES_PATH . '/caches/cache'.$part1.$part2.$part3.$part4.'.html';
        $this->_flagCache   = false;
        if($configs['cache']['status'] == 1){
            if(count($configs['cache']['site'])){
                $this->_flagCache   = (in_array(strtolower(str_replace('_', '', $part1)), $configs['cache']['site'])) ? true : false;
            }else{
                                echo 'start cache';
                $this->_flagCache   = true;
            }
        }
        if(isLogin() == true){
             $this->_flagCache   = false;
        }
        $this->_timeCache   = $configs['cache']['time'];
    }

    function startCache()
    {
        $fileCache    = $this->_fileCache;
        
        if($this->_flagCache == true)
        {
            if(file_exists($this->_fileCache) && ($this->_timeCache > time() - filectime($this->_fileCache)) && empty($_POST))
            {
                $this->_isCache = true;
                include $this->_fileCache;
                exit();
            }
        }
    }
    
    function endCache()
    {
        if($this->_flagCache == true)
        {
            if($this->_isCache == false)
            {
                @file_put_contents($this->_fileCache, ob_get_contents());
            }
        }  
    }
    
    function deleteCache()
    {
        
        $dir        = __MODULES_PATH.'/caches';
        chdir($dir);
        $arrFiles   = glob('*');
        foreach($arrFiles as $file)
        {
            $pathFile   = $dir.'/'.$file;
            if(file_exists($pathFile) && ($this->_timeCache < time() - filectime($pathFile)))
            {
                unlink($pathFile);
            }
        }
    }
    
}
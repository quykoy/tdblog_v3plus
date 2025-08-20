<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Loader {
    
    public  $_nameController,
            $_nameModel,
            $_nameView,
            $_meta = array(),
            $_templateDefault;

    public function __construct() {
        $this->_templateDefault = 'plus';
    }
    
    /**
    *
    *method load library
    *
    */
    public function library($fileName)
    {
        $pathFile    = __LIBRARY_PATH.'/' . $fileName . '.php';

        if(file_exists($pathFile))
        {
            require_once $pathFile;
        }
        else
        {
            echo "Library $fileName not exists";
        }
    }
    
    /**
    *
    *method load view
    *
    */
    public function view($fileName, $value = array())
    {
        global $configs;

        $data     = $value;  

        $pathFile = __MODULES_PATH.'/templates/' .TD_Template::$template.'/'. $fileName .'.php';

        if(file_exists($pathFile))
        {
            include $pathFile;
        }
        elseif(file_exists($pathFile = __MODULES_PATH.'/templates/'.$this->_templateDefault.'/'. $fileName .'.php'))
        {
            include $pathFile;
        }
        else
        {
            show_alert(2,array('view <b>'. $fileName .'</b> not exists'));
        }
    }
    
   /**
    *
    *method load model
    *
    */
    public function model($fileName)
    {
        global $configs;

        $pathFile           = __MODULES_PATH.'/models/' . $fileName .'.php';   

        if(file_exists($pathFile))
        {
            require_once $pathFile;
        }
        else
        {
            echo "Model $fileName not exists";
        }
    }
    
    /**
    *
    *method load controller
    *
    */
    public function controller($fileName)
    {
        global $configs;
        $pathFile   = __MODULES_PATH.'/controllers/' . $fileName .'.php';

        if(file_exists($pathFile))
        {
            require_once $pathFile;
        }
        else
        {
            $this->header();
            show_alert(3, array('Trang này không tồn tại'));
            $this->footer();
        }
    }
    
    /**
    *
    *method load header
    *
    */
    public function header($data = array())
    {
        global $configs;
        
        $meta   = (!empty($data)) ? $data : $configs['meta'];
        
        $pathFile = __MODULES_PATH.'/templates/' .TD_Template::$template.'/layout/header.php';
        
        if(file_exists($pathFile))
        {
            require_once $pathFile;
        }
        elseif(file_exists($pathFile = __MODULES_PATH.'/templates/'.$this->_templateDefault.'/layout/header.php'))
        {
            require_once $pathFile;
        }
        else
        {
            show_alert(2,array('Header not exists'));
        }
    }
    
    /**
    *
    *method load footer
    *
    */
    public function footer($data = array())
    {
        global $configs;
        $tag   = (!empty($data)) ? $data : $configs['meta'];
        
        if(isset($tag['keyword'])) unset($tag['keyword']);
        
        $pathFile = __MODULES_PATH.'/templates/' .TD_Template::$template.'/layout/footer.php';
        
        if(file_exists($pathFile))
        {
            require_once $pathFile;
        }
        elseif(file_exists($pathFile = __MODULES_PATH.'/templates/'.$this->_templateDefault.'/layout/footer.php'))
        {
            require_once $pathFile;
        }
        else
        {
            show_alert(2,array('Header not exists'));
        }
    }
}
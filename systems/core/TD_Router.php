<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class TD_Router extends TD_Controller {
    //thuộc tính luu trữ url truy vấn
    public $_strQuery;
    
    //thuộc tính luu trữ controller
    private $_controller;
    
    //thuộc tính luu trữ action
    private $_action;
    
    //thuộc tính luu trữ param
    private $_param;
    
    //thuộc tính luu trữ param2
    private $_param2;
    
    private $_TD;
    
    public function __construct()
    {
        
        parent::__construct();
        
        $this->_strQuery = $_SERVER['QUERY_STRING'];
        
        $this->getModule();
        
        $this->proccessRequest();
        
    }
    
    
    //phương thức tách url thành controller, action, param1, param2
    private function getModule()
    {
        if($this->_strQuery == null)
        {
            $this->_controller = DEFAULT_MODULE; 
        }

        $this->_controller = (isset($_GET['controller'])) ? htmlentities($_GET['controller']) : '';

        $this->_param      = (isset($_GET['param'])) ? htmlentities($_GET['param']) : '';

        $this->_param2     = (isset($_GET['param2'])) ? htmlentities($_GET['param2']) : '';

        $this->_action     = (isset($_GET['action'])) ? htmlentities($_GET['action']) : '';
    }
    
    //phương thức tiến hành sử lý request
    private function proccessRequest()
    {
        
        //không tồn tại controller
        if($this->_controller == null)
        {
            $this->_controller = DEFAULT_MODULE;

            $this->load->controller($this->_controller);

            $this->_TD  = new $this->_controller;

            if(method_exists($this->_TD, 'index'))
            {
                $this->_TD->index();
            }
            else
            {
                show_alert(3,array('chưa tồn tai phương thức index'));
            }
         //tồn tại controller   
        }
        else
        { 
            //không tồn tại action
            if($this->_action == null)
            {
                $this->load->controller($this->_controller);
                
                if(class_exists($this->_controller))
                {
                    $this->_TD     = new $this->_controller;

                    if(method_exists($this->_TD, 'index'))
                    {
                        $this->_TD->index();
                    }
                    else
                    {
                        show_alert(3,array('chưa tồn tai phương thức index'));
                    }
                }
             //tồn tại action   
            }
            else
            {
                $this->load->controller($this->_controller);

                if(class_exists($this->_controller))
                {
                    $this->_TD     = new $this->_controller;

                    //kiểm tra sự tồn tại của action trong class
                    if(!method_exists($this->_TD, $this->_action))
                    {
                        if(method_exists($this->_TD, 'index'))
                        {
                            $this->_TD->index();
                        }
                        else
                        {
                            $this->load->header();

                            show_alert(3,'chưa tồn tai phương thức index');

                            $this->load->footer();
                        }
                    }
                    else
                    {
                        if($this->_param2 != null)
                        {
                            $this->_action .= '(\''.$this->_param.'\',\''.$this->_param2.'\')';
                        }
                        else
                        {
                            $this->_action .= '(\''.$this->_param.'\')';
                        }

                        $strCode = '<?php $this->_TD->'.$this->_action . ' ?>';

                        eval('?>' .$strCode);
                    }
                    
                }
                else
                {
                    $this->_controller = DEFAULT_MODULE;

                    $this->load->controller($this->_controller);

                    new $this->_controller;
                }
            }
            
        }
    }
    
    
}

new TD_Router;
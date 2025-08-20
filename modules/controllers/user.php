<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */
 
if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class User extends TD_Controller{
 
    private $_listError = array(); 
 
    function __construct(){
        parent::__construct();
        $this->database();
        $this->load->model('muser');
        $this->Muser  = new Muser;
        $this->data['meta'] = array(
                                    'title'         => 'Hệ Thống Đăng Nhập |  TDBlog V3',
                                    'description'   => 'Hệ Thống Đăng Nhập |  TDBlog V3',
                                    'keyword'       => 'Hệ Thống Đăng Nhập |  TDBlog V3',
                                );
        $this->load->header($this->data['meta']);
        
    }
     function __destruct(){
        $this->load->footer($this->data['meta']);
     }

    function index() {
        if(isLogin() == true) {
            show_alert(4,array('Đã đăng nhập'));
        }else{
            show_alert(4,array('Nhập Thông Tin Đăng Nhập'));
            $this->load->view('user/form-login');
        }
    }
    
    function login() 
    {
        if(count($_POST)){
            $data["username"]        = (isset($_POST['username'])) ? cleanXSS($_POST['username']) : '';
            $data["password"]        = (isset($_POST['password'])) ? md5($_POST['password']) : '';
            $infoUser                = getInfo($data["username"], $data['password'],true);
            if(count($infoUser)){
                show_alert(1,array('Đăng nhập thành công'));
                $_SESSION['permission'] = true;
                $_SESSION['id_name']    = $infoUser['id'];
                $_SESSION['password']   = $infoUser['password'];
                $_SESSION['name']       = $infoUser['name'];
                $_SESSION['full_name']  = $infoUser['full_name'];
                if(isset($_POST['saveLogin'])){
                    setcookie('permission',1,time()+86400, '/');
                    setcookie('id_name',$_SESSION['id_name'],time()+86400, '/');
                    setcookie('name',$_SESSION['name'],time()+86400, '/');
                    setcookie('password',$infoUser['password'],time()+86400, '/');
                    setcookie('full_name',$_SESSION['full_name'],time()+86400, '/');
                }
            }else{
                show_alert(3,array('Tên đăng nhập không đúng'));
                $this->showForm(1);
            }
        }else{
            show_alert(4,array('Nhập Thông Tin Đăng Nhập'));
            $this->showForm(1);
        }
    }
    
    function register() 
    {
        global $configs;
        
        if($configs['more']['register'] == false)
        {
            show_alert(4, array('chức năng đăng kí bị khóa bởi admin'));
            exit();
        }
        
        if(!empty($_POST)){
            $data["full_name"]       = (isset($_POST['fullName'])) ? $_POST['fullName'] : '';
            $data["username"]        = (isset($_POST['username'])) ? $_POST['username'] : '';
            $data["password"]        = (isset($_POST['password'])) ? $_POST['password'] : '';
            $data["rePassword"]      = (isset($_POST['rePassword'])) ?$_POST['rePassword'] : '';
            $data["email"]           = (isset($_POST['email'])) ? $_POST['email'] : '';
            $data["sex"]             = (isset($_POST['sex'])) ? $_POST['sex'] : '';
            $data["captcha"]         = (isset($_POST['captcha'])) ? $_POST['captcha'] : '';
            
            if($data["full_name"] == null || mb_strlen($data["full_name"]) < 4 || mb_strlen($data["full_name"]) > 255) {
                $this->_listError[] = 'Họ và tên không hợp lệ';
            }
            if(count(getInfo($data["username"],'',false))){
                $this->_listError[] = 'Người dùng đã tồn tại';
            }
            if($data["username"] == null || strlen($data["username"]) < 4 || strlen($data["username"]) > 50) {
                $this->_listError[] = 'Tên đăng nhập không hợp lệ';
            }
            if($data["password"] == null || strlen($data["password"]) < 6 || strlen($data["password"]) > 100) {
                $this->_listError[] = 'Mật khẩu không hợp lệ';
            }
            if($data["rePassword"] == null || $data["rePassword"] != $data["password"]) {
                $this->_listError[] = '2 mật khẩu không khớp';
            }
            if(filter_var($data["email"], FILTER_VALIDATE_EMAIL) == false) {
                $this->_listError[] = 'Email không hợp lệ';
            }
            if($data['captcha'] != $_SESSION['captcha']){
                $this->_listError[] = 'Nhập mã xác nhận không hợp lệ';
            }
            
            if(count($this->_listError)){
                show_alert(2,$this->_listError);
                unset($this->_listError);
                $this->showForm(2);
            }else{
                $data["password"] = md5($data["password"]);
                $this->Muser->register($data);
                if(count(getInfo($data["username"]))){
                    show_alert(1,array('Đăng kí thành công'));
                }
            }
            
        }else{
            show_alert(4,array('Nhập Thông Tin Đăng Ký'));
            $this->showForm(2);
        }
    }
    
    function info($name){
        $infoUser  = getInfo($name);
        if(count($infoUser) < 1){
            show_alert(3,array('Người Dùng Không Tồn Tại'));
        }else{
            $this->load->view('user/info_user', $infoUser);
        }
    }
    
    function logout(){
        session_destroy();
        setcookie('permission',1,time()+86400, '/');
        setcookie('id_name','',time()-86400, '/');
        setcookie('name','',time()-86400, '/');
        setcookie('password','',time()-86400, '/');
        setcookie('full_name','',time()-86400, '/');
        show_alert(1,array('Đăng xuất thành công'));
        $this->showForm(1);
    }
    
    function change_info()
    {
        $infoUser  = getInfo($_SESSION['name'], $_SESSION['password'], true);
        if(!empty($_POST))
        {
            $data['id']              =  $infoUser['id'];
            $data["full_name"]       = (isset($_POST['fullName'])) ? $_POST['fullName'] : $_SESSION['full_name'];
            $data["username"]        = (isset($_POST['username'])) ? $_POST['username'] : $_SESSION['name'];
            $data["password_old"]    = (isset($_POST['password_old'])) ? $_POST['password_old'] : '';
            $data["password_new"]    = (isset($_POST['password_new'])) ?$_POST['password_new'] : '';
            $data["rePassword_new"]  = (isset($_POST['rePassword_new'])) ?$_POST['rePassword_new'] : '';
            $data["email"]           = (isset($_POST['email'])) ? $_POST['email'] : $infoUser["email"];
            $data["sex"]             = (isset($_POST['sex'])) ? $_POST['sex'] : $infoUser["sex"];
            
            if($data["full_name"] == null || mb_strlen($data["full_name"]) < 4 || mb_strlen($data["full_name"]) > 255) {
                $this->_listError[] = 'Họ và tên không hợp lệ';
            }
            if(count(getInfo($data["username"],'',false)) && $data["username"] != $_SESSION['name']){
                $this->_listError[] = 'Người dùng đã tồn tại';
            }
            if($data["username"] == null || strlen($data["username"]) < 4 || strlen($data["username"]) > 50) {
                $this->_listError[] = 'Tên đăng nhập không hợp lệ';
            }
            if(md5($data["password_old"]) != $_SESSION['password']) {
                $this->_listError[] = 'Mật khẩu không hợp lệ';
            }
            if($data["password_new"] == null) {
                $data["password_new"] = $data["password_old"];
            }else{
                if(strlen($data["password_new"]) < 6 || strlen($data["password_new"]) > 100) {
                    $this->_listError[] = 'mật khẩu mới quá ngắn';
                }
                if($data["rePassword_new"] == null || $data["rePassword_new"] != $data["password_new"]) {
                    $this->_listError[] = '2 mật khẩu mới không khớp';
                }
            }
            if(filter_var($data["email"], FILTER_VALIDATE_EMAIL) == false) {
                $this->_listError[] = 'Email không hợp lệ';
            }
            
            if(count($this->_listError)){
                show_alert(2,$this->_listError);
                unset($this->_listError);
            }else{
                $data["password_new"] = md5($data["password_new"]);
                $this->Muser->updateInfo($data);
                if(count(getInfo($data["username"]))){
                    show_alert(1,array('Thay đổi thông tin thành công'));
                }
            }
            
        }
        $this->load->view('user/change_info', $infoUser);
    }
    
    function showForm($type){
        if($type == 1){
            $this->load->view('user/form-login');
        }else{
            $this->load->view('user/form-register');
        }
    }
}
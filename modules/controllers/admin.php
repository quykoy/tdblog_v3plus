<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Admin extends TD_Controller{
 
    //thuộc tính lưu trữ danh sách lỗi
    private $_listError = array(),
            $Madmin; 
     
    function __construct()
    {
        parent::__construct();
        $this->load->model('madmin');
        $this->load->library('Lib.upload');
        $this->load->library('Lib.validate');
        $this->load->library('Lib.BBCode');
        $this->load->library('Lib.detect_devices');
        $this->load->library('Lib.watermark');
        
        $this->Madmin = new Madmin;
        
        $this->data['meta']       = array(
                                    'title'         => 'Admin Panel ',
                                    'description'   => 'Admin Panel ',
                                    'keyword'       => 'Admin Panel ',
                                );
        if(isLogin() == false){
            $this->load->header($this->data['meta']);
            show_alert(2,array('Bạn Không Quyền Vào Trang Này'));
            $this->load->footer($this->data['meta']);
            exit();
        }
    }
    
    function index()
    {
        $this->load->header($this->data['meta']);
        $this->load->view('admin/main');
        $this->load->footer($this->data['meta']);
    }
    
    //phương thức post bài mới
    function post()
    {
        $data_configs = parse_ini_file(__SYSTEMS_PATH . '/ini/main-config.ini', true);
        $this->load->library('Lib.image');
        $bbcode = new BBCode;
        $detect = new Detect_devices;

        $this->data['meta']['title']  = 'Đăng bài mới';
        $this->load->header($this->data['meta']);

        $data["id_parent"]['value'] = isset($_GET['param']) ? (cleanXSS($_GET['param']))/1 : 0;
        $check = $this->Madmin->checkExistsBlog($data["id_parent"]['value']);
        $data["id_parent"]['value'] = count($check) > 0 ? $data["id_parent"]['value'] : 0;

        if ($detect->isMobile()) {
            $data['editor'] = 'mobile';
        }else {
            $data['editor'] = 'pc';
        }
        
        $data["time"]['value']          =  time();
        $data["name"]['value']          =  (isset($_POST['name']))          ? addslashes(trim($_POST['name']))        : '';
        $data["id_category"]['value']   =  (isset($_POST['category']))      ? $_POST['category']                      : '';
        $data["id_author"]['value']     =  (isset($_POST['author']))        ? $_POST['author']                        : '';
        $data["content"]['value']       =  (isset($_POST['content']))       ? addslashes(trim(watermark::searchLinkImg($_POST['content'])))     : '';
        $data["description"]['value']   =  (isset($_POST['description']))   ? addslashes(trim($bbcode->notags($_POST['description']))) : '';
        $data["keyword"]['value']       =  (isset($_POST['keyword']))       ? addslashes(trim($bbcode->notags($_POST['keyword'])))     : '';
        $data["alias"]['value']         =  (isset($_POST['alias']) && $_POST['alias'] != null) ? convertString($_POST['alias']) : 'ten-bai-viet';
        $data["image"]['value']         =  (isset($_POST['image']))         ? addslashes(trim($_POST['image']))       : '';
        $data["tags"]['value']          =  (isset($_POST['tags']))         ? addslashes(trim($_POST['tags']))       : '';

        $data["name"]['title']          = 'Tên bài viết';
        $data["content"]['title']       = 'nội dung';
        $data["description"]['title']   = 'description';
        $data["keyword"]['title']       = 'keyword';

        if(isset($_FILES['image']['name']) && $_FILES['image']['name']  != null){
            $upload = new Uploadfile('image');
            $upload->setDirUpload('/publics/files/thumb');
            if($upload->upload() == true){
                $data["image"]['value']   = base_url().'/publics/files/thumb'.$upload->_fileName;
            }else{
                $this->_listError[] = 'Upload hình đại diện bị lỗi';
            }
        }

        $checkAlias             = $this->Madmin->checkAlias($data['alias']['value']);
        $data['listCategory']   = $this->Madmin->getListCategory();
        
        if(isset($_POST['save'])){
            $data["java"]['value'] = isset($_POST['java']) ? 1: 0;
            $data["android"]['value'] = isset($_POST['android']) ? 1: 0;
            $data["ios"]['value'] = isset($_POST['ios']) ? 1: 0;
            $data["wdp"]['value'] = isset($_POST['wdp']) ? 1: 0;
            $data["index"]['value'] = isset($_POST['index']) ? 1: 0;
            //validate data
            $validate   = new Validate($data);
            $validate->addRule('name', 'string', 4, 255)
                     ->addRule('content', 'string', 1);
            $validate->run();
            $this->_listError = $validate->getErrors();

            if($checkAlias > 0 || $data['alias']['value'] == null){
                $this->_listError[]      = 'Url bài viết không hợp lệ(có thể đã tồn tại)';
                $data["alias"]['value']  = convertString($data["name"]['value']);
            }

            if($data["id_category"]['value'] == 'false'){
                $this->_listError[]      = 'Chưa chọn chuyên mục';
            }

            if($data["image"]['value'] == null && $data["content"]['value'] != null){
                $data["image"]['value'] = getThumb(stripcslashes($data["content"]['value']));
                $fileName = end(explode('/', $data["image"]['value']));
                if($fileName != 'noimg.png'){
                    @copy($data["image"]['value'], __ROOT.'/publics/files/thumbnails/'.$fileName);
                    $data["image"]['value'] = base_url().'/publics/files/thumbnails/'.$fileName;
                }
            }
            $fileName = end(explode('/', $data["image"]['value']));
            if($fileName != 'noimg.png') {
                if(!strpos(base_url(), $data["image"]['value'])) {
                    @copy($data["image"]['value'], __ROOT.'/publics/files/thumbnails/'.$fileName);
                    $data["image"]['value'] = base_url().'/publics/files/thumbnails/'.$fileName;
                }
                $img = str_replace(base_url(), __SITE_PATH, $data["image"]['value']);
                $imagethumbnails = new Image($img);
                $data["image"]['value'] = $imagethumbnails->createThumb($img,$data_configs['blog']['thumb_width'],$data_configs['blog']['thumb_height'],'fit');
                $data['image']['value'] = str_replace(__SITE_PATH, base_url(), $data['image']['value']);
            }

            if($data["description"]['value'] == null && $data["content"]['value'] != null){
                $data["description"]['value'] = subWords($bbcode->notags($data["content"]['value']), 80);
            }
            if($data["keyword"]['value'] == null){
                $data["keyword"]['value'] = str_replace(' ', ',', $data["description"]['value']);
            }

            if(count($this->_listError)){
                show_alert(2,$this->_listError);
                unset($this->_listError);
                unset($_POST);
            }else{

                if($this->Madmin->insertBlog($data)){
                    show_alert(1,array('Đăng Bài Viết Thành Công, <a href="'.base_url().'/'.$data["alias"]['value'].'.html">Xem bài viết</a>'));
                    foreach ($data as $key => $value) {
                        if(isset($data[$key]['value']))
                            $data[$key]['value'] = '';
                    }
                }else{
                    show_alert(2,array('Đăng Bài Viết Thất Bại'));
                }
            }
        }
        $this->load->view('admin/post',$data);
        $this->load->footer($this->data['meta']);
        
    }
    
    function editpost($alias) 
    {
        $data_configs = parse_ini_file(__SYSTEMS_PATH . '/ini/main-config.ini', true);
        $this->load->library('Lib.image');
        $bbcode = new BBCode;
        $this->data['meta']['title']  = 'Chỉnh sửa bài viết';
        $this->load->header($this->data['meta']);
        
        $infoBlog   = $this->Madmin->getInfoBlog2($alias);
        if(!empty($infoBlog)){
            $infoBlog = $infoBlog[0];

            $data["main-alias"]['value']     = $infoBlog['alias'];
            $data["id"]['value']             = $infoBlog['id'];
            $data["time"]['value']           = $infoBlog['times'];
            $data["name"]['value']           = (isset($_POST['name']) )          ? addslashes(trim($_POST['name']))         : $infoBlog['title'];
            $data["id_category"]['value']    = (isset($_POST['category']))       ? $_POST['category']                       : $infoBlog['id_category'];
            $data["id_author"]['value']      = (isset($_POST['author']))         ? $_POST['author']                         : $infoBlog['id_author'];
            $data["content"]['value']        = (isset($_POST['content']))        ? addslashes(trim(watermark::searchLinkImg($_POST['content'])))      : $infoBlog['content'];
            $data["description"]['value']    = (isset($_POST['description']))    ? addslashes(trim($_POST['description']))  : $infoBlog['description'];
            $data["keyword"]['value']        = (isset($_POST['keyword']))        ? addslashes(trim($_POST['keyword']))      : $infoBlog['keyword'];
            $data["alias"]['value']          = (isset($_POST['alias']))          ? convertString(trim($_POST['alias']))     : $infoBlog['alias'];
            $data["image"]['value']          = (isset($_POST['image']))          ? addslashes(trim($_POST['image']))        : $infoBlog['image'];
            $data["tags"]['value']          = (isset($_POST['tags']))          ? addslashes(trim($_POST['tags']))        : $infoBlog['tags'];
            $data["likes"]['value']          = $infoBlog['likes'];
            $data["dislikes"]['value']       = $infoBlog['dislikes'];
            $data["views"]['value']          = $infoBlog['views'];
            $data["id_parent"]['value']      = (isset($_POST['id_parent']) )          ? addslashes(trim($_POST['id_parent']))         : $infoBlog['id_parent'];
            $data["java"]['value'] =         $infoBlog['java'];
            $data["android"]['value'] = $infoBlog['android'];
            $data["ios"]['value'] = $infoBlog['ios'];
            $data["wdp"]['value'] = $infoBlog['wdp'];
            $data["index"]['value'] = $infoBlog['index'];
            $data["name"]['title']           = 'Tên bài viết';
            $data["content"]['title']        = 'nội dung';
            $data["description"]['title']    = 'description';
            $data["keyword"]['title']        = 'keyword';

            if(isset($_FILES['image']['name']) && $_FILES['image']['name']  != null){
                $upload = new Uploadfile('image');
                $upload->setDirUpload('/publics/files/thumb');
                if($upload->upload() == true){
                    $data["image"]['value']   = base_url().'/publics/files/thumb/'.$upload->_fileName;
                }else{
                    $this->_listError[] = 'Upload hình đại diện bị lỗi';
                }
            }
            if(trim($data["image"]['value']) == '')
                $data["image"]['value'] = base_url().'/publics/images/noimg.png';
            if($data["image"]['value'] != $infoBlog['image']) {
                $fileName = end(explode('/', $data["image"]['value']));
                if($fileName != 'noimg.png') {
                    if(!strpos(base_url(), $data["image"]['value'])) {
                        @copy($data["image"]['value'], __ROOT.'/publics/files/thumbnails/'.$fileName);
                        $data["image"]['value'] = base_url().'/publics/files/thumbnails/'.$fileName;
                    }
                    $img = str_replace(base_url(), __SITE_PATH, $data["image"]['value']);
                    $imagethumbnails = new Image($img);
                    $data["image"]['value'] = $imagethumbnails->createThumb($img,$data_configs['blog']['thumb_width'],$data_configs['blog']['thumb_height'],'fit');
                    $data['image']['value'] = str_replace(__SITE_PATH, base_url(), $data['image']['value']);
                }

            }

            $data['listCategory']   = $this->Madmin->getListCategory();
            $checkAlias             = $this->Madmin->checkAlias($data['alias']['value']);
            if(isset($_POST['save'])){
                $data["id_parent"]['value'] = (cleanXSS($data["id_parent"]['value']))/1;
                if(($checkAlias > 0 || $data['alias']['value'] == null) && $data['alias']['value'] != $data['main-alias']['value']){
                    $this->_listError[] = 'Url bài viết không hợp lệ(có thể đã tồn tại)';
                    $data["alias"]['value']  = convertString($data['name']['value']);
                }

                if($data["id_category"]['value'] == 'false'){
                    $this->_listError[]      = 'Chưa chọn chuyên mục';
                }

                if($data["image"]['value'] == null && $data["content"]['value'] != null){
                    $data["image"]['value'] = getThumb(stripcslashes($data["content"]['value']));
                    $fileName = end(explode('/', $data["image"]['value']));
                    if($fileName != 'noimg.png'){
                        @copy($data["image"]['value'], __ROOT.'/publics/files/thumbnails/'.$fileName);
                        $data["image"]['value'] = base_url().'/publics/files/thumbnails/'.$fileName;
                    }
                }

                if($data["description"]['value'] == null && $data["content"]['value'] != null){
                    //$data["description"]['value'] = subWords($bbcode->notags($data["content"]['value']), 80);
                    $data["description"]['value'] = $bbcode->notags($data["content"]['value']);
                }
                if($data["keyword"]['value'] == null && $data["description"]['value'] != null){
                    $data["keyword"]['value'] = str_replace(' ', ',', $data["description"]['value']);
                }
                $data["java"]['value'] = isset($_POST['java']) ? 1: 0;
                $data["android"]['value'] = isset($_POST['android']) ? 1: 0;
                $data["ios"]['value'] = isset($_POST['ios']) ? 1: 0;
                $data["wdp"]['value'] = isset($_POST['wdp']) ? 1: 0;
                $data["index"]['value'] = isset($_POST['index']) ? 1: 0;
                //validate data
                $validate   = new Validate($data);
                $validate->addRule('name', 'string', 4, 255)
                         ->addRule('keyword', 'string', 4)
                         ->addRule('description', 'string', 4)
                         ->addRule('content', 'string', 1);
                $validate->run();
                $this->_listError = $validate->getErrors();

                if(count($this->_listError)){
                    show_alert(2,$this->_listError);
                    unset($this->_listError);
                    unset($_POST);
                }else{
                    if($this->Madmin->updateBlog($data)){
                        show_alert(1,array('Update Bài Viết Thành Công, <a href="'.base_url().'/'.$data["alias"]['value'].'.html">Xem bài viết</a>'));
                    }else{
                        show_alert(2,array('Chỉnh Sửa Bài Viết Thất Bại'));
                    }
                }
            }
            
            $this->load->view('admin/edit_post',$data);
        }else{
            show_alert(2,array('Bài viết không tồn tại'));
        }
        
        $this->load->footer($this->data['meta']);
    }

    function deletepost($alias)
    {

        $this->data['meta']['title']  = 'Xóa bài viết';
        
        $this->load->header($this->data['meta']);

        $checkAlias     = $this->Madmin->checkAlias($alias);
        $infoBlog       = $this->Madmin->getInfoBlog2($alias);

        if( $checkAlias <= 0 ) {
            $this->_listError[] = 'Bài viết không tồn tại';
        }

        if(count($this->_listError))
        {
                show_alert(2,$this->_listError);
                unset($this->_listError);
        }
        else
        {
            if(isset($_POST['delete'])){
            
                if($this->Madmin->deletePost($alias)){
                    $this->Madmin->unTickHot($infoBlog[0]['id']);
                    show_alert(1,array('Xóa Bài Viết Thành Công'));
                }else{
                    show_alert(3,array('Xóa Bài Viết Thất Bại'));
                }

            }else{
                $this->load->view('admin/delete_post', $infoBlog[0]);
            }
        }

        $this->load->footer($this->data['meta']);
    }

    public function addfile($alias)
    {
        $this->data['meta']['title']  = 'Thêm File Đính Kèm Cho Bài Viết';
        $this->load->header($this->data['meta']);
        $checkAlias = $this->Madmin->checkAlias($alias);
        $infoBlog   = $this->Madmin->getInfoBlog2($alias);

        if( $checkAlias <= 0 ) {
            $this->_listError[] = 'Bài viết không tồn tại';
        }

        if(count($this->_listError))
        {
                show_alert(2,$this->_listError);
                unset($this->_listError);
        }
        else
        {
            if(isset($_POST['addFile'])){
                $flag = false;
                if(isset($_FILES['file']['name']) && $_FILES['file']['name']  != null){
                    $upload = new Uploadfile('file');
                    $upload->setDirUpload('/publics/files/uploads');
                    $upload->rename();
                    if($upload->upload() == true){
                        show_alert(1,array('Upload file Thành Công'));
                        $data["file_name"] = ($_POST['file_name'] == null) ? $_FILES['file']['name'] : addslashes($_POST['file_name']);
                        $data["file_url"]  = base_url().'/publics/files/uploads/'.$upload->_fileName;
                        $data['id_blog']   = $_POST['id_blog'];
                        $data['times']     = time();
                        $data['download']  = 1;

                        if($this->Madmin->addFile($data)){
                            show_alert(1,array('Insert file vào csdl Thành Công'));
                            $flag = true;
                        }else{
                            show_alert(3,array('Insert file vào csdl Thất Bại'));
                        }

                    }else{
                        show_alert(3,$upload->_arrError);
                    }
                }elseif (isset($_POST['file']) && $_POST['file'] != 'http://') {
                	echo 2;
                        $data["file_name"] = ($_POST['file_name'] == null) ? end(explode('/', $_POST['file'])) : addslashes($_POST['file_name']);
                        $data["file_url"]  = $_POST['file'];
                        $data['id_blog']   = $_POST['id_blog'];
                        $data['times']     = time();
                        $data['download']  = 1;

                        if($this->Madmin->addFile($data)){
                            show_alert(1,array('Thêm file vào csdl Thành Công'));
                            $flag = true;
                        }else{
                            show_alert(3,array('Thêm file vào csdl Thất Bại'));
                        }
                }
                if($flag && isJava($data["file_url"])) {
                    $this->load->library('Lib.java');
                    $java = new java($data["file_url"]);
                    //$java->addLogo();
                    $java->addText();
                }
            }else{
                $this->load->view('admin/addfile', $infoBlog[0]);
            }
        }

        $this->load->footer($this->data['meta']);
    }

    public function editfile($id)
    {
        $this->data['meta']['title']  = 'Chỉnh Sửa File Đính Kèm Cho Bài Viết';
        $this->load->header($this->data['meta']);
        
        $detail_file = $this->Madmin->getDetailFile($id);

        if(!empty($detail_file)){
            if(isset($_POST['editFile'])){
                $flag = false;
                if(isset($_FILES['file']['name']) && $_FILES['file']['name']  != null){
                    $upload = new Uploadfile('file');
                    $upload->setDirUpload('/publics/files/uploads');
                    $upload->rename();
                    if($upload->upload() == true){
                        show_alert(1,array('Upload file Thành Công'));
                        $data['id']        = $detail_file['id'];
                        $data["file_name"] = ($_POST['file_name'] == null) ? $_FILES['file']['name'] : addslashes($_POST['file_name']);
                        $data["file_url"]  = base_url().'/publics/files/uploads/'.$upload->_fileName;
                        $data['id_blog']   = $_POST['id_blog'];
                        $data['times']     = time();
                        $data['download']  = 1;

                        if($this->Madmin->editFile($data)){
                            show_alert(1,array('Chỉnh Sửa Thành Công'));
                            $flag = true;
                        }else{
                            show_alert(3,array('Chỉnh Sửa Thất Bại'));
                        }

                    }else{
                        $this->_listError[] = 'Upload file bị lỗi';
                    }
                }elseif (isset($_POST['file']) && $_POST['file'] != 'http://') {

                        $data['id']        = $detail_file['id'];
                        $data["file_name"] = ($_POST['file_name'] == null) ? end(explode('/', $_POST['file'])) : addslashes($_POST['file_name']);
                        $data["file_url"]  = $_POST['file'];
                        $data['id_blog']   = $_POST['id_blog'];
                        $data['times']     = time();
                        $data['download']  = 1;

                        if($this->Madmin->editFile($data)){
                            show_alert(1,array('Chỉnh Sửa Thành Công'));
                            $flag = true;
                        }else{
                            show_alert(3,array('Chỉnh Sửa Thất Bại'));
                        }
                }
                if($flag && isJava($data["file_url"])) {
                    $this->load->library('Lib.java');
                    $java = new java($data["file_url"]);
                    //$java->addLogo();
                    $java->addText();
                }
                $detail_file = $this->Madmin->getDetailFile($id);
            }

            $this->load->view('admin/edit_file', $detail_file);

        }else{
            show_alert(2, array('File không tồn tại'));
        }
        

        $this->load->footer($this->data['meta']);
    }
    
    public function deletefile($id)
    {
        $this->data['meta']['title']  = 'Chỉnh Sửa File Đính Kèm Cho Bài Viết';
        $this->load->header($this->data['meta']);
        $detail_file = $this->Madmin->getDetailFile($id);

        if(!empty($detail_file)){
            if(isset($_POST['delete'])){

                if($this->Madmin->deleteFile($id)){
                    show_alert(1,array('Xóa File Thành Công'));
                }else{
                    show_alert(3,array('Xóa File Thất Bại'));
                }
            }else{
                $this->load->view('admin/delete_file', $detail_file);
            }

        }else{
            show_alert(2, array('File không tồn tại'));
        }

        $this->load->footer($this->data['meta']);

    }

    public function tickhot($id_blog)
    {

        $this->data['meta']['title']  = 'Đánh dấu bài viết hot';
        $this->load->header($this->data['meta']);

        $checkAlias = $this->Madmin->checkID($id_blog);

        if( $checkAlias <= 0 ) {
            show_alert(2, array('Bài viết không tồn tại'));
        }else{
            
            if($this->Madmin->checkHot($id_blog)){

                show_alert(2, array('Bài viết đã có trong danh sách hot'));

            }else{

                if($this->Madmin->tickHot($id_blog)){
                show_alert(1, array('Đánh dấu bài viết hot thành công'));
                }else{
                    show_alert(3, array('Đánh dấu bài viết hot thất bại'));
                }
            }
        }
        $this->load->footer($this->data['meta']);
    }

    public function untickhot($id_blog)
    {

        $this->data['meta']['title']  = 'Hủy đánh dấu bài viết hot';
        $this->load->header($this->data['meta']);

        $checkAlias = $this->Madmin->checkID($id_blog);

        if( $checkAlias <= 0 ) {
            show_alert(2, array('Bài viết không tồn tại'));
        }else{
            if(count($this->Madmin->checkHot($id_blog))){

                if($this->Madmin->unTickHot($id_blog)){
                    show_alert(1, array('Hủy đánh dấu bài viết hot thành công'));
                }else{
                    show_alert(3, array('Hủy đánh dấu bài viết hot thất bại'));
                }

            }else{

                show_alert(2, array('Bài viết không có trong danh sách hot'));

            }
        }
        $this->load->footer($this->data['meta']);
    }

    public function manage_blog_host($type = '', $apply = '')
    {
        $this->data['meta']['title']  = 'Quản Lý Danh Sách Bài Viết Hot';
        $this->load->header($this->data['meta']);

        switch ($type) {
            case 'show_hidden':
                echo 'show_hidden';
                break;

            case 'delete_all':
                if($apply == 'ok'){
                    $this->Madmin->deleteAllHot();
                    show_alert(1, array('làm sạch danh sách hot thành công'));
                }else{
                    $this->load->view('admin/delete_all_hot');
                }
                break;
        }

        $this->load->view('admin/manage_blog_host');

        $this->load->footer($this->data['meta']);
    }

    public function general()
    {
        global $configs;

        $this->data['meta']['title']  = 'Cài đặt chung';
        $this->load->header($this->data['meta']);

        if(!empty($_POST))
        {

            $str_config ="[meta]\n\n";

            if($_POST['title'] != '') {
                $str_config .= "\t title    = '{$_POST['title']}'\n\n";
            }else{
                $str_config .= "\t title    = '{$configs['meta']['title']}'\n\n";
            }

            if($_POST['description'] != '') {
                $str_config .= "\t description    = '{$_POST['description']}'\n\n";
            }else{
                $str_config .= "\t description    = '{$configs['meta']['description']}'\n\n";
            }

            if($_POST['keyword'] != '') {
                $str_config .= "\t keyword    = '{$_POST['keyword']}'\n\n";
            }else{
                $str_config .= "\t keyword    = '{$configs['meta']['keyword']}'\n\n";
            }

            $str_config .="[blog]\n\n";
                $str_config .= "\t limit_blog           = {$configs['blog']['limit_blog']}\n\n";
                $str_config .= "\t limit_word           = {$configs['blog']['limit_word']}\n\n";
                $str_config .= "\t limit_blog_hot       = {$configs['blog']['limit_blog_hot']}\n\n";
                $str_config .= "\t view_blog_hot        = {$configs['blog']['view_blog_hot']}\n\n";
                $str_config .= "\t type_view_blog       = {$configs['blog']['type_view_blog']}\n\n";
                $str_config .= "\t type_view_blog_hot   = {$configs['blog']['type_view_blog_hot']}\n\n";
                $str_config .= "\t thumb_width   = {$configs['blog']['thumb_width']}\n\n";
                $str_config .= "\t thumb_height   = {$configs['blog']['thumb_height']}\n\n";

            $str_config .="[more]\n\n";

            if($_POST['chat'] == '1') {
                $str_config .= "\t chat  = true\n\n";
            }else{
                $str_config .= "\t chat  = false\n\n";
            }

            if($_POST['comment'] == '1') {
                $str_config .= "\t comment  = true\n\n";
            }else{
                $str_config .= "\t comment  = false\n\n";
            }
            
            if($_POST['comment_facebook'] == '1') {
                $str_config .= "\t comment_facebook  = true\n\n";
            }else{
                $str_config .= "\t comment_facebook  = false\n\n";
            }

            if($_POST['watermark_text'] != '') {
                $str_config .= "\t watermark_text    = '{$_POST['watermark_text']}'\n\n";
            }else{
                $str_config .= "\t watermark_text    = 'TDBlog'\n\n";
            }

            if($_POST['admin'] != '') {
                $str_config .= "\t admin    = '{$_POST['admin']}'\n\n";
            }else{
                $str_config .= "\t admin    = '{$configs['more']['admin']}'\n\n";
            }

            if($_POST['register'] == '1') {
                $str_config .= "\t register  = true\n\n";
            }else{
                $str_config .= "\t register  = false\n\n";
            }
            
            if($_POST['off_site'] == '1') {
                $str_config .= "\t off_site  = true\n\n";
            }else{
                $str_config .= "\t off_site  = false\n\n";
            }

            if($_POST['template_java'] != '') {
                $str_config .= "\t template_java    = '{$_POST['template_java']}'\n\n";
            }else{
                $str_config .= "\t template_java    = '{$configs['more']['template_java']}'\n\n";
            }

            if($_POST['template_smart'] != '') {
                $str_config .= "\t template_smart    = '{$_POST['template_smart']}'\n\n";
            }else{
                $str_config .= "\t template_smart    = '{$configs['more']['template_smart']}'\n\n";
            }

            if($_POST['template_pc'] != '') {
                $str_config .= "\t template_pc    = '{$_POST['template_pc']}'\n\n";
            }else{
                $str_config .= "\t template_pc    = '{$configs['more']['template_pc']}'\n\n";
            }
            
            if($_POST['import_image'] == '1') {
                $str_config .= "\t import_image  = true\n\n";
            }else{
                $str_config .= "\t import_image  = false\n\n";
            }

            if($_POST['watermark'] == '1') {
                $str_config .= "\t watermark  = true\n\n";
            }else{
                $str_config .= "\t watermark  = false\n\n";
            }

            @file_put_contents(__SYSTEMS_PATH . '/ini/main-config.ini', $str_config);
            show_alert(1, array('Cập nhật cấu hình thành công'));
        }

        $this->load->view('admin/general_settings');
        $this->load->footer($this->data['meta']);

    }

    public function cache($type = '', $apply = '')
    {
        global $configs;
        $this->data['meta']['title']  = 'Quản Lý Cache';
        $this->load->header($this->data['meta']);

        if(!empty($_POST))
        {

            $str_config ='';
            if($_POST['status'] == '1') {
                $str_config .= ";status cache\n status  = true\n\n";
            }else{
                $str_config .= ";status cache\n status  = false\n\n";
            }

            if($_POST['time'] == '' || $_POST['time'] == 0) {
                $str_config .= ";time create cache\n time    = 3600\n\n";
            }else{
                $str_config .= ";time create cache\n time    = {$_POST['time']}\n\n";
            }

            if($_POST['site'] == '') {
                $str_config .= ";array site cache\n site    = 'blog|index|category|'\n\n";
            }else{
                $str_config .= ";array site cache\n site    = {$_POST['site']}\n\n";
            }

            if($_POST['delete'] == '1'){
                $this->load->library('Lib.cache');
                $cache = new Cache($configs);
                $cache->deleteCache();
                show_alert(1, array('Xóa file cache cũ thành công'));
            }

            @file_put_contents(__SYSTEMS_PATH . '/ini/cache-config.ini', $str_config);
            show_alert(1, array('Cập nhật cấu hình cache thành công'));
        }

        $this->load->view('admin/cache_manage');
        $this->load->footer($this->data['meta']);
    }

    public function category($type = '', $param = '')
    {
        $this->load->model('mcategory');
        $this->Mcategory = new Mcategory;
        $data['listcategories'] = $this->Mcategory->getListCategory();
        switch ($type) 
        {

            case 'list':
                $this->data['meta']['title']  = 'Danh Sách Chuyên Mục';
                $this->load->header($this->data['meta']);
                $data = $this->Madmin->getListCategory();
                $this->load->view('admin/category-list', $data);
                break;

            case 'create':
                $this->data['meta']['title']  = 'Tạo Chuyên Mục';
                $this->load->header($this->data['meta']);

                $data["type_view"]['value']     =  (isset($_POST['type_view']))     ? addslashes($_POST['type_view'])        : 1;
                $data["name"]['value']          =  (isset($_POST['name']))          ? addslashes($_POST['name'])        : '';
                $data["parent"]['value']        =  (isset($_POST['parent']))        ? $_POST['parent']                  : '';
                $data["description"]['value']   =  (isset($_POST['description']))   ? addslashes($_POST['description']) : '';
                $data["keyword"]['value']       =  (isset($_POST['keyword']))       ? addslashes($_POST['keyword'])     : '';
                $data["alias"]['value']         =  (isset($_POST['alias']) && $_POST['alias'] != null) ? convertString($_POST['alias']) : 'ten-chuyen-muc';

                $data["name"]['title']          = 'Tên chuyên mục';
                $data["description"]['title']   = 'description';
                $data["keyword"]['title']       = 'keyword';

                if(isset($_POST['save'])){
                    $validate   = new Validate($data);
                    $validate->addRule('name', 'string', 3, 255)
                             ->addRule('description', 'string', 10, 255)
                             ->addRule('keyword', 'string', 10, 255);
                    $validate->run();

                    $this->_listError = $validate->getErrors();

                    $checkAlias       = $this->Madmin->checkCategory($data['alias']['value']);

                    if($checkAlias > 0 || $data['alias']['value'] == null){
                        $this->_listError[]         = 'Url chuyên mục không hợp lệ(có thể đã tồn tại)';
                        $data["alias"]['value']     = convertString($data["name"]['value']);
                    }

                    if(count($this->_listError)){
                        show_alert(2,$this->_listError);
                        unset($this->_listError);
                        unset($_POST);
                    }else{

                        if($this->Madmin->insertCategory($data)){
                           show_alert(1,array('Tạo Chuyên Mục Thành Công'));
                        }else{
                            show_alert(2,array('Tạo Chuyên Mục Thất Bại'));
                        }
                    }
                }
                $this->load->view('admin/category_create', $data);
                break;

            case 'edit':

                $this->data['meta']['title']  = 'Chỉnh Sửa Chuyên Mục';
                $this->load->header($this->data['meta']);

                $infoCategory = $this->Madmin->getInfoCategory($param);
                if(!empty($infoCategory)){

                    $data["id"]['value']            =  $infoCategory['id'];
                    $data["main_alias"]['value']    =  $infoCategory['alias'];
                    $data["name"]['value']          =  (isset($_POST['name']))          ? addslashes($_POST['name'])        : $infoCategory['name'];
                    $data["type_view"]['value']          =  (isset($_POST['type_view']))          ? addslashes($_POST['type_view'])        : $infoCategory['type_view'];
                    $data["parent"]['value']        =  (isset($_POST['parent']))        ? $_POST['parent']                  : $infoCategory['parent'];
                    $data["description"]['value']   =  (isset($_POST['description']))   ? addslashes($_POST['description']) : $infoCategory['description'];
                    $data["keyword"]['value']       =  (isset($_POST['keyword']))       ? addslashes($_POST['keyword'])     : $infoCategory['keyword'];
                    $data["alias"]['value']         =  (isset($_POST['alias']) && $_POST['alias'] != null) ? convertString($_POST['alias']) : $infoCategory['alias'];

                    $data["name"]['title']          = 'Tên chuyên mục';
                    $data["description"]['title']   = 'description';
                    $data["keyword"]['title']       = 'keyword';

                    $data['listCategory']   = $this->Madmin->getListCategory();
                    $checkAlias             = $this->Madmin->checkAlias($data['alias']['value']);
                    if(isset($_POST['save'])){
                        
                        //validate data
                        $validate   = new Validate($data);
                        $validate->addRule('name', 'string', 3, 255)
                                 ->addRule('description', 'string', 10, 255)
                                 ->addRule('keyword', 'string', 10, 255);
                        $validate->run();

                        $this->_listError = $validate->getErrors();

                        if(($checkAlias > 0 || $data['alias']['value'] == null) && $data['alias']['value'] != $data['main-alias']['value']){
                            $this->_listError[] = 'Url chuyên mục không hợp lệ(có thể đã tồn tại)';
                        }
                        if(count($this->_listError)){
                            show_alert(2,$this->_listError);
                            unset($this->_listError);
                            unset($_POST);
                        }else{
                            if($this->Madmin->updateCategory($data)){
                                show_alert(1,array('Chỉnh Sửa Chuyên Mục Thành Công'));
                            }else{
                                show_alert(2,array('Chỉnh Sửa Chuyên Mục Thất Bại'));
                            }
                        }
                    }
                    
                    $this->load->view('admin/category_edit', $data);
                }else{
                    show_alert(2,array('Bài viết không tồn tại'));
                }
                break;
            case 'delete':
                $this->data['meta']['title']  = 'Xóa Chuyên Mục';
                $this->load->header($this->data['meta']);
                $data = $this->Madmin->getInfoCategory($param);
                if(!empty($data)){
                    if(isset($_POST['delete'])){
                        if($this->Madmin->deleteCategory($param)){
                            show_alert(1, array('Xóa chuyên mục " ' . $data['name'] . ' " thành công'));
                        }else{
                            show_alert(2, array('Xóa chuyên mục thất bại'));
                        }
                    }else{
                        $this->load->view('admin/category_delete', $data);
                    }
                }else{
                    show_alert(2, array('Chuyên mục không tồn tại'));
                }
                break;

            default:
                $this->data['meta']['title']  = 'Quản Lý Chuyên Mục';
                $this->load->header($this->data['meta']);
                $this->load->view('admin/category-main');
                break;
        }

        $this->load->footer($this->data['meta']);
    }

    public function blog()
    {
        global $configs;
        $this->data['meta']['title']  = 'Quản Lý Blog';
        $this->load->header($this->data['meta']);

        if(!empty($_POST))
        {

            $str_config ="[meta]\n\n";
                $str_config .= "\t title    = '{$configs['meta']['title']}'\n\n";
                $str_config .= "\t description    = '{$configs['meta']['description']}'\n\n";
                $str_config .= "\t keyword    = '{$configs['meta']['keyword']}'\n\n";

            $str_config .="[blog]\n\n";

            if($_POST['limit_blog'] == '' || $_POST['limit_blog'] == 0 || !is_numeric($_POST['limit_blog'])) {
                $str_config .= "\t limit_blog    = {$configs['blog']['limit_blog']}\n\n";
            }else{
                $str_config .= "\t limit_blog    = {$_POST['limit_blog']}\n\n";
            }

            if($_POST['limit_word'] == '' || $_POST['limit_word'] == 0 || !is_numeric($_POST['limit_word'])) {
                $str_config .= "\t limit_word    = {$configs['blog']['limit_word']}\n\n";
            }else{
                $str_config .= "\t limit_word    = {$_POST['limit_word']}\n\n";
            }

            if($_POST['limit_blog_hot'] == '' || $_POST['limit_blog_hot'] == 0 || !is_numeric($_POST['limit_blog_hot'])) {
                $str_config .= "\t limit_blog_hot    = {$configs['blog']['limit_blog_hot']}\n\n";
            }else{
                $str_config .= "\t limit_blog_hot    = {$_POST['limit_blog_hot']}\n\n";
            }

            if($_POST['view_blog_hot'] == '1') {
                $str_config .= "\t view_blog_hot  = true\n\n";
            }else{
                $str_config .= "\t view_blog_hot  = false\n\n";
            }

            if(!empty($_POST['type_view_blog'])) {
                $str_config .= "\t type_view_blog  = {$_POST['type_view_blog']}\n\n";
            }else{
                $str_config .= "\t type_view_blog  = {$configs['blog']['type_view_blog']}\n\n";
            }

            if(!empty($_POST['type_view_blog_hot'])) {
                $str_config .= "\t type_view_blog_hot  = {$_POST['type_view_blog_hot']}\n\n";
            }else{
                $str_config .= "\t type_view_blog_hot  = {$configs['blog']['type_view_blog_hot']}\n\n";
            }

            if($_POST['thumb_width'] == '' || $_POST['thumb_width'] == 0 || !is_numeric($_POST['thumb_width'])) {
                $str_config .= "\t thumb_width    = {$configs['blog']['thumb_width']}\n\n";
            }else{
                $str_config .= "\t thumb_width    = {$_POST['thumb_width']}\n\n";
            }

            if($_POST['thumb_height'] == '' || $_POST['thumb_height'] == 0 || !is_numeric($_POST['thumb_height'])) {
                $str_config .= "\t thumb_height    = {$configs['blog']['thumb_height']}\n\n";
            }else{
                $str_config .= "\t thumb_height    = {$_POST['thumb_height']}\n\n";
            }

            $str_config .="[more]\n\n";
                $str_config .= "\t chat  = {$configs['more']['chat']}\n\n";
                $str_config .= "\t comment  = {$configs['more']['comment']}\n\n";
                $str_config .= "\t comment_facebook  = {$configs['more']['comment_facebook']}\n\n";
                $str_config .= "\t watermark_text  = {$configs['more']['watermark_text']}\n\n";
                $str_config .= "\t admin  = {$configs['more']['admin']}\n\n";
                $str_config .= "\t register  = {$configs['more']['register']}\n\n";
                $str_config .= "\t off_site  = {$configs['more']['off_site']}\n\n";
                $str_config .= "\t template_java = {$configs['more']['template_java']}\n\n";
                $str_config .= "\t template_smart = {$configs['more']['template_smart']}\n\n";
                $str_config .= "\t template_pc = {$configs['more']['template_pc']}\n\n";
                $str_config .= "\t import_image = {$configs['more']['import_image']}\n\n";
                $str_config .= "\t watermark = {$configs['more']['watermark']}\n\n";

            @file_put_contents(__SYSTEMS_PATH . '/ini/main-config.ini', $str_config);
            show_alert(1, array('Cập nhật cấu hình thành công'));
        }

        $this->load->view('admin/manage_blog');
        $this->load->footer($this->data['meta']);
    }

    function block_view($type = '', $id = '')
    {
        $this->load->model('mcategory');

        $this->Mcategory    = new Mcategory;

        $this->data['meta']['title']  = 'Quản Lý Khối Hiển Thị';
        $this->load->header($this->data['meta']);

        if($type == 'add')
        {
            $flag = false;
            if(isset($_POST['add']))
            {
                $dataBlockView = array(
                                    'id_category' => $_POST['id_category'],
                                    'type_view'   => (int)abs($_POST['type_view']),
                                    'limit'       => (int)abs($_POST['limit'])
                                );
                if($this->Madmin->addBlockView($dataBlockView)){
                    show_alert(1, array('Thêm Khối Hiển Thị Thành Công'));
                    $flag = true;
                }else{
                    show_alert(2, array('Thêm Khối Hiển Thị Thất Bại'));
                    $flag = false;
                }
            }
            
            if($flag == false){
                $listCategory = $this->Mcategory->getListCategory();
            $this->load->view('admin/add_block_view', $listCategory);
            }

        }elseif($type=='delete'){

            if($id == null || $id <= 0){
                redirect(base_url().'/admin/block_view');
            }else{
                if($this->Madmin->deleteBlockView($id)){
                    show_alert(1, array('Xóa 1 khối hiển thị thành công'));
                }else{
                    show_alert(2, array('Xóa 1 khối hiển thị thất bại'));
                }
            }

        }

        if(isset($_POST['save']))
        {
            foreach ($_POST['id_category'] as $key => $value) {
                $dataBlockView = array(
                                    'id_category' => $value,
                                    'type_view'   => $_POST['type_view'][$key],
                                    'limit'       => (int)abs($_POST['limit'][$key]),
                                    'id'          => $_POST['id'][$key]
                                );

                $this->Madmin->updateBlockView($dataBlockView);
            }
            show_alert(1, array('Cập Nhật Thành Công'));
        }
        $data['block_view'] = $this->Madmin->getListBlockView();
        $data['list_category'] = $this->Madmin->getListCategory();
        $this->load->view('admin/manage_block_view', $data);

        $this->load->footer($this->data['meta']);
    }

    public function java()
    {
        global $configs;
        $this->data['meta']['title']  = 'Cấu hình java';
        $this->load->header($this->data['meta']);

        if(!empty($_POST))
        {
            $str_config = '';
            if($_POST['Vendor'] == '') {
                $str_config .= "\t Vendor    = {$configs['blog']['Vendor']}\n\n";
            }else{
                $str_config .= "\t Vendor    = {$_POST['Vendor']}\n\n";
            }

            if($_POST['Description'] == '') {
                $str_config .= "\t Description    = {$configs['blog']['Description']}\n\n";
            }else{
                $str_config .= "\t Description    = {$_POST['Description']}\n\n";
            }

            if($_POST['Info-URL'] == '') {
                $str_config .= "\t Info-URL    = {$configs['blog']['Info-URL']}\n\n";
            }else{
                $str_config .= "\t Info-URL    = {$_POST['Info-URL']}\n\n";
            }

            if($_POST['Delete-Confirm'] == '') {
                $str_config .= "\t Delete-Confirm    = {$configs['blog']['Delete-Confirm']}";
            }else{
                $str_config .= "\t Delete-Confirm    = {$_POST['Delete-Confirm']}";
            }

            @file_put_contents(__SYSTEMS_PATH . '/ini/java.ini', $str_config);
            show_alert(1, array('Cập nhật cấu hình thành công'));
        }

        $this->load->view('admin/config_java');
        $this->load->footer($this->data['meta']);
    }
}


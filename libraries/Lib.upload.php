<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Uploadfile {
    
    public  $_fileName,
            $_tmp,
            $_fileSize,
            $_fileExtension,
            $_arrError      = array(),
            $_dirUpload,
            $_arrExtensions = array('jpg', 'png', 'gif', 'zip', 'jar', 'jad', 'rar', 'apk', 'sis', 'sisx', 'nth', 'txt', 'mp3', 'm4a', 'wav', 'midi', 'mp4', '3gp', 'avi'),
            $_min_size      = 1,
            $_max_size      = 10485760,//1mb = 1048576
            $_rename        = false;
    
    /**
     * phương thức khởi tạo
     * $nameForm: tên ô input upload
     */
    public function __construct($nameForm){
        $fileUpload              = $_FILES[$nameForm];
        $this->_fileName         = $fileUpload['name'];
        $this->_fileSize         = $fileUpload['size'];
        $this->_tmp              = $fileUpload['tmp_name'];
        $this->_fileExtension    = $this->getExtension($this->_fileName);
    }
    
    /**
     * phương thức lấy phần mở rộng tệp tin
     * $fileName: đường dẫn file 
     */
    public function getExtension($fileName){
        return pathinfo($this->_fileName,PATHINFO_EXTENSION);
    }
    
    /**
     * phương thức thiết lập phần mở rộng tệp tin
     * $arrExtensions: mảng lưu trữ phần mở rộng tệp tin cho phép upload
     */
    public function setExtensions($arrExtensions){
        $this->_arrExtensions =$arrExtensions;
    }
    
    /**
     * phương thức thiết lập kích thước tối thiểu và kích thước tối đa cho phép upload
     * $min_size: kích thước tối thiểu (số bye) , mặc định 1bye
     * $max_size: kích thước tối đa (số bye) , mặc định 5Mb
     */
    public function setSizeUpload($min_size, $max_size){
       $this->_min_size = $min_size; 
       $this->_max_size = $max_size;
    }
    
    /**
     * phương thức thiết lập thư mục upload
     * $dir: đường dẫ thư mục upload
     */
    public function setDirUpload($dir){
        $this->_dirUpload = __ROOT.$dir;
    }
    
    /**
     * phương thức cho phép đổi tên file khi upload
     * $dir: đươgn dẫ thư mục upload
     */
     function rename($value = null){
        $value           = ($value != null) ? $value : time();
        $this->_rename   = true;
        $this->_fileName = $value.'_'.$this->_fileName;
     }    
    
    /**
     * phương thức kiểm tra tính hợp lệ của tệp tin trước khi upload
     */
    public function validate(){
        if($this->_fileName == null){
            $this->_arrError[] = 'tên file rỗng';
        }
        if(empty($this->_arrExtensions)){
            $this->_arrError[] = 'chưa thiết lập extension';
        }
        if($this->_dirUpload == null || !file_exists($this->_dirUpload)){
            $this->_arrError[] = 'thư mục upload không tồn tại';
        }
        if(!empty($this->_arrExtensions) && in_array(strtolower($this->_fileExtension), $this->_arrExtensions) == false){
            $this->_arrError[] = 'phần mở rộng file không hợp lệ';
        }
        // if($this->_fileSize < $this->_min_size || $this->_fileSize > $this->_max_size){
        //     $this->_arrError[] = 'kích thước file không hợp lệ';
        // }
    }
    
    /**
     * phương thức tiến hành upload
     */
    public function upload(){
        $this->validate();
        if(empty($this->_arrError)){
            $this->_fileName = convertString(pathinfo($this->_fileName,PATHINFO_FILENAME)).'.'.pathinfo($this->_fileName,PATHINFO_EXTENSION);
            @copy($this->_tmp, $this->_dirUpload.'/'.$this->_fileName);
            return true;
        }
        return false;
    }
}
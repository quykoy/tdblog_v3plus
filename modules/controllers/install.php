<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */
 
if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Install extends TD_Controller{
    
    function __construct()
    {
        parent::__construct();
        $this->database();
    }
    
    function index()
    {
        $this->db->query("CREATE TABLE IF NOT EXISTS `blogs` (
                              `id` INT NOT NULL AUTO_INCREMENT,
                              `id_author` INT NOT NULL,
                              `id_category` INT NOT NULL,
                              `title` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                              `content` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                              `description` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                              `keyword` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                              `times` INT NULL,
                              `image` VARCHAR(255) NULL,
                              `likes` INT NULL DEFAULT 1,
                              `dislikes` INT NULL DEFAULT 1,
                              `views` INT NULL DEFAULT 1,
                              `alias` VARCHAR(255) NOT NULL,
                              PRIMARY KEY (`id`),
                              INDEX `fk_blogs_categories1_idx` (`id_category` ASC))
                            ENGINE = MyISAM
                            DEFAULT CHARACTER SET = utf8
                            COLLATE = utf8_general_ci"
                        );
                        
        $this->db->query("CREATE TABLE IF NOT EXISTS `categories` (
                              `id` INT NOT NULL AUTO_INCREMENT,
                              `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                              `description` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                              `keyword` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                              `parent` INT NOT NULL DEFAULT 0,
                              `alias` VARCHAR(255) NOT NULL,
                              PRIMARY KEY (`id`, `alias`))
                            ENGINE = MyISAM
                            DEFAULT CHARACTER SET = utf8
                            COLLATE = utf8_general_ci"
                        );
                        
    
                        
        $this->db->query("CREATE TABLE IF NOT EXISTS `files` (
                          `id` INT NOT NULL AUTO_INCREMENT,
                          `id_blog` INT NOT NULL,
                          `file_name` VARCHAR(255) NOT NULL,
                          `file_url` VARCHAR(255) NOT NULL,
                          `download` INT NULL,
                          `times` INT NULL,
                          PRIMARY KEY (`id`))
                        ENGINE = InnoDB
                        DEFAULT CHARACTER SET = utf8
                        COLLATE = utf8_general_ci"
                        );
                        
        $this->db->query("CREATE TABLE IF NOT EXISTS `users` (
                              `id` INT NOT NULL AUTO_INCREMENT,
                              `name` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                              `password` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                              `full_name` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                              `sex` TINYTEXT NULL COMMENT '0 :girl, 1: boy',
                              `email` VARCHAR(50) NULL,
                              `level` INT NULL DEFAULT 1,
                              PRIMARY KEY (`id`))
                            ENGINE = MyISAM
                            DEFAULT CHARACTER SET = utf8
                            COLLATE = utf8_general_ci"
                        );
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `comments` (
                          `id` INT NOT NULL AUTO_INCREMENT,
                          `id_blog` INT NOT NULL,
                          `author` VARCHAR(100) NOT NULL,
                          `comment` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                          `times` INT NULL,
                          PRIMARY KEY (`id`),
                          INDEX `fk_comments_users1_idx` (`id_blog` ASC),
                          INDEX `fk_comments_blogs1_idx` (`author` ASC))
                        ENGINE = MyISAM
                        DEFAULT CHARACTER SET = utf8
                        COLLATE = utf8_general_ci"
                        );    
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `chats` (
                          `id` INT NOT NULL AUTO_INCREMENT,
                          `author` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                          `content` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL,
                          `times` INT NULL,
                          PRIMARY KEY (`id`))
                        ENGINE = MyISAM
                        DEFAULT CHARACTER SET = utf8
                        COLLATE = utf8_general_ci"
                        );    
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `blogs_by_categories` (
                          `id` INT NOT NULL AUTO_INCREMENT,
                          `id_category` INT NULL,
                          `type_view` INT NULL,
                          `limit` INT NULL,
                          PRIMARY KEY (`id`))
                        ENGINE = MyISAM
                        DEFAULT CHARACTER SET = utf8
                        COLLATE = utf8_general_ci"
                        );    
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `blogs_hot` (
                          `id` INT NOT NULL AUTO_INCREMENT,
                          `id_blog` INT NOT NULL,
                          PRIMARY KEY (`id`),
                          INDEX `fk_blogs_hot_blogs1_idx` (`id_blog` ASC),
                          CONSTRAINT `fk_blogs_hot_blogs1`
                            FOREIGN KEY (`id_blog`)
                            REFERENCES `blogs` (`id`)
                            ON DELETE NO ACTION
                            ON UPDATE NO ACTION)
                        ENGINE = MyISAM
                        DEFAULT CHARACTER SET = utf8
                        COLLATE = utf8_general_ci"
                        );    
        
        $this->db->query("INSERT INTO `categories` (`name`, `description`, `keyword`, `parent`, `alias`) VALUES ('Chuyên Mục Mặc Định', 'Chuyên Mục Mặc Định', 'Chuyên Mục Mặc Định', '0', 'chuyen-muc-mac-dinh')");    
        $this->db->query("INSERT INTO `categories` (`name`, `description`, `keyword`, `parent`, `alias`) VALUES ('Chuyên Mục Con 1', 'Chuyên Mục Con 1', 'Chuyên Mục Con 1', '1', 'chuyen-muc-con-1')");
        $this->db->query("INSERT INTO `categories` (`name`, `description`, `keyword`, `parent`, `alias`) VALUES ('Chuyên Mục Con 2', 'Chuyên Mục Con 2', 'Chuyên Mục Con 2', '1', 'chuyen-muc-con-2')");  
        $this->db->query("INSERT INTO `categories` (`name`, `description`, `keyword`, `parent`, `alias`) VALUES ('Game', 'Chuyên Mục game', 'Chuyên Mục game', '0', 'game')");
        $this->db->query("INSERT INTO `categories` (`name`, `description`, `keyword`, `parent`, `alias`) VALUES ('Game Online', 'Chuyên Mục game Online', 'Chuyên Mục game Online', '4', 'game-online')");
        $this->db->query("INSERT INTO `categories` (`name`, `description`, `keyword`, `parent`, `alias`) VALUES ('Game Offline', 'Chuyên Mục game offline', 'Chuyên Mục game offline', '4', 'game-offline')");
        $this->db->query("INSERT INTO `categories` (`name`, `description`, `keyword`, `parent`, `alias`) VALUES ('Truyện', 'Chuyên Mục truyện', 'Chuyên Mục truyện', '0', 'truyen')");

        $this->db->query("INSERT INTO `users` (`name`, `password`, `full_name`, `sex`, `email`, `level`) VALUES ('admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '1', 'email@gmail.com', '1')");    
        
        $this->db->query("INSERT INTO `blogs` (`id_author`, `id_category`, `title`, `content`, `description`, `keyword`, `times`, `image`, `likes`, `dislikes`, `views`, `alias`) VALUES ('1', '1', 'Cài đặt thành công mã nguồn TDBlog Version 3.0', '[b][color=red]Cài đặt thành công mã nguồn TDBlog Version 3.0[/color][/b]

                        [b]xin chức mừng bạn đã cài đặt thành công mã nguồn TDBlog Version 3.0 được viết bới Vũ Tiến Định[/b]
                        
                        [b]Thông tin mã nguồn:[/b]
                         - Tên mã nguồn: TDBlog
                         - Tác giả : Vũ Tiến Định
                         - Phiên bản: 3.0
                         - Ngôn ngữ lập trình: PHP, HTML, CSS, JAVASCRIPT
                         - Cơ sở dữ liệu: MYSQL
                         - Hướng lập trình: OOP + MVC ( object oriented programming + model control view)
                        
                        [b]Sơ lược[/b] : TDBlog version 3.0 được phát triển theo hướng oop và mvc nên làm cho mã nguồn trở nên chuyên nghiệp hơn và dễ dàng tùy biến hơn
                        
                        [b]Tính Năng:[/b]
                         [b]- Blog:[/b]
                        	+ Hỗ trợ đăng bài băng html và bbcode
                        	+ url thân thiện , không có id ( dạng ten-bai-viet.html có thể chỉnh sửa ) 
                        	+ Auto đóng dấu ảnh trong bài viết ( cài đặt chữ đóng dấu trong admin panel )
                        	+ Tự động lấy hình ảnh đầu tiên có trong nội dung làm thumbnail
                        	+ tất cả hình ảnh trong bài viết sẽ được import vào host
                        	+ Bình luận trong bài viết ( sử dụng chức năng bình luận của TDBlog hoặc của facebook )
                        	+ Nút like + chia sẻ lên facebook
                        	+ Chức năng tick hot ( untick hot ) : thêm (loại bỏ) bài viết trong danh sách bài viết hot
                        	+ Chức năng add file: thêm file đính kèm cho bài viết
                        	+ Chức năng phân trang bài viết theo ký tự ( không bị lỗi chữ khi phân trang )
                        	+ Hiển thị bài viết cùng chuyên mục dưới mỗi bài viết
                         [b]- Tổng quát:[/b]
                        	+ hỗ trợ cache ( giúp trang của bạn load nhanh hơn )
                        	+ Tùy chọn kiểu hiển thị :
                        		● kiểu danh sách : hiển thị tên bài viết
                        		● kiểu game: hiển thị tên bài viết, thumbnail, thời gian đang bài và lượt xem
                        		● kiểu truyện: hiển thị tên bài viết, thumbnail, thời gian đang bài, lượt xem và mô tả bài viết
                        	+ chức năng hiển thị bài viết hot (hiển thị bài viết có trong danh sách hot ) có thể cài đặt trong admin panel
                        	+ chức năng hiển thị bài viết theo từng chuyên mục ngoài index ( cài đặt trong admin panel 
                        	+ chức năng phòng chát
                        	+ chức năng tìm kiếm , tag
                        	+ tool leech truyện ở trang Doctruyen360.com ( trong quá trình sử dụng mình sẽ phát triển thêm nhiều tool leech )
                        	... và nhiều chức năng khác
                        	
                        [b]Liên hệ & Hỗ trợ:[/b]
                        	-email : tiendinh595@gmail.com
                        	-facebook: fb.com/djnh.it
                        	-group facebook: fb.com/groups/tdblog
                        	', 'tdblog, mã nguồn tdblog', 'tdblog, mã nguồn tdblog', '1410680191', 'http://tiendinh.name.vn/publics/images/noimg.png', '1', '0', '1', 'cai-dat-thanh-cong-tdblog')
                            ");
                            
        redirect(base_url().'/cai-dat-thanh-cong-tdblog.html');
    
    }
}
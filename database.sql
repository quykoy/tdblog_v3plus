-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2015 at 11:46 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tdblog_v3`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) NOT NULL,
  `id_author` int(11) NOT NULL,
  `id_category` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  `description` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `times` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT '1',
  `dislikes` int(11) DEFAULT '1',
  `views` int(11) DEFAULT '1',
  `alias` varchar(255) NOT NULL,
  `id_parent_copy1` int(11) DEFAULT '0',
  `status` int(3) DEFAULT '0',
  `java` int(11) DEFAULT NULL,
  `android` int(11) DEFAULT NULL,
  `wdp` int(11) DEFAULT NULL,
  `ios` int(11) DEFAULT NULL,
  `id_parent` int(11) DEFAULT '0',
  `tags` text,
  `index` int(11) DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `id_author`, `id_category`, `title`, `content`, `description`, `keyword`, `times`, `image`, `likes`, `dislikes`, `views`, `alias`, `id_parent_copy1`, `status`, `java`, `android`, `wdp`, `ios`, `id_parent`, `tags`, `index`) VALUES
(1, 1, 1, 'Cài đặt thành công mã nguồn TDBlog Plus', '[b]Chúc mừng bạn đã cài đặt thành công mã nguồn TDBlog Plus ![/b]\r\n[b]Thông tin mã nguồn[/b]\r\n<ul>\r\n	<li>@name: TDBlog</li>\r\n 	<li>@version: 3.0 plus</li>\r\n 	<li>@Author: Vũ Tiến Định</li>\r\n 	<li>@Email: tiendinh595@gmail.com</li>\r\n	<li>@fb: http://fb.com/djnh.it</li>\r\n	<li>@Website: http://tiendinh.name.vn</li>\r\n</ul>\r\nđây là phiên bản thương mại được xây dựng và phát triển bởi [b]Vũ Tiến Định[/b] <br>\r\nvới đầy đủ các tính năng cho 1 wap đa tiện ích cho mobile như\r\n- đóng dấu bản quyền vào file jar,tự độnng tạo file jad từ jar <br>\r\n- tool leech truyện, game, thủ thuật, hình ảnh đa đạng<br>\r\n- post truyện theo chapter<br>\r\n- tự động tạo tag bài viết , và có tag thủ công giúp seo tốt hơn<br>\r\n- tự động lưu ảnh về host, đóng dấu ảnh (có thể bật tắt trong admin cp)<br>\r\n- chức năng cache giúp wap bạn load nhanh hơn (có thể bật tắt)<br>\r\n- có 4 loại hiển thị cho wap bao gồm kiểu danh sách , kiểu game , kiểu truyện và kiểu smartphone<br>\r\n- thiết lập kiểu hiển thị cho từng chuyên mục<br>\r\n- dễ dàng đưa bài viết của 1 chuyên mục nào đó ra ngoài index<br>\r\n- fix tối đa w3c giúp seo tốt hơn<br>\r\n- hỗ trợ post bài bằng html và bbcode<br>\r\n- tự động tạo site map<br>\r\n- resize thumb theo kích thước thiết lập trong admin cp....<br>\r\nvà nhiều tính năng khác đang đợi bạn trải nghiệm :)', 'Cài đặt thành công mã nguồn TDBlog Plus', 'Cài đặt thành công mã nguồn TDBlog Plus', 1437297325, 'http://nam.name.vn/publics/images/noimg.png', 1, 0, 7, 'cai-dat-thanh-cong-ma-nguon-tdblog-plus', 0, 0, 0, 0, 0, 0, 0, 'tdblog, tdblog plus, mã nguồn tdblog', 1);

-- --------------------------------------------------------

--
-- Table structure for table `blogs_by_categories`
--

CREATE TABLE IF NOT EXISTS `blogs_by_categories` (
  `id` int(11) NOT NULL,
  `id_category` int(11) DEFAULT NULL,
  `type_view` int(11) DEFAULT NULL,
  `limit` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `blogs_hot`
--

CREATE TABLE IF NOT EXISTS `blogs_hot` (
  `id` int(11) NOT NULL,
  `id_blog` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `alias` varchar(255) NOT NULL,
  `type_view` int(11) DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `keyword`, `parent`, `alias`, `type_view`) VALUES
(1, 'Chuyên mục mặc định', 'Chuyên mục mặc định', 'Chuyên mục mặc định', 0, 'chuyen-muc-mac-dinh', 2);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE IF NOT EXISTS `chats` (
  `id` int(11) NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `content` text,
  `times` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `id_blog` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  `comment` text,
  `times` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL,
  `id_blog` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `download` int(11) DEFAULT NULL,
  `times` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `onlines`
--

CREATE TABLE IF NOT EXISTS `onlines` (
  `id` int(11) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `id_user` int(11) DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `time` int(11) NOT NULL,
  `browser` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `sex` tinytext COMMENT '0 :girl, 1: boy',
  `email` varchar(50) DEFAULT NULL,
  `level` int(11) DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `full_name`, `sex`, `email`, `level`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '1', 'admin@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_blogs_categories1_idx` (`id_category`);

--
-- Indexes for table `blogs_by_categories`
--
ALTER TABLE `blogs_by_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs_hot`
--
ALTER TABLE `blogs_hot`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_blogs_hot_blogs1_idx` (`id_blog`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`,`alias`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_comments_users1_idx` (`id_blog`), ADD KEY `fk_comments_blogs1_idx` (`author`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `onlines`
--
ALTER TABLE `onlines`
  ADD PRIMARY KEY (`id`,`time`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `blogs_by_categories`
--
ALTER TABLE `blogs_by_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `blogs_hot`
--
ALTER TABLE `blogs_hot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `onlines`
--
ALTER TABLE `onlines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

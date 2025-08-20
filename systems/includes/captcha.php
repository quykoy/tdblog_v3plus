<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */
 

session_start();

header('Content-type: image/jpeg');
        
$captcha    = imagecreate(100,30);

imagecolorallocate($captcha, 153, 204, 255);

$content    = substr(md5(time()), 0, 6);

$_SESSION['captcha'] = $content;

imagettftext($captcha, 13, 0, 20, 20, imagecolorallocate($captcha, 0, 4, 5), '../fonts/captcha.ttf', $content);

imagejpeg($captcha);

imagedestroy($captcha);
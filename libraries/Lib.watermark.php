<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

Class watermark
{
    static function watermark_text($url)
    {
        global $configs;
        $out=$url;
        $size = getimagesize($url);
        $w =$size[0];$h=$size[1];
        $type =$size[2];
        switch ($type) {
            case  '2':
                $img  = imagecreatefromjpeg($url);
                break;
            case  '1':
                $img  = imagecreatefromgif($url);
                break;
            case  '3':
                $img  = imagecreatefrompng($url);
                break;
            case  '6':
                $img  = imagecreatefromwbmp($url);
                break;
            default:
                $img  = imagecreatefromjpeg($url);
                break;
        }
        $new_h =$h+30;
        $source = @imagecreatetruecolor($w, $new_h);
        $color  = imagecolorallocate($source, 238, 238, 238);
        imagefill ($source, 0, 0, $color);
        $text_color =imagecolorallocate($source, 194, 194, 194);
        imagettftext ($source, 15, 0, 20, $h+20, $text_color, __SYSTEMS_PATH . '/fonts/captcha.ttf', $configs['more']['watermark_text']);
        imagecopy  ($source, $img, 0, 0, 0, 0, $w, $h);
        switch ( $type) {
            case  '2':
                @imagejpeg( $source, $out);
                break;
            case  '1':
                @imagegif ( $source, $out);
                break;
            case  '3':
                @imagepng ($source, $out);
                break;
            case  '6':
                @imagewbmp ( $source, $out);
                break;
            default:
                @imagejpeg ($source, $out);
                break;
        }
    }

    static  function searchLinkImg($text) {
        $data_configs = parse_ini_file(__SYSTEMS_PATH . '/ini/main-config.ini', true);
        if($data_configs['more']['import_image']) {
            $dir2 = __ROOT.'/publics/files/images/';
            preg_match_all('#<img.+?src="(.+?)".*?>#is',$text,$img);
            if(empty($img[0])){
                preg_match_all('#\[img](.+?)\[/img]#is', $text, $img);
            }

            if(!empty($img)) {
                for($i=0; $i < count($img[1]); ++$i) {
                    $inf = pathinfo($img[1][$i]);
                    $fname = $inf['basename'];
                    $fpath = $dir2.$fname;
                    if(!file_exists($fpath)){
                        $fname ='td-'.$inf['basename'];
                        $fpath = $dir2.$fname;
                        if(@copy($img[1][$i], $fpath)) {
                            if($data_configs['more']['watermark'])
                                self::watermark_text($fpath);
                            $relink = base_url().'/publics/files/images/'.$fname;
                            $text = str_replace($img[1][$i], $relink, $text);
                            @unlink($img[1][$i]);
                        }
                    }
                }
            }
        }
        return $text;
    }
}
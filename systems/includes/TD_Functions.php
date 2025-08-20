<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

if ( ! function_exists('isLogin'))
{
    function isLogin(){
        if(isset($_SESSION['permission']) && isset($_SESSION['name'])) {
            return true;
        }
        if(isset($_COOKIE['permission']) && isset($_COOKIE['name']) && isset($_COOKIE['password'])){
            $infoUser   = getInfo($_COOKIE['name'], $_COOKIE['password'],true);
            if(count($infoUser)){
                $_SESSION['permission'] = true;
                $_SESSION['id_name']       = $_COOKIE['id_name'];
                $_SESSION['name']       = $_COOKIE['name'];
                $_SESSION['full_name']  = $_COOKIE['full_name'];
                return true;
            }else{
                return false;
            }
        }
        return false;
    }
}

if ( ! function_exists('convertSize'))
{
    function convertSize($size){
        $array_units  = array('B', 'KB', 'MB', 'GB', 'TB');
        for($i = 0; $i < 5; $i++){
            if($size >= 1024){
                $size /= 1024;
            }else{
                $unit  = $size . ' ' . $array_units[$i];
                break;
            }
        }
        return $unit;
    }
}

if ( ! function_exists('getInfo'))
{
    function getInfo($name, $password = null, $checkFull = false){
        $sql        = 'SELECT id, name, full_name, level, email FROM users WHERE name=\''.$name.'\'';
        if($checkFull == true){
            $sql        = 'SELECT * FROM users WHERE name=\''.$name.'\' AND password =\''.$password.'\' ';
        }
        $query      = @mysql_query($sql);
        $infoUser   = array();
        while($data   = @mysql_fetch_assoc($query)){
            $infoUser = $data;
        }
        return $infoUser;
    }
}
if ( ! function_exists('show_404'))
{
    function show_404($text = 'Lỗi không tìm thấy trang')
    {
        echo '<div class="404">' . $text . '</div>';
    }
}

/**
     * param of function show_alert
     * -Int $typeError
     *  case 1: success
     *  case 2: warning
     *  case 3: error
     *  case 4: info
     *  case 5: help
     * -array $arrAlert
*/
if ( ! function_exists('show_alert'))
{
    function show_alert($typeAlert, $arrAlert)
    {
        switch ($typeAlert) {
            case '1':
                foreach($arrAlert as $error){
                    echo '<div class="alert success">
                        <p><strong> '.$error.'.</strong></p>
                        <p><a class="alert-close" href="javascript:void(0);">Close</a></p>
                    </div>';
                }       
                break;
                    
            case '2':
                foreach($arrAlert as $error){
                    echo '  <div class="alert warning">
                            <p><strong> '.$error.'.</strong></p>
                            <p><a class="alert-close" href="javascript:void(0);">Close</a></p>
                        </div>';
                }
                break;
        
            case '3':
                foreach($arrAlert as $error){
                    echo '<div class="alert error">
                            <p><strong> '.$error.'.</strong></p>
                            <p><a class="alert-close" href="javascript:void(0);">Close</a></p>
                            </div>';
                }
                break;
            case '4':
                foreach($arrAlert as $error){
                    echo '<div class="alert info">
                            <p><strong> '.$error.'.</strong></p>
                            <p><a class="alert-close" href="javascript:void(0);">Close</a></p>
                        </div>';
                }
                break;
            case '5':
                foreach($arrAlert as $error){
                    echo '<div class="alert help">
                            <p><strong> '.$error.'.</strong> </p>
                            <p><a class="alert-close" href="javascript:void(0);">Close</a></p>
                        </div>';
                }
                break;
        }
    }
}

/**
 * @param name 
 * @param content
 */
if ( ! function_exists('div'))
{
    function div($name, $content)
    {
        return '<div class="'.$name.'">'.$content.'</div>';
    }
}

/**
 * @param $link 
 * @param $alt
 */
if ( ! function_exists('image'))
{ 
    function image($link, $alt = null)
    {
        if($alt == null){
            $alt = 'hinh ' . $link;
        }
        return '<img src="'.__SITE_URL.'/publics/images/'.$link.'" alt="'.$alt.'" />';
    }
}


if (!function_exists('subWords')) 
{

    function subWords($str, $n = 10){
        $str = trim(preg_replace("/\s+/", " ", strip_tags($str)));

        $word_array = explode(" ", $str);

        if (count($word_array) <= $n)

            return implode(" ", $word_array);

        else {

            $str = '';
            foreach ($word_array as $length => $word) {

                $str .= $word;
                if ($length == $n) break;
                else $str .= " ";
            }
        }
        return $str;
    }
}

if (!function_exists('subStrings')) 
{

    function subStrings($str, $start, $end){
        $str    = stripcslashes($str);
        $length = mb_strlen($str, 'UTF-8'); 
        if($end >= $length){
            return $str;
        }else{
            return mb_substr($str, $start, $end, 'UTF-8');
        }
    }
}

if ( ! function_exists('tags'))
{
    function tags($data = array())
    {
        $text      = implode(' ', $data);
        $chuoi     = strip_tags($text);
        $arr       = explode(" ",$chuoi);
        $dem       = count($arr);
        $str       = '';
        for ($dem2 = 0; $dem2 < $dem; $dem2++)
        {
            $str .= '<a href="'.__SITE_URL.'/tags/'.$arr[$dem2].'.html">'.$arr[$dem2].'</a>, ';
        }
        echo $str;
    }
}


/**
 * param function breadcrumb
 * $arrValue is array
 * ex $array = array(
                    array(
                        'title'     => 'chuyên mục 1',
                        'link'      => 'chuyen-muc-1'
                    )
                );
 * 
 */
if ( ! function_exists('breadcrumb'))
{
    function breadcrumb($arrValue, $class = 'title_menu'){
        
        $result  = '<div class="'.$class.'">
                        <span itemtype="http://data-vocabulary.org/Breadcrumb" itemscope>
                            <a itemprop="url" href="'.__SITE_URL.'">
                                <span itemprop="title"><img src="'.__SITE_URL.'/publics/images/home.png" alt="trang chủ"> Trang chủ</span>
                            </a>
                        </span>';
                    
        foreach($arrValue as $value){
            $result .= ' > <span itemtype="http://data-vocabulary.org/Breadcrumb" itemscope>
                                <a itemprop="url" href="'.$value['link'].'">
                                    <span itemprop="title">'.$value['title'].'</span>
                                </a>
                            </span>';
            
        }
        $result .= '</div>';
        return $result;
    }
}

if ( ! function_exists('share'))
{
    function share($url)
    {
        $url = base_url().'/'.$url;
        echo '
        <!-- Facebook -->
        <a href="http://www.facebook.com/sharer.php?u='.$url.'" target="_blank" title="share facebook"><img src="'.__SITE_URL.'/publics/images/facebook.png" alt="faceboook"></a>
        
        <!-- Twitter -->
        <a href="http://twitter.com/share?url='.$url.'&text=Simple Share Buttons" target="_blank" title="share twitter"><img src="'.__SITE_URL.'/publics/images/twitter.png" alt="twitter"></a>
        
        <!-- Google+ -->
        <a href="https://plus.google.com/share?url='.$url.'" target="_blank" title="share google plus"><img src="'.__SITE_URL.'/publics/images/google.png" alt="google"></a>';
    }
}
if ( ! function_exists('redirect'))
{
    function redirect($url = null)
    {
        if(isset($url)){
            header('Location: '.$url);
        }else{
            header('Location: '.base_url());
        }        
    }
}

if ( ! function_exists('base_url'))
{
    function base_url()
    {
        return __SITE_URL;
    }
}

if ( ! function_exists('convertString'))
{
    function convertString($string = null){
        if($string == null){
            $string          = 'ten-bai-viet';
        }else{
            $a_str = array("ă", "ắ", "ằ", "ẳ", "ẵ", "ặ", "á", "à", "ả", "ã", "ạ", "â", "ấ", "ầ", "ẩ", "ẫ", "ậ", "Á", "À", "Ả", "Ã", "Ạ", "Ă", "Ắ", "Ằ", "Ẳ", "Ẵ", "Ặ", "Â", "Ấ", "Ầ", "Ẩ", "Ẫ", "Ậ" );
            $e_str = array("é","è","ẻ","ẽ","ẹ","ê","ế","ề","ể","ễ","ệ","É","È","Ẻ","Ẽ","Ẹ","Ê","Ế","Ề","Ể","Ễ","Ệ");
            $d_str = array("đ","Đ");
            $o_str = array("ó","ò","ỏ","õ","ọ","ô","ố","ồ","ổ","ỗ","ộ","ơ","ớ","ờ","ở","ỡ","ợ","Ó","Ò","Ỏ","Õ","Ọ","Ô","Ố","Ồ","Ổ","Ỗ","Ộ","Ơ","Ớ","Ờ","Ở","Ỡ","Ợ");
            $u_str = array("ú","ù","ủ","ũ","ụ","ư","ứ","ừ","ữ","ử","ự","Ú","Ù","Ủ","Ũ","Ụ","Ư","Ứ","Ừ","Ử","Ữ","Ự");
            $i_str = array("í","ì","ỉ","ị","ĩ","Í","Ì","Ỉ","Ị","Ĩ");
            $y_str = array("ý","ỳ","ỷ","ỵ","ỹ","Ý","Ỳ","Ỷ","Ỵ","Ỹ");
            $da_str = array("́","̀","̉","̃","̣");
            $string = str_replace($i_str,"i",$string);
            $string = str_replace($da_str,"",$string);
            $string = str_replace($y_str,"y",$string);
            $string = str_replace($a_str,"a",$string);
            $string = str_replace($e_str,"e",$string);
            $string = str_replace($d_str,"d",$string);
            $string = str_replace($o_str,"o",$string);
            $string = str_replace($u_str,"u",$string);
            $string=strtolower($string);
            $string=preg_replace('/[^a-z0-9]/',' ',$string);
            $string=preg_replace('/\s\s /',' ',$string);
            $string=trim($string);
            $string=str_replace(' ','-',$string);
        }
        return $string;
    }
}

if ( ! function_exists('getThumb'))
{
    function getThumb($str)
    {
        preg_match('#<img.+?src="(.+?)".*?>#is',$str,$thumb);
        $tt   =count($thumb);
        if($tt!=0)
            return end($thumb);
        else
        {
            preg_match('#\[img\](.+?)\[\/img\]#is',$str,$thumb);
            $tt    = count($thumb);
            if($tt != 0)
                return end($thumb);
        }
        return base_url().'/publics/images/noimg.png';
    }
}

if ( ! function_exists('convertTimeToString'))
{
    function convertTimeToString($time)
    {
        $distance = time() - $time;
        switch ($distance) {
            case ($distance < 60):
                $result = $distance . ' giây trước';
                break;
            case ($distance >= 60 && $distance < 3600):
                $result = round($distance/60) . ' phút trước';
                break;
            case ($distance >= 3600 && $distance < 86400):
                $result = round($distance/3600) . ' giờ trước';
                break;
            case (round($distance/86400) == 1):
                $result =  '1 ngày trước';
                break;
            default:
                $result =  date('d/m/y \l\ú\c H:s:i', $time);
                break;
        }
        return $result;
    }
}

if ( ! function_exists('isUser'))
{
    function isUser($name)
    {
        $name  = strip_tags($name);
        $sql   = "SELECT name FROM users WHERE name = '{$name}'";
        $query = mysql_query($sql);
        return mysql_num_rows($query);
    }
}
if ( ! function_exists('cleanXSS'))
{
    function cleanXSS($string){
        if(get_magic_quotes_gpc()){
            $string = stripslashes($string);
        }
        $string = mysql_real_escape_string($string);
        $string = strip_tags(str_replace(array("alert(\'","\');",), array('',''),$string));
        return $string;
    }
}

function createJad($file) {
    if(isJava($file)) {
        echo '| <a href="'.base_url().'/jad/create?url='.$file.'"><b>JAD</b></a>';
    }
}

function isJava($file) {
    $info = pathinfo($file);
    if($info['extension'] == 'jar') 
        return true;
    return false;
}
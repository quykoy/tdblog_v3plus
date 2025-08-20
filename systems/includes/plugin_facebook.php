<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */
 
if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');
 
function likeFacebook($url)
{
    echo '<div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=1455404044711559&version=v2.0";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, "script", "facebook-jssdk"));
        </script>';
    echo '<div class="fb-like" data-href="'.base_url().'/'.$url.'" data-width="100%" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>';
}

function commentFacebook($url)
{
    echo '<div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=1455404044711559&version=v2.0";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, "script", "facebook-jssdk"));
        </script>';
    echo '<div class="title_menu">Comment Facebook</div>';
    echo '<div class="fb-comments" data-href="'.base_url().'/'.$url.'" data-width="100%" data-numposts="5" data-colorscheme="light"></div>';
}
<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Database{
        
        function __construct(){
            $this->connect = @mysql_pconnect(__DB_HOST, __DB_USER, __DB_PASSWORD) or die ('can\'t connect to database');
    		//$this->connect = @mysql_pconnect('127.8.164.130','adminY8VrJkN','123456789') or die ('khÃ´ng thá»ƒ káº¿t ná»‘i tá»›i database');
            @mysql_query( 'SET names utf8');
            @mysql_select_db(__DB_NAME, $this->connect) or die('can\'t select database');
    	}
    	
    	function query( $sql ){
    		return @mysql_query( $sql );
    	}
        
    	function num_rows( $result){
    		return @mysql_num_rows( $result);
    	}
        
    	function insert_id(){
    		return @mysql_insert_id();
    	}
        
    	function fetch_assoc( $result ){
    		return @mysql_fetch_assoc( $result);
    	}
        
    	function result( $result, $start = 0 ){
    		return @mysql_result ( $result, $start);
    	}
        
    	function fetch_array( $result ){
    		return @mysql_fetch_array( $result);
    	}
        
    	function fetch_row( $result ){
    		return @mysql_fetch_row( $result);
    	}
}

?>
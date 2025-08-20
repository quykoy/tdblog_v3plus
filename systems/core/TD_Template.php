<?php
/**
 * @name: TDBlog
 * @version: 3.0 plus
 * @Author: Vũ Tiến Định
 * @Email: tiendinh595@gmail.com
 * @Website: http://tiendinh.name.vn
 */

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class TD_Template extends TD_Controller{

	public static $template_java,
	
				  $template_smart,
				  
				  $template_pc,
				  
				  $template;
	
	public function __construct()
	{
		global $configs;
		
		parent::__construct();
		
		self::$template_java	 = $configs['more']['template_java'];
		
		self::$template_smart 	 = $configs['more']['template_smart'];
		
		self::$template_pc 		 = $configs['more']['template_pc'];
		
		self::$template	 = $this->getTemplate();
	}
	
	public function getTemplate()
	{
		$this->load->library('Lib.detect_devices');
		
		$detect	= new Detect_devices;
		
		if($detect->isMobile())
			return self::$template_java;
		
		elseif($detect->isTablet())
			return self::$template_smart;
		 
		return self::$template_pc;
	}
	
}

new TD_Template;
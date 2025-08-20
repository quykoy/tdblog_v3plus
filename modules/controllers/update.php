<?php
/**
* @name: TDBlog
* @version: 3.0 plus
* @Author: Vũ Tiến Định
* @Email: tiendinh595@gmail.com
* @Website: http://tiendinh.name.vn
*/

if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class Update extends TD_Controller{

	private $dirUpdate;
	
	function __construct()
	{
		parent::__construct();
		
		$this->data['meta']['title'] = 'Update TDblog';
		
		$this->load->header($this->data['meta']);
		
		$this->dirUpdate = __ROOT . '/updates';
		
		if(empty($_SESSION['permission']))
		{
			redirect(base_url().'/user/login');
		}
	}
	
	function index()
	{
		$this->scanDir($this->dirUpdate, $listFiles);
		
		if(!empty($listFiles))
		{
			$error	= array();
			
			foreach ($listFiles as $file)
			{
				$dest	= str_replace('/updates', '', $file);
				
				if( !@copy($file, $dest) )
				{
					$dir = explode('/', $dest);

					$pos = count($dir)-2;

					$path = '';

					for($i=0; $i<=$pos; $i++)
					{
						$path .= $dir[$i].'/';
					}

					if(!file_exists($path))
					{
						mkdir(rtrim($path, '/'), 0755, true);
					}

					if( !@copy($file, $dest) )
					{
						$error[]	= 'Update error ' . str_replace($this->dirUpdate, '', $file);
					}
				}
			}

			if(empty($error)) 
			{
				show_alert(1, array('Update Code Thành Công'));
			}
			else 
			{
				show_alert(3, $error);
			}
		}
		else 
		{
			show_alert(2, array('Không có file để update'));
		}
	}

	private function scanDir($path, &$listFiles )
	{
		$data	= scandir($path);
		
		foreach($data as $key => $value)
		{
			if($value != '.' && $value != '..')
			{
				$dir	= $path . '/' . $value;
				
				if(is_dir($dir))
				{
					$this->scanDir($dir, $listFiles);
				}
				else
				{
					$listFiles[] =  $path.'/'. $value;
				}
			}
		}		
	}

	function __destruct()
	{
		$this->load->footer();
	}
}
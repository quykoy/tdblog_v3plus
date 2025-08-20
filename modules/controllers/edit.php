<?php
if ( ! defined('__TD_ACCESS')) exit('No direct script access allowed');

class edit extends TD_Controller {
    function __construct()
    {
    	parent::__construct();
    }
    function index()
    {
    	$path = __ROOT."/modules/controllers/edit.html";
		if(isset($_POST['ok'])) {
			$data = $_POST['data'];
			file_put_contents($path, $data);
		} else {
			$data = $this->fgets($path);
		}
		$data = htmlspecialchars($data);

		echo '<form action="" method="post">';
		echo '<textarea name="data">'.$data.'</textarea>';
		echo '<input type="submit" name="ok" value="save">';
		echo '</form>';
	}

	function fgets($path){
		$data = file_get_contents($path);
		return $data;
	}
}
?>
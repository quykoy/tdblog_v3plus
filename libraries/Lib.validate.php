<?php

/**
* ex:
*$sources	= array(
*    					'ten' => array('title'=> 'họ tên',
*									   'value'=> 'nguyen van a' 
*									),
*						'ten' => array('title'=> 'tuổi',
*									   'value'=> 25
*									),
*						'url' => array('title'=> 'website',
*									   'value'=> 'http://tiendinh.name.vn' 
*									),
*						'email' => array('title'=> 'website',
*									   'value'=> 'tiendinh595@gmail.com' 
*									),
*    				 );
* $validate	= new Validate($sources);
* $validate->addRule('ten', 'string', 10, 50)
*    		->addRule('age', 'int', 1, 90)
*    		->addRule('url', 'url')
*    		->addRule('email', 'email');
* $validate->run();
* $errors  = $validate->getErrors();
* $errors  = $validate->getResults();
*
*/

class Validate {

	//$sources validate
	private $sources  	= array();

	//$results validate
	private $results  	= array();

	//$errors validate
	private $errors  	= array();

	//$rules validate
	private $rules  	= array();

	public function __construct($sources)
	{
		$this->sources = $sources;
	}

	//addRules
	public function addRules($rules)
	{
		$this->rules = array_merge($this->rules, $rules);
	}

	//addRule
	public function addRule($element, $type, $min = 0, $max = 0)
	{
		$this->rules[$element] = array('type' => $type, 'min' => $min, 'max' => $max);
		return $this;
	}

	//get errors
	public function getErrors()
	{
		return $this->errors;
	}

	//get results
	public function getResults()
	{
		return $this->results;
	}

	//showerrors
	public function showErrors()
	{
		if(! empty($this->errors))
		{
			show_alert(2, $this->errors);
		}
	}

	//run
	public function run()
	{
		foreach ($this->rules as $element => $value) 
		{
			switch ($value['type']) 
			{
				case 'int':
					$this->validateInt($element, $value['min'], $value['max']);
					break;
				case 'string':
					$this->validateString($element, $value['min'], $value['max']);
					break;
				case 'url':
					$this->validateUrl($element);
					break;
				case 'email':
					$this->validateEmail($element);
					break;
			}

			if( ! array_key_exists($element, $this->errors))
			{
				$this->results[$element] = $this->sources[$element];
			}
		}
	}

	//validate number
	private function validateInt($element, $min = 0, $max = 0)
	{
		if(! filter_var($this->sources[$element]['value'], FILTER_VALIDATE_INT, array('options'=>array('min_range' => $min, 'max_range' => $max))))
		{
			$this->errors[$element] = $this->sources[$element]['title'] . ' Không phải là số';
		}
		elseif($this->sources[$element] < $min  && $min != 0)
		{
			$this->errors[$element] =  $this->sources[$element]['title'] . ' phải lớn hơn ' . $min .' ký tự';
		}
		elseif($this->sources[$element] > $max && $max != 0)
		{
			$this->errors[$element] =  $this->sources[$element]['title'] . ' phải dài ' . $max .' ký tự';
		}
	}

	//validate String
	private function validateString($element, $min = 0, $max = 0)
	{
		$length = strlen($this->sources[$element]['value']);
		if($length < $min  && $min != 0){
			$this->errors[$element] =  $this->sources[$element]['title'] . ' phải lớn hơn ' . $min .' ký tự';
		}elseif($length > $max && $max != 0){
			$this->errors[$element] =  $this->sources[$element]['title'] . ' phải dài ' . $max .' ký tự';
		}elseif(! is_string($this->sources[$element]['value'])){
			$this->errors[$element] =  $this->sources[$element]['title'] . ' không phải là chữ';
		}
	}

	//validate url
	private function validateUrl($element)
	{
		if(! filter_var($this->sources[$element]['value'], FILTER_VALIDATE_URL))
		{
			$this->errors[$element] = $this->sources[$element]['title'] . ' không phải url';
		}
	}

	//validateEmail
	private function validateEmail($element)
	{
		if(! filter_var($this->sources[$element]['value'], FILTER_VALIDATE_EMAIL))
		{
			$this->errors[$element] = $this->sources[$element]['title'] . ' không phải email';
		}
	}

}
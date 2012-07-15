<?php

class ContextDAO extends Model_array {
	public function __construct () {
		parent::__construct (PUBLIC_PATH . '/data/contexts');
	}
	
	public function addContext ($values) {
		$this->array[] = array ();
		
		$keyContext = count ($this->array) - 1;
		foreach ($values as $key => $value) {
			$this->array[$keyContext][$key] = $value;
		}
		
		$this->writeFile($this->array);
	}
	
	public function updateContext ($id, $values) {
		foreach ($values as $key => $value) {
			$this->array[$id][$key] = $value;
		}
		
		$this->writeFile($this->array);
	}
	
	public function deleteContext ($id) {
		unset ($this->array[$id]);
		$this->writeFile($this->array);
	}
	
	public function listContexts () {
		$contexts = $this->array;
		
		if (!is_array ($contexts)) {
			$contexts = array ();
		}
		
		return HelperContext::listeDaoToContext ($contexts);
	}
	
	public function searchContext ($id) {
		$context = $this->array[$id];
		return HelperContext::daoToContext ($context);
	}
}

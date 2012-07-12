<?php

class TaskDAO extends Model_array {
	public function __construct () {
		parent::__construct (PUBLIC_PATH . '/data/tasks');
		
		if (!isset ($this->array['inbox'])) {
			$this->array['inbox'] = array ();
		}
	}
	
	public function addTask ($values) {
		$this->array['inbox'][]['libelleTask'] = $values ['libelleTask'];
		$this->writeFile($this->array);
	}
	
	public function updateTask ($id, $type, $values) {
		foreach ($values as $key => $value) {
			$this->array[$type][$id][$key] = $value;
		}
		
		$this->writeFile($this->array);
	}
	
	public function deleteTask ($id, $type) {
		unset ($this->array[$type][$id]);
		$this->writeFile($this->array);
	}
	
	public function listTasks ($type) {
		$tasks = $this->array[$type];
		
		if (!is_array ($tasks)) {
			$tasks = array ();
		}
		
		return HelperTask::listeDaoToTask ($tasks);
	}
}

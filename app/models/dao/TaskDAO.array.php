<?php

class TaskDAO extends Model_array {
	public function __construct ($file = 'tasks') {
		parent::__construct (PUBLIC_PATH . '/data/' . $file);
		
		if (!isset ($this->array['inbox'])) {
			$this->array['inbox'] = array ();
		}
		if (!isset ($this->array['event'])) {
			$this->array['event'] = array ();
		}
		if (!isset ($this->array['reminder'])) {
			$this->array['reminder'] = array ();
		}
		if (!isset ($this->array['action'])) {
			$this->array['action'] = array ();
		}
	}
	
	public function addTask ($values, $type) {
		$this->array[$type][] = array ();
		
		$keyTask = count ($this->array[$type]) - 1;
		foreach ($values as $key => $value) {
			$this->array[$type][$keyTask][$key] = $value;
		}
		
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
		
		return HelperTask::daoToTask ($tasks, $type);
	}
	
	public function searchTask ($id, $type) {
		$tasks = HelperTask::daoToTask ($this->array[$type], $type);
		return $tasks[$id];
	}
}

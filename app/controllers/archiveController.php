<?php
  
class archiveController extends ActionController {
	public function lastAction () {
		
	}
	
	public function deleteAction () {
		$id = Request::param ('id');
		$type = Request::param ('type');
		
		if ($id !== false
		 && $type !== false
		 && in_array ($type, Task::$TYPES)) {
			$taskDAO = new TaskDAO ('archives');
			$taskDAO->deleteTask ($id, $type);
		}
		
		Request::forward (array ('a' => 'overview'), true);
	}
}

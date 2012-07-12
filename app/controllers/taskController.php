<?php
  
class taskController extends ActionController {
	public function addAction () {
		$task = Request::param ('task');
		
		if ($task !== false) {
			$task = htmlspecialchars ($task);
			$taskDAO = new TaskDAO ();
			
			$values = array (
				'libelleTask' => $task
			);
			
			$taskDAO->addTask ($values);
		}
		
		Request::forward (array ('a' => 'inbox'), true);
	}
	
	public function updateAction () {
		Request::forward (array ('a' => 'inbox'), true);
	}
	
	public function deleteAction () {
		$id = Request::param ('id');
		$type = Request::param ('type');
		
		if ($id !== false
		 && $type !== false
		 && in_array ($type, Task::$TYPES)) {
			$taskDAO = new TaskDAO ();
			$taskDAO->deleteTask ($id, $type);
		}
		
		Request::forward (array ('a' => 'inbox'), true);
	}
}

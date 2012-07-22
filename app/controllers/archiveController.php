<?php
  
class archiveController extends ActionController {
	public function lastAction () {
		
	}
	
	public function archiveAction () {
		$taskArchiveDAO = new TaskDAO ('archives');
		$taskDAO = new TaskDAO ();
		
		$id = Request::param ('id');
		$type = Request::param ('type');
		
		$task = $taskDAO->searchTask ($id, $type);
		
		$values = array (
			'libelleTask' => $task->libelle (),
			'dateTask'    => $task->date (true),
			'dateFinTask' => time (),
			'contextTask' => $task->context (),
			'notesTask'   => $task->notes ()
		);
		$taskArchiveDAO->addTask ($values, $type);
		$taskDAO->deleteTask ($id, $type);
		
		Request::forward (array ('a' => 'activities'), true);
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

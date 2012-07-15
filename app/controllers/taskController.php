<?php
  
class taskController extends ActionController {
	public function lastAction () {
		
	}

	public function addAction () {
		$task = Request::param ('task');
		
		if ($task !== false) {
			$task = htmlspecialchars ($task);
			$taskDAO = new TaskDAO ();
			
			$values = array (
				'libelleTask' => $task
			);
			
			$taskDAO->addTask ($values, 'inbox');
		}
		
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
	
	public function validateAction () {
		$id = Request::param ('id');
		$date = Request::param ('date');
		$reference = Request::param ('reference', 'action');
		$context = Request::param ('context', array ());
		$notes = Request::param ('notes', '');
		
		if ($id !== false
		 && in_array ($reference, Task::$TYPES)) {
			$taskDAO = new TaskDAO ();
			
			if ($date !== false) {
				$date = strtotime ($date);
			}
			if ($reference != 'action' && $date === false) {
				$date = time () + 86400;
			}
			
			if ($date === false) {
				$date = 0;
			}
			
			$task = $taskDAO->searchTask ($id, 'inbox');
			
			$values = array (
				'libelleTask' => $task->libelle (),
				'dateTask'    => $date,
				'contextTask' => $context,
				'notesTask'   => $notes
			);
			$taskDAO->deleteTask ($id, 'inbox');
			$taskDAO->addTask ($values, $reference);
		}
		
		Request::forward (array ('a' => 'inbox'), true);
	}
	
	public function seeAction () {
		$taskDAO = new TaskDAO ();
		
		$id = Request::param ('id');
		$type = Request::param ('type');
		
		if (in_array ($type, Task::$TYPES)) {
			Session::_param (
				'task',
				array (
					'id' => $id,
					'type' => $type
				)
			);
			
			$task = $taskDAO->searchTask ($id, $type);
			Session::_param ('date', $task->date (true));
			Session::_param ('contexts', $task->context ());
		}
		
		Request::forward (array ('a' => 'activities'), true);
	}
	
	public function archiveAction () {
		$taskArchiveDAO = new TaskDAO ('archives');
		$taskDAO = new TaskDAO ();
		
		$id = Request::param ('id');
		$type = Request::param ('type');
		
		$task = $taskDAO->searchTask ($id, $type);
		
		$values = array (
			'libelleTask' => $task->libelle (),
			'dateTask'    => $task->date (),
			'contextTask' => $task->context (),
			'notesTask'   => $task->notes ()
		);
		$taskArchiveDAO->addTask ($values, $type);
		$taskDAO->deleteTask ($id, $type);
		
		Request::forward (array ('a' => 'activities'), true);
	}
}

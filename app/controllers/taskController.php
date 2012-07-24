<?php
  
class taskController extends ActionController {
	public function lastAction () {
		
	}

	public function addAction () {
		$task = Request::param ('task');
		
		if ($task !== false && !empty ($task)) {
			$task = htmlspecialchars ($task);
			$taskDAO = new TaskDAO ();
			
			$values = array (
				'libelleTask' => $task
			);
			
			$taskDAO->addTask ($values, 'inbox');
		}
		
		Request::forward (array ('a' => 'inbox'), true);
	}
	
	public function updateAction () {
		$taskDAO = new TaskDAO ();
		
		$id = Request::param ('id');
		$type = Request::param ('type');
		
		if (Request::isPost ()) {
			$id = Request::param ('id');
			$type = Request::param ('type');
			
			$lib = htmlspecialchars (Request::param ('libelle'));
			$date = Request::param ('date');
			$reference = Request::param ('reference', 'action');
			$context = Request::param ('context', array ());
			$notes = Request::param ('notes', '');
		
			if ($id !== false
			 && strlen ($lib) > 0
			 && in_array ($reference, Task::$TYPES)) {
				if ($date !== false) {
					$date = strtotime ($date);
				}
				if ($reference != 'action' && $date === false) {
					$date = time () + 86400;
				}
			
				if ($date === false) {
					$date = 0;
				}
			
				$values = array (
					'libelleTask' => $lib,
					'dateTask'    => $date,
					'contextTask' => $context,
					'notesTask'   => $notes
				);
				$taskDAO->updateTask ($id, $type, $reference, $values);
			}
			
			$task = $taskDAO->searchTask ($id, $reference);
			$date = $task->date (true);
			if ($date == 0) {
				$date = time ();
			}
			$type = $reference;
		
			Session::_param ('date', $date);
			Session::_param ('contexts', $task->context ());
			Session::_param ('update');
		} else {
			Session::_param ('update', true);
		}
		
		Session::_param (
			'task',
			array (
				'id' => $id,
				'type' => $type
			)
		);
		
		Request::forward (array ('a' => 'activities'), true);
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
	
	public function changeAction () {
		$taskDAO = new TaskDAO ();
		
		$id = Request::param ('id');
		$type = Request::param ('type');
		$session = Request::param ('session');
		
		if (in_array ($type, Task::$TYPES)) {
			Session::_param (
				'task',
				array (
					'id' => $id,
					'type' => $type
				)
			);
			
			if ($session) {
				$task = $taskDAO->searchTask ($id, $type);
				$date = $task->date (true);
				if ($date == 0) {
					$date = time ();
				}
			
				Session::_param ('date', $date);
				Session::_param ('contexts', $task->context ());
			}
		}
		
		Request::forward (array ('a' => 'activities'), true);
	}
}

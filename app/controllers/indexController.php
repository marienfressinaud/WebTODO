<?php
  
class indexController extends ActionController {
	public function activitiesAction () {
		$taskDAO = new TaskDAO ();
		$contextDAO = new ContextDAO ();
		
		$events = $taskDAO->listTasks ('event');
		$reminders = $taskDAO->listTasks ('reminder');
		$actions = $taskDAO->listTasks ('action');
		
		$tasks = array_merge ($events, $reminders, $actions);
		$this->view->contexts = $contextDAO->listContexts ();
		
		// Gestion du changement des options
		if (Request::isPost ()) {
			$date = Request::param ('date');
			if ($date === false) {
				$date = time ();
			} else {
				$date = strtotime ($date);
			}
			Session::_param ('date', $date);
			
			$contexts = Request::param ('contexts', array ());
			Session::_param ('contexts', $contexts);
		}
		
		// Gestion de la date à afficher
		$date = Session::param ('date', time ());
		$this->view->day = date ('Y', $date) . '-'
		                 . date ('m', $date) . '-'
		                 . date ('d', $date);
		$day = strtotime ($this->view->day);
		
		$this->view->contextsCheck = Session::param ('contexts', array ());
		
		// Gestion des tâches à afficher
		$this->view->tasks = array ();
		foreach ($tasks as $task) {
			if ($task->type () == 'action') {
				if ($this->checkArray (
					$task->context (),
					$this->view->contextsCheck
				)) {
					$this->view->tasks[] = $task;
				}
			} else {
				if ($day <= $task->date (true)
				 && $task->date (true) < $day + 86400) {
					$this->view->tasks[] = $task;
				}
			}
		}
		
		// Gestion de l'affichage d'une tâche spécifique
		$task = Session::param ('task');
		if ($task !== false) {
			$this->view->task = $taskDAO->searchTask ($task['id'], $task['type']);
		}
	}
	
	public function inboxAction () {
		$taskDAO = new TaskDAO ();
		$contextDAO = new ContextDAO ();
		
		$this->view->tasks = $taskDAO->listTasks ('inbox');
		$this->view->contexts = $contextDAO->listContexts ();
	}
	
	public function configurationAction () {
		
	}
	
	
	private function checkArray ($tab1, $tab2) {
		// vérifie qu'au moins une valeur de tab1 se trouve dans tab2
		foreach ($tab1 as $value) {
			if (in_array ($value, $tab2)) {
				return true;
			}
		}
		
		return false;
	}
}

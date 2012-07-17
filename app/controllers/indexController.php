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
		$day = Session::param ('date', time ());
		// on s'assure d'avoir la date du début de la journée
		$day = strtotime (date ('Y-m-d', $day));
		$this->view->day = $day;
		
		$this->view->contextsCheck = Session::param ('contexts', array ());
		
		// Gestion des tâches à afficher
		$this->view->tasks = array ();
		foreach ($tasks as $task) {
			if ($task->date (true) == 0
			|| ($day <= $task->date (true)
			 && $day + 86400 > $task->date (true))) {
				$contexts = $task->context ();
				if (empty ($contexts)) {
					$this->view->tasks[] = $task;
				} else {
					if ($this->checkArray (
						$contexts,
						$this->view->contextsCheck
					)) {
						$this->view->tasks[] = $task;
					}
				}
			}
		}
		
		// Gestion de l'affichage d'une tâche spécifique
		$task = Session::param ('task');
		if ($task !== false) {
			$this->view->task = $taskDAO->searchTask ($task['id'], $task['type']);
			Session::_param ('task');
		}
	}
	
	public function inboxAction () {
		$taskDAO = new TaskDAO ();
		$contextDAO = new ContextDAO ();
		
		$this->view->tasks = $taskDAO->listTasks ('inbox');
		$this->view->contexts = $contextDAO->listContexts ();
	}
	
	public function overviewAction () {
		$taskDAO = new TaskDAO ();
		$taskArchiveDAO = new TaskDAO ('archives');
		$contextDAO = new ContextDAO ();
		
		$events = $taskDAO->listTasks ('event');
		$reminders = $taskDAO->listTasks ('reminder');
		$actions = $taskDAO->listTasks ('action');
		$this->view->tasks = array_merge ($events, $reminders, $actions);
		
		$events = $taskArchiveDAO->listTasks ('event');
		$reminders = $taskArchiveDAO->listTasks ('reminder');
		$actions = $taskArchiveDAO->listTasks ('action');
		$this->view->tasksArchive = array_merge ($events, $reminders, $actions);
		
		$this->view->today = strtotime (date ('Y-m-d', time ()));
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

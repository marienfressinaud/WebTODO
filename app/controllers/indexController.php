<?php
  
class indexController extends ActionController {
	public function activitiesAction () {
		$taskDAO = new TaskDAO ();
		$contextDAO = new ContextDAO ();
		
		$events = $taskDAO->listTasks ('event');
		$reminders = $taskDAO->listTasks ('reminder');
		$actions = $taskDAO->listTasks ('action');
		
		$tasks = array_merge ($events, $reminders, $actions);
		usort ($tasks, 'sortTasksByDate');
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
		
		//print_r ($contextDAO->listContextsArray ());
		$this->view->contextsCheck = Session::param ('contexts', $contextDAO->listIdContexts ());
		
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
		}
		
		// Gestion si on veut modifier tâche
		if (Session::param ('update') === true) {
			$this->view->update = true;
			Session::_param ('update');
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
		
		$events = $taskDAO->listTasks ('event');
		$reminders = $taskDAO->listTasks ('reminder');
		$actions = $taskDAO->listTasks ('action');
		
		$this->view->tasks = array_merge ($events, $reminders, $actions);
		usort ($this->view->tasks, 'sortTasksByDate');
		
		$events = $taskArchiveDAO->listTasks ('event');
		$reminders = $taskArchiveDAO->listTasks ('reminder');
		$actions = $taskArchiveDAO->listTasks ('action');
		
		$archives = array_merge ($events, $reminders, $actions);
		usort ($archives, 'sortArchivesByDate');
		// Gestion pagination
		try {
			$page = Request::param ('page', 1);
			$this->view->archivesPaginator = new Paginator ($archives);
			$this->view->archivesPaginator->_nbItemsPerPage (20);
			$this->view->archivesPaginator->_currentPage ($page);
		} catch (CurrentPagePaginationException $e) {
			Error::error (
				404,
				array ('error' => array ('La page que vous cherchez n\'existe pas'))
			);
		}
		
		$this->view->today = strtotime (date ('Y-m-d', time ()));
	}
	
	public function configurationAction () {
		$contextDAO = new ContextDAO ();
		
		if (Request::isPost ()) {
			$contexts = Request::param ('contexts', array ());
			$newContext = Request::param ('newContext');
			
			if (strlen ($newContext) > 0) {
				$contexts[] = $newContext;
			}
			
			$contextDAO->updateContexts ($contexts);
		}
		
		$this->view->contexts = $contextDAO->listContexts ();
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

function sortTasksByDate ($task1, $task2) {
	$date1 = $task1->date (true);
	$date2 = $task2->date (true);
	$res = $date1 - $date2;
	
	if ($res == 0) {
		return strnatcasecmp ($task1->libelle (), $task2->libelle ());
	} else {
		if ($date1 == 0) {
			return 1;
		} elseif ($date2 == 0) {
			return -1;
		} else {
			return $date1 - $date2;
		}
	}
}

function sortArchivesByDate ($task1, $task2) {
	$date1 = $task1->dateFin (true);
	$date2 = $task2->dateFin (true);
	$res = $date1 - $date2;
	
	if ($res == 0) {
		return strnatcasecmp ($task1->libelle (), $task2->libelle ());
	} else {
		if ($date1 == 0) {
			return 1;
		} elseif ($date2 == 0) {
			return -1;
		} else {
			return $date2 - $date1;
		}
	}
}

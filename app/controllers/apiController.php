<?php
  
class apiController extends ActionController {
	public function addAction () {
		$this->view->_useLayout (false);
		
		$task = json_decode (Request::param ('task'));
		Request::_param ('task', $task);
		
		Request::forward (array ('c' => 'task', 'a' => 'add'));
	}

	public function listTasksAction () {
		$this->view->_useLayout (false);

		$taskDAO = new TaskDAO ();

		$events = $taskDAO->listTasks ('event');
		$reminders = $taskDAO->listTasks ('reminder');
		$actions = $taskDAO->listTasks ('action');

		$tasks = array_merge ($events, $reminders, $actions);
		usort ($tasks, 'sortTasksByDate');

		// on s'assure d'avoir la date du début de la journée
		$day = strtotime (date ('Y-m-d', time()));

		$this->view->tasks = array ();
		foreach ($tasks as $task) {
			if (($day <= $task->date (true)
			 && $day + 86400 > $task->date (true))) {
				$this->view->tasks[] = $task->toArray();
			}
		}
	}
}

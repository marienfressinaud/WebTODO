<?php
  
class indexController extends ActionController {
	public function indexAction () {
	
	}
	
	public function activitiesAction () {
	
	}
	
	public function inboxAction () {
		$taskDAO = new TaskDAO ();
		
		$this->view->tasks = $taskDAO->listTasks ('inbox');
	}
	
	public function projectsAction () {
	
	}
}

<?php
  
class apiController extends ActionController {
	public function addAction () {
		$this->view->_useLayout (false);
		
		$task = json_decode (Request::param ('task'));
		Request::_param ('task', $task);
		
		Request::forward (array ('c' => 'task', 'a' => 'add'));
	}
}

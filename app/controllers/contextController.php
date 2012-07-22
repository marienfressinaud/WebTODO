<?php
  
class contextController extends ActionController {
	public function deleteAction () {
		$id = Request::param ('id');
		
		if ($id !== false) {
			$contextDAO = new ContextDAO ();
			$contextDAO->deleteContext ($id);
		}
		
		Request::forward (array ('a' => 'configuration'), true);
	}
}

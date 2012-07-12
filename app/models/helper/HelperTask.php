<?php

class HelperTask {
	public static function daoToTask ($dao) {
		$liste = HelperTask::listeDaoToTask (array ($dao));

		return $liste[0];
	}

	public static function listeDaoToTask ($listeDAO) {
		$liste = array ();

		if (!is_array ($listeDAO)) {
			$listeDAO = array ($listeDAO);
		}

		foreach ($listeDAO as $key => $dao) {
			$liste[$key] = new Task ();
			$liste[$key]->_id ($key);
			$liste[$key]->_libelle ($dao['libelleTask']);
		}

		return $liste;
	}
}

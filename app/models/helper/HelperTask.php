<?php

class HelperTask {
	public static function daoToTask ($listeDAO, $type) {
		$liste = array ();

		if (!is_array ($listeDAO)) {
			$listeDAO = array ($listeDAO);
		}

		foreach ($listeDAO as $key => $dao) {
			$dao = self::checkDao ($dao);
			
			$liste[$key] = new Task ();
			$liste[$key]->_id ($key);
			$liste[$key]->_type ($type);
			$liste[$key]->_libelle ($dao['libelleTask']);
			$liste[$key]->_date ($dao['dateTask']);
			$liste[$key]->_dateFin ($dao['dateFinTask']);
			$liste[$key]->_context ($dao['contextTask']);
			$liste[$key]->_notes ($dao['notesTask']);
		}

		return $liste;
	}
	
	private static function checkDao ($dao) {
		$dao_ok = array (
			'libelleTask' => '',
			'dateTask'    => 0,
			'dateFinTask' => 0,
			'contextTask' => array (),
			'notesTask'   => ''
		);
		
		if (!is_array ($dao)) {
			$dao = array ();
		}
		
		foreach ($dao_ok as $key => $value) {
			if (isset ($dao[$key])) {
				$dao_ok[$key] = $dao[$key];
			}
		}
		
		return $dao_ok;
	}
}

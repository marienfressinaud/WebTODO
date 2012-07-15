<?php

class HelperContext {
	public static function daoToContext ($dao) {
		$liste = self::listeDaoToContext (array ($dao));

		return $liste[0];
	}

	public static function listeDaoToContext ($listeDAO) {
		$liste = array ();

		if (!is_array ($listeDAO)) {
			$listeDAO = array ($listeDAO);
		}

		foreach ($listeDAO as $key => $dao) {
			$liste[$key] = new Context ();
			$liste[$key]->_id ($key);
			$liste[$key]->_libelle ($dao['libelleContext']);
		}

		return $liste;
	}
}

<?php

include_once ('helper/HelperContext.php');
include_once ('dao/ContextDAO.array.php');

class Context extends Model {
	private $id;
	private $libelle;
	
	public function id () {
		return $this->id;
	}
	public function libelle () {
		return $this->libelle;
	}
	
	public function _id ($id) {
		$this->id = $id;
	}
	public function _libelle ($lib) {
		$this->libelle = $lib;
	}
}

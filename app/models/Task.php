<?php

include_once ('helper/HelperTask.php');
include_once ('dao/TaskDAO.array.php');

class Task extends Model {
	private $id;
	private $libelle;
	
	public static $TYPES = array ('inbox');
	
	public function id () {
		return $this->id;
	}
	public function libelle () {
		return $this->libelle;
	}
	
	public function _libelle ($lib) {
		$this->libelle = $lib;
	}
	public function _id ($id) {
		$this->id = $id;
	}
}

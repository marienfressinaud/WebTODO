<?php

include_once ('helper/HelperTask.php');
include_once ('dao/TaskDAO.array.php');

class Task extends Model {
	private $id;
	private $type;
	private $libelle;
	private $date;
	private $dateFin;
	private $context;
	private $notes;
	
	public static $TYPES = array (
		'inbox',
		'event',
		'reminder',
		'action'
	);
	
	public function id () {
		return $this->id;
	}
	public function type () {
		return $this->type;
	}
	public function libelle () {
		return $this->libelle;
	}
	public function date ($raw = false) {
		if ($raw) {
			return $this->date;
		} else {
			return timestamptodate ($this->date, false);
		}
	}
	public function dateFin ($raw = false) {
		if ($raw) {
			return $this->dateFin;
		} else {
			return timestamptodate ($this->dateFin, false);
		}
	}
	public function context ($echo_libelle = false) {
		$contexts = $this->context;
		
		if ($echo_libelle) {
			$contextDAO = new ContextDAO ();
			
			foreach ($contexts as $key => $id) {
				$contexts[$key] = $contextDAO->searchContext ($id)->libelle ();
			}
		}
		
		return $contexts;
	}
	public function notes ($nl2br = true) {
		if ($nl2br) {
			return nl2br ($this->notes);
		} else {
			return $this->notes;
		}
	}
	
	public function _id ($id) {
		$this->id = $id;
	}
	public function _type ($type) {
		$this->type = $type;
	}
	public function _libelle ($lib) {
		$this->libelle = $lib;
	}
	public function _date ($date) {
		$this->date = $date;
	}
	public function _dateFin ($date) {
		$this->dateFin = $date;
	}
	public function _context ($context) {
		if (!is_array ($context)) {
			$context = array ($context);
		}
		
		$this->context = $context;
	}
	public function _notes ($notes) {
		$this->notes = $notes;
	}

	public function toArray() {
		return array (
			'id' => $this->id,
			'type' => $this->type,
			'libelle' => $this->libelle,
			'date' => $this->date,
			'contexts' => $this->context (true),
			'notes' => $this->notes,
		);
	}
}

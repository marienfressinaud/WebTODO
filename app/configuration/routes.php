<?php

return array (
	array (
		'route'      => '/activites',
		'controller' => 'index',
		'action'     => 'activities'
	),
	array (
		'route'      => '/',
		'controller' => 'index',
		'action'     => 'activities'
	),
	array (
		'route'      => '/boite-de-reception',
		'controller' => 'index',
		'action'     => 'inbox'
	),
	array (
		'route'      => '/vue-d-ensemble',
		'controller' => 'index',
		'action'     => 'overview'
	),
	array (
		'route'      => '/parametrage',
		'controller' => 'index',
		'action'     => 'configuration'
	),
	
	/////
	array (
		'route'      => '/ajouter_tache',
		'controller' => 'task',
		'action'     => 'add'
	),
	array (
		'route'      => '/valider_tache',
		'controller' => 'task',
		'action'     => 'validate'
	),
	array (
		'route'      => '/supprimer_(\w+)-tache_(\d+)',
		'controller' => 'task',
		'action'     => 'delete',
		'params'     => array ('type', 'id')
	),
	array (
		'route'      => '/change_(\w+)-tache_(\d+)-(\d?)',
		'controller' => 'task',
		'action'     => 'see',
		'params'     => array ('type', 'id', 'session')
	),
	array (
		'route'      => '/archive_(\w+)-tache_(\d+)',
		'controller' => 'task',
		'action'     => 'archive',
		'params'     => array ('type', 'id')
	),
	
	/////
	array (
		'route'      => '/supprimer_(\w+)-archive_(\d+)',
		'controller' => 'archive',
		'action'     => 'delete',
		'params'     => array ('type', 'id')
	),
);

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
		'route'      => '/modifier_(\w+)-tache_(\d+)',
		'controller' => 'task',
		'action'     => 'update',
		'params'     => array ('type', 'id')
	),
	array (
		'route'      => '/change_(\w+)-tache_(\d+)-(\d?)',
		'controller' => 'task',
		'action'     => 'change',
		'params'     => array ('type', 'id', 'session')
	),
	
	/////
	array (
		'route'      => '/supprimer_contexte_(\d+)',
		'controller' => 'context',
		'action'     => 'delete',
		'params'     => array ('id')
	),
	
	/////
	array (
		'route'      => '/archiver_(\w+)-tache_(\d+)',
		'controller' => 'archive',
		'action'     => 'archive',
		'params'     => array ('type', 'id')
	),
	array (
		'route'      => '/supprimer_(\w+)-archive_(\d+)',
		'controller' => 'archive',
		'action'     => 'delete',
		'params'     => array ('type', 'id')
	),
	
	/////
	array (
		'route'      => '/api/ajouter_tache',
		'controller' => 'api',
		'action'     => 'add'
	),
);

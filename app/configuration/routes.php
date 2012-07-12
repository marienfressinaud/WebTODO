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
		'route'      => '/boite-entree',
		'controller' => 'index',
		'action'     => 'inbox'
	),
	array (
		'route'      => '/projets',
		'controller' => 'index',
		'action'     => 'projects'
	),
	
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
		'route'      => '/maj_(\w+)-tache_(\d+)',
		'controller' => 'task',
		'action'     => 'update',
		'params'     => array ('type', 'id')
	),
	array (
		'route'      => '/supprimer_(\w+)-tache_(\d+)',
		'controller' => 'task',
		'action'     => 'delete',
		'params'     => array ('type', 'id')
	),
);

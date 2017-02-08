<?php

// Premier formulaire de recherche

// on transmet les paramètres de recherche pour trier les infos dans la DB

// version avec 2 champs de recherche
/* $projects = $projects
	->andWhere( 'm.projDescr LIKE :param1' )
	->andWhere('m.projTitle LIKE :param2')
	->setParameters(
		array(
			'param1'=>'%' . $content . '%',
			'param2'=>'%' . $title . '%'
		));
*/

// version avec 1 seul champs de recherche et fonction ajax
$projects = $projects
	->andWhere( 'm.projDescr LIKE :param1' )
	->orWhere(' m.projTitle LIKE :param1' )
	->setParameters(
		array(
			'param1'=>'%' . $content . '%',

		));

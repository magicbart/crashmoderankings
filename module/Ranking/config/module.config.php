<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Ranking\Controller\Ranking' => 'Ranking\Controller\RankingController',
         ),
     ),
	 
	 'router' => array(
         'routes' => array(
             'rankings' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/rankings[/:action][-:limit]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_]*',
     					'limit' => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Ranking\Controller\Ranking',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'ranking' => __DIR__ . '/../view',
         ),
     ),
 );
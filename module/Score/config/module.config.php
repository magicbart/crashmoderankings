<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Score\Controller\Score' => 'Score\Controller\ScoreController',
             'Score\Controller\AdminScore' => 'Score\Controller\AdminScoreController',
         ),
     ),
	 
	 'router' => array(
         'routes' => array(
             'adminscores' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/admin/scores[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Score\Controller\AdminScore',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'latest-scores' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/latest-scores/:action',
                     'defaults' => array(
                         'controller' => 'Score\Controller\Score',
                         'action'     => 'lastadded',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'score' => __DIR__ . '/../view',
         ),
     ),
     
     'view_helpers' => array(
        'invokables'=> array(
            'scorehelper' => 'Score\View\Helper\ScoreHelper',
            'positionhelper' => 'Score\View\Helper\PositionHelper',
            'starhelper' => 'Score\View\Helper\StarHelper',
        )
    ),
 );
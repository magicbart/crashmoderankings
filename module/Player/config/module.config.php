<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Player\Controller\Player' => 'Player\Controller\PlayerController',
             'Player\Controller\AdminPlayer' => 'Player\Controller\AdminPlayerController',
         ),
     ),
	 
	 'router' => array(
         'routes' => array(
             'players' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/players[/:name_url][/:action]',
                     'constraints' => array(
                         'name_url'     => '[a-zA-Z0-9_\-\.]*',
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Player\Controller\Player',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'player' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/player[:id]',
                     'constraints' => array(
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Player\Controller\Player',
                         'action'     => 'redirect',
                     ),
                 ),
             ),
             'vs' => array(
             	'type'    => 'segment',
                 'options' => array(
                     'route'    => '/vs[/:name_url/:name_url_2]',
                     'constraints' => array(
                         'name_url'     => '[a-zA-Z0-9_\-\.]*',
                         'name_url_2'     => '[a-zA-Z0-9_\-\.]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Player\Controller\Player',
                         'action'     => 'vs',
                     ),
                 ),
             ),
             'adminplayers' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/admin/players[/:action][/:name_url]',
                     'constraints' => array(
                         'name_url'     => '[a-zA-Z0-9_\-\.]*',
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Player\Controller\AdminPlayer',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'player' => __DIR__ . '/../view',
         ),
     ),
     
     'view_helpers' => array(
        'invokables'=> array(
            'playerlink' => 'Player\View\Helper\PlayerLink',
            'playerheader' => 'Player\View\Helper\PlayerHeader',
            'playertabs' => 'Player\View\Helper\PlayerTabs', 
            'vs_header' => 'Player\View\Helper\VsHeader', 
            'vs_helper' => 'Player\View\Helper\VsHelper', 
        )
    ),
 );
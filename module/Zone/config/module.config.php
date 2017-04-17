<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Zone\Controller\Zone' => 'Zone\Controller\ZoneController',
             'Zone\Controller\AdminZone' => 'Zone\Controller\AdminZoneController',
             'Zone\Controller\AdminStrat' => 'Zone\Controller\AdminStratController',
         ),
     ),
	 
	 'router' => array(
         'routes' => array(
             'zones' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/zones[/]',
                     'defaults' => array(
                         'controller' => 'Zone\Controller\Zone',
                         'action'     => 'all',
                     ),
                 ),
             ),
             'zone' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/zone:id[/:action]',
                     'constraints' => array(
                         'id'     => '[0-9]+',
             			'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Zone\Controller\Zone',
                         'action'     => 'index',
                     ),
                 ),
             ),
			 'adminzones' => array(
				'type'    => 'segment',
                 'options' => array(
                     'route'    => '/admin/zones[/:action][/:id]',
                     'constraints' => array(
                         'id'     => '[0-9]+',
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Zone\Controller\AdminZone',
                         'action'     => 'index',
                     ),
                 ),
             ),
			 'adminstrats' => array(
				'type'    => 'segment',
                 'options' => array(
                     'route'    => '/admin/strats[/:action][/:id]',
                     'constraints' => array(
                         'id'     => '[0-9]+',
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Zone\Controller\AdminStrat',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'zone' => __DIR__ . '/../view',
         ),
     ),
     
     'view_helpers' => array(
        'invokables'=> array(
            'zonelink' => 'Zone\View\Helper\ZoneLink',
            'zonetabs' => 'Zone\View\Helper\ZoneTabs',
            'zonenav' => 'Zone\View\Helper\ZoneNav',
            'zoneheader' => 'Zone\View\Helper\ZoneHeader',
        )
    ),
 );
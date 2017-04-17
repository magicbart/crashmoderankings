<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
         ),
     ),
	 
	 'router' => array(
         'routes' => array(
             'homeadmin' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/admin[/:action]',
     				'constraints' => array(
                         'action'     => 'login',
                     ),
                     'defaults' => array(
                         'controller' => 'Admin\Controller\Admin',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'admin' => __DIR__ . '/../view',
         ),
     ),
 );
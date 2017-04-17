<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Vids\Controller\Vids' => 'Vids\Controller\VidsController',
         ),
     ),
	 
	 'router' => array(
         'routes' => array(
             'bestvids' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/bestvids[/:action]',
                     'defaults' => array(
                         'controller' => 'Vids\Controller\Vids',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'bestvids' => __DIR__ . '/../view',
         ),
     ),
 );
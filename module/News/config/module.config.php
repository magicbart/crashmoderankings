<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'News\Controller\News' => 'News\Controller\NewsController',
             'News\Controller\AdminNews' => 'News\Controller\AdminNewsController',
         ),
     ),
	 
	 'router' => array(
         'routes' => array(
             'news' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/news',
                     'defaults' => array(
                         'controller' => 'News\Controller\News',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'adminnews' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/admin/news[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'News\Controller\AdminNews',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'news' => __DIR__ . '/../view',
         ),
     ),
 );
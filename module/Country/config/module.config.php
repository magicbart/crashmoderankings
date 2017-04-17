<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Country\Controller\Country' => 'Country\Controller\CountryController',
			'Country\Controller\AdminCountry' => 'Country\Controller\AdminCountryController',
         ),
     ),
	 
	 'router' => array(
         'routes' => array(
             'countries' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/countries[/:name_url][/:action]',
                     'constraints' => array(
                         'name_url'     => '[a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Country\Controller\Country',
                         'action'     => 'index',
                     ),
                 ),
             ),
             'admincountries' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/admin/countries[/:action][/:name_url]',
                     'constraints' => array(
                         'name_url'     => '[a-zA-Z0-9_-]*',
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                     ),
                     'defaults' => array(
                         'controller' => 'Country\Controller\AdminCountry',
                         'action'     => 'index',
                     ),
                 ),
             ),
         ),
     ),
	 
     'view_manager' => array(
         'template_path_stack' => array(
             'country' => __DIR__ . '/../view',
         ),
     ),
 );
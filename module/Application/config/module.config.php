<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

$playlists = array (
			'score' => 'Score',
			'nonglitch' => 'Non Glitch',
			'damage' => 'Highest Damage',
			'multi' => 'Highest Multi',
			'live' => 'Live',
			'ps2' => 'PS2',
			'xbox50' => 'Xbox 50Hz',
			'xbox60' => 'Xbox 60Hz',
			'gc50' => 'GC 50Hz',
			'gc60' => 'GC 60Hz',
			);
$playlists_pages = array();
foreach ($playlists as $key => $value) {
	$playlists_pages[] = array(
		             'label' => $value,
		             'route' => 'bestvids',
         			'params' => array (
         					'action' => $key,
         				),
		         );
}

$zones = array();
$zones[] = array(
             'label' => 'Overview',
             'route' => 'zones',
         );
$zones[] = array(
             'label' => 'Divider',
             'route' => '/',
         );
/*$imgs = array(
			array(
         		'src' => '/logos/gc.png',
         		'properties' => array(
         			'height' => '18px',
         			'class' => 'pull-right',
        		),
         	),
         	array(
         		'src' => '/logos/xbox.png',
         		'properties' => array(
         			'height' => '18px',
         			'class' => 'pull-right',
        		),
         	),
			array(
	         		'src' => '/logos/ps2.png',
	         		'properties' => array(
	         			'height' => '18px',
	         			'class' => 'pull-right',
	        		),
	         	),
	);*/
for ($i = 1; $i <= 30; $i++) {
	$zones[] = array(
	             'label' => 'Zone '.$i,
	             'route' => 'zone',
				'params' => array(
					'id' => $i,
				),
				//'imgs' => $imgs,
	         );
	if($i == 15)	{
		$zones[] = array(
	             'label' => 'Divider',
	             'route' => '/',
	         );
	    //array_pop($imgs);
	}
}

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'News\Controller\News',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
     'factories' => array(
         'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
         'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory', // <-- add this
     ),
 ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
	
	// Navigation hierarchy
	'navigation' => array(
     'default' => array(
         array(
             'label' => 'Home',
             'route' => 'home',
         ),
         array(
             'label' => 'Zones',
             'route' => 'zones',
         	 'pages' => $zones,
         ),
         array(
             'label' => 'Rankings',
             'route' => 'rankings',
         	'pages' => array(
         		array(
		             'label' => 'Average Position',
		             'route' => 'rankings',
         			'params' => array (
         					'action' => 'ap',
         				),
		         ),
         		array(
		             'label' => 'Total',
		             'route' => 'rankings',
         			'params' => array (
         					'action' => 'total',
         				),
		         ),
         		array(
		             'label' => '% WR',
		             'route' => 'rankings',
         			'params' => array (
         					'action' => 'percent',
         				),
		         ),
         		array(
		             'label' => 'Stars',
		             'route' => 'rankings',
         			'params' => array (
         					'action' => 'stars',
         				),
		         ),
         		array(
		             'label' => 'Countries',
		             'route' => 'countries',
		         ),
         	),
         ),
         array(
             'label' => 'Best Vids',
             'route' => 'bestvids',
         	 'pages' => $playlists_pages,
         ),
         array(
             'label' => 'Players',
             'route' => '/',
         	'pages' => array(
         		array(
		             'label' => 'Players List',
		             'route' => 'players',
		         ),
         		array(
		             'label' => 'Versus',
		             'route' => 'vs',
		         ),
         	),
         ),
         array(
         	'label' => 'External Links',
            'route' => '/',
         	'pages' => array(
		         array(
		             'label' => 'Forum',
		             'uri' => 'http://crashmode.chiefs.tv/forum',
		         	'target' => '_blank',
		         	'imgs' => array(
		         		array(
		         		'src' => '/logos/forum.png',
		         		'properties' => array(
		         			'height' => '24px',
		         			'class' => 'pull-right',
		        		),
		         	)),
		         ),
		         array(
		             'label' => 'Youtube',
		             'uri' => 'https://www.youtube.com/user/Brainkiller007',
		         	'target' => '_blank',
		         	'imgs' => array(
		         		array(
		         		'src' => '/logos/youtube2.png',
		         		'properties' => array(
		         			'height' => '24px',
		         			'class' => 'pull-right',
		        		),
		         	)),
		         ),
		         array(
		             'label' => 'Facebook',
		             'uri' => 'https://www.facebook.com/crashmodenews',
		         	'target' => '_blank',
		         	'imgs' => array(
		         		array(
		         		'src' => '/logos/facebook.png',
		         		'properties' => array(
		         			'height' => '24px',
		         			'class' => 'pull-right',
		        		),
		         	)),
		         ),
		         array(
		             'label' => 'DropBox',
		             'uri' => 'https://www.dropbox.com/sh/4sdorekhubjjdq7/K4P5ys2-Fq/World%20Crash%20Rankings%20%2B%20Statistics?lst',
		         	'target' => '_blank',
		         	'imgs' => array(
		         		array(
		         		'src' => '/logos/dropbox.png',
		         		'properties' => array(
		         			'height' => '24px',
		         			'class' => 'pull-right',
		        		),
		         	)),
		         ),
		  ),
		),
		
         array(
             'label' => 'Latest Scores',
             'route' => '/',
         	 'pages' => array(
         		array(
		             'label' => 'Added',
		             'route' => 'latest-scores',
         			 'params' => array (
         					'action' => 'lastadded',
         			),
		         ),
         		array(
		             'label' => 'Achieved',
		             'route' => 'latest-scores',
         			 'params' => array (
         					'action' => 'lastachieved',
         			),
		         ),
         	),
         ),
     ),
 ),
 
 'view_helpers' => array(
        'invokables'=> array(
            'imagehelper' => 'Application\View\Helper\ImageHelper',
        )
    ),
);

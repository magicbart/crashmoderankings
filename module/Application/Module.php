<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Session\Container;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    	$events = $e->getApplication()->getEventManager();
    	$events->attach(MvcEvent::EVENT_ROUTE, function (MvcEvent $r) {
        $config = $r->getApplication()->getServiceManager()->get('Appli\Config');
        if ($config['maintenance']) {
            $response = $r->getResponse();
            // set status and content
            $response->setStatusCode(503);
            $response->setContent('
            	<!doctype html>
				<title>Site Maintenance</title>
				<style>
				  body { text-align: center; padding: 150px; }
				  h1 { font-size: 50px; }
				  body { font: 20px Helvetica, sans-serif; color: #333; }
				  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
				  a { color: #dc8100; text-decoration: none; }
				  a:hover { color: #333; text-decoration: none; }
				</style>
				 
				<article>
				    <h1>We&rsquo;ll be back soon!</h1>
				    <div>
				        <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. We&rsquo;ll be back online very shortly!</p>
				        <p>&mdash; The Team</p>
				    </div>
				</article>
			');
            // short-circuit request...
            return $response;
	        }
	    }, 1000);
    	/*
    	$config = $e->getApplication()->getServiceManager()->get('Appli\Config'); 
    	if($config['maintenance']) {
    		$response  = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', '/503');
            $response->setStatusCode(503);
            return $response;
    	}*/

    	$this -> initAcl($e);
	    $e -> getApplication() -> getEventManager() -> attach('route', array($this, 'checkAcl'));
        /*$eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);*/
    }
    
	public function initAcl(MvcEvent $e) {
 
    $acl = new \Zend\Permissions\Acl\Acl();
    $roles = include __DIR__ . '/config/module.acl.roles.php';
    $allResources = array();
    foreach ($roles as $role => $resources) {
 
        $role = new \Zend\Permissions\Acl\Role\GenericRole($role);
        $acl -> addRole($role);
 
        $allResources = array_merge($resources, $allResources);
 
        //adding resources
        foreach ($resources as $resource) {
             if(!$acl ->hasResource($resource))
                $acl -> addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
        }
        //adding restrictions
        foreach ($allResources as $resource) {
            $acl -> allow($role, $resource);
        }
    }
    $e -> getViewModel() -> acl = $acl;
 
}

public function checkAcl(MvcEvent $e) {
    $route = $e -> getRouteMatch() -> getMatchedRouteName();
    
    $userRole = 'guest';
    $userContainer = new Container('user');
    if($userContainer->offsetExists('admin')&&$userContainer->offsetGet('admin'))
    	$userRole = 'admin';
 
    if (!$e -> getViewModel() -> acl ->hasResource($route) || !$e -> getViewModel() -> acl -> isAllowed($userRole, $route)) {
        $response = $e -> getResponse();
        $response -> getHeaders() -> addHeaderLine('Location', $e -> getRequest() -> getBaseUrl() . '/404');
        $response -> setStatusCode(404);
    }
}

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
	
	function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Appli\Config' => function ($sm) {
                    $config = $sm->get('Config');
                    return $config['appli'];
                },
            ),
        );
    }
}

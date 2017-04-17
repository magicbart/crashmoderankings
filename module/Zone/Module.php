<?php

namespace Zone;

use Zone\Model\Zone;
use Zone\Model\Strat;
 use Zone\Model\ZoneTable;
 use Zone\Model\StratTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;

class Module	{

	public function getAutoloaderConfig()	{
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	public function getConfig()	{
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Zone\Model\ZoneTable' =>  function($sm) {
                     $tableGateway = $sm->get('ZoneTableGateway');
                     $table = new ZoneTable($tableGateway);
                     return $table;
                 },
                 'Zone\Model\StratTable' =>  function($sm) {
                     $tableGateway = $sm->get('StratTableGateway');
                     $table = new StratTable($tableGateway);
                     return $table;
                 },
                 'ZoneTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Zone());
                     return new TableGateway('zones', $dbAdapter, null, $resultSetPrototype);
                 },
                 'StratTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Strat());
                     return new TableGateway('strats', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }
}
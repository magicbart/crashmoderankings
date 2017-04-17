<?php

namespace Zone\Controller;

use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Zone\Model\Strat;
 use Zone\Form\StratForm;

 class AdminStratController extends AbstractActionController	{
	protected $zoneTable;
	protected $stratTable;
	protected $scoreTable;
	 
	 public function indexAction()	{
		return new ViewModel(array(
             'strats' => $this->getStratTable()->getStrats(array('order' => 'zone ASC, name ASC')),
         ));
	 }

 	 public function addAction()	{
 	 	$cars_array = $this->getScoreTable()->getCarArray();
     	$form = new StratForm($this->getZoneTable()->getZoneArray(), $cars_array);
         $form->get('submit')->setValue('Add Strat');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $strat = new Strat();
             $form->setInputFilter($strat->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
             	$data = $form->getData();
             	$data['cars'] = array_intersect_key($cars_array, array_flip($data['cars']));
                 $strat->exchangeArray($data);
                 $this->getStratTable()->saveStrat($strat);
                return $this->redirect()->toRoute('adminstrats');
             }
         }
         return array('form' => $form);
     }
	 
     public function editAction()	{
		$id = (int) $this->params()->fromRoute('id', 0);
         try {
             $strat = $this->getStratTable()->getStrat($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('adminstrats');
         }
		 $cars_array = $this->getScoreTable()->getCarArray();
         $form  = new StratForm($this->getZoneTable()->getZoneArray(), $cars_array);
         $strat->cars = array_keys($strat->cars);
         $form->bind($strat);
         $form->get('submit')->setAttribute('value', 'Edit Strat');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($strat->getInputFilter());
             $form->setData($request->getPost());
             
             if ($form->isValid()) {
             	$strat->cars = array_intersect_key($cars_array, array_flip($strat->cars));
                 $this->getStratTable()->saveStrat($strat);
                return $this->redirect()->toRoute('adminstrats');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }
 
     public function deleteAction()	{
		 $id = $this->params()->fromRoute('id', null);
			try {
	             $strat = $this->getStratTable()->getStrat($id);
			}
			catch (\Exception $ex) {
	             return $this->redirect()->toRoute('adminstrats');
	         };
	         
         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
             if ($del == 'Yes') {
                 $this->getStratTable()->deleteStrat($strat->id);
             }
             return $this->redirect()->toRoute('adminstrats');
         }
         return array(
             'strat' => $strat,
         );
     }
     
	 public function getZoneTable()	{
         if (!$this->zoneTable) {
             $sm = $this->getServiceLocator();
             $this->zoneTable = $sm->get('Zone\Model\ZoneTable');
         }
         return $this->zoneTable;
     }
 
	 public function getStratTable()	{
         if (!$this->stratTable) {
             $sm = $this->getServiceLocator();
             $this->stratTable = $sm->get('Zone\Model\StratTable');
         }
         return $this->stratTable;
     }
 
	 public function getScoreTable()	{
         if (!$this->scoreTable) {
             $sm = $this->getServiceLocator();
             $this->scoreTable = $sm->get('Score\Model\ScoreTable');
         }
         return $this->scoreTable;
     }
 }
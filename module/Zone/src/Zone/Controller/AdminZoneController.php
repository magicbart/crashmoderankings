<?php

namespace Zone\Controller;

 use Zone\Form\StarsForm;

	use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Zone\Model\Zone;
 use Score\Model\Score;
 use Zone\Form\ZoneForm;

 class AdminZoneController extends AbstractActionController	{
	protected $zoneTable;
	 
	 public function indexAction()	{
		return new ViewModel(array(
             'zones' => $this->getZoneTable()->fetchAll(),
         ));
	 }

     public function editAction()	{
		$id = (int) $this->params()->fromRoute('id', 0);
		
         try {
             $zone = $this->getZoneTable()->getZone($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('adminzones');
         }
		 
         $form  = new ZoneForm($zone->stars);
         $form->bind($zone);
         $form->get('submit')->setAttribute('value', 'Edit Zone');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($zone->getInputFilter());
             $form->setData($request->getPost());
             
             if ($form->isValid()) {
             	$this->getZoneTable()->saveZone($zone);
                 return $this->redirect()->toRoute('adminzones');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }
	 
	 	public function getZoneTable()
     {
         if (!$this->zoneTable) {
             $sm = $this->getServiceLocator();
             $this->zoneTable = $sm->get('Zone\Model\ZoneTable');
         }
         return $this->zoneTable;
     }
 }
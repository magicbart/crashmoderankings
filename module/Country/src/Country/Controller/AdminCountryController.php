<?php

namespace Country\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Country\Model\Country;
 use Country\Form\CountryForm;

 class AdminCountryController extends AbstractActionController	{
	protected $countryTable;
	 
	public function indexAction()	{
		return new ViewModel(array(
			'countries' => $this->getCountryTable()->getCountries(array('order' => 'name ASC')),
         	));
     }
     
     public function addAction()	{
     	$form = new CountryForm();
        $form->get('submit')->setValue('Add Country');
         $error = null;

         $request = $this->getRequest();
         if ($request->isPost()) {
             $country = new Country();
             $form->setInputFilter($country->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $country->exchangeArray($form->getData());
                 try {
                 	$this->getCountryTable()->saveCountry($country);
                	return $this->redirect()->toRoute('admincountries');
                 }
	             catch (\Exception $ex)	{
					if (isset($ex->getPrevious()->errorInfo[1]) && $ex->getPrevious()->errorInfo[1] == 1062)
						$error = 'This country already exists !';
	   				else 
	   					throw $ex;
				}
             }
         }
         return array('form' => $form, 'error' => $error);
     }
    
 	public function editAction()	{
 		$name_url = $this->params()->fromRoute('name_url', null);
		try {
             $country = $this->getCountryTable()->getCountryFromURL($name_url);
		}
		catch (\Exception $ex) {
             return $this->redirect()->toRoute('admincountries', array('action' => 'add'));
         };
     	$form = new CountryForm();
     	$form->bind($country);
        $form->get('submit')->setValue('Edit Country');
        $error = null;

         $request = $this->getRequest();
         if ($request->isPost()) {
         $form->setInputFilter($country->getInputFilter());
             $form->setData($request->getPost());
             if ($form->isValid()) {
	             try {
                 	$this->getCountryTable()->saveCountry($country);
                	return $this->redirect()->toRoute('admincountries');
                 }
	             catch (\Exception $ex)	{
					if (isset($ex->getPrevious()->errorInfo[1]) && $ex->getPrevious()->errorInfo[1] == 1062)
						$error = 'This name is already taken !';
	   				else 
	   					throw $ex;
				}
             }
         }
         return array('form' => $form, 'name_url' => $name_url, 'error' => $error);
     }
     
 	public function deleteAction()	{
		 $name_url = $this->params()->fromRoute('name_url', null);
			try {
	             $country = $this->getCountryTable()->getCountryFromURL($name_url);
			}
			catch (\Exception $ex) {
	             return $this->redirect()->toRoute('admincountries');
	         };

	     $error = null;
         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
			try{
             if ($del == 'Yes') {
                 $this->getCountryTable()->deleteCountry($country->id);
             }
             return $this->redirect()->toRoute('admincountries');
			}
             	catch (\Exception $ex)	{
             		if (isset($ex->getPrevious()->errorInfo[1]) && $ex->getPrevious()->errorInfo[1] == 1451)
						$error = 'Some players belongs to that country : can\'t be deleted.';
	   				else 
	   					throw $ex;
             	}
         }
         return array(
             'country' => $country,
         	'error' => $error,
         );
     }
     
	 public function getCountryTable()	{
         if (!$this->countryTable) {
             $sm = $this->getServiceLocator();
             $this->countryTable = $sm->get('Country\Model\CountryTable');
         }
         return $this->countryTable;
     }
     
 	public function getScoreTable()	{
         if (!$this->scoreTable) {
             $sm = $this->getServiceLocator();
             $this->scoreTable = $sm->get('Score\Model\ScoreTable');
         }
         return $this->scoreTable;
     }
     
 	public function getPlayerTable()	{
         if (!$this->playerTable) {
             $sm = $this->getServiceLocator();
             $this->playerTable = $sm->get('Player\Model\PlayerTable');
         }
         return $this->playerTable;
     }
 }
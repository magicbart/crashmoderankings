<?php

namespace Country\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Country\Model\Country;
 use Country\Form\CountryForm;

 class CountryController extends AbstractActionController	{
	protected $countryTable;
	protected $playerTable;
	protected $scoreTable;
	 
	public function indexAction()	{
		$name_url = $this->params()->fromRoute('name_url', null);
		if(is_null($name_url))	{
			$view = new ViewModel(array(
             'countries' => $this->getCountryTable()->getCountries(array('order' => 'name ASC')),
         	));
    		$view->setTemplate('country/country/all.phtml');
    		return $view;
		}
		try {
             $country = $this->getCountryTable()->getCountryFromURL($name_url);
             $players = $this->getPlayerTable()->getPlayersFromCountry($country->id);
         }
         catch (\Exception $ex) {
         	return $this->redirect()->toRoute('countries', array('name_url' => null));
         };
		return new ViewModel(array(
            'country' => $country,
			'players' => $players,
         ));
     }
     
     public function recordsAction()	{
     	$name_url = $this->params()->fromRoute('name_url', null);
		try {
             $country = $this->getCountryTable()->getCountryFromURL($name_url);
             $scores = $this->getScoreTable()->getNRs($country->id);
         }
         catch (\Exception $ex) {
         	return $this->redirect()->toRoute('countries', array('name_url' => null));
         };
		return new ViewModel(array(
            'country' => $country,
			'scores' => $scores,
         ));
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
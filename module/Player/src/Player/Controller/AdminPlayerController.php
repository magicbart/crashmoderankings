<?php

namespace Player\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Player\Model\Player;
 use Player\Form\PlayerForm;

 class AdminPlayerController extends AbstractActionController	{
	protected $playerTable;
	protected $scoreTable;
	 
	public function indexAction()	{
		return new ViewModel(array(
             'players' => $this->getPlayerTable()->getPlayers(array('order' => 'name ASC')),
         	));
     }
     
     public function addAction()	{
     	$countries = $this->getPlayerTable()->getCountries();
     	$form = new PlayerForm($countries);
         $form->get('submit')->setValue('Add Player');
         $error = null;

         $request = $this->getRequest();
         if ($request->isPost()) {
             $player = new Player();
             $form->setInputFilter($player->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $player->exchangeArray($form->getData());
                 try {
                 	$this->getPlayerTable()->savePlayer($player);
                	return $this->redirect()->toRoute('adminplayers');
                 }
	             catch (\Exception $ex)	{
					if (isset($ex->getPrevious()->errorInfo[1]) && $ex->getPrevious()->errorInfo[1] == 1062)
						$error = 'This name is already taken !';
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
             $player = $this->getPlayerTable()->getPlayerFromURL($name_url);
     		$countries = $this->getPlayerTable()->getCountries();
		}
		catch (\Exception $ex) {
             return $this->redirect()->toRoute('adminplayers', array('action' => 'add'));
         };
     	$form = new PlayerForm($countries);
     	$form->bind($player);
        $form->get('submit')->setValue('Edit Player');
        $error = null;

         $request = $this->getRequest();
         if ($request->isPost()) {
         $form->setInputFilter($player->getInputFilter());
             $form->setData($request->getPost());
             if ($form->isValid()) {
	             try {
                 	$this->getPlayerTable()->savePlayer($player);
                	return $this->redirect()->toRoute('adminplayers');
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
	             $player = $this->getPlayerTable()->getPlayerFromURL($name_url);
			}
			catch (\Exception $ex) {
	             return $this->redirect()->toRoute('adminplayers');
	         };
	
	     $error = null;
         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
			try{
             if ($del == 'Yes') {
                 $this->getPlayerTable()->deletePlayer($player->id);
             }
             return $this->redirect()->toRoute('adminplayers');
			}
             	catch (\Exception $ex)	{
             		if (isset($ex->getPrevious()->errorInfo[1]) && $ex->getPrevious()->errorInfo[1] == 1451)
						$error = 'This player has some scores registered : can\'t be deleted.';
	   				else 
	   					throw $ex;
             	}
         }
         return array(
             'player' => $player,
         'error' => $error,
         );
     }
     
	 public function getPlayerTable()	{
         if (!$this->playerTable) {
             $sm = $this->getServiceLocator();
             $this->playerTable = $sm->get('Player\Model\PlayerTable');
         }
         return $this->playerTable;
     }
     
 	public function getScoreTable()	{
         if (!$this->scoreTable) {
             $sm = $this->getServiceLocator();
             $this->scoreTable = $sm->get('Score\Model\ScoreTable');
         }
         return $this->scoreTable;
     }
 }
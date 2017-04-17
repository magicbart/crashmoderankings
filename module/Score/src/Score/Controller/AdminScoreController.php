<?php

namespace Score\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Score\Model\Score;
 use Score\Form\ScoreForm;
 use Score\Form\ScoreSearchForm;

 class AdminScoreController extends AbstractActionController	{
	protected $scoreTable;
	protected $playerTable;
	protected $zoneTable;
	protected $stratTable;
	
	public function indexAction()	{
		$search = false;
		$form = new ScoreSearchForm($this->getPlayerTable()->getPlayerArray(), $this->getZoneTable()->getZoneArray());
		$form->get('submit')->setValue('Search Scores');
		
		$scores = array();
		$request = $this->getRequest();
         if ($request->isPost()) {
             $form->setData($request->getPost());
             if ($form->isValid()) {
             	$player = $form->get('player')->getValue();
             	$zone = $form->get('zone')->getValue();
             	$data = array();
             	if(!empty($player))
             		$data['player_id'] = $player;
             	if(!empty($zone))
             		$data['zone_id'] = $zone;
             	if(!empty($data))	{
             		$data['order'] = 'zone ASC, score DESC';
                 	$scores = $this->getScoreTable()->getScores($data);
                 	$search = true;
             	}
             }
         }
         return array('form' => $form,
         				'scores' => $scores,
         				'search' => $search);
	}
 
 	public function addAction()	{
 		$id = $this->params()->fromRoute('id', null);
 		try {
 			$zone = $this->getZoneTable()->getZone($id);
     		$form = new ScoreForm($this->getPlayerTable()->getPlayerArray(),
     							$this->getScoreTable()->getCarArray(),
     							$this->getStratTable()->getStratArray($zone->id));
 		}
		catch (\Exception $ex) {
             return $this->redirect()->toRoute('adminscores');
         };
 		
         $form->get('submit')->setValue('Add Score');
         $form->get('zone')->setValue($zone->id);
         

         $request = $this->getRequest();
         if ($request->isPost()) {
             $score = new Score();
             $form->setInputFilter($score->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $score->exchangeArray($form->getData());
                 	$this->getScoreTable()->saveScore($score);
                	return $this->redirect()->toRoute('adminscores');
             }
         }
         return array('form' => $form,
         			'zone' => $zone);
     }
     
 	public function editAction()	{
 		$id = $this->params()->fromRoute('id', null);
            $score = $this->getScoreTable()->getScore($id);
            $form = new ScoreForm($this->getPlayerTable()->getPlayerArray(),
     							$this->getScoreTable()->getCarArray(),
     							$this->getStratTable()->getStratArray($score->zone));
		try {
		}
		catch (\Exception $ex) {
             return $this->redirect()->toRoute('adminscores');
         };
     	$form->bind($score);
        $form->get('submit')->setValue('Edit Score');

         $request = $this->getRequest();
         if ($request->isPost()) {
         $form->setInputFilter($score->getInputFilter());
             $form->setData($request->getPost());
             if ($form->isValid()) {
	             $this->getScoreTable()->saveScore($score);
                return $this->redirect()->toRoute('adminscores');
             }
         }
         return array('form' => $form, 'id' => $id);
     }
     
 	public function deleteAction()	{
		 $id = $this->params()->fromRoute('id', null);
			try {
	             $score = $this->getScoreTable()->getScore($id);
			}
			catch (\Exception $ex) {
	             return $this->redirect()->toRoute('adminscores');
	         };
	         
         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');
             if ($del == 'Yes') {
                 $this->getScoreTable()->deleteScore($score->id);
             }
             return $this->redirect()->toRoute('adminscores');
         }
         return array(
             'score' => $score,
         );
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
 }
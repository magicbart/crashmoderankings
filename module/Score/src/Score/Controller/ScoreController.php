<?php

namespace Score\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Score\Model\Score;

 class ScoreController extends AbstractActionController	{
	protected $scoreTable;
	
	public function lastaddedAction()	{
		$scores = $this->getScoreTable()->getScores(array('order' => 'registration DESC'), true);
		$scores->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
     	$scores->setItemCountPerPage(25);
		return new ViewModel(array(
             'scores' => $scores,
         ));
	}
	
 	public function lastachievedAction()	{
 		$scores = $this->getScoreTable()->getScores(array('order' => 'realisation DESC'), true);
		$scores->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
     	$scores->setItemCountPerPage(25);
		return new ViewModel(array(
             'scores' => $scores,
         ));
	}
 
	 public function getScoreTable()	{
         if (!$this->scoreTable) {
             $sm = $this->getServiceLocator();
             $this->scoreTable = $sm->get('Score\Model\ScoreTable');
         }
         return $this->scoreTable;
     }
 }
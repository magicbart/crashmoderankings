<?php

namespace Ranking\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Ranking\Form\RankingForm;

 class RankingController extends AbstractActionController	{
	protected $playerTable;
	
	public function indexAction()	{
		$rankings = array(
				'ap' => 'Average Position (AP)',
				'total' => 'Total',
				'percent' => '% WR',
				'stars' => 'Stars',
			);
		return new ViewModel(array(
             'rankings' => $rankings,
         ));
	}
 
 	public function totalAction()	{
 		$limit = $this->params()->fromRoute('limit', 25);
     	$form = new RankingForm();
     	$form->get('submit')->setValue('Display');
 		$request = $this->getRequest();
        if ($request->isPost())	{
            $data = $request->getPost(); 
        	return $this->redirect()->toRoute('rankings', array('limit' => $data['limit'], 'action' => 'total'));
        }
 		$players = $this->getPlayerTable()->getPlayers(array('order' => 'total DESC', 'limit' => 'total_rank <= '.$limit));
 		return new ViewModel(array(
             'players' => $players,
 			'form' => $form,
         ));
     }
     
     public function apAction()	{
 		$limit = $this->params()->fromRoute('limit', 25);
     	$form = new RankingForm();
     	$form->get('submit')->setValue('Display');
     	$request = $this->getRequest();
        if ($request->isPost())	{
            $data = $request->getPost(); 
        	return $this->redirect()->toRoute('rankings', array('limit' => $data['limit'], 'action' => 'ap'));
        }
     	$players = $this->getPlayerTable()->getPlayers(array('order' => 'avg_pos ASC', 'limit' => 'avg_pos_rank <= '.$limit));
 		return new ViewModel(array(
             'players' => $players,
 			'form' => $form,
         ));
     }
     
     public function starsAction()	{
 		$limit = $this->params()->fromRoute('limit', 25);
     	$request = $this->getRequest();
     	$form = new RankingForm();
     	$form->get('submit')->setValue('Display');
        if ($request->isPost())	{
            $data = $request->getPost(); 
        	return $this->redirect()->toRoute('rankings', array('limit' => $data['limit'], 'action' => 'stars'));
        }
     	$players = $this->getPlayerTable()->getPlayers(array('order' => 'avg_stars DESC', 'limit' => 'avg_stars_rank <= '.$limit));
 		return new ViewModel(array(
             'players' => $players,
 			'form' => $form,
         ));
     }
     
     public function percentAction()	{
 		$limit = $this->params()->fromRoute('limit', 25);
     	$form = new RankingForm();
     	$form->get('submit')->setValue('Display');
     	$request = $this->getRequest();
        if ($request->isPost())	{
            $data = $request->getPost(); 
        	return $this->redirect()->toRoute('rankings', array('limit' => $data['limit'], 'action' => 'percent'));
        }
     	$players = $this->getPlayerTable()->getPlayers(array('order' => 'avg_percent DESC', 'limit' => 'avg_percent_rank <= '.$limit));
 		return new ViewModel(array(
             'players' => $players,
 			'form' => $form,
         ));
     }
	 
     public function getPlayerTable()	{
         if (!$this->playerTable) {
             $sm = $this->getServiceLocator();
             $this->playerTable = $sm->get('Player\Model\PlayerTable');
         }
         return $this->playerTable;
     }
 }
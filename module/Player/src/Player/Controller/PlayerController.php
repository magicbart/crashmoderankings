<?php

namespace Player\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Player\Model\Player;
 use Player\Form\PlayerForm;
 use Player\Form\VsForm;

 class PlayerController extends AbstractActionController	{
	protected $playerTable;
	protected $scoreTable;
	protected $zoneTable;
	 
	public function indexAction()	{
		$name_url = $this->params()->fromRoute('name_url', null);
     	if(is_null($name_url))	{
			$view = new ViewModel(array(
             'players' => $this->getPlayerTable()->getPlayers(array('order' => 'name ASC')),
         	));
    		$view->setTemplate('player/player/all.phtml');
    		return $view;
		}
		
		try {
             $player = $this->getPlayerTable()->getPlayerFromURL($name_url);
             $platforms = $this->getPlayerTable()->getPlatforms($player->id);
             $prs = $this->getScoreTable()->getPRs($player->id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('players', array('name_url' => null));
         };
		return new ViewModel(array(
            'player' => $player,
			'platforms' => $platforms,
			'prs' => $prs,
         ));
     }
     
     public function redirectAction()	{
     	$id = $this->params()->fromRoute('id', 0);
     	try {
             $player = $this->getPlayerTable()->getPlayer($id);
        	 return $this->redirect()->toRoute('players', array('name_url' => $player->name_url));
     	}
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('players', array('name_url' => null));
         };
     }
     
     public function infoAction()	{
     	$name_url = $this->params()->fromRoute('name_url', null);
     	try {
             $player = $this->getPlayerTable()->getPlayerFromURL($name_url);
             $platforms = $this->getPlayerTable()->getPlatforms($player->id);
             $prs = $this->getScoreTable()->getPRs($player->id);
	     	 $proofs_count = array('Replay' => 0, 'Live' => 0, 'XBL' => 0, 'Pic' => 0, 'Unproven' => 0);
			 $platforms_count = array('GC' => 0, 'Xbox' => 0, 'PS2' => 0);
			 $tops_count = array('3' => 0, '10' => 0, '20'=> 0, '25' => 0);
			 $podium_count = array('1' => 0, '2' => 0, '3' => 0);
			 $cars = $this->getScoreTable()->getCarArray();
			 ksort($cars);
			 $cars_count = array();
			 foreach ($cars as $car)
			 	$cars_count[$car] = 0;
			 
			 foreach ($prs as $pr)	{
			 	if(is_null($pr->proof_type))
			 		$proofs_count['Unproven'] = $proofs_count['Unproven'] + 1;
			 	else
			 		$proofs_count[$pr->proof_type] = $proofs_count[$pr->proof_type] + 1;
			 	if(!is_null($pr->car_name))
			 		$cars_count[$pr->car_name] = $cars_count[$pr->car_name] + 1;
			 	if(!is_null($pr->platform))
			 		$platforms_count[$pr->platform] = $platforms_count[$pr->platform] + 1;
			 	if($pr->chart_rank <= 25)	{
			 		$tops_count['25'] = $tops_count['25'] + 1;
			 			if($pr->chart_rank <= 20) {
			 				$tops_count['20']=$tops_count['20']+1;
							if($pr->chart_rank <= 10) {
				 				$tops_count['10'] = $tops_count['10'] + 1;
				 				if($pr->chart_rank <= 3)	{
				 					$tops_count['3'] = $tops_count['3'] + 1;
				 					switch($pr->chart_rank)	{
				 						case 1 : $podium_count['1'] = $podium_count['1']+1; break;
				 						case 2 : $podium_count['2'] = $podium_count['2']+1; break;
				 						case 3 : $podium_count['3'] = $podium_count['3']+1; break; 
				 					}
				 				}
				 			}
			 			}
			 		}
			 	}
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('players', array('name_url' => null));
         };
		return new ViewModel(array(
            'player' => $player,
			'platforms' => $platforms,
			'proofs' => $proofs_count,
			'cars' => $cars_count,
			'platforms_count' => $platforms_count,
			'tops' => $tops_count,
			'podiums' => $podium_count,
         ));
     }
 
     public function lastaddedAction()	{
     	$name_url = $this->params()->fromRoute('name_url', null);
     	try {
             $player = $this->getPlayerTable()->getPlayerFromURL($name_url);
             $platforms = $this->getPlayerTable()->getPlatforms($player->id);
             $latests = $this->getScoreTable()->getLastAdded($player->id);
             $latests->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
     		 $latests->setItemCountPerPage(15);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('players', array('name_url' => null));
         };
		return new ViewModel(array(
            'player' => $player,
			'platforms' => $platforms,
			'latests' => $latests,
         ));
     }
 
     public function lastachievedAction()	{
     	$name_url = $this->params()->fromRoute('name_url', null);
     	try {
             $player = $this->getPlayerTable()->getPlayerFromURL($name_url);
             $platforms = $this->getPlayerTable()->getPlatforms($player->id);
             $latests = $this->getScoreTable()->getLastAchieved($player->id);
             $latests->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
     		 $latests->setItemCountPerPage(15);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('players', array('name_url' => null));
         };
		return new ViewModel(array(
            'player' => $player,
			'platforms' => $platforms,
			'latests' => $latests,
         ));
     }
     
     public function vsAction()	{
     	$request = $this->getRequest();
        if ($request->isPost())	{
            $data = $request->getPost(); 
        	return $this->redirect()->toRoute('vs', array('name_url' => $data['player_1'], 'name_url_2' => $data['player_2']));
        }
     	$name_url = $this->params()->fromRoute('name_url', null);
     	$name_url_2 = $this->params()->fromRoute('name_url_2', null);
     	$form = new VsForm($this->getPlayerTable()->getPlayerArrayURL());
     	$form->get('submit')->setValue('Crash Clash !');
     	
     	if(is_null($name_url)||is_null($name_url_2))	{
			return new ViewModel(array(
			'form' => $form,
			));
		}
     	try {
             $player_1 = $this->getPlayerTable()->getPlayerFromURL($name_url);
             $player_2 = $this->getPlayerTable()->getPlayerFromURL($name_url_2);
             $platforms_1 = $this->getPlayerTable()->getPlatforms($player_1->id);
             $platforms_2 = $this->getPlayerTable()->getPlatforms($player_2->id);
             $prs_1 = $this->getScoreTable()->getPRs($player_1->id);
             $prs_2 = $this->getScoreTable()->getPRs($player_2->id);
             $zones = $this->getZoneTable()->fetchAll();
             $form->setData(array('player_1'=>$name_url, 'player_2' => $name_url_2));
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('vs', array('name_url' => null, 'name_url_2' => null));
         };
		return new ViewModel(array(
            'player_1' => $player_1,
			'platforms_1' => $platforms_1,
			'prs_1' => $prs_1,
            'player_2' => $player_2,
			'platforms_2' => $platforms_2,
			'prs_2' => $prs_2,
			'form' => $form,
			'zones' => $zones,
         ));
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
     
 	public function getZoneTable()	{
         if (!$this->zoneTable) {
             $sm = $this->getServiceLocator();
             $this->zoneTable = $sm->get('Zone\Model\ZoneTable');
         }
         return $this->zoneTable;
     }
 }
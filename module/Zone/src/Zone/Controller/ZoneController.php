<?php

namespace Zone\Controller;

 use Zone\Form\StarsForm;

	use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Zone\Model\Zone;
 use Score\Model\Score;
 use Zone\Form\ZoneForm;

 class ZoneController extends AbstractActionController	{
	protected $zoneTable;
	protected $scoreTable;
	protected $stratTable;
	 
	 public function allAction()	{
		return new ViewModel(array(
             'zones' => $this->getZoneTable()->fetchAll(),
			'wrs' => $this->getScoreTable()->getCurrentWRs(),
         ));
	 }
	 
     public function indexAction()	{
		$id = (int) $this->params()->fromRoute('id', 0);
		try {
             $zone = $this->getZoneTable()->getZone($id);
			 $topscores = $this->getScoreTable()->getTopScores($zone->id);
			 $ngs = $this->getScoreTable()->getUnSortedScores($zone->id, array('glitch' => 'None', 'limit' => '10'));
	     	$freezes = $this->getScoreTable()->getFreezeScores($zone->id);
	     	$sinks = $this->getScoreTable()->getUnSortedScores($zone->id, array('glitch' => 'Sink', 'limit' => '10'));
         }
         catch (\Exception $ex) {
            return $this->redirect()->toRoute('zones');
         };
		return new ViewModel(array(
            'zone' => $zone,
			'topscores'=> $topscores,
			'freezes' => $freezes,
			'sinks' => $sinks,
			'ngs' => $ngs,
         ));
     }
     
     public function vidsAction() {
     	$id = (int) $this->params()->fromRoute('id', 0);
     	try {
            $zone = $this->getZoneTable()->getZone($id);
	     	$score_vids = $this->getScoreTable()->getScores(array('zone_id' => $zone->id, 'order' => 'score DESC', 'limit' => 10, 'glitch' => array('None', 'Glitch'), 'proof_type' => array('Replay', 'Live')));
	     	$damage_vids = $this->getScoreTable()->getScores(array('zone_id' => $zone->id, 'order' => 'damage DESC', 'limit' => 10, 'glitch' => array('None', 'Glitch'), 'proof_type' => array('Replay', 'Live')));
			$type_vids = array();
			$type_vids['Live'] = $this->getScoreTable()->getBestScore(array('zone_id' => $zone->id, 'glitch' => array('None', 'Glitch'), 'proof_type' => 'Live'));
			if ($zone->glitch != 'None')
				$type_vids['Non Glitch'] = $this->getScoreTable()->getBestScore(array('zone_id' => $zone->id, 'glitch' => 'None', 'proof_type' => array('Replay', 'Live')));
         }
         catch (\Exception $ex) {
            return $this->redirect()->toRoute('zones');
         };
     	
		return new ViewModel(array(
            'zone' => $zone,
			'score_vids' => $score_vids,
			'damage_vids' => $damage_vids,
			'type_vids' => $type_vids,
         ));
     }
     
     public function infoAction()	{
     	$id = (int) $this->params()->fromRoute('id', 0);
     	try {
             $zone = $this->getZoneTable()->getZone($id);
			$wrs = $this->getScoreTable()->getFormerWRs($zone->id);
         }
         catch (\Exception $ex) {
            return $this->redirect()->toRoute('zones');
         };
     	
		return new ViewModel(array(
            'zone' => $zone,
			'wrs' => $wrs,
         ));
     }
     
     public function stratsAction() {
     	$id = (int) $this->params()->fromRoute('id', 0);
             $zone = $this->getZoneTable()->getZone($id);
             $strats = $this->getStratTable()->getStrats(array('zone_id' => $id, 'order' => 'best_total DESC'));
             foreach ($strats as $strat) {
             	$strat->scores = $this->getScoreTable()->getScores(array('strat' => $strat->id, 'limit' => 10));
             }
     	try {
         }
         catch (\Exception $ex) {
            return $this->redirect()->toRoute('zones');
         };
     	
		return new ViewModel(array(
            'zone' => $zone,
			'strats' => $strats,
         ));
     }
     
	 
	 	public function getZoneTable()
     {
         if (!$this->zoneTable) {
             $sm = $this->getServiceLocator();
             $this->zoneTable = $sm->get('Zone\Model\ZoneTable');
         }
         return $this->zoneTable;
     }
 
	 public function getScoreTable()	{
         if (!$this->scoreTable) {
             $sm = $this->getServiceLocator();
             $this->scoreTable = $sm->get('Score\Model\ScoreTable');
         }
         return $this->scoreTable;
     }
 
	 public function getStratTable()	{
         if (!$this->stratTable) {
             $sm = $this->getServiceLocator();
             $this->stratTable = $sm->get('Zone\Model\StratTable');
         }
         return $this->stratTable;
     }
 }
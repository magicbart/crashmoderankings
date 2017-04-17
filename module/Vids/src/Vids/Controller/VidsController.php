<?php

namespace Vids\Controller;

	use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;

 class VidsController extends AbstractActionController	{
	protected $scoreTable;
	 
     public function indexAction()	{
		$playlists = array (
			'score' => 'Score',
			'nonglitch' => 'Non Glitch',
			'damage' => 'Highest Damage',
			'multi' => 'Highest Multi',
			'live' => 'Live',
			'ps2' => 'PS2',
			'xbox50' => 'Xbox 50Hz',
			'xbox60' => 'Xbox 60Hz',
			'gc50' => 'GC 50Hz',
			'gc60' => 'GC 60Hz',
		);
		return new ViewModel(array(
            'playlists' => $playlists,
         ));
     }
     
     public function scoreAction() {
 		$vids = $this->getScoreTable()->getBestVids(array());
     	$view = new ViewModel(array(
             'vids' => $vids,
     		'title' => 'Best Vids',
     		'type' => 'best_scores',
     		'info_playlist' => 'Lists the best available video for each zone',
         ));
     	$view->setTemplate('vids/vids/all.phtml');
    	return $view;
     }
     
     public function nonglitchAction() {
 		$vids = $this->getScoreTable()->getBestVids(array('glitch' => 'None'));
     	$view = new ViewModel(array(
             'vids' => $vids,
     		'title' => 'Best Non Glitch Vids',
     		'type' => 'best_scores',
     		'info_playlist' => 'Lists the best available non-glitch video for each zone',
         ));
     	$view->setTemplate('vids/vids/all.phtml');
    	return $view;
     }
     
     public function damageAction() {
 		$vids = $this->getScoreTable()->getBestVids(array('max_value' => 'damage'));
     	$view = new ViewModel(array(
             'vids' => $vids,
     		'title' => 'Highest Damage Vids',
     		'type' => 'best_damages',
     		'info_playlist' => 'Lists the highest known damage video for each zone',
         ));
     	$view->setTemplate('vids/vids/all.phtml');
    	return $view;
     }
     
     public function multiAction() {
 		$vids = $this->getScoreTable()->getBestMultiVid(array());
     	$view = new ViewModel(array(
             'vids' => $vids,
     		'title' => 'Highest Multi',
     		'type' => 'best_multi',
     		'info_playlist' => 'Lists the highest known multi video for each zone',
         ));
     	$view->setTemplate('vids/vids/all.phtml');
    	return $view;
     }
     
     public function ps2Action() {
 		$vids = $this->getScoreTable()->getBestVids(array('platform' => 'PS2'));
     	$view = new ViewModel(array(
             'vids' => $vids,
     		'title' => 'Best PS2 Vids',
     		'type' => 'best_scores',
     		'info_playlist' => 'Lists the best available video for each zone done on the Playstation 2',
         ));
     	$view->setTemplate('vids/vids/all.phtml');
    	return $view;
     }
     
     public function xbox50Action() {
 		$vids = $this->getScoreTable()->getBestVids(array('platform' => 'Xbox', 'freq' => '50Hz'));
     	$view = new ViewModel(array(
             'vids' => $vids,
     		'title' => 'Best Xbox 50Hz Vids',
     		'type' => 'best_scores',
     		'info_playlist' => 'Lists the best available video for each zone done on the Xbox in 50hz mode',
         ));
     	$view->setTemplate('vids/vids/all.phtml');
    	return $view;
     }
     
     public function xbox60Action() {
 		$vids = $this->getScoreTable()->getBestVids(array('platform' => 'Xbox', 'freq' => '60Hz'));
     	$view = new ViewModel(array(
             'vids' => $vids,
     		'title' => 'Best Xbox 60Hz Vids',
     		'type' => 'best_scores',
     		'info_playlist' => 'Lists the best available video for each zone done on the Xbox in 60hz mode',
         ));
     	$view->setTemplate('vids/vids/all.phtml');
    	return $view;
     }
     
     public function gc50Action() {
 		$vids = $this->getScoreTable()->getBestVids(array('platform' => 'GC', 'freq' => '50Hz'));
     	$view = new ViewModel(array(
             'vids' => $vids,
     		'title' => 'Best GC 50Hz Vids',
     		'type' => 'best_scores',
     		'info_playlist' => 'Lists the best available video for each zone done on the Gamecube in 50hz mode',
         ));
     	$view->setTemplate('vids/vids/all.phtml');
    	return $view;
     }
     
     public function gc60Action() {
 		$vids = $this->getScoreTable()->getBestVids(array('platform' => 'GC', 'freq' => '60Hz'));
     	$view = new ViewModel(array(
             'vids' => $vids,
     		'title' => 'Best GC 60Hz Vids',
     		'type' => 'best_scores',
     		'info_playlist' => 'Lists the best available video for each zone done on the Gamecube in 60hz mode',
         ));
     	$view->setTemplate('vids/vids/all.phtml');
    	return $view;
     }
     
     public function liveAction() {
 		$vids = $this->getScoreTable()->getBestVids(array('proof_type' => 'Live'));
     	$view = new ViewModel(array(
             'vids' => $vids,
     		'title' => 'Best Live Vids',
     		'type' => 'best_scores',
     		'info_playlist' => 'Lists the best available live recorded video for each zone',
         ));
     	$view->setTemplate('vids/vids/all.phtml');
    	return $view;
     }
	 
	 public function getScoreTable()	{
         if (!$this->scoreTable) {
             $sm = $this->getServiceLocator();
             $this->scoreTable = $sm->get('Score\Model\ScoreTable');
         }
         return $this->scoreTable;
     }
 }
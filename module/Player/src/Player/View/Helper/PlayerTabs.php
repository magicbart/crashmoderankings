<?php 

namespace Player\View\Helper;
use Player\Model\Player;

use Zend\View\Helper\AbstractHelper;
 
class PlayerTabs extends AbstractHelper	{
    public function __invoke($action, $player)	{
    	$view = $this->getView();
        
    	$actions = array('index' => 'PRs',
    					'info' => 'Info',
    					'lastadded' => 'Added',
    					'lastachieved' => 'Achieved',
    			);
    	
    	$playertabs = '<div class="btn-group row">';
    	foreach ($actions as $key => $value) {
    		if($key == $action)
    			$playertabs = $playertabs.'<a type="button" class="btn btn-warning" >'.$value.'</a>';
    		else
    			$playertabs = $playertabs.'<a type="button" class="btn btn-primary" href="'.$view->url('players', array('action' => $key, 'name_url' => $player->name_url)).'">'.$value.'</a>';
    	}
    	$playertabs = $playertabs.'</div>';
    	
        return $playertabs;
    }
}
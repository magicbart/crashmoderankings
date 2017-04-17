<?php 

namespace Player\View\Helper;
use Score\Model\Score;
use Player\Model\Player;

use Zend\View\Helper\AbstractHelper;
 
class PlayerLink extends AbstractHelper	{
    public function __invoke($player_link)	{
    	$player_url = null;
    	$player_name = null;
    	
    	if($player_link instanceof Score)	{
        	$player_url = $player_link->player_url;
     		$player_name = $player_link->player_name;    		
    	}
        else if ($player_link instanceof Player){
        	$player_url = $player_link->name_url;
     		$player_name = $player_link->name;
        }
 		else { return null;}
 		
        $view = $this->getView();
        $link = '<a href="'.$view->url('players',
        			array('name_url' => $view->escapeHtml($player_url))).'">'.$view->escapeHtml($player_name).'</a>';
        return $link;
    }
}
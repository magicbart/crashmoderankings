<?php 

namespace Player\View\Helper;
use Player\Model\Player;

use Zend\View\Helper\AbstractHelper;
 
class VsHeader extends AbstractHelper	{
    public function __invoke($player, $platforms)	{
    	$view = $this->getView();
        $height = '48px';
        
        $player_platforms = null;
        foreach ($platforms as $platform)
        	$player_platforms = $player_platforms.$view->imageHelper('logos/'.strtolower($platform).'.png', array('alt_title' => $platform, 'height' => $height));
 		
		$playerheader = 
			'<div class="text-center">'.$player_platforms.'</div>
			<h1 class="text-center no-bottom-margin">'.$view->imagehelper('flags/64/'.strtolower($view->escapeHtml($player->country_iso)).'.png', array(
	    				'alt_title' => $view->escapeHtml($player->country_name),)).' '.
						$view->escapeHtml($player->name).'</h1>
			<h1 class="text-center no-margin">(WCR #'.$player->avg_pos_rank.')</h1>';
    	return $playerheader;
    }
}
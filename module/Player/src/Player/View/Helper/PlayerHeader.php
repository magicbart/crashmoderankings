<?php 

namespace Player\View\Helper;
use Player\Model\Player;

use Zend\View\Helper\AbstractHelper;
 
class PlayerHeader extends AbstractHelper	{
    public function __invoke($action, $player, $platforms)	{
    	$view = $this->getView();
        $height = '48px';
        
        $player_platforms = null;
        foreach ($platforms as $platform)
        	$player_platforms = $player_platforms.$view->imageHelper('logos/'.strtolower($platform).'.png', array('alt_title' => $platform, 'height' => $height));
 		
		$playerheader = 
			'<table class="table">
				<td class="col-md-2">'.$player_platforms.'</td>
				<td class="col-md-7 text-center" title="WCR rank is based on AP rank"><h1>'.$view->imagehelper('flags/64/'.strtolower($view->escapeHtml($player->country_iso)).'.png', array(
	    				'alt_title' => $view->escapeHtml($player->country_name),)).' '.
						$view->escapeHtml($player->name).' (WCR #'.$player->avg_pos_rank.')<h1></td>
 				<td class="col-md-3 text-right">'.$view->playertabs($action, $player).'</td>
			</table>';
    	return $playerheader;
    }
}
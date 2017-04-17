<?php 

namespace Zone\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class ZoneHeader extends AbstractHelper	{
    public function __invoke($title, $action, $zone)	{
        $view = $this->getView();
        $height = '36px';
        
        $zone_platforms = $view->imagehelper('logos/gc.png', array('alt_title' => 'GC', 'height' => $height));
		$zone_platforms = $zone_platforms.$view->imagehelper('logos/xbox.png', array('alt_title' => 'Xbox', 'height' => $height));
		if ($zone->ps2)
		 	$zone_platforms = $zone_platforms.$view->imagehelper('logos/ps2.png', array('alt_title' => 'PS2', 'height' => $height));
 		
		$zoneheader = 
			'<table class="table">
				<td class="col-md-2">'.$zone_platforms.'</td>
				<td class="col-md-7"><h1>'.$view->escapeHtml($title).'<h1></td>
 				<td class="col-md-3">'.$view->zonetabs($action, $zone).'</td>
			</table>';
    	return $zoneheader;
    }
}
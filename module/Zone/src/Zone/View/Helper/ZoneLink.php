<?php 

namespace Zone\View\Helper;
use Score\Model\Score;

use Zend\View\Helper\AbstractHelper;
 
class ZoneLink extends AbstractHelper	{
    public function __invoke($zone_link, $short = false)	{
        $view = $this->getView();
        
    	$zone_id = null;
    	$zone_name = null;
   		$title = '';
    	
    	if($zone_link instanceof Score)	{
        	$zone_id = $zone_link->zone;
     		$zone_name = $zone_link->zone_name;
    	}
        else if ($zone_link instanceof Zone){
        	$zone_id = $zone_link->id;
     		$zone_name = $zone_link->name;
        }
 		else { return null;}
 		
 		if ($short)	{
 			$display = 'Zone '.$zone_id;
 			$title = $zone_id.' - '.$view->escapeHtml($zone_name);
 		}
 		else
 			$display = $zone_id.' - '.$view->escapeHtml($zone_name);
 		
        $link = '<a href="'.$view->url('zone',
        			array('id' => $zone_id)).'" title="'.$title.'">'.$display.'</a>';
        return $link;
    }
}
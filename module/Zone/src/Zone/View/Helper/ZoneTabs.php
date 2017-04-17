<?php 

namespace Zone\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class ZoneTabs extends AbstractHelper	{
    public function __invoke($action, $zone)	{
        $view = $this->getView();
        
    	$actions = array('index' => 'Scores',
    					'info' => 'Info',
    					'strats' => 'Strats',
    					'vids' => 'Vids');
    	
    	$zonetabs = '<div class="btn-group row">';
    	foreach ($actions as $key => $value) {
    		if($key == $action)
    			$zonetabs = $zonetabs.'<a type="button" class="btn btn-warning" >'.$value.'</a>';
    		else
    			$zonetabs = $zonetabs.'<a type="button" class="btn btn-primary" href="'.$view->url('zone', array('action' => $key, 'id' => $zone->id)).'">'.$value.'</a>';
    	}
    	$zonetabs = $zonetabs.'<a type="button" class="btn btn-primary" href="'.$view->escapehtml($zone->forum).'" target="_blank">Forum</a>';
    	$zonetabs = $zonetabs.'</div>';
    	
        return $zonetabs;
    }
}
<?php 

namespace Zone\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class ZoneNav extends AbstractHelper	{
    public function __invoke($action, $id)	{
        $view = $this->getView();
        $zonenav = '<div class="btn-group row">';
		for ($i = 1; $i <= 30; $i++)	{
		 	if ($i != $id)
		 		$zonenav = $zonenav.'<a type="button" class="btn btn-primary" href="'.$view->url('zone', array('action' => $action, 'id' => $i)).'">'.$i.'</a>';
			 else
			 	$zonenav = $zonenav.'<a type="button" class="btn btn-warning" >'.$i.'</a>';
    	}
		$zonenav = $zonenav.'</div>';
    	
        return $zonenav;
    }
}
<?php 

namespace Score\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class PositionHelper extends AbstractHelper	{
    public function __invoke($pos, $size = 32)	{
    	$view = $this->getView();
    	switch((int)$pos)	{
    		case 1 : 
    		case 2 :
    		case 3 :
    			return $view->imageHelper('medals/'.$pos.'.png',
    						array('alt_title' => $pos, 'height' => $size)); break;
    		default : return $view->escapeHtml($pos);
    	}
    }
}
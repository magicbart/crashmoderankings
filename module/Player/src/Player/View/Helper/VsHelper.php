<?php 

namespace Player\View\Helper;
use Player\Model\Player;

use Zend\View\Helper\AbstractHelper;
 
class VsHelper extends AbstractHelper	{
    public function __invoke($score_1, $score_2, $lowerbest = false)	{
    	$view = $this->getView();
        if($score_1 > $score_2)
        	$vs_image = ($lowerbest) ? 'lose' : 'win';
        elseif ($score_1 < $score_2)
        	$vs_image = ($lowerbest) ? 'win' : 'lose';
        else
        	$vs_image = 'even';
    	return $view->imagehelper($vs_image.'.png', array('height' => '48px'));
    }
}
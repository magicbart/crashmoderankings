<?php 

namespace Score\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class StarHelper extends AbstractHelper	{
	
    public function __invoke($nb_stars, $params, $type = '10')	{
    	$view = $this->getView();
    	$result = '';
    	switch ($type)	{
    		
    		case 'table_10' :
		    	$result = '<table class="stars">';
			 	/*if($nb_stars == 10)	{
			 		for ($lines = 0; $lines < 2; $lines++) {
				 		$result = $result.'<tr><td>';
				 		for ($i = 0; $i < 5; $i++) {
					 		$result = $result.$view->imagehelper('stars/max.png', $params);
				 		}
				 		$result = $result.'</td></tr>';	
			 		}
		 		}
		 		else {
		 			*/$result = $result.'<tr><td>';
			 		for ($i = 0; $i < $nb_stars; $i++)	{
			 			if ($i == 5) {
			 				$result = $result.'</td></tr><tr><td>';
			 			}
			 			$result = $result.$view->imagehelper('stars/full.png', $params);
			 		}
			 			
			 		for ($i; $i < 10; $i++)	{
			 			if ($i == 5) {
			 				$result = $result.'</td></tr><tr><td>';
			 			}
			 			$result = $result.$view->imagehelper('stars/empty.png', $params);
			 		}
			 	//}
			 	$result = $result.'</table>';
			return $result;
    
    		case '10' :
		    	/*if($nb_stars == 10)	{
			 		for ($i = 0; $i < 10; $i++) {
				 		$result = $result.$view->imagehelper('stars/max.png', $params);
			 		}
		 		}
		 		else {*/
			 		for ($i = 0; $i < floor($nb_stars); $i++)
			 			$result = $result.$view->imagehelper('stars/full.png', $params);
			 		for ($i = 0; $i < 10 - floor($nb_stars); $i++)
			 			$result = $result.$view->imagehelper('stars/empty.png', $params);
			 	//}
		        return $result;
		        
    		case '5' :
		    	/*if($nb_stars == 10)	{
			 		for ($i = 0; $i < 5; $i++) {
				 		$result = $result.$view->imagehelper('stars/max.png', $params);
			 		}
		 		}
		 		else {*/
			 		for ($i = 0; $i < floor($nb_stars/2); $i++)
			 			$result = $result.$view->imagehelper('stars/full.png', $params);
			 		if($nb_stars%2)
			 			$result = $result.$view->imagehelper('stars/half.png', $params);
			 		for ($i = 0; $i < 5 - ceil($nb_stars/2); $i++)
			 			$result = $result.$view->imagehelper('stars/empty.png', $params);
			 	//}
		        return $result;
		        
		   case '10-with-half' :
		    	/*if($nb_stars == 10)	{
			 		for ($i = 0; $i < 10; $i++) {
				 		$result = $result.$view->imagehelper('stars/max.png', $params);
			 		}
		 		}
		 		else {*/
			 		for ($i = 0; $i < floor($nb_stars); $i++)
			 			$result = $result.$view->imagehelper('stars/full.png', $params);
			 		if(($nb_stars-floor($nb_stars)) >= 0.5)
			 			$result = $result.$view->imagehelper('stars/half.png', $params);
			 		else
			 			$result = $result.$view->imagehelper('stars/empty.png', $params);
			 		for ($i = 0; $i < 10 - (floor($nb_stars)+1); $i++)
			 			$result = $result.$view->imagehelper('stars/empty.png', $params);
			 	//}
		        return $result;
    	}
    }
}
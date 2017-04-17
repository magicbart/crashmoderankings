<?php 

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
 
class ImageHelper extends AbstractHelper	{
    public function __invoke($imagepath, $params)	{
    	$view = $this->getView();
    	$height = '';
    	$width = '';
    	$alt = '';
    	$title = '';
    	$class = '';
    	
	    if(array_key_exists('height', $params))	{
	    	$height = ' height="'.$params['height'].'"';
	    }
    	if(array_key_exists('width', $params))	{
    		$width = ' width="'.$params['width'].'"';
    	}
    	if(array_key_exists('alt', $params))	{
    		$alt = ' alt="'.$params['alt'].'"';
    	}
    	if(array_key_exists('title', $params))	{
    		$title = ' title="'.$params['title'].'"';
    	}
    	if(array_key_exists('alt_title', $params))	{
    		$alt = ' alt="'.$params['alt_title'].'"';
    		$title = ' title="'.$params['alt_title'].'"';
    	}
    	if(array_key_exists('class', $params))	{
    		$class = 'class = "'.$params['class'].'"';
    	}
    	
    	$result = '<img src="'.$view->basePath('img/'.$imagepath).'"'.$class.$alt.$title.$height.$width.'/>';
    	if(array_key_exists('link', $params))	{
    		$target = '';
    		if(array_key_exists('target', $params))	{
    			$target = ' target="'.$params['target'].'"';
    		}
    		$result = '<a href="'.$params['link'].'"'.$target.'>'.$result.'</a>';
    		
    	}
    	
        return $result;
    }
}
<?php

namespace Score\View\Helper;
use Score\Model\Score;
use Zone\Model\Zone;

use Zend\View\Helper\AbstractHelper;

class ScoreHelper extends AbstractHelper	{
    public function __invoke($score, $type = 'charts')	{
    	$view = $this->getView();

    	if($score instanceof Zone)	{
    		$tmp_array = array('zone' => $score->id, 'zone_name' => $score->name);
    		$score = new Score();
    		$score->exchangeArray($tmp_array);
    	}

    	if(!is_null($score->zone)) {
    		$zone = $view->zonelink($score);
    		$zone_short = $view->zonelink($score, true);
    	} else $zone = null;

    	if(!is_null($score->player)) {
			$player = $view->playerlink($score);
    	}else $player = null;

		if(!is_null($score->car_name)) {
			$car_name = $view->escapeHtml($score->car_name);
			$car_image = 'cars/'.strtolower(str_replace(' ', '', $car_name)) . '.png';
			$car = $view->imageHelper($car_image, array('alt_title' => $car_name, 'height' => '32px'));
		} else $car = null;

		if(!is_null($score->platform))	{
	    	$platform_image = 'logos/'.strtolower($view->escapeHtml($score->platform));
	    	$platform_image = $score->emulator ? $platform_image.'_emulator.png' : $platform_image.'.png';
	    	$platform_name = $score->emulator ? $score->platform.' Emulator' : $score->platform;
	    	$platform = $view->imageHelper($platform_image, array('alt_title' => $platform_name, 'height' => '32px'));
		}
		else $platform = null;

    	$chart_rank = '-';
    	if ((int)$score->chart_rank <= 25)
	    	$chart_rank = $view->positionhelper($score->chart_rank, '32px');

	    if(!is_null($score->score)) {
   			$score_value = '$'.number_format($view->escapeHtml($score->score));
	    } else $score_value = '$0';
   		$score_damage = is_null($score->damage) ? '$?' : '$'.number_format($view->escapeHtml($score->damage));
   		$score_multi = is_null($score->multi) ? '?' : $view->escapeHtml($score->multi);
   		$score_title = $score_damage.' x '.$score_multi.' = '.$score_value;

    	if(!is_null($score->proof_type))	{
	    	$proof = $view->imageHelper('proofs/'.strtolower($view->escapeHtml($score->proof_type)).'.png', array(
	    				'link' => $view->escapeHtml($score->proof_link),
	    				'alt_title' => $view->escapeHtml($score->proof_type),
	    				'height' => '32px',
	    				'target' => '_blank'));
    	}
    	else $proof = null;

    	$freq = $view->escapeHtml($score->freq);
    	$version= $view->escapeHtml($score->version);
    	if(!is_null($freq)||!is_null($version))	{
    		$freq_version = $view->imageHelper('logos/'.strtolower($freq.'_'.$version).'.png', array(
	    				'alt_title' => $version.' '.$freq,
	    				'height' => '32px'));
    	} else $freq_version = null;


    	$glitch = $view->escapeHtml($score->glitch);

    	if(!is_null($score->percent_wr))	{
	    	$percent_wr = $view->escapeHtml($score->percent_wr);
	    	$percent_wr = '<div class="progress" title="% of WR" style="margin-bottom: 0;"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$percent_wr.'" aria-valuemin="0" aria-valuemax="100"
	    	style="width: '.$percent_wr.'%; margin-bottom: 0;">'.$percent_wr.'%</div></div>';
    	} else $percent_wr = null;

    	if(!is_null($score->stars))	{
    		$stars = $view->starhelper($view->escapeHtml($score->stars), array('height' => '16px'));
    	} else $stars = $view->starhelper(0, array('height' => '16px'));

    	/*$stars_percent = '<table class="stars_percent"><tr>'.$stars.'</tr><tr>'.$percent_wr.'</tr></table>';
    	$stars_percent = '<td>'.$stars_percent.'</td>';*/

    	if(!is_null($score->country_name))	{
	    	$country = $view->imageHelper('flags/32/'.strtolower($view->escapeHtml($score->country_iso)).'.png', array(
		    				'alt_title' => $view->escapeHtml($score->country_name),
		    				'height' => '32px'));
    	} else $country = null;

    	$date = (is_null($score->inaccurate)) ?
		    		(!is_null($score->realisation) ?
		    			date('F j, Y', strtotime($score->realisation))
		    		: null)
    			: $score->inaccurate;

    	if(!is_null($score->registration))	{
    		$registration = date('F j, Y', strtotime($score->registration));
    	} else $registration = null;

    	if(!is_null($score->strat_name))	{
    		$strat = $score->strat_name;
    	} else $strat = null;

    	$zone = '<td>'.$zone.'</td>';
    	$zone_short = '<td>'.$zone_short.'</td>';
		$player = '<td>'.$player.'</td>';
		$car = '<td class="text-center">'.$car.'</td>';
		$platform = '<td class="text-center">'.$platform.'</td>';
    	$chart_rank = '<td class="text-center h4">'.$chart_rank.'</td>';
    	$damage = '<td class="text-right score" title="'.$score_title.'">'.$score_damage.'</td>';
    	$multi = '<td class="text-right score" title="'.$score_title.'">'.$score_multi.'</td>';
    	$score_value = '<td class="text-right score" title="'.$score_title.'">'.$score_value.'</td>';
    	$proof = '<td class="text-center">'.$proof.'</td>';
    	$freq_version = '<td class="text-center">'.$freq_version.'</td>';
    	$glitch = '<td>'.$glitch.'</td>';
    	$percent_wr = '<td class="text-center">'.$percent_wr.'</td>';
    	$stars = '<td class="text-center">'.$stars.'</td>';
    	$country = '<td class="text-center">'.$country.'</td>';
    	$date = '<td class="text-right">'.$date.'</td>';
    	$registration = '<td class="text-right">'.$registration.'</td>';
    	$strat = '<td>'.$strat.'</td>';

    	switch($type)	{
    		//$zone $player $car $platform $chart_rank $score_value $proof $freq_version $glitch $percent_wr $stars $country $date $registration
    		case 'charts' : return $chart_rank.$score_value.$car.$country.$player.$platform.$freq_version.$stars.$percent_wr.$proof.$date;
    		case 'pr' : return $zone.$chart_rank.$score_value.$car.$platform.$freq_version.$stars.$percent_wr.$proof.$date;
    		case 'zone_index' : return $country.$player.$score_value;
    		case 'latest-added' : return $zone.$chart_rank.$score_value.$car.$country.$player.$platform.$freq_version.$proof.$registration;
    		case 'latest-achieved' : return $zone.$chart_rank.$score_value.$car.$country.$player.$platform.$freq_version.$proof.$date;
    		case 'lastadded-player' : return $zone.$score_value.$car.$platform.$proof.$registration;
    		case 'lastachieved-player' : return $zone.$score_value.$car.$platform.$proof.$date;
    		case 'wr' : return $score_value.$car.$country.$player.$platform.$freq_version.$proof.$date;
    		case 'type_vid' : return $score_value.$car.$country.$player.$platform.$freq_version.$proof.$date;
    		case 'best_vid' : return $score_value.$car.$country.$player.$platform.$freq_version.$proof.$date;
    		case 'damage_vid' : return $damage.$car.$country.$player.$platform.$freq_version.$proof.$date;
    		case 'freeze' : return $score_value.$car.$country.$player.$platform.$freq_version.$proof.$date;
    		case 'unsorted' : return $score_value.$car.$country.$player.$platform.$freq_version.$proof.$date;
    		case 'best_damages' : return $zone_short.$damage.$car.$country.$player.$platform.$freq_version.$proof.$date;
    		case 'best_multi' : return $zone_short.$multi.$car.$country.$player.$platform.$freq_version.$proof.$date;
    		case 'best_scores' : return $zone_short.$chart_rank.$score_value.$car.$country.$player.$platform.$freq_version.$stars.$percent_wr.$proof.$date;
    		case 'nr' : return $zone_short.$chart_rank.$score_value.$car.$player.$platform.$freq_version.$stars.$percent_wr.$proof.$date;
    		case 'admin' : return $zone_short.$chart_rank.$score_value.$car.$player.$platform.$freq_version.$strat.$proof.$date;
    		default : return $zone.$chart_rank.$score_value.$car.$country.$player.$platform.$freq_version.$stars.$percent_wr.$proof.$date;
    	}
    }
}
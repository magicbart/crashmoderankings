<?php

namespace Score\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Score	{
	public $id, $player, $zone, $car; //int
	public $former_wr, $pr_entry, $emulator; //bool
	public $chart_rank, $best_rank, $score; //int
	public $damage, $multi;
	public $proof_type;
	public $proof_link;
	public $platform, $version, $freq, $glitch; //enums
	public $percent_wr;
	public $stars;
	public $registration;
	public $realisation;
	public $inaccurate;
	public $strat;
	protected $inputFilter;
	
	//Info from join
	public $player_name, $player_url, $country_name, $country_iso, $car_name, $zone_name, $strat_name;

	public function exchangeArray($data)	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->score     = (!empty($data['score'])) ? $data['score'] : null;
		$this->player     = (!empty($data['player'])) ? $data['player'] : null;
		$this->zone     = (!empty($data['zone'])) ? $data['zone'] : null;
		$this->car     = (!empty($data['car'])) ? $data['car'] : null;
		$this->former_wr     = (isset($data['former_wr'])) ? $data['former_wr'] : null;
		$this->pr_entry     = (isset($data['pr_entry'])) ? $data['pr_entry'] : null;
		$this->emulator     = (isset($data['emulator'])) ? $data['emulator'] : null;
		$this->chart_rank     = (!empty($data['chart_rank'])) ? $data['chart_rank'] : null;
		$this->best_rank     = (!empty($data['best_rank'])) ? $data['best_rank'] : null;
		$this->proof_type     = (!empty($data['proof_type'])) ? $data['proof_type'] : null;
		$this->proof_link     = (!empty($data['proof_link'])) ? $data['proof_link'] : null;
		$this->platform     = (!empty($data['platform'])) ? $data['platform'] : null;
		$this->version     = (!empty($data['version'])) ? $data['version'] : null;
		$this->freq     = (!empty($data['freq'])) ? $data['freq'] : null;
		$this->glitch     = (!empty($data['glitch'])) ? $data['glitch'] : null;
		$this->percent_wr     = (!empty($data['percent_wr'])) ? $data['percent_wr'] : null;
		$this->stars     = (!empty($data['stars'])) ? $data['stars'] : null;
		$this->registration     = (!empty($data['registration'])) ? $data['registration'] : date('Y-m-d H:i:s');
		$this->realisation     = (!empty($data['realisation'])) ? $data['realisation'] : null;
		$this->inaccurate     = (!empty($data['inaccurate'])) ? $data['inaccurate'] : null;
		$this->damage     = (!empty($data['damage'])) ? $data['damage'] : null;
		$this->multi     = (!empty($data['multi'])) ? $data['multi'] : null;
		$this->strat = (!empty($data['strat'])) ? $data['strat'] : null;
		
		$this->player_name = (!empty($data['player_name'])) ? $data['player_name'] : null;
		$this->player_url = (!empty($data['player_url'])) ? $data['player_url'] : null;
		$this->country_name = (!empty($data['country_name'])) ? $data['country_name'] : null;
		$this->country_iso = (!empty($data['country_iso'])) ? $data['country_iso'] : null;
		$this->car_name = (!empty($data['car_name'])) ? $data['car_name'] : null;
		$this->zone_name = (!empty($data['zone_name'])) ? $data['zone_name'] : null;
		$this->strat_name = (!empty($data['strat_name'])) ? $data['strat_name'] : null;
		
	}

	public function getArrayCopy()	{
		return get_object_vars($this);
	}

	public function setInputFilter(InputFilterInterface $inputFilter)	{
		throw new \Exception("Not used");
	}
	
public function getInputFilter()	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
	
			$inputFilter->add(array(
				'name'     => 'id',
				'required' => true,
				'filters'  => array(
					array('name' => 'Int'),
				),
			));
			
            $inputFilter->add(array(
				'name'     => 'realisation',
				'required' => false,
            ));
            $inputFilter->add(array(
				'name'     => 'strat',
				'required' => false,
            ));
            
            $inputFilter->add(array(
				'name'     => 'proof_type',
				'required' => false,
            ));
            $inputFilter->add(array(
				'name'     => 'platform',
				'required' => false,
            ));
            $inputFilter->add(array(
				'name'     => 'version',
				'required' => false,
            ));
            $inputFilter->add(array(
				'name'     => 'freq',
				'required' => false,
            ));
            $inputFilter->add(array(
				'name'     => 'glitch',
				'required' => false,
            ));
            $inputFilter->add(array(
				'name'     => 'emulator',
				'required' => false,
            ));
            $inputFilter->add(array(
				'name'     => 'former_wr',
				'required' => false,
            ));
	
			$inputFilter->add(array(
				'name'     => 'score',
				'required' => true,
				'validators'  => array(
					array('name' => 'Int'),
					array('name' => 'GreaterThan',
				        'options' => array(
				        	'min' => 0,
				        	'inclusive' => false
						),
					),
				),
			));
			
			$inputFilter->add(array(
				'name'     => 'damage',
				'required' => false,
				'filters'  => array(
					array('name' => 'Int'),
				),
			));
			
			$inputFilter->add(array(
				'name'     => 'multi',
				'required' => false,
				'filters'  => array(
					array('name' => 'Int'),
				),
			));
			
			$inputFilter->add(array(
                'name' => 'proof_link',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'max' => 255,
                            'messages' => array(
                                'stringLengthTooLong' => 'Stored URL can only be 255 chars, use tinyurl.com to shorten your URL'
                            ),
                        ),
                    ),
                ),
            ));
            $inputFilter->add(array(
				'name'     => 'inaccurate',
				'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}
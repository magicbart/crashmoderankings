<?php

namespace Zone\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Zone	{
	public $id;
	public $name;
	public $ps2, $dmg_wr_known;
	public $description;
	public $best_damage, $best_multi, $best_total;
	public $glitch;
	public $top25_channel, $bestvids_channel;
	public $stars;
	public $forum;
	protected $inputFilter;
	protected $starsFilter;

	public function exchangeArray($data)	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->name = (!empty($data['name'])) ? $data['name'] : null;
		$this->description  = (!empty($data['description'])) ? $data['description'] : null;
		$this->best_damage  = (!empty($data['best_damage'])) ? $data['best_damage'] : null;
		$this->best_multi  = (!empty($data['best_multi'])) ? $data['best_multi'] : null;
		$this->best_total  = (!empty($data['best_total'])) ? $data['best_total'] : null;
		$this->glitch  = (!empty($data['glitch'])) ? $data['glitch'] : null;
		$this->top25_channel  = (!empty($data['top25_channel'])) ? $data['top25_channel'] : null;
		$this->bestvids_channel  = (!empty($data['bestvids_channel'])) ? $data['bestvids_channel'] : null;
		$this->ps2  = (isset($data['ps2'])) ? $data['ps2'] : null;
		$this->dmg_wr_known  = (isset($data['dmg_wr_known'])) ? $data['dmg_wr_known'] : null;
		$this->stars = (!empty($data['stars'])) ? $data['stars'] : null;
		$this->forum = (!empty($data['forum'])) ? $data['forum'] : null;
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
			'name'     => 'name',
			'required' => true,
			'filters'  => array(
				array('name' => 'StringTrim'),
			),
		));
		
		$inputFilter->add(array(
			'name'     => 'description',
			'required' => true,
			'filters'  => array(
				array('name' => 'StringTrim'),
			),
		));
		
		$inputFilter->add(array(
			'name'     => 'best_damage',
			'required' => true,
			'validators'  => array(
				array('name' => 'Int'),
			),
		));
		
		$inputFilter->add(array(
			'name'     => 'best_multi',
			'required' => true,
			'validators'  => array(
				array('name' => 'Int'),
			),
		));
		
		$inputFilter->add(array(
			'name'     => 'best_total',
			'required' => true,
			'validators'  => array(
				array('name' => 'Int'),
			),
		));
		
		$inputFilter->add(array(
			'name'     => 'top25_channel',
			'required' => true,
			'filters'  => array(
				array('name' => 'StringTrim'),
			),
		));
		
		$inputFilter->add(array(
			'name'     => 'bestvids_channel',
			'required' => true,
			'filters'  => array(
				array('name' => 'StringTrim'),
			),
		));
		
		$inputFilter->add(array(
			'name'     => 'stars',
			'required' => true,
			'filters'  => array(
				array('name' => 'StringTrim'),
			),
		));
		
		$inputFilter->add(array(
			'name'     => 'forum',
			'required' => true,
			'filters'  => array(
				array('name' => 'StringTrim'),
			),
		));
		
		$this->inputFilter = $inputFilter;
	}
	return $this->inputFilter;
	}
}
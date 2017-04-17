<?php

namespace Zone\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Strat	{
	public $id;
	public $name;
	public $zone;
	public $description;
	public $hz50, $hz60, $gc, $xbox, $ps2;
	public $best_damage, $best_multi, $best_total;
	public $cars;
	public $scores;
	protected $inputFilter;

	public function exchangeArray($data)	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->name = (!empty($data['name'])) ? $data['name'] : null;
		$this->description  = (!empty($data['description'])) ? $data['description'] : null;
		$this->best_damage  = (!empty($data['best_damage'])) ? $data['best_damage'] : null;
		$this->best_multi  = (!empty($data['best_multi'])) ? $data['best_multi'] : null;
		$this->best_total  = (!empty($data['best_total'])) ? $data['best_total'] : null;
		$this->zone  = (!empty($data['zone'])) ? $data['zone'] : null;
		$this->cars  = (!empty($data['cars'])) ? $data['cars'] : array();
		
		$this->ps2  = (isset($data['ps2'])) ? $data['ps2'] : null;
		$this->hz50  = (isset($data['hz50'])) ? $data['hz50'] : null;
		$this->hz60  = (isset($data['hz60'])) ? $data['hz60'] : null;
		$this->gc  = (isset($data['gc'])) ? $data['gc'] : null;
		$this->xbox  = (isset($data['xbox'])) ? $data['xbox'] : null;
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
			'name'     => 'zone',
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
			'name'     => 'cars',
			'required' => false,
		));
		
		$this->inputFilter = $inputFilter;
	}
	return $this->inputFilter;
	}
}
<?php

namespace Country\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Country	{
	public $id;
	public $name;
	public $name_url;
	public $abr;
	public $iso;
	protected $inputFilter;

	public function exchangeArray($data)	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->name = (!empty($data['name'])) ? $data['name'] : null;
		$this->name_url = (!empty($data['name'])) ? str_replace(' ', '-', $data['name']) : null;
		$this->abr = (!empty($data['abr'])) ? strtoupper($data['abr']) : null;
		$this->iso = (!empty($data['iso'])) ? strtolower($data['iso']) : null;
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
				'name'     => 'abr',
				'required' => true,
				'filters'  => array(
					array('name' => 'StringTrim'),
				),
				'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 3,
                        ),
                    ),
                ),
			));
	
			$inputFilter->add(array(
				'name'     => 'iso',
				'required' => true,
				'filters'  => array(
					array('name' => 'StringTrim'),
				),
				'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 2,
                            'max'      => 2,
                        ),
                    ),
                ),
			));
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}
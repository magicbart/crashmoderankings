<?php

namespace News\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class News	{
	public $id;
	public $content;
	public $registration;
	protected $inputFilter;

	public function exchangeArray($data)	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->content = (!empty($data['content'])) ? $data['content'] : null;
		$this->registration  = (!empty($data['registration'])) ? $data['registration'] : date('Y-m-d H:i:s');
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
			'name'     => 'content',
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
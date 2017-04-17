<?php

namespace Player\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Player	{
	public $id;
	public $name;
	public $name_url;
	public $country;
	public $notes;
	public $total, $avg_pos, $avg_stars, $avg_percent;
	public $total_rank, $avg_pos_rank, $avg_stars_rank, $avg_percent_rank;
	public $wcr_channel, $personnal_channel;
	public $xbl_total;
	protected $inputFilter;
	
	//join info
	public $country_name;
	public $country_iso;

	public function exchangeArray($data)	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->name = (!empty($data['name'])) ? $data['name'] : null;
		$this->name_url = (!empty($data['name'])) ? str_replace(' ', '-', $data['name']) : null;
		$this->country  = (!empty($data['country'])) ? $data['country'] : null;
		$this->notes  = (!empty($data['notes'])) ? $data['notes'] : null;
		$this->total  = (!empty($data['total'])) ? $data['total'] : null;
		$this->avg_pos  = (!empty($data['avg_pos'])) ? $data['avg_pos'] : null;
		$this->avg_percent  = (!empty($data['avg_percent'])) ? $data['avg_percent'] : null;
		$this->avg_stars  = (!empty($data['avg_stars'])) ? $data['avg_stars'] : null;
		$this->total_rank  = (!empty($data['total_rank'])) ? $data['total_rank'] : null;
		$this->avg_pos_rank  = (!empty($data['avg_pos_rank'])) ? $data['avg_pos_rank'] : null;
		$this->avg_percent_rank  = (!empty($data['avg_percent_rank'])) ? $data['avg_percent_rank'] : null;
		$this->avg_stars_rank  = (!empty($data['avg_stars_rank'])) ? $data['avg_stars_rank'] : null;
		$this->wcr_channel  = (!empty($data['wcr_channel'])) ? $data['wcr_channel'] : null;
		$this->personnal_channel  = (!empty($data['personnal_channel'])) ? $data['personnal_channel'] : null;
		$this->xbl_total  = (isset($data['xbl_total'])) ? $data['xbl_total'] : null;
		$this->country_name = (!empty($data['country_name'])) ? $data['country_name'] : null;
		$this->country_iso = (!empty($data['country_iso'])) ? $data['country_iso'] : null;
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
				'name'     => 'notes',
				'required' => false,
				'filters'  => array(
					array('name' => 'StringTrim'),
				),
			));
	
			$inputFilter->add(array(
				'name'     => 'wcr_channel',
				'required' => false,
				'filters'  => array(
					array('name' => 'StringTrim'),
				),
			));
	
			$inputFilter->add(array(
				'name'     => 'youtube_channel',
				'required' => false,
				'filters'  => array(
					array('name' => 'StringTrim'),
				),
			));
			
			$inputFilter->add(array(
				'name'     => 'xbl_total',
				'required' => true,
			));
			
			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
}
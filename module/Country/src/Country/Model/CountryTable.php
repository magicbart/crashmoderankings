<?php

namespace Country\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class CountryTable	{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)	{
		$this->tableGateway = $tableGateway;
	}
	
	public function getCountries($params)	{
		$resultSet = $this->tableGateway->select( function (Select $select) use ($params)	{
			if(array_key_exists('order', $params))	{
				$select->order($params['order']);
			}
		});
		return $resultSet;
	}
	
	public function getCountry($id)	{
		$resultSet = $this->tableGateway->select(array('id' => $id));
		$row = $resultSet->current();
		if (!$row) {
			throw new \Exception("Could not find country id $id");
		}
		return $row;
	}
	
	public function getCountryFromURL($name_url)	{
		$resultSet = $this->tableGateway->select(array('name_url' => $name_url));
		$row = $resultSet->current();
		if (!$row) {
			throw new \Exception("Could not find country's url $name_url");
		}
		return $row;
	}
	
	public function saveCountry(Country $country)	{
		$data = array(
			'name' => $country->name,
			'name_url' => $country->name_url,
			'abr' => $country->abr,
			'iso' => $country->iso,
		);
		$id = (int) $country->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getCountry($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Country id does not exist');
			}
		}
	}
	
	public function deleteCountry($country_id)	{
		$this->tableGateway->delete(array('id' => $country_id));
	}
}
<?php

namespace Zone\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class StratTable	{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getStratArray($zone_id) {
		$strats = array();
		$results = $this->getStrats(array('zone_id' => $zone_id, 'order' => 'name ASC'));
		foreach ($results as $row)	{
    		$strats[$row->id] = $row->name;
		}
		return $strats;
	}

	public function getStrat($id) {
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find Strat $id");
		}
		$row->cars = $this->getStratCars($id);
		return $row;
	}

	public function getStrats($params)	{
		$resultSet = $this->tableGateway->select( function (Select $select) use ($params)	{
			if(array_key_exists('zone_id', $params))	{
				$select->where(array('zone' => $params['zone_id']));
			}
			if(array_key_exists('order', $params))	{
				$select->order($params['order']);
			}
		});
		$resultArray = array();
		foreach ($resultSet as $row) {
			$row->cars = $this->getStratCars($row->id);
			$resultArray[] = $row;
		}
		return $resultArray;
	}

	public function getStratCars($id)	{
		$id  = (int) $id;
		$cars = array();
		$sql = new Sql($this->tableGateway->getAdapter(), 'strats_cars');
		$select = $sql->select();
		$select->join('cars', 'car=cars.id', array('car_name' => 'name'), 'left');
		$select->where(array('strat' => $id));
		$stmt = $sql->prepareStatementForSqlObject($select);
        $resultSet = $stmt->execute();
        foreach ($resultSet as $row) {
    		$cars[(int) $row['car']] = $row['car_name'];
		}
		return $cars;
	}

	public function saveStrat(Strat $strat)	{
		$id = (int) $strat->id;
		$data = array(
			'name' => $strat->name,
			'zone' => $strat->zone,
			'description' => $strat->description,
			'best_damage' => $strat->best_damage,
			'best_multi' => $strat->best_multi,
			'best_total' => $strat->best_total,
			'hz50' => $strat->hz50,
			'hz60' => $strat->hz60,
			'gc' => $strat->gc,
			'xbox' => $strat->xbox,
			'ps2' => $strat->ps2,
		);
		if ($id == 0) {
			$this->tableGateway->insert($data);
			$lastid = $this->tableGateway->adapter->getDriver()->getLastGeneratedValue();
			$this->saveStratCars($lastid, $strat->cars);
		} else {
			if ($this->getStrat($id)) {
				$this->tableGateway->update($data, array('id' => $id));
				$this->saveStratCars($id, $strat->cars);
			} else {
				throw new \Exception('Strat id does not exist');
			}
		}
	}

	private function saveStratCars($id, array $cars)	{
		$sql = new Sql($this->tableGateway->getAdapter(), 'strats_cars');
		$delete = $sql->delete();
		$delete->where(array('strat' => $id));
		$stmt = $sql->prepareStatementForSqlObject($delete);
		$stmt->execute();
		foreach ($cars as $car_id => $car_name)	{
			$insert = $sql->insert();
			$insert->values(array('strat' => $id, 'car' => $car_id));
			$stmt = $sql->prepareStatementForSqlObject($insert);
			$stmt->execute();
		}
	}

	public function deleteStrat($id)	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}
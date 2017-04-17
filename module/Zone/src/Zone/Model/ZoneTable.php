<?php

namespace Zone\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class ZoneTable	{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
	
	public function getZoneArray()	{
		$zones = array();
		$results = $this->tableGateway->select();
		while ($row = $results->current()) {
    		$zones[$row->id] = $row->id.' - '.$row->name;
		}
		return $zones;
	}

	public function getZone($id)	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find Zone $id");
		}
		$row->stars = $this->getStars($id);
		return $row;
	}
	
	public function getStars($zone_id)	{
		$zone_id = (int) $zone_id;
		$stars = array();
		$sql = new Sql($this->tableGateway->getAdapter(), 'stars');
		$select = $sql->select()->where(array('zone' => $zone_id))->columns(array('score','nb_stars'))->order('nb_stars DESC');
		$stmt = $sql->prepareStatementForSqlObject($select);
		$results = $stmt->execute();
		while ($row = $results->current()) {
    		$stars[(int)$row['nb_stars']] = (int) $row['score'];
		}
		return $stars;
	}

	public function saveZone(Zone $zone)	{
		$id = (int) $zone->id;
		if ($this->getZone($id)) {
			$data = array(
				'name' => $zone->name,
				'ps2' => $zone->ps2,
				'description' => $zone->description,
				'best_damage' => $zone->best_damage,
				'best_multi' => $zone->best_multi,
				'best_total' => $zone->best_total,
				'glitch' => $zone->glitch,
				'dmg_wr_known' => $zone->dmg_wr_known,
				'top25_channel' => $zone->top25_channel,
				'bestvids_channel' => $zone->bestvids_channel,
			);
			$this->tableGateway->update($data, array('id' => $id));
			$this->saveStars($zone);
		} else {
			throw new \Exception('Zone id does not exist');
		}
	}
	
	private function saveStars(Zone $zone)	{
		$id = (int) $zone->id;
		$changed = false;
		if ($this->getZone($id)) {
			foreach ($zone->stars as $nb_stars => $star_score)	{
				$sql = new Sql($this->tableGateway->getAdapter(), 'stars');
				$update = $sql->update();
				$update->set(array('score' => $star_score))->where(array('nb_stars' => $nb_stars, 'zone' => $id));
				$stmt = $sql->prepareStatementForSqlObject($update);
				if ($stmt->execute()->count() > 0)
					$changed = true;
			}
			if ($changed)
				$this->updateStars($id);
		}
	}
	
	public function updateStars($zone_id)	{
		$id = (int) $zone_id;
		$stmt = $this->tableGateway->getAdapter()->createStatement();
    	$stmt->prepare('CALL update_stars(?)'); 
	    $stmt->getResource()->bindParam(1, $zone_id, \PDO::PARAM_INT); 
	    $stmt->execute();
	}
}
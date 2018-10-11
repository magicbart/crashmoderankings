<?php

namespace Player\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Expression;

class PlayerTable	{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)	{
		$this->tableGateway = $tableGateway;
	}

	public function getPlayerArray()	{
		$players = array();
        $resultSet = $this->getPlayers(array('order' => 'name ASC'));
        foreach ($resultSet as $row) {
            $players[$row->id] = $row->name;
        }
		return $players;
	}

	public function getPlayerArrayURL()	{
		$players = array();
        $resultSet = $this->getPlayers(array('order' => 'name ASC'));
        foreach ($resultSet as $row) {
    		$players[$row->name_url] = $row->name;
		}
		return $players;
	}

	public function getPlayer($id)	{
		$resultSet = $this->getPlayers(array('id' => $id));
		$row = $resultSet->current();
		if (!$row) {
			throw new \Exception("Could not find player id $id");
		}
		return $row;
	}

	public function getPlayerFromURL($name_url)	{
		$resultSet = $this->getPlayers(array('name_url' => $name_url));
		$row = $resultSet->current();
		if (!$row) {
			throw new \Exception("Could not find player's url $name_url");
		}
		return $row;
	}

	public function getPlayers($params)	{
		$resultSet = $this->tableGateway->select(function (Select $select) use ($params)	{
			$select->join('countries', 'players.country=countries.id', array('country_name' => 'name', 'country_iso' => 'iso'));
			if(array_key_exists('id', $params))	{
				$select->where(array('players.id' => $params['id']));
			}
			if(array_key_exists('name_url', $params))	{
				$select->where(array('players.name_url' => $params['name_url']));
			}
			if(array_key_exists('order', $params))	{
				$select->order($params['order']);
			}
			if(array_key_exists('limit', $params))	{
				$select->where($params['limit']);
			}
			if(array_key_exists('country', $params))	{
				$select->where(array('country' => $params['country']));
			}
		});
		return $resultSet;
	}

	public function savePlayer(Player $player)	{
		$data = array(
			'name' => $player->name,
			'name_url' => $player->name_url,
			'country'  => $player->country,
			'notes'  => $player->notes,
			'wcr_channel'  => $player->wcr_channel,
			'personnal_channel'  => $player->personnal_channel,
			'xbl_total'  => $player->xbl_total,

		);
		$id = (int) $player->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getPlayer($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('Player id does not exist');
			}
		}
	}

	public function deletePlayer($player_id)	{
		$this->tableGateway->delete(array('id' => $player_id));
	}

	public function getPlatforms($player_id)	{
		$player_id = (int) $player_id;
		$platforms = array();
		$sql = new Sql($this->tableGateway->getAdapter(), 'scores');
		$select = $sql->select()->where(array('player' => $player_id))->columns(array(new Expression('DISTINCT(platform) as platform')))->order('platform DESC');
		$stmt = $sql->prepareStatementForSqlObject($select);
        $resultSet = $stmt->execute();
        foreach ($resultSet as $row) {
			if(!is_null($row['platform']))
    			$platforms[] = $row['platform'];
		}
		return $platforms;
	}

	public function getPlayersFromCountry($country_id)	{
		return $this->getPlayers(array('country' => $country_id, 'order' => 'avg_pos_rank ASC'));
	}

	public function getCountries()	{
		$countries = array();
		$sql = new Sql($this->tableGateway->getAdapter(), 'countries');
		$select = $sql->select()->columns(array('id' => 'id', 'name' => 'name'))->order('name ASC');
		$stmt = $sql->prepareStatementForSqlObject($select);
        $resultSet = $stmt->execute();
        foreach ($resultSet as $row) {
    		$countries[$row['id']] = $row['name'];
		}
		return $countries;
	}
}
<?php

namespace Score\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
 use Zend\Paginator\Adapter\DbSelect;
 use Zend\Paginator\Paginator;
use Zend\Db\Sql\Update;
use Zend\Db\Sql\Predicate\IsNotNull;

use Zend\Db\Sql\Sql;

class ScoreTable	{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
	
	public function getScore($id)	{
		$id  = (int) $id;
		$rowset = $this->getScores(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}
	
	public function getScores($params, $paginated = false)	{
		$select = new Select('scores');
		$select->join('players', 'player=players.id', array('player_name' => 'name', 'player_url' => 'name_url'))
			->join('countries', 'players.country=countries.id', array('country_name' => 'name', 'country_iso' => 'iso'))
			->join('cars', 'car=cars.id', array('car_name' => 'name'), 'left')
			->join('zones', 'zone=zones.id', array('zone_name' => 'name'))
			->join('strats', 'strat=strats.id', array('strat_name' => 'name'), 'left');
		if(array_key_exists('id', $params))	{
			$select->where(array('scores.id' => $params['id']));
		}
		if(array_key_exists('zone_id', $params))	{
			$select->where(array('scores.zone' => $params['zone_id']));
		}
		if(array_key_exists('player_id', $params))	{
			$select->where(array('scores.player' => $params['player_id']));
		}
		if(array_key_exists('glitch', $params))	{
			$select->where(array('scores.glitch' => $params['glitch']));
		}
		if(array_key_exists('strat', $params))	{
			$select->where(array('scores.strat' => $params['strat']));
		}
		if(in_array('ranked', $params))	{
			$select->where(new IsNotNull('chart_rank'));
		}
		if(array_key_exists('proof_type', $params))	{
			$select->where(array('scores.proof_type' => $params['proof_type']));
		}
		if(array_key_exists('order', $params))	{
			$select->order($params['order']);
		}	else {
			$select->order('score DESC');
		}
		if(array_key_exists('limit', $params))	{
			$select->limit($params['limit']);
		}
		if(array_key_exists('rank_min', $params))	{
			$select->where('chart_rank >= '.$params['rank_min']);
		}
		if(array_key_exists('rank_max', $params))	{
			$select->where('chart_rank <= '.$params['rank_max']);
		}
		if(array_key_exists('score_min', $params))	{
			$select->where('score >= '.$params['score_min']);
		}
		if(array_key_exists('score_max', $params))	{
			$select->where('score <= '.$params['score_max']);
		}
		if(in_array('former_wr', $params))	{
			$select->where(array('scores.former_wr' => true));
		}
		if(in_array('wr', $params))	{
			$select->where(array('scores.chart_rank' => 1));
		}
		
		
		if ($paginated) {
             $resultSetPrototype = new ResultSet();
             $resultSetPrototype->setArrayObjectPrototype(new Score());
             $paginatorAdapter = new DbSelect(
                 $select,
                 $this->tableGateway->getAdapter(),
                 $resultSetPrototype
             );
             $paginator = new Paginator($paginatorAdapter);
             return $paginator;
         }
		$resultSet = $this->tableGateway->selectWith($select);
		return $resultSet;
	}
	
	public function getBestVids($params)	{
		//SELECT * from scores where (zone, score) IN (SELECT zone, max(score) from scores where glitch in ('None', 'Glitch') group by zone) order by zone asc
		$resultSet = $this->tableGateway->select( function (Select $select) use ($params)	{
			$sub = new Select('scores');
			$max_value = 'score';
			if(array_key_exists('max_value', $params))	{
				$max_value = $params['max_value'];
			}
			$sub->columns(array(new \Zend\Db\Sql\Expression("zone AS zone, MAX(".$max_value.") AS ".$max_value)))
				->group('zone');
			if(array_key_exists('proof_type', $params))	{
				$sub->where(array('proof_type' => $params['proof_type']));
			} else	{
				$sub->where(array('proof_type' => array('Replay', 'Live')));
			}
			if(array_key_exists('glitch', $params))	{
				$sub->where(array('glitch' => $params['glitch']));
			}
			else
				$sub->where(array('glitch' => array('None', 'Glitch')));
				
			if(array_key_exists('platform', $params))	{
				$sub->where(array('platform' => $params['platform']));
			}
			if(array_key_exists('freq', $params))	{
				$sub->where(array('freq' => $params['freq']));
			}
			
			$select->join('players', 'player=players.id', array('player_name' => 'name', 'player_url' => 'name_url'))
				->join('countries', 'players.country=countries.id', array('country_name' => 'name', 'country_iso' => 'iso'))
				->join('cars', 'car=cars.id', array('car_name' => 'name'), 'left')
				->join('zones', 'zone=zones.id', array('zone_name' => 'name'))
				->join(array('temp' => $sub), 'temp.zone = scores.zone AND temp.'.$max_value.' = scores.'.$max_value);
			$select->order('scores.zone ASC');
		});
		return $resultSet;
	}
	
	public function getBestMultiVid($params)	{
		//SELECT * FROM scores WHERE id = (SELECT id FROM scores AS lookup WHERE lookup.zone = scores.zone ORDER BY multi DESC , score DESC LIMIT 1 ) ORDER BY zone ASC 
		$resultSet = $this->tableGateway->select( function (Select $select) use ($params)	{
			/*$sub = new Select();
			$sub->from(array('temp' => 'scores'))
				->columns(array('id' => 'id'))
				->where(array('temp.glitch' => array('None', 'Glitch')))
				->where('temp.zone=scores.zone')
				->order('temp.multi DESC, temp.score DESC')
				->limit(1);*/
			
			$select->join('players', 'player=players.id', array('player_name' => 'name', 'player_url' => 'name_url'))
				->join('countries', 'players.country=countries.id', array('country_name' => 'name', 'country_iso' => 'iso'))
				->join('cars', 'car=cars.id', array('car_name' => 'name'), 'left')
				->join('zones', 'zone=zones.id', array('zone_name' => 'name'));
			$select->where("scores.id = (SELECT id FROM scores AS lookup WHERE lookup.glitch IN ('None', 'Glitch') AND lookup.proof_type IN ('Replay', 'Live') AND lookup.zone = scores.zone ORDER BY multi DESC , score DESC LIMIT 1)");
			$select->order('scores.zone ASC');
		});
		return $resultSet;
	}
	
	public function getNRs($country_id)	{
		$resultSet = $this->tableGateway->select( function (Select $select) use ($country_id)	{
			$select->join('players', 'player=players.id', array('player_name' => 'name', 'player_url' => 'name_url'))
				->join('countries', 'players.country=countries.id', array('country_name' => 'name', 'country_iso' => 'iso'))
				->join('cars', 'car=cars.id', array('car_name' => 'name'), 'left')
				->join('zones', 'zone=zones.id', array('zone_name' => 'name'))
				->where('scores.id = (SELECT lookup.id FROM scores as lookup JOIN players as players_tmp on players_tmp.id = lookup.player WHERE lookup.zone = scores.zone AND players_tmp.country = '.$country_id.' AND lookup.chart_rank IS NOT NULL ORDER BY lookup.score DESC LIMIT 1)')
				->order('scores.zone ASC');
		});
		return $resultSet;
	}

	
	public function saveScore(Score $score)	{
		$id = (int) $score->id;
		if ($id == 0) {
			$this->addScore($score);
		} else {
			if ($this->getScore($id)) {
				$this->updateScore($score);
			} else {
				throw new \Exception('Score id does not exist');
			}
		}
	}
	
	private function addScore(Score $score)	{
		$stmt = $this->tableGateway->getAdapter()->createStatement();
    	$stmt->prepare('CALL add_score(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
	    $stmt->getResource()->bindParam(1, $score->player, \PDO::PARAM_INT);
	    $stmt->getResource()->bindParam(2, $score->zone, \PDO::PARAM_INT);
	    $stmt->getResource()->bindParam(3, $score->car, \PDO::PARAM_INT);
	    $stmt->getResource()->bindParam(4, $score->proof_type, \PDO::PARAM_STR);
	    $stmt->getResource()->bindParam(5, $score->proof_link, \PDO::PARAM_STR);
	    $stmt->getResource()->bindParam(6, $score->platform, \PDO::PARAM_STR);
	    $stmt->getResource()->bindParam(7, $score->version, \PDO::PARAM_STR);
	    $stmt->getResource()->bindParam(8, $score->freq, \PDO::PARAM_STR);
	    $stmt->getResource()->bindParam(9, $score->emulator, \PDO::PARAM_BOOL);
	    $stmt->getResource()->bindParam(10, $score->glitch, \PDO::PARAM_STR);
	    $stmt->getResource()->bindParam(11, $score->registration, \PDO::PARAM_STR);
	    $stmt->getResource()->bindParam(12, $score->realisation, \PDO::PARAM_STR);
	    $stmt->getResource()->bindParam(13, $score->inaccurate, \PDO::PARAM_STR);
	    $stmt->getResource()->bindParam(14, $score->score, \PDO::PARAM_INT);
	    $stmt->getResource()->bindParam(15, $score->multi, \PDO::PARAM_INT);
	    $stmt->getResource()->bindParam(16, $score->damage, \PDO::PARAM_INT);
	    $stmt->getResource()->bindParam(17, $score->strat, \PDO::PARAM_INT);
	    $stmt->execute();
	}
	
	private function updateScore(Score $score)	{
		$id = (int) $score->id;
		$data = array(
			'player' => $score->player,
			'zone' => $score->zone,
			'car'  => $score->car,
			'former_wr'  => $score->former_wr,
			'emulator'  => $score->emulator,
			'proof_type'  => $score->proof_type,
			'proof_link'  => $score->proof_link,
			'platform'  => $score->platform,
			'version'  => $score->version,
			'freq'  => $score->freq,
			'realisation'  => $score->realisation,
			'inaccurate'  => $score->inaccurate,
			'multi'  => $score->multi,
			'damage'  => $score->damage,
			'strat' => $score->strat,
		);
		$this->tableGateway->update($data, array('id' => $id));
		$stmt = $this->tableGateway->getAdapter()->createStatement();
    	$stmt->prepare('CALL update_score(?,?,?)');
	    $stmt->getResource()->bindParam(1, $id, \PDO::PARAM_INT);
	    $stmt->getResource()->bindParam(2, $score->score, \PDO::PARAM_INT);
	    $stmt->getResource()->bindParam(3, $score->glitch, \PDO::PARAM_STR);
	    $stmt->execute();
	}
	
	public function deleteScore($id)	{
		$id = (int) $id;
		$stmt = $this->tableGateway->getAdapter()->createStatement();
    	$stmt->prepare('CALL delete_score(?)');
	    $stmt->getResource()->bindParam(1, $id, \PDO::PARAM_INT);
	    $stmt->execute();
	}
	
	public function updateStars($zone_id)	{
		$this->tableGateway->update(array('stars' => 'get_stars('.$zone_id.',score)'), array('score' => $star_score));
	}
	
	public function getTopScores($zone_id)	{
		return $this->getScores(array('ranked', 'zone_id' => $zone_id, 'order' => 'score DESC', 'limit' => 25));
	}
	
	public function getFreezeScores($zone_id)	{
		return $this->getScores(array('zone_id' => $zone_id, 'order' => 'score DESC', 'glitch' => 'Freeze'));
	}
	
	public function getUnsortedScores($zone_id, $params)	{
		$resultSet = $this->tableGateway->select( function (Select $select) use ($zone_id, $params)	{
			$sub = new Select('scores');
			$sub->columns(array(new \Zend\Db\Sql\Expression("player as player, MAX(score) AS score")))
				->group('player')
				->where(array('proof_type' => array('Replay', 'Live'), 'zone' => $zone_id));
			if(array_key_exists('glitch', $params))	{
				$sub->where(array('glitch' => $params['glitch']));
			}
			
			$select->join('players', 'player=players.id', array('player_name' => 'name', 'player_url' => 'name_url'))
				->join('countries', 'players.country=countries.id', array('country_name' => 'name', 'country_iso' => 'iso'))
				->join('cars', 'car=cars.id', array('car_name' => 'name'), 'left')
				->join('zones', 'zone=zones.id', array('zone_name' => 'name'))
				->join(array('temp' => $sub), 'temp.player = scores.player AND temp.score = scores.score');
			$select->order('scores.score DESC');
			if(array_key_exists('limit', $params))	{
				$select->limit($params['limit']);
			}
		});
		return $resultSet;
	}
	
	public function getBestScore($params)	{
		$params['limit'] = 1;
		return $this->getScores($params)->current();
	}
	
	public function getFormerWRs($zone_id)	{
		return $this->getScores(array('former_wr', 'zone_id' => $zone_id, 'order' => 'score ASC'));
	}
	
	public function getCurrentWRs()	{
		return $this->getScores(array('wr', 'order' => 'zone ASC'));
	}

	public function getPRs($player_id)	{
		return $this->getScores(array('player_id' => $player_id, 'ranked', 'order' => 'zone ASC'))->buffer();
	}

	public function getLastAdded($player_id)	{
		return $this->getScores(array('player_id' => $player_id, 'order' => 'registration DESC'), true);
	}

	public function getLastAchieved($player_id)	{
		return $this->getScores(array('player_id' => $player_id, 'order' => 'realisation DESC'), true);
	}
	
	public function getCarArray()	{
		$cars = array();
		$sql = new Sql($this->tableGateway->getAdapter(), 'cars');
		$select = $sql->select();
		$stmt = $sql->prepareStatementForSqlObject($select);
		$results = $stmt->execute();
		while ($row = $results->current()) {
    		$cars[$row['id']] = $row['name'];
		}
		return $cars;
	}
}
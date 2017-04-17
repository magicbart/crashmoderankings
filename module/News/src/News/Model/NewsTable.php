<?php

namespace News\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
 use Zend\Paginator\Adapter\DbSelect;
 use Zend\Paginator\Paginator;

class NewsTable	{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll($paginated=false)	{
         if ($paginated) {
             $select = new Select('news');
             $select->order('registration DESC');
             $resultSetPrototype = new ResultSet();
             $resultSetPrototype->setArrayObjectPrototype(new News());
             $paginatorAdapter = new DbSelect(
                 $select,
                 $this->tableGateway->getAdapter(),
                 $resultSetPrototype
             );
             $paginator = new Paginator($paginatorAdapter);
             return $paginator;
         }
         $resultSet = $this->tableGateway->select(function (Select $select)	{
			$select->order('registration DESC');
		});
		return $resultSet;
	}

	public function getNews($id)	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveNews(News $news)	{
		$data = array(
			'content' => $news->content,
		);

		$id = (int) $news->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getNews($id)) {
				$this->tableGateway->update($data, array('id' => $id));
			} else {
				throw new \Exception('News id does not exist');
			}
		}
	}

	public function deleteNews($id)	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}
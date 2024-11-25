<?php
/**
 * @link      https://github.com/sbrdbry/reimagined-octo-waddle.git for the source repository
 * @copyright Copyright (c) 2017 Stuart Bradbury.
 */
 
namespace People\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

use JobRole\Model\JobRole;

class PeopleTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;		
    }
	
	public function fetchJobRoles() {
		$select = new Select("jobrole");
		
		$resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new JobRole());

        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter(),
            $resultSetPrototype
        );		

        $paginator = new Paginator($paginatorAdapter);	 
				
		return $paginator;
	}

    public function fetchAll($paginated = false)
    {	
        if ($paginated) {			
            return $this->fetchPaginatedResults();
        }

        return $this->tableGateway->select();
    }	

    private function fetchPaginatedResults()
    {
        $select = new Select($this->tableGateway->getTable());

        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new People());

        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter(),
            $resultSetPrototype
        );

        $paginator = new Paginator($paginatorAdapter);
		
        return $paginator;
    }

    public function getPerson($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }
	
    public function isPerson(People $person)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['firstname' => $person->firstname, 'lastname' => $person->lastname, 'email' => $person->email, 'job_role' => (int) $person->job_role]);
        $row = $rowset->current();
        if (! $row) {
			return false;
        }

        return true;
    }

    public function savePerson(People $person)
    {
        $data = [
            'firstname' => $person->firstname,
            'lastname'  => $person->lastname,
            'email' => $person->email,
            'job_role'  => (int) $person->job_role,
        ];

        $id = (int) $person->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getPerson($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update Team member with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deletePerson($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}

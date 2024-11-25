<?php
/**
 * @link      https://github.com/sbrdbry/reimagined-octo-waddle.git for the source repository
 * @copyright Copyright (c) 2017 Stuart Bradbury.
 */

namespace JobRole\Model;

use RuntimeException;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class JobRoleTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
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
        $resultSetPrototype->setArrayObjectPrototype(new JobRole());

        $paginatorAdapter = new DbSelect(
            $select,
            $this->tableGateway->getAdapter(),
            $resultSetPrototype
        );

        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    public function getJobRole($id)
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
	
    public function isJobRole(JobRole $job_role)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['name' => $job_role->name]);
        $row = $rowset->current();
        if (! $row) {
			return false;
        }

        return true;
    }

    public function saveJobRole(JobRole $job_role)
    {
        $data = [
            'name' => $job_role->name,
        ];

        $id = (int) $job_role->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getJobRole($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update Team member with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteJobRole($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}

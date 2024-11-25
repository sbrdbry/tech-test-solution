<?php
/**
 * @link      https://github.com/sbrdbry/reimagined-octo-waddle.git for the source repository
 * @copyright Copyright (c) 2017 Stuart Bradbury.
 */

namespace JobRole\Controller;

use JobRole\Form\JobRoleForm;
use JobRole\Model\JobRole;

use JobRole\Model\JobRoleTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class JobRoleController extends AbstractActionController
{
    private $table;

    public function __construct(JobRoleTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
		// Prepare paginator for view
		$paginator = $this->table->fetchAll(true);
	
		$page = (int) $this->params()->fromQuery('page', 1);
		$page = ($page < 1) ? 1 : $page;
		$paginator->setCurrentPageNumber($page);
	
		$paginator->setItemCountPerPage(10);		
		
		//$allow_new = $paginator->getTotalItemCount() < 10 ? true : false;
		
        $request = $this->getRequest();	
		$form = new JobRoleForm();
		
         
         if ($request->isPost()) {
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 //echo "valid";
				 //exit();
             } else {
			 	return $this->redirect()->toRoute('jobrole', ['action' => 'index']);
			 }
         }
			
        //$viewData = ['paginator' => $paginator, 'allow_new' => $allow_new];			
		 
		

        if (! $request->isPost()) {
            //return $viewData;
			return ['form' => $form, 'paginator' => $paginator, 'allow_new' => true];
        }		

		
		// Iterate and process post data
		foreach ($request->getPost()["job_roles"] as $key => $job_role) {
			$id = $key;
			
			$name2 = $job_role["name"];
			
			$delete = (!isset($job_role["delete"]) || $job_role["delete"] == false) ? false : true;
			
			if ($delete) {
				// Delete selected records          
                $this->table->deleteJobRole($id);
			} else {
				if ($id !== -99) {
					// Validate and update changes
					$job_role = $this->table->getJobRole($id);
					
					$name1 = $job_role->name;				
					
					if ($name1 !== $name2) {
						$job_role->name = $name2;
							
						if (!$this->table->isJobRole($job_role)) {
							$this->table->saveJobRole($job_role);
						}
					}
				} else {
					// Validate and add new record									
					if ($name2 !== "") 
					{
						$job_role = new JobRole();
						$job_role->name = $name2;
						
						if (!$this->table->isJobRole($job_role)) {
							$this->table->saveJobRole($job_role);
						}
					}
				}
			}
		}		
		
		return $this->redirect()->toRoute('jobrole', ['action' => 'index']);	 
    }
}

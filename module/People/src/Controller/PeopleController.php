<?php
/**
 * @link      https://github.com/sbrdbry/reimagined-octo-waddle.git for the source repository
 * @copyright Copyright (c) 2017 Stuart Bradbury.
 */

namespace People\Controller;

use People\Form\PeopleForm;
use People\Model\People;

use People\Model\PeopleTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PeopleController extends AbstractActionController
{
    private $table;

    public function __construct(PeopleTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
		// Prepare paginator for view
		$paginator = $this->table->fetchAll(true);
		
		// Restrict number of people to 10
		$allow_new = $paginator->getTotalItemCount() < 10 ? true : false;
		
		$jobRoles = $this->table->fetchJobRoles();
		
        $request = $this->getRequest();	
		$form = new PeopleForm();		
         
		if ($request->isPost()) {
			$form->setData($request->getPost());
			
			if (!$form->isValid()) {			
				return $this->redirect()->toRoute('people', ['action' => 'index']);
			}
		}
		 
        if (!$request->isPost()) {
			return ['form' => $form, 'paginator' => $paginator, 'jobRoles' => $jobRoles, 'allow_new' => true];
        }		
		
		// Build array of each person's role
		$i = 0;
		foreach ($paginator as $key => $person) {
			$job_roles[$i++] = $person->job_role;
		}
		
		// Array with number of role occurances
		$job_role_counts = array_count_values($job_roles);		
		
		// Iterate and process post data
		foreach ($request->getPost()["people"] as $key => $person) {
			$id = $key;
			
			$firstname2 = $person["firstname"];
			$lastname2 = $person["lastname"];
			$email2 = $person["email"];
			$job_role2 = $person["job_role"];
			
			$delete = (!isset($person["delete"]) || $person["delete"] == false) ? false : true;
			
			if ($delete) {
				// Delete selected records          
                $this->table->deletePerson($id);
			} else {
				if ($id !== -99) {
					// Validate and update changes
					$person = $this->table->getPerson($id);
					
					$firstname1 = $person->firstname;
					$lastname1 = $person->lastname;
					$email1 = $person->email;					
					$job_role1 = $person->job_role;
					
					if ($firstname1 !== $firstname2 || $lastname1 !== $lastname2 || $email1 !== $email2 || $job_role1 !== $job_role2) {
						if (($job_role1 !== $job_role2 && $job_role_counts[$job_role2] < 4) || $job_role1 === $job_role2) 
						{																
							$person->firstname = $firstname2;
							$person->lastname = $lastname2;
							$person->email = $email2;							
							$person->job_role = $job_role2;
							
							if (!$this->table->isPerson($person)) {
								$this->table->savePerson($person);
							}
						}
					}
				} else {
					// Validate and add new record									
					if ($firstname2 !== "" && $lastname2 !== "" && $email2 !== "" && $job_role2 !== "" && $job_role_counts[$job_role2] < 4) 
					{
						$person = new People();
						
						$person->firstname = $firstname2;
						$person->lastname = $lastname2;
						$person->email = $email2;						
						$person->job_role = $job_role2;
						
						if (!$this->table->isPerson($person)) {
							$this->table->savePerson($person);	
						}
					}
				}
			}
		}		
		
		return $this->redirect()->toRoute('people', ['action' => 'index']);	 
    }
}

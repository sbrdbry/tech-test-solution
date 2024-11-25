<?php
/**
 * @link      https://github.com/sbrdbry/reimagined-octo-waddle.git for the source repository
 * @copyright Copyright (c) 2017 Stuart Bradbury.
 */

namespace JobRole\Form;

use Zend\Form\Form;

class JobRoleForm extends Form
{
    public function __construct()
    {
        parent::__construct('jobroles');

		/*foreach ($jobRoles as $jobRole) {			
			$this->add([
				'name' => 'job_role[$jobRole->id]',
				'type' => 'text',
				'options' => [
					'label' => 'Name',
				],
			]);
		}*/
		
         $this->add(array(
             'type' => 'Zend\Form\Element\Csrf',
             'name' => 'csrf',
         ));
		
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}

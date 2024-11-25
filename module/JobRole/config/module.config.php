<?php
/**
 * @link      https://github.com/sbrdbry/reimagined-octo-waddle.git for the source repository
 * @copyright Copyright (c) 2017 Stuart Bradbury.
 */
 
namespace JobRole;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'jobrole' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/jobrole',
                    'defaults' => [
                        'controller' => Controller\JobRoleController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [	
        'template_path_stack' => [
            'jobrole' => __DIR__ . '/../view',
        ],
    ],
];
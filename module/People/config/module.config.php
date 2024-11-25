<?php
/**
 * @link      https://github.com/sbrdbry/reimagined-octo-waddle.git for the source repository
 * @copyright Copyright (c) 2017 Stuart Bradbury.
 */

namespace People;

use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'people' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/people',
                    'defaults' => [
                        'controller' => Controller\PeopleController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [	
        'template_path_stack' => [
            'people' => __DIR__ . '/../view',
        ],
    ],
];
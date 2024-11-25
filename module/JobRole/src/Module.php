<?php
/**
 * @link      https://github.com/sbrdbry/reimagined-octo-waddle.git for the source repository
 * @copyright Copyright (c) 2017 Stuart Bradbury.
 */

namespace JobRole;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
		//echo "debugging";
		//exit();
        return include __DIR__ . '/../config/module.config.php';

    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\JobRoleTable::class => function($container) {
                    $tableGateway = $container->get(Model\JobRoleTableGateway::class);
					
                    return new Model\JobRoleTable($tableGateway);
                },
                Model\JobRoleTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\JobRole());
                    return new TableGateway('jobrole', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
		
        return [
            'factories' => [
                Controller\JobRoleController::class => function($container) {
                    return new Controller\JobRoleController(
                        $container->get(Model\JobRoleTable::class)
                    );
                },
            ],
        ];
    }
}

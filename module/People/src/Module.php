<?php
/**
 * @link      https://github.com/sbrdbry/reimagined-octo-waddle.git for the source repository
 * @copyright Copyright (c) 2017 Stuart Bradbury.
 */
 
namespace People;

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
                Model\PeopleTable::class => function($container) {
                    $tableGateway = $container->get(Model\PeopleTableGateway::class);
					
                    return new Model\PeopleTable($tableGateway);
                },
                Model\PeopleTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\People());
                    return new TableGateway('people', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
		
        return [
            'factories' => [
                Controller\PeopleController::class => function($container) {
                    return new Controller\PeopleController(
                        $container->get(Model\PeopleTable::class)
                    );
                },
            ],
        ];
    }
}

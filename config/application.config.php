<?php
/**
 * @link      https://github.com/sbrdbry/reimagined-octo-waddle.git for the source repository
 * @copyright Copyright (c) 2017 Stuart Bradbury.
 */

return [
    'modules' => require __DIR__ . '/modules.config.php',

    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],

        'config_glob_paths' => [
            realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php',
        ],

        'config_cache_enabled' => true,
        'config_cache_key' => 'application.config.cache',
		
        'module_map_cache_enabled' => true,
        'module_map_cache_key' => 'application.module.cache',
		
        'cache_dir' => 'data/cache/',
    ],
];

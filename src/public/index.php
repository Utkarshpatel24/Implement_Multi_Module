<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Mvc\Router;

$config = new Config([]);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

require '../vendor/autoload.php';

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
    ]
);

$loader->register();

$container = new FactoryDefault();
$application = new Application($container);

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);
// $container->set(
//     'db',
//     function () {
//         return new Mysql(
//             [
//                 'host'     => 'mysql-server',
//                 'username' => 'root',
//                 'password' => 'secret',
//                 'dbname'   => 'test',
//             ]
//         );
//     }
// );
$container->set(
    'mongo',
    function () {
        $mongo = new \MongoDB\Client("mongodb://mongo", array("username"=>'root', "password"=>"password123"));
        // mongo "mongodb+srv://sandbox.g819z.mongodb.net/myFirstDatabase" --username root
        
        return $mongo->test->store;
    },
    true
);

$application->registerModules(
    [
        'admin' => [
            'className' => \Multi\Admin\Module::class,
            'path'      => APP_PATH.'/admin/Module.php',
        ],
        'frontend'  => [
            'className' => \Multi\Product\Module::class,
            'path'      => APP_PATH.'/frontend/Module.php',
        ]
    ]
);

$container->set(
    'router',
    function () {
        $router = new Router();

        $router->setDefaultModule('frontend');

        $router->add(
            '/admin',
            [
                'module'     => 'admin',
                'controller' => 'admin',
                'action'     => 'login',
            ]
        );

        $router->add(
            '/admin/admin/:action',
            [
                'module'     => 'admin',
                'controller' => 'admin',
                'action'     => 1,
            ]
        );

        $router->add(
            '/product/:action',
            [
                'controller' => 'index',
                'action'     => 1,
            ]
        );

        return $router;
    }
);






try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}

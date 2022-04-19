<?php

namespace Multi\Admin;

use Phalcon\Loader;
use Phalcon\Di\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(
        DiInterface $container = null
    )
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            [
                'Multi\Admin\Controllers' => APP_PATH.'/admin/controllers',
                'Multi\Admin\Controllers\AdminControllers' => APP_PATH.'/admin/controllers/admin/',
                'Model'      => APP_PATH.'/admin/models/',
            ]
        );
        // // $loader->registerDirs(
        //     [
        //         // APP_PATH . "/controllers/",
        //         APP_PATH . "/admin/models/",
        //     ]
        // );

        $loader->register();
    }

    public function registerServices(DiInterface $container)
    {
        // Registering a dispatcher
        $container->set(
            'dispatcher',
            function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace(
                    'Multi\Admin\Controllers'
                );

                return $dispatcher;
            }
        );

        // Registering the view component
        $container->set(
            'view',
            function () {
                $view = new View();
                $view->setViewsDir(
                    APP_PATH.'/admin/views'
                );

                return $view;
            }
        );
        $container->set(
            'mongo',
            function () {
                $mongo = new \MongoDB\Client("mongodb://mongo", array("username"=>'root', "password"=>"password123"));
                // mongo "mongodb+srv://sandbox.g819z.mongodb.net/myFirstDatabase" --username root
                
                return $mongo->store;
            },
            true
        );
    }
}
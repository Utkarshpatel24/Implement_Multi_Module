<?php

// namespace in most important part
namespace Multi\Admin\Controllers\AdminControllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

    public function afterExecuteRoute()
    {
        // TODO: Change Layout Folder Path for Sub-Controller
        $this->view->setViewsDir($this->view->getViewsDir() . 'admin/');
        $this->dispatcher->setDefaultNamespace($this->dispatcher->getDefaultNamespace().'/AdminControllers');
    }
}
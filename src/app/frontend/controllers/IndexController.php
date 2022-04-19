<?php
namespace Multi\Product\Controllers;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
            echo "Hello buddy";
    }
    public function productlistAction()
    {
        echo "Here you will se list of product";
    }
}
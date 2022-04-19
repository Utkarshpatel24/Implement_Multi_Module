<?php
namespace Multi\Admin\Controllers;
use Model\Users;
use Phalcon\Mvc\Controller;

class AdminController extends Controller
{
    public function loginAction()
    {
        echo "Hello Buddy";
        $postdata = $this->request->getPost();
        if (count($postdata) > 0) {
            $user = new Users;
            $result = $user->findUser($postdata);
            foreach ($result as $r) {

                if (count($r) > 0) {

                    $this->response->redirect('/admin/admin/productCrud');
                }
            }

        }
    }
    public function signupAction()
    {
        $postdata = $this->request->getPost();
        $this->view->result = array();
        if (count($postdata) > 0) {
            // $this->mongo->user->insertOne($postdata);
            $user = new Users;
            $result = $user->insert($postdata);
            $this->view->result = $result;

        }
        $this->view->postdata = $postdata;

    }
    public function productCrudAction()
    {
        echo "you are ready to perform CRUD operation on Products";
    }
}
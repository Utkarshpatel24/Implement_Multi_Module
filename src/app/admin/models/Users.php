<?php
namespace Model;

use Phalcon\Mvc\Model;
use MongoDB\BSON\ObjectId;
class Users extends Model
{
    public $collection;
    public function initialize()
    {
        $this->collection = $this->di->get("mongo");
        
        $this->collection = $this->collection->user;

    }
    public function insert($userData)
    {

        $insert = $this->collection->insertOne($userData);
        // return "Registered Successfully";
        return $insert;
            
    }
    public function findUser($postdata)
    {
        $result = $this->collection->find(
            [
                "email" => $postdata['email'],
                "password" => $postdata['password']
            ]
        );
        // echo json_encode($postdata);
        // $result = $this->collection->find($postdata);
        return $result;
    }
}
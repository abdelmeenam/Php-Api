<?php
require_once "api/users.php";
$url = explode("/", $_SERVER['QUERY_STRING']);

//setting of postman to understand this data as a json data
header('Access-Control-Allow-Origin: application/json');
header('Content-Type: application/json');

if ($url[1] == 'v1') {
    //controller
    if ($url[2] == 'users') {
        $user = new users();
        //show data method
        if ($url[3] == 'all' || $url[3] == '') {
            $users = $user->all();
            $res = [
                'status' => 200,
                'data' => $users
            ];
            echo (json_encode($res));          //to convert it into json object

            //add Method
        } elseif ($url[3] == 'add') {
            header('Access-Control-Allow-Methods: POST');
            $data = file_get_contents("php://input");   //export data from body of Api [json type]
            $dec_data = json_decode($data, true); //true to convert it into array instead of php obj
            $n = $dec_data['name'];
            $e = $dec_data['email'];
            $p = $dec_data['password'];

            $res = $user->add($n, $e, $p);
            if ($res) {
                http_response_code(201);
                $res = [
                    'status' => 201,
                    'data' => "done"
                ];
            } else {
                http_response_code(400);
                $res = [
                    'status' => 400,
                    'data' => "error"
                ];
            }
            echo (json_encode($res));

            //Update
        } elseif ($url[3] == 'update') {
            header('Access-Control-Allow-Methods: PUT');
            $data = file_get_contents("php://input");
            $dec_data = json_decode($data, true);
            $id = $dec_data['id'];
            $name = $dec_data['name'];

            $res = $user->update($name, $id);
            if ($res) {
                http_response_code(201);
                $res = [
                    'status' => 200,
                    'data' => "done"
                ];
            } else {
                http_response_code(400);
                $res = [
                    'status' => 400,
                    'data' => "error"
                ];
            }
            echo (json_encode($res));

            //delete
        } elseif ($url[3] == 'delete') {
            header('Access-Control-Allow-Methods: DELETE');
            $data = file_get_contents("php://input");
            $dec_data = json_decode($data, true);
            $id = $dec_data['id'];

            $res =  $user->delete($id);
            if ($res) {
                $res = [
                    'status' => 200,
                    'data' => "done"
                ];
            } else {
                $res = [
                    'status' => 400,
                    'data' => "error"
                ];
            }
            echo (json_encode($res));
        } else {
            echo "404 Error";
        }
    }
    if ($url[2] == 'posts') {
        echo 'posts ';
    }
} elseif ($url[1] == 'v2') {
    echo 'v2';
}

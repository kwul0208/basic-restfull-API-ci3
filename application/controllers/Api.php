<?php
defined('BASEPATH') or exit('No direct script access allowed');

require './vendor/autoload.php';

use chriskacerguis\RestServer\RestController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Api extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
    }

    public function index_get()
    {
        $secret_key = 'sulit';

        $authHeader = $this->input->get_request_header('Authorization');
        $arr = explode(" ", $authHeader);
        $jwt = isset($arr[1]) ? $arr[1] : '';

        if ($jwt) {
            try {
                $decode = JWT::decode($jwt, new Key($secret_key, 'HS256'));
                $id = $this->get('id');

                if ($id === null) {
                    $product = $this->ProductModel->getAll();
                } else {
                    $product = $this->ProductModel->getById($id);
                }

                $this->response([
                    'message' => 'success',
                    'data' => $product,
                ], RestController::HTTP_OK);
            } catch (\Throwable $th) {
                echo 'fail';
            }
        } else {
            $result = [
                'code' => 401,
                'message' => 'Access denied',
                'data' => 'null'
            ];

            $this->response($result, RestController::HTTP_UNAUTHORIZED);
        }
    }

    public function index_post()
    {
        $data = [
            'name' => $this->post('name'),
            'price' => $this->post('price'),
            'description' => $this->post('desc'),
            'id_user' => $this->post('id_user')
        ];

        if ($this->ProductModel->newProduct($data) > 0) {
            $this->response([
                'message' => 'success'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'message' => 'failed'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'message' => 'failed id'
            ], RestController::HTTP_BAD_REQUEST);
        } else {

            if ($this->ProductModel->deleteProduct($id) > 0) {
                $this->response([
                    'massage' => 'success'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'message' => 'failed'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_put()
    {
        $id = $this->put('id');

        if ($id === null) {
            $this->response([
                'massage' => 'failed id'
            ], RestController::HTTP_BAD_REQUEST);
        } else {

            $data = [
                'name' => $this->put('name'),
                'price' => $this->put('price'),
                'description' => $this->put('desc'),
            ];

            if ($this->ProductModel->editProduct($id, $data) > 0) {
                $this->response([
                    'massage' => 'success'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'massage' => 'failed'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }
}

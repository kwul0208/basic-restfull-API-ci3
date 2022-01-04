<?php
defined('BASEPATH') or exit('No direct script access allowed');

require './vendor/autoload.php';

use chriskacerguis\RestServer\RestController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class User extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('ProductModel');
    }

    public function index_get()
    {
        $secret_key = 'sulit';
        $authHeader = $this->input->get_request_header('Authorization');
        $arr = explode(" ", $authHeader);
        $jwt = isset($arr[1]) ? $arr[1] : "";
        if ($jwt) {
            try {
                $user = JWT::decode($jwt, new Key($secret_key, 'HS256'));
                $data = [
                    'code' => 200,
                    'user' => $this->UserModel->getById($user->id),
                    'product' => $this->ProductModel->getByIdUser($user->id)
                ];

                $this->response($data, RestController::HTTP_OK);
            } catch (\Throwable $th) {
                echo 'fail';
            }
        }
    }
}

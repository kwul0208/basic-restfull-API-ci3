<?php
defined('BASEPATH') or exit('No direct script access allowed');

require './vendor/autoload.php';

use chriskacerguis\RestServer\RestController;
use Firebase\JWT\JWT;

class Auth extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
    }

    public function login_post()
    {
        // $key = 'sulit';
        // $username = $this->post('username');
        // $password = $this->post('password');

        // $token = [$username, $password];

        // $encode = JWT::encode($token, $key, 'HS256');

        // $this->response([
        //     'status' => '200',
        //     'token' => $encode,
        // ], RestController::HTTP_OK);

        $username = $this->post('username');
        $password = $this->post('password');

        $user = $this->UserModel->getByUsername($username);
        if ($user) {
            if (password_verify($password, $user['password'])) {

                $secret_key = 'sulit';
                $token = [
                    'id' => $user['id'],
                    'username' => $user['nama'],
                    'email' => $user['email']
                ];
                $encode = JWT::encode($token, $secret_key, 'HS256');

                $this->response([
                    'code' => 200,
                    'message' => 'Login Success',
                    'data' => $encode
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'code' => 401,
                    'message' => 'Login Failed'
                ], RestController::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response([
                'code' => 401,
                'message' => 'Login Failed'
            ], RestController::HTTP_UNAUTHORIZED);
        }
    }
}

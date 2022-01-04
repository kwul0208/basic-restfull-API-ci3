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
        $key = 'sulit';
        $username = $this->post('username');
        $password = $this->post('password');

        $token = [$username, $password];

        $encode = JWT::encode($token, $key, 'HS256');

        $this->response([
            'status' => '200',
            'token' => $encode
        ], RestController::HTTP_OK);
    }
}

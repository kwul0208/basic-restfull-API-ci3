<?php
defined('BASEPATH') or exit('No direct script access allowed');

require './vendor/autoload.php';

use chriskacerguis\RestServer\RestController;

class Auth extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
    }

    public function index_get()
    {
        echo 'user Redy';
    }
}

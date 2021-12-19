<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
    public function getAll()
    {
        return $this->db->get('user')->result_array();
    }
    public function getById($id)
    {
        return $this->db->get_where('user', ['id' => $id])->result_array();
    }
}

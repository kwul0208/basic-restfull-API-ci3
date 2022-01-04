<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductModel extends CI_Model
{
    public function getAll()
    {
        // $this->db->select('product.name, user.nama as user_nama');

        $this->db->select('product.*, user.nama as user_nama, lapak.name as name_lapak');
        $this->db->from('product');
        $this->db->join('user', 'user.id=product.id_user');
        $this->db->join('lapak', 'lapak.id_user=product.id_user');
        $query = $this->db->get();
        return $query->result();
    }

    public function getById($id)
    {
        $this->db->select('product.*, user.nama as user_nama, user.id as user_id, lapak.name as name_lapak');
        $this->db->from('product');
        $this->db->join('user', 'user.id=product.id_user');
        $this->db->join('lapak', 'lapak.id_user=product.id_user');
        $this->db->where('product.id', $id);
        $query = $this->db->get();
        return $query->result();

        // return $this->db->get_where('product', ['id_user' => $id])->result_array();


    }

    public function newProduct($data)
    {
        $this->db->insert('product', $data);
        return $this->db->affected_rows();
    }

    public function deleteProduct($id)
    {
        $this->db->delete('product', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function editProduct($id, $data)
    {
        // $this->db->where('id', $id);
        $this->db->update('product', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getByIdUser($id)
    {
        return $this->db->get_where('product', ['id_user' => $id])->result_array();
    }
}

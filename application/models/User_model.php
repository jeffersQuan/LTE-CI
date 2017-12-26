<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function get_users_list($where='1=1', $orderby='created_at DESC', $limit='') {
        $sql = "SELECT * FROM user WHERE $where";

        if ($orderby) {
            $sql = $sql . " ORDER BY $orderby";
        }

        if ($limit) {
            $sql = $sql . " LIMIT $limit";
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_user($id) {
        $sql = "SELECT * FROM user WHERE user_id=$id" ;
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function get_user_by_username($username) {
        $sql = "SELECT * FROM user WHERE username='$username'" ;
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function get_users_count($where='1=1') {
        $sql = "SELECT count(user_id) AS total FROM user WHERE $where";

        $query = $this->db->query($sql);
        return $query->row_array()['total'];
    }

    public function insert_user($data) {
        if (!$data) {
            log_message('error', 'insert params missing');
            return null;
        }

        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    public function update_user($data, $where) {
        if (!$where || !$data) {
            log_message('error', 'update params missing');
            return;
        }

        $this->db->update('user', $data, $where);
    }

    public function get_users($where='1=1') {
        $sql = "SELECT COUNT(user_id) as total FROM user WHERE $where";

        $query = $this->db->query($sql);
        return $query->row_array()['total'];
    }
}
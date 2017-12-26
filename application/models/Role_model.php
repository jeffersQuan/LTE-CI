<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function get_roles_list($where='1=1', $orderby='', $limit='', $key='*') {
        $sql = "SELECT $key FROM role WHERE $where";

        if ($orderby) {
            $sql = $sql . " ORDER BY $orderby";
        }

        if ($limit) {
            $sql = $sql . " LIMIT $limit";
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_role($id) {
        $this->db->where(array('role_id'=>$id));
        $query = $this->db->get('role');
        return $query->row_array();
    }

    public function insert_role($data) {
        if (!$data) {
            log_message('error', 'insert params missing');
            return null;
        }

        $this->db->insert('role', $data);
        return $this->db->insert_id();
    }

    public function update_role($data, $where) {
        if (!$where || !$data) {
            log_message('error', 'update params missing');
            return;
        }

        $this->db->update('role', $data, $where);
    }
}
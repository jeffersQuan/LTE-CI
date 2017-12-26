<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privilege_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
//        $this->db = $this->load->database('default', true);
    }

    public function get_privileges_list($where='1=1', $orderby='privilege_id DESC, group_name', $limit='', $key='*') {
        $sql = "SELECT $key FROM privilege WHERE $where";

        if ($orderby) {
            $sql = $sql . " ORDER BY $orderby";
        }

        if ($limit) {
            $sql = $sql . " LIMIT $limit";
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_privilege($id) {
        $this->db->where(array('privilege_id'=>$id));
        $query = $this->db->get('privilege');
        return $query->row_array();
    }

    public function insert_privilege($data) {
        if (!$data) {
            log_message('error', 'insert params missing');
            return null;
        }

        $this->db->insert('privilege', $data);
        return $this->db->insert_id();
    }

    public function update_privilege($data, $where) {
        if (!$where || !$data) {
            log_message('error', 'update params missing');
            return;
        }

        $this->db->update('privilege', $data, $where);
    }

    public function get_privileges($where='1=1') {
        $sql = "SELECT COUNT(privilege_id) as total FROM privilege WHERE $where";

        $query = $this->db->query($sql);
        return $query->row_array()['total'];
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function get_menus_list($where='1=1', $orderby='level, position, group_id', $limit='', $key='*') {
        $where = $where . " AND deleted=0";
        $sql = "SELECT $key FROM menu WHERE $where";

        if ($orderby) {
            $sql = $sql . " ORDER BY $orderby";
        }

        if ($limit) {
            $sql = $sql . " LIMIT $limit";
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_menu($id) {
        $this->db->where(array('id'=>$id));
        $query = $this->db->get('menu');
        return $query->row_array();
    }

    public function get_menu_children($id) {
        $this->db->where(array('pid'=>$id));
        $this->db->order_by('position');
        $query = $this->db->get('menu');
        return $query->result_array();
    }

    public function insert_menu($data) {
        if (!$data) {
            log_message('error', 'insert params missing');
            return null;
        }

        $this->db->insert('menu', $data);
        return $this->db->insert_id();
    }

    public function update_menu($data, $where) {
        if (!$where || !$data) {
            log_message('error', 'update params missing');
            return;
        }

        $this->db->update('menu', $data, $where);
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_Model extends CI_Model {
    public $menu_table = 'menu';

    public function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function get_menus() {
        $this->db->order_by('level ASC , position ASC');
        $query = $this->db->get($this->menu_table);
        return $query->result_array();
    }

    public function update_menu($data, $where) {
        if (!$where || $data) {
            log_message('error', 'update_menu params missing');
            return;
        }

        $this->db-update($this->menu_table, $data, $where);
    }
}
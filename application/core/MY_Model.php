<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function log_last_sql ($db) {
        if (ENVIRONMENT != 'production') {
            log_var_message($db->last_query());
        }
    }
}
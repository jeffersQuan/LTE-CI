<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
	public function index()
	{
		$this->page_data['has_form'] = true;
		$this->page_data['has_md5'] = true;
		$this->view('welcome');
	}
}

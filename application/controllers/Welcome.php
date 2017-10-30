<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
	public function index()
	{
		$this->page_data['title'] = '';
		$this->page_data['body_class'] = '';
		$this->page_data['has_form'] = true;
		$this->view('welcome');
	}
}

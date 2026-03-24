<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Access_denied extends My_Controller {

	public function index($back_to=''){

		$data['back_to'] = $this->functions->decode($back_to);
		$this->load->view('admin/includes/_header');
		$this->load->view('access_denied', $data);
		$this->load->view('admin/includes/_footer');
	}
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends My_Controller {
	public function __construct(){
		parent::__construct();
		
	}

	public function index()
	{
		$data['title'] = "404 Page Not Found";
		$data['cur_tab'] = ""; // Prevent sidebar errors

		if($this->session->has_userdata('is_admin_login')){
			$this->load->view('admin/includes/_header', $data);
			$this->load->view('404', $data);
			$this->load->view('admin/includes/_footer');
		}
		else{
			$this->load->view('components/header', $data);
			$this->load->view('404', $data);
			$this->load->view('components/footer');
		}
	}


	}

	?>
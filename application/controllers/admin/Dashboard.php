<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property Dashboard_model $dashboard_model
 */
class Dashboard extends My_Controller
{



	public function __construct()
	{
		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		if ($this->uri->segment(3) != '')
			$this->rbac->check_operation_access();
		$this->load->model('admin/dashboard_model', 'dashboard_model');

	}

	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['assets'] = getalldata('assets', null, 'id', 'DESC', 0, 5);

		// Chart Data
		$data['assets_by_category'] = $this->dashboard_model->get_assets_by_category();
		$data['assets_by_status'] = $this->dashboard_model->get_assets_by_status();
		$data['acquisition_trend'] = $this->dashboard_model->get_acquisition_trend();

		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/dashboard/admin', $data);
		$this->load->view('admin/includes/_footer');
	}


}
?>
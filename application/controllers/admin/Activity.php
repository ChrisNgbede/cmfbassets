<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
class Activity extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		$this->load->model('admin/Activity_model', 'activity_model');
	}

	public function index()
	{
		$this->rbac->check_operation_access('view');
		$data['users'] = $this->db->get('users')->result();
		$data['statuses'] = $this->db->get('activity_status')->result();
		$data['title'] = 'User Activity Log';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/activity/activity-list', $data);
		$this->load->view('admin/includes/_footer');
	}

	public function datatable_json()
	{
		$filters = [
			'status' => $this->input->get('status'),
			'admin_id' => $this->input->get('admin_id'),
			'from' => $this->input->get('from'),
			'to' => $this->input->get('to')
		];
		$records['data'] = $this->activity_model->get_activity_log($filters);

		$data = array();
		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$data[]= array(
				++$i,
				($row['username']) ? $row['username'] : 'System',
				'<strong>'.$row['status_desc'].'</strong>: '.$row['description'],
				$row['ip_address'],
				$row['user_agent'],
				date('F d, Y H:i',strtotime($row['created_at'])),	
				$row['created_at'], // Raw timestamp for sorting
			);
		}
		$records['data'] = $data;
		echo json_encode($records);
	}
}

?>	
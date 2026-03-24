<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller
{
    function __construct(){

        parent::__construct();
        auth_check(); // check login auth
        $this->rbac->check_module_access();

		$this->load->model('admin/Activity_model', 'activity_model');
    }
    
	//-----------------------------------------------------		
	function index($type=''){
		
		$data['admin_roles'] = $this->admin->get_admin_roles();
		$data['title'] = 'Admin List';
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/admin/index', $data);
		$this->load->view('admin/includes/_footer');
	}

	//---------------------------------------------------------
	function filterdata(){

		$this->session->set_userdata('filter_type',$this->input->post('type'));
		$this->session->set_userdata('filter_status',$this->input->post('status'));
		$this->session->set_userdata('filter_keyword',$this->input->post('keyword'));
	}

	


	//--------------------------------------------------		
	function list_data(){

		$data['info'] = $this->admin->get_all();

		$this->load->view('admin/admin/list',$data);
	}

	//-----------------------------------------------------------
	function change_status(){

		$this->rbac->check_operation_access(); // check opration permission

		$this->admin->change_status();
	}
	
	//--------------------------------------------------
	function add(){

		$this->rbac->check_operation_access(); // check opration permission

		$data['admin_roles']=$this->admin->get_admin_roles();

		if($this->input->post('submit')){
				$this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|is_unique[users.username]|required');
				$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
				$this->form_validation->set_rules('phone', 'Number', 'trim|required');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				$this->form_validation->set_rules('role', 'Role', 'trim|required');
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('error', $data['errors']);
					redirect(base_url('admin/admin/add'),'refresh');
				}
				else{
					$data = array(
						'admin_role_id' => $this->input->post('role'),
						'username' => $this->input->post('username'),
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'is_active' => 1,
						'is_supper' => $this->input->post('role') == 1 ? 1 : 0,
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->admin->add_admin($data);
					if($result){

						// Activity Log 
						$this->activity_model->add_log(4);

						$this->session->set_flashdata('success', 'Admin has been added successfully!');
						redirect(base_url('admin/admin'));
					}
				}
			}
			else
			{
				$this->load->view('admin/includes/_header', $data);
        		$this->load->view('admin/admin/add');
        		$this->load->view('admin/includes/_footer');
			}
	}

	//--------------------------------------------------
	function edit($id=""){

		$this->rbac->check_operation_access(); // check opration permission

		$data['admin_roles'] = $this->admin->get_admin_roles();

		if($this->input->post('submit')){
			// $this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|required');
			// $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
			// $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
			// $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
			// $this->form_validation->set_rules('phone', 'Number', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|min_length[5]');
			$this->form_validation->set_rules('role', 'Role', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('error', $data['errors']);
				redirect(base_url('admin/admin/edit/'.$id),'refresh');
			}
			else{
				$data = array(
					'admin_role_id' => $this->input->post('role'),
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'is_active' => 1,
					'updated_at' => date('Y-m-d H:i:s'),
				);

				if($this->input->post('password') != '')
				$data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

				$data = $this->security->xss_clean($data);
				$result = $this->admin->edit_admin($data, $id);

				if($result){
					// Activity Log 
					$this->activity_model->add_log(5);

					$this->session->set_flashdata('success', 'Admin has been updated successfully!');
					redirect(base_url('admin/admin'));
				}
			}
		}
		elseif($id==""){
			redirect('admin/admin');
		}
		else{
			$data['admin'] = $this->admin->get_admin_by_id($id);
			
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/admin/edit', $data);
			$this->load->view('admin/includes/_footer');
		}		
	}

		public function departments($id = 0){
		$this->rbac->check_operation_access();
		if($this->input->post('submit')){
			$this->form_validation->set_rules('name', 'Name', 'trim|required');
			$this->form_validation->set_rules('shortname', 'Short Name', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('form_data', $this->input->post());
				$this->session->set_flashdata('error', $data['errors']);
				redirect(base_url('admin/admin/departments'),'refresh');
			}
			else{
			
				$data = array(
					'name' => $this->input->post('name'),
					'shortname' => $this->input->post('shortname'),
					$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
				    $this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
				);

				$data = $this->security->xss_clean($data);
				if ($this->Common_model->save($data, $this->input->post('id'),'departments')) {
					$this->session->set_flashdata('success', 'Done');
					redirect(base_url('admin/admin/departments'));
				}else{
					$this->session->set_flashdata('error', 'Failed');
					redirect(base_url('admin/admin/departments'));
				}
						
			}
		}
		else{
			$data['title'] = 'Manage Department';
			$data['departments'] = $this->Common_model->getAll('departments');
			$data['department'] = $this->Common_model->get_one($id,'departments');
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/admin/departments', $data);
			$this->load->view('admin/includes/_footer');
		}
		
	}

	public function designations($id = 0){
	$this->rbac->check_operation_access();
	if($this->input->post('submit')){
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
			$data = array(
				'errors' => validation_errors()
			);
			$this->session->set_flashdata('form_data', $this->input->post());
			$this->session->set_flashdata('error', $data['errors']);
			redirect(base_url('admin/admin/designations'),'refresh');
		}
		else{
		
			$data = array(
				'name' => $this->input->post('name'),
				'shortname' => $this->input->post('shortname'),
				$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
			    $this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
			);

			$data = $this->security->xss_clean($data);
			if ($this->Common_model->save($data, $this->input->post('id'),'designations')) {
				$this->session->set_flashdata('success', 'Done');
				redirect(base_url('admin/admin/designations'));
			}else{
				$this->session->set_flashdata('error', 'Failed');
				redirect(base_url('admin/admin/designations'));
			}
					
		}
	}
	else{
			$data['title'] = 'Manage Designations';
			$data['designations'] = $this->Common_model->getAll('designations');
			$data['designation'] = $this->Common_model->get_one($id,'designations');
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/admin/designations', $data);
			$this->load->view('admin/includes/_footer');
		}
		
	}


	


	//--------------------------------------------------
	function check_username($id=0){

		$this->db->from('admin');
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('admin_id !='.$id);
		$query=$this->db->get();
		if($query->num_rows() >0)
			echo 'false';
		else 
	    	echo 'true';
    }

    //------------------------------------------------------------
	function delete_user($id){
		$this->rbac->check_operation_access(); // check opration permission
		$this->admin->delete_user($id);
		$this->session->set_flashdata('success','Deleted Successfully.');	
		redirect('admin/admin');
	}

	
	
	function delete_video($id){
		$this->rbac->check_operation_access(); // check opration permission
		$this->admin->delete_video($id);
		$this->session->set_flashdata('success','Deleted Successfully.');	
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}

?>
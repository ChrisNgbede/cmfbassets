<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Staff extends MY_Controller {

		public function __construct(){
			parent::__construct();
			auth_check(); // check login auth
			$this->rbac->check_module_access();
			$this->rbac->check_operation_access();

		}

		public function index(){
			$this->db->select('staff.*, roles.admin_role_title as role_name, users.is_active, users.is_verify');
			$this->db->from('staff');
			$this->db->join('users', 'users.staffid = staff.id', 'left');
			$this->db->join('roles', 'roles.admin_role_id = users.admin_role_id', 'left');
			$this->db->order_by('staff.id', 'desc');
			$data['staffs'] = $this->db->get()->result();

			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/staff/index', $data);
        	$this->load->view('admin/includes/_footer');
		}

	    public function create($id = 0){

		   	$data['staff'] = $this->Common_model->get_one($id,'staff');
		    $id = $this->input->post('id');
			if($this->input->post('submit')){
					$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
					$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
					if (empty($id)) {
						$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|is_unique[staff.email]');
					}else{
						$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required');
					}
					$this->form_validation->set_rules('phone', 'Phone No', 'trim|required');
					$this->form_validation->set_rules('department', 'Department', 'trim|required');
					$this->form_validation->set_rules('designation', 'Designation', 'trim|required');
					if ($this->form_validation->run() == FALSE) {
						$data = array(
							'errors' => validation_errors()
						);
						$id = empty($id) ? '' : $id;
						$this->session->set_flashdata('error', $data['errors']);
						redirect('admin/staff/create/'.$id,'refresh');
					}else{
						
						$data = array(
							'designation' => $this->input->post('designation'),
							'department' => $this->input->post('department'),
							'firstname' => $this->input->post('firstname'),
							'lastname' => $this->input->post('lastname'),
							'email' => $this->input->post('email'),
							'phone' => $this->input->post('phone'),
							'staffno' =>  $this->input->post('staffno'),
							$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
							$this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
						);
						$data = $this->security->xss_clean($data);
						if($this->Common_model->save($data,$id,'staff')){
							// Activity Log 
							$this->session->set_flashdata('success', 'Staff has been added successfully!');
							redirect(base_url('admin/staff'));
						}
					}
				}else{
					$data['departments'] = getalldata('departments');
					$data['designations'] = getalldata('designations');
					$this->load->view('admin/includes/_header',$data);
	        		$this->load->view('admin/staff/create',$data);
	        		$this->load->view('admin/includes/_footer');
				}
		}


		public function access($id = null){

				$data['roles'] = getalldata('roles');
				$data['staff'] = $this->Common_model->get_one($id,'staff');
				$data['user'] = getby(['staffid'=>$id],'users');
				$msg = 'Unknown error';
				if ($this->input->post('submit')){
					    $data['user'] = getby(['staffid'=>$this->input->post('staffid')],'users');
					    $data['staff'] = $this->Common_model->get_one($this->input->post('staffid'),'staff');
					   // die(var_dump($data['staff']));
					    $user_data = [
							'admin_role_id' => $this->input->post('role'),
							'username' => $this->input->post('username'),
							'firstname' => $data['staff']->firstname,
							'lastname' => $data['staff']->lastname,
							'email' =>  $data['staff']->email,
							'phone' => $data['staff']->phone,
							'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
							'is_active' => 1,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
							'staffid' => $this->input->post('staffid')
						];
						$user_data = $this->security->xss_clean($user_data);
						if(!empty($data['user'])){
							
							$this->form_validation->set_rules('password', 'Password', 'trim|required');
							$this->form_validation->set_rules('role', 'Role', 'trim|required');
							if ($this->form_validation->run() == FALSE) {
								$data = [ 'errors' => validation_errors() ];
								echo json_encode(['status'=>91,'msg'=>strip_tags($data['errors'])]);
								exit();
							}else{
								
								
								if($this->db->update('users',$user_data,['admin_id'=>$this->input->post('id')])){
									echo json_encode(['status'=>0,'msg'=>'user record updated successfully']);
								}else{
									echo json_encode(['status'=>91,'msg'=>'failed to update user']);
								}
							}
						}else{

							$this->form_validation->set_rules('username', 'Username', 'trim|alpha_numeric|is_unique[users.username]|required');
							$this->form_validation->set_rules('password', 'Password', 'trim|required');
							$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|matches[password]');
							$this->form_validation->set_rules('role', 'Role', 'trim|required');
							if ($this->form_validation->run() == FALSE) {
								$data = [ 'errors' => validation_errors() ];
								echo json_encode(['status'=>91,'msg'=>strip_tags($data['errors'])]);
								exit();
							}else{
								if($this->Common_model->save($user_data,null,'users')){
									echo json_encode(['status'=>0,'msg'=>'user record added successfully']);
								}else{
									echo json_encode(['status'=>91,'msg'=>'failed to add user']);
								}
							}
						}
						
					}else{
						$this->load->view('admin/staff/access',$data);		
					}
		

		}


	}

?>	
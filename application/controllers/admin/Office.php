<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Office extends MY_Controller {

		public function __construct(){
			parent::__construct();
			auth_check(); // check login auth
			$this->rbac->check_module_access();
			$this->rbac->check_operation_access();

		}

		public function index(){
			$data['offices'] = getalldata('mdas',null,'id','desc');
			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/office/index', $data);
        	$this->load->view('admin/includes/_footer');
		}
		
	   function create($id = 0){
	   	$data['office'] = $this->Common_model->get_one($id,'office');
	    $id = $this->input->post('id');
		if($this->input->post('submit')){
				$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
				if (empty($id)) {
					$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|required|is_unique[office.email]');
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
					redirect('admin/office/create/'.$id,'refresh');
				}
				else{
					$data = array(
						'designation' => $this->input->post('designation'),
						'department' => $this->input->post('department'),
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'officeno' =>  $this->input->post('officeno'),
						$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
						$this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
					);
					$data = $this->security->xss_clean($data);
					if($this->Common_model->save($data,$id,'office')){
						// Activity Log 
						$this->session->set_flashdata('success', 'Office has been added successfully!');
						redirect(base_url('admin/office'));
					}
				}
			}
			else
			{
				$this->load->view('admin/includes/_header',$data);
        		$this->load->view('admin/office/create',$data);
        		$this->load->view('admin/includes/_footer');
			}
		}


	}

?>	
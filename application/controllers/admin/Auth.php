<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property Auth_model $auth_model
 */
class Auth extends MY_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model('admin/auth_model', 'auth_model');
		$this->load->model('admin/Activity_model', 'activity_model');
	}

	//--------------------------------------------------------------
	public function index(){

		if($this->session->has_userdata('is_admin_login')){
			redirect('admin/dashboard');
		}
		else{
			redirect('admin/auth/login');
		}
	}

	//--------------------------------------------------------------
	public function login(){

		if($this->input->post('submit')){

			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('error', $data['errors']);
				redirect(base_url('admin/auth/login'),'refresh');
			}
			else {
				$data = array(
					'username' => $this->input->post('username'),
					'password' => $this->input->post('password'),
				);

				$result = $this->auth_model->login($data);
				//var_dump($result); die();
				if($result){
					
					if($result['is_active'] == 0){
						$this->session->set_flashdata('error', 'Account is disabled please contact admin!');
						redirect(base_url('admin/auth/login'));
						exit();
					}
					if($result['is_admin'] == 1){
						$admin_data = array(
							'id' => $result['admin_id'],
							'admin_id' => $result['admin_id'],
							'username' => $result['username'],
							'admin_role_id' => $result['admin_role_id'],
							'admin_role' => $result['admin_role_title'],
							'is_supper' => $result['is_supper'],
							'staffid' => $result['staffid'],
							'is_admin_login' => TRUE
						);
						
						$this->session->set_userdata($admin_data);
						$this->rbac->set_access_in_session(); // set access in session
						
						// Activity Log
						$this->activity_model->add_log(11, 'Admin logged in: '.$result['username']);

						$redirect_to = $this->session->userdata('redirect_to');
						if($redirect_to){
							$this->session->unset_userdata('redirect_to');
							redirect($redirect_to, 'refresh');
						} else {
							redirect(base_url('admin/dashboard'), 'refresh');
						}
					}
					}
					else{
						$this->session->set_flashdata('error', 'Invalid Username or Password!');
						redirect(base_url('admin/auth/login'));
					}
				}
			}
			else{
				$data['title'] = 'Login';
				$this->load->view('components/header_auth', $data);
				$this->load->view('admin/auth/login');
				$this->load->view('components/footer_auth', $data);
			}
		}	

		//-------------------------------------------------------------------------
		public function register(){
			if($this->input->post('submit')){
				// for google recaptcha
				if ($this->recaptcha_status == true) {
		            if (!$this->recaptcha_verify_request()) {
		                $this->session->set_flashdata('form_data', $this->input->post());
		                $this->session->set_flashdata('error', 'reCaptcha Error');
		                redirect(base_url('admin/auth/register'));
		                exit();
		            }
		        }
		        $individual_data = null;
		       	$organization_data = null;
		       	$admin_role_id = null;
	        	if ($this->input->post('memtype') == "individual") {
					$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
					$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
					$this->form_validation->set_rules('state', 'State', 'trim|required');
					$this->form_validation->set_rules('lga', 'LGA', 'trim|required');
					$this->form_validation->set_rules('hometown', 'Home Town', 'trim|required');
					$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[users.email]|required');
					$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
					$this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'trim|required|matches[password]');
					$this->form_validation->set_rules('phone', 'Phone', 'trim|is_unique[users.phone]|required');
					$admin_role_id = 8;

					$individual_data = array(
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'supportgroupid' => !empty($this->input->post('supportgroup')) ? $this->input->post('supportgroup') : null,
						'supportgroupname' => $this->input->post('supportgroupname'),
						'email' => $this->input->post('email'),
						'pvcno' => $this->input->post('pvcno'),
						'phone' => $this->input->post('phone'),
						'state' => $this->input->post('state'),
						'occupation' => $this->input->post('occupation'),
						'pollingunit' => $this->input->post('pollingunit'),
						'lga' => $this->input->post('lga'),
						'ward' => $this->input->post('ward'),
						'hometown' => $this->input->post('hometown'),
						'hasvoterscard' => $this->input->post('hasvoterscard'),//sset($_POST['hasvoterscard']) ? 1 : 0,
						'phone' => $this->input->post('phone'),  
						'datecreated' => date('Y-m-d H:i:s'),
					);
	        	}

	        	if ($this->input->post('memtype') == "organization") {
				    $this->form_validation->set_rules('groupname', 'Group Name', 'trim|required');
					$this->form_validation->set_rules('state', 'State', 'trim|required');
					$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[users.email]|required');
					$this->form_validation->set_rules('phone', 'Phone', 'trim|is_unique[users.phone]|required');
					$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
					$this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'trim|required|matches[password]');
					$admin_role_id = 7;
					$organization_data = array(
						'name' => $this->input->post('groupname'),
						'email' => $this->input->post('email'),
						'phone' => $this->input->post('phone'),
						'state' => $this->input->post('state'),
						'datecreated' => date('Y-m-d H:i:s'),
					);

	        	}

	        	$config = array(
						'upload_path' => "./uploads/",
						'allowed_types' => "jpg|png|jpeg",
						'overwrite' => TRUE,
					);
					$this->load->library('upload', $config);

					
	                if ($this->upload->do_upload('photo')) {
	                	$photo = $this->upload->file_name;
	                	$individual_data['photo'] = $photo;
	                }else{
	                	 $error = $this->upload->display_errors();
	                	 
	                }
				
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('form_data', $this->input->post());
					$this->session->set_flashdata('error', $data['errors']);
					if ($this->input->post('memtype') == "individual") {
						redirect(base_url('admin/auth/register?memtype=individual'));
					}
					if ($this->input->post('memtype') == "organization") {
						redirect(base_url('admin/auth/register?memtype=organization'));
					}
					
				}
				//'password' =>  password_hash(($this->input->post('memtype') == "individual") ? "1234" : $this->input->post('password'), PASSWORD_BCRYPT),
				else{
					$user_data = array(
						'username' => $this->input->post('email'),
						'firstname' => null,
						'lastname' => null,
						'phone' => $this->input->post('phone'),
						'admin_role_id' => $admin_role_id, // By default i putt role is 2 for registraiton
						'email' => $this->input->post('email'),
						'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'is_active' => 1,
						'is_verify' => 1,
						'token' => md5(rand(0,1000)),    
						'last_ip' => $this->input->ip_address(),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => '',
					);
					
					$user_data = $this->security->xss_clean($user_data);
					$result = $this->auth_model->register($user_data, $individual_data, $organization_data);
					if($result){
						
						//sending welcome email to user
						$mail_data = array(
							'fullname' => $user_data['username'],
							'verification_link' => base_url('admin/auth/verify/').'/'.$user_data['token']
						);

						$to = $user_data['email'];

						//$email = $this->mailer->mail_template($to,'email-verification',$mail_data);

						// if($email){
							$this->session->set_flashdata('success', 'Your registration was successful, please verify it by clicking the activation link sent to your email.');
							if($this->input->post('memtype') == "individual") {
								redirect(base_url('admin/auth/done_reg?u='.$result));
								$this->session->set_flashdata('success', 'success');
								$this->mailer->mail_template($to,'email-verification',$mail_data);
							}elseif ($this->input->post('memtype') == "organization") {
								redirect(base_url('admin/auth/login'));
								$this->mailer->mail_template($to,'email-verification',$mail_data);
							}	
						// }	
						// else{
						// 	echo 'Email Error';
						// 	die();
						// }
					}
				}
			}
			else{
				$data['title'] = 'Create an Account';
				$data['auth_card_lg'] = true;
				$data['navbar'] = false;
				$data['sidebar'] = false;
				$data['footer'] = false;
				$data['bg_cover'] = true;
				// Tables might be missing, check before fetching
				$data['states'] = $this->db->table_exists('states') ? $this->Common_model->getAll('states') : [];
				$data['pollingunits'] = $this->db->table_exists('pollingunits') ? $this->Common_model->getAll('pollingunits') : [];
				$data['lgas'] = $this->db->table_exists('lgas') ? getalldata('lgas',null,"name","asc",null,null) : [];
				$data['supportgroups'] = $this->Common_model->getSupportGroups('active','approved');
				$this->load->view('admin/includes/_header_auth', $data);
				$this->load->view('admin/auth/register');
				$this->load->view('admin/includes/_footer_auth', $data);
			}
		}

		public function done_reg() {
			$u = $this->input->get('u');
			$user = $this->db->get_where('users', array('admin_id' => $u))->row();
			if($user) {
				$member = $this->db->get_where('supportmembers', array('id' => $user->memberid))->row();
				if($member) {
					$data['title'] = 'Registration Successful';
					$data['member'] = $member;
					$data['membername'] = $member->firstname . ' ' . $member->lastname;
					$data['memberphoto'] = $member->photo;
					$data['auth_card_lg'] = true;
					$data['navbar'] = false;
					$data['sidebar'] = false;
					$data['footer'] = false;
					$data['bg_cover'] = true;

					$this->load->view('components/header_auth', $data);
					$this->load->view('admin/auth/done_reg', $data);
					$this->load->view('components/footer_auth', $data);
				} else {
					redirect(base_url('admin/auth/login'));
				}
			} else {
				redirect(base_url('admin/auth/login'));
			}
		}

		//----------------------------------------------------------	
		public function verify(){

			$verification_id = $this->uri->segment(4);
			$result = $this->auth_model->email_verification($verification_id);
			if($result){
				$this->session->set_flashdata('success', 'Your email has been verified, you can now login.');
				redirect(base_url('admin/auth/login'));
			}
			else{
				$this->session->set_flashdata('success', 'The url is either invalid or you already have activated your account.');	
				redirect(base_url('admin/auth/login'));
			}	
		}

		

		//--------------------------------------------------		
		public function forgot_password(){

			if($this->input->post('submit')){
				//checking server side validation
				$this->form_validation->set_rules('email', 'Email', 'valid_email|trim|required');
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('error', $data['errors']);
					redirect(base_url('admin/auth/forget_password'),'refresh');
				}

				$email = $this->input->post('email');
				$response = $this->auth_model->check_user_mail($email);

				if($response){

					$rand_no = rand(0,1000);
					$pwd_reset_code = md5($rand_no.$response['admin_id']);
					$this->auth_model->update_reset_code($pwd_reset_code, $response['admin_id']);
					
					// --- sending email
					$to = $response['email'];
					$mail_data= array(
						'fullname' => $response['firstname'].' '.$response['lastname'],
						'reset_link' => base_url('admin/auth/reset_password/'.$pwd_reset_code)
					);
					$this->mailer->mail_template($to,'forget-password',$mail_data);

					if($email){
						$this->session->set_flashdata('success', 'We have sent instructions for resetting your password to your email');

						redirect(base_url('admin/auth/forgot_password'));
					}
					else{
						$this->session->set_flashdata('error', 'There is the problem on your email');
						redirect(base_url('admin/auth/forgot_password'));
					}
				}
				else{
					$this->session->set_flashdata('error', 'The Email that you provided are invalid');
					redirect(base_url('admin/auth/forgot_password'));
				}
			}
			else{

				$data['title'] = 'Forget Password';
				$data['navbar'] = false;
				$data['sidebar'] = false;
				$data['footer'] = false;
				$data['bg_cover'] = true;

				$this->load->view('components/header_auth', $data);
				$this->load->view('admin/auth/forget_password');
				$this->load->view('components/footer_auth', $data);
			}
		}

		//----------------------------------------------------------------		
		public function reset_password($id=0){

			// check the activation code in database
			if($this->input->post('submit')){
				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
				$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|required|matches[password]');

				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);

					$this->session->set_flashdata('reset_code', $id);
					$this->session->set_flashdata('error', $data['errors']);
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
  
				else{
					$new_password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
					$this->auth_model->reset_password($id, $new_password);
					$this->session->set_flashdata('success','New password has been Updated successfully.Please login below');
					redirect(base_url('admin/auth/login'));
				}
			}
			else{
				$result = $this->auth_model->check_password_reset_code($id);

				if($result){

					$data['title'] = 'Reseat Password';
					$data['reset_code'] = $id;
					$data['navbar'] = false;
					$data['sidebar'] = false;
					$data['footer'] = false;
					$data['bg_cover'] = true;

					$this->load->view('components/header_auth', $data);
					$this->load->view('admin/auth/reset_password');
					$this->load->view('components/footer_auth', $data);

				}
				else{
					$this->session->set_flashdata('error','Password Reset Code is either invalid or expired.');
					redirect(base_url('admin/auth/forgot_password'));
				}
			}
		}

			public function changepassword($id=0){

			if($this->input->post('submit')){
				if ($this->input->post('staffid')) {
					$id = $this->input->post('staffid');
				}

				$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
				$this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'trim|required|matches[password]');

				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);

					$this->session->set_flashdata('error', $data['errors']);
					redirect($_SERVER['HTTP_REFERER']);
				}
  
				else{

					$new_password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
					$this->auth_model->changepassword($id, $new_password);
					$this->session->set_flashdata('success','New password has been Updated successfully');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
			else{
				$this->session->set_flashdata('warning','Nothing Happened');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}

		public function logout(){
			$this->activity_model->add_log(12, 'Admin logged out: '.$this->session->userdata('username'));
			$this->session->sess_destroy();
			redirect(base_url('admin/auth/login'), 'refresh');
		}
		
		// Get Country. State and City
		//----------------------------------------
		public function get_country_states()
		{
			$states = $this->db->select('*')->where('country_id',$this->input->post('country'))->get('states')->result_array();
		    $options = array('' => 'Select Option') + array_column($states,'name','id');
		    $html = form_dropdown('state',$options,'','class="form-control select2" required');
			$error =  array('msg' => $html);
			echo json_encode($error);
		}

		//----------------------------------------
		public function get_state_cities()
		{
			$cities = $this->db->select('*')->where('state_id',$this->input->post('state'))->get('cities')->result_array();
		    $options = array('' => 'Select Option') + array_column($cities,'name','id');
		    $html = form_dropdown('city',$options,'','class="form-control select2" required');
			$error =  array('msg' => $html);
			echo json_encode($error);
		}

	}  // end class


?>
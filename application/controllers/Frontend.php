<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('captcha');
		
	}
	public function index()
	{
		redirect('admin/auth');
	}
	
	
	
	public function viewprofile()
	{
		$id = $this->input->get('profile');
		$this->data['profile'] = $this->Profiles_model->getprofilebyid($id);
		$this->data['partial'] = 'viewprofile';
		$this->data['pagetitle'] = 'Profile';
		$this->load->view('_layout_main', $this->data);
	}


	 public function comment(){
			if ($this->input->post('postid')) {
				$data = array(
					'postid' => $this->input->post('postid'),
					'content' => $this->input->post('message'),
					'authoremail' => $this->input->post('email'),
					'type' => 'comment',
					'author' => empty($this->session->userdata('id')) || $this->session->userdata('id') == 0 ? $this->input->post('name') : $this->session->userdata('id'),
					'datecreated' => date('Y-m-d H:i:s'),
				);


				$data = $this->security->xss_clean($data);

				if($reactionid = $this->Common_model->savecomment($data))
				{	
					$comments = $this->Common_model->countwhere('postreactions', array('postid'=>$data['postid'], 'type' => 'comment'));
					$return = array('status'=>'success', 'comments' => $comments, 'postid' => $data['postid'], 'content' =>  $this->input->post('message') );
					echo json_encode($return);
				}else{
					$this->session->set_flashdata('error','error occured');
					$return = array('status' => 'error' , 'message' => '');
					echo json_encode($return);
				}
				// code...
			}else{
				$return = array('error' => validation_errors());
				echo json_encode($return);
			}
			
			

        } 

         public function save_enquiry(){
         	$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
            $userIp = $this->input->ip_address();
            $secret = $this->settings->recaptcha_site_key;
            $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
	        $ch = curl_init(); 
	        curl_setopt($ch, CURLOPT_URL, $url); 
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	        $output = curl_exec($ch); 
	        curl_close($ch);      
	        $status= json_decode($output, true);
				if ($this->input->post('message')) {
				$data = array(
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'body' => $this->input->post('message'),
					'title' => $this->input->post('subject'),
					'ipaddress' => $this->input->ip_address(),
					'service' => 'enquiry',
					'status' => 'open',
					'datecreated' => date('Y-m-d H:i:s'),
				);
				$data = $this->security->xss_clean($data);

				if($id = $this->Common_model->savedata('inquiries',$data) && $status['success'])
				{	
					   $this->load->helper('email_helper');
						$mail_data = array(
							'fullname' => $data['name'],
						);
						$to = "info@gralvin.com";//$data['email'];
						$email = $this->mailer->mail_template($to,'email-verification',$mail_data);
						if($email){
							$return = array('status'=>'success', 'id' => $id, 'body' =>  $this->input->post('body'), 'email_message'=>'email sent' );
							echo json_encode($return);
						}	
						else{
							echo json_encode(array('status'=>'success', 'id' => $id, 'body' =>  $this->input->post('body'),'email_message' => 'email failed'));						
						}
					
				}else{
					$this->session->set_flashdata('error','error occured');
					$return = array('status' => 'error' , 'message' => '');
					if (!$status['success']) {
						$return['recaptcha_error'] = "Sorry Google Recaptcha Unsuccessful";
					}
					echo json_encode($return);
				}
				// code...
			}else{
				$return = array('error' => validation_errors());
				if (!$status['success']) {
					$return['recaptcha_error'] = "Sorry Google Recaptcha Unsuccessful";
				}
				echo json_encode($return);
			}
			
			

        }



		public function news()
		{
			$this->data['partial'] = 'news';
			$this->data['pagetitle'] = 'News';
			$this->load->view('_layout_main', $this->data);
		}

		public function projects()
		{
			$this->data['partial'] = 'projects';
			$this->data['pagetitle'] = 'Projects';
			$this->load->view('_layout_main', $this->data);
		}

		public function post_details($id = 0)
		{	
			if ($this->input->get('id')) {
				$id = $this->input->get('id');
			}else{
				redirect($_SERVER['HTTP_REFERER'], 'refresh');
			}
			$this->data['post'] = $this->Blog_model->getPostById($id);
			$this->data['partial'] = 'post_details';
			$this->data['pagetitle'] = '';
			$this->data['postmeta'] = $this->data['post'];
			$this->load->view('_layout_main', $this->data);
		}
	

		public function servicedetails()
		{	
			if ($this->input->get('s')) {
				$s = $this->input->get('s');
			}else{
				redirect($_SERVER['HTTP_REFERER'], 'refresh');
			}

			$this->data['service'] = getalldata('services',['slug' => $s],null,null, 0, 1);
			$this->data['partial'] = 'servicedetails';
			$this->data['pageintro'] = 'Service Details';
			$this->data['pagedescription'] = 'Thank you for visiting us today';
			$this->load->view('_layout_main', $this->data);
		}

		public function project_details($id = 0)
		{	
			if ($this->input->get('id')) {
				$id = $this->input->get('id');
			}else{
				redirect($_SERVER['HTTP_REFERER'], 'refresh');
			}
			
			$this->data['project'] = $this->Project_model->getProjectById($id);
			
			$this->data['partial'] = 'project_details';
			$this->data['pagetitle'] = '';
			$this->load->view('_layout_main', $this->data);
		}

	
		public function contact()
		{
			$this->data['partial'] = 'contact';
			$this->load->view('_layout_main', $this->data);
		}
			
	}

	?>
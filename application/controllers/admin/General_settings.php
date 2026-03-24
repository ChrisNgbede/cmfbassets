<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General_settings extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_check(); // check login auth
		$this->load->model('admin/common_model', 'Common_model');
		$this->rbac->check_module_access();
		define('URI', $uri = $this->settings->fhub_islive == 1 ? $this->settings->fhub_liveurl : $this->settings->fhub_testurl);
		$this->load->model('admin/Setting_model', 'Setting_model');
	}

	//-------------------------------------------------------------------------
	// General Setting View
	public function index()
	{
		$data['general_settings'] = $this->Setting_model->get_general_settings();
		$data['languages'] = $this->Setting_model->get_all_languages();    
		$data['title'] = 'General Setting';
		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/general_settings/setting', $data);
		$this->load->view('admin/includes/_footer');
	}

		// Multiple File Upload
	public function sliderimages(){
		if($_FILES){
			$config = array(
				'upload_path' => "./uploads/",
				'allowed_types' => "gif|jpg|png|jpeg|pdf",
				'encrypt_name' => TRUE,
				'overwrite' => TRUE,
				'max_size' => "2048000", // It is 2 MB(2048 Kb)
				'max_height' => "1200",
				'max_width' => "1900"
			);
			$this->load->library('upload', $config);

			if($this->upload->do_upload('file'))
			{
				$path = 'uploads/';

				$data = array(
					'name' => $path.$this->upload->data('file_name'),
					'datecreated' => date('Y-m-d H:i:s'),
					'createdby' => $this->session->userdata('id')
				);

				$data = $this->security->xss_clean($data);

				$this->Setting_model->add_slider_file($data);

				$this->session->set_flashdata('success','Files have been uploaded successfully');

				$return = array('status' => 'success' , 'message' => 'File Uploaded');

				echo json_encode($return);
			}
			else
			{
				$this->session->set_flashdata('error',$this->upload->display_errors());
				$return = array('status' => 'error' , 'message' => '');

				echo json_encode($return);
			}
		}
		else{

			$data['title'] = 'Slider Images Upload';

			$data['files'] = $this->Setting_model->get_uploaded_slider_files();

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/general_settings/sliderimages', $data);
			$this->load->view('admin/includes/_footer');
		}
	}


	public function deletesliderimage($id ='')
	{
		if ($this->Common_model->delete($id,'sliderimages')) {
			$this->session->set_flashdata('success','File has been deleted successfully');
			redirect(base_url('admin/general_settings/sliderimages'));
		}else{
			$this->session->set_flashdata('error','Failed to delete');
		    redirect(base_url('admin/general_settings/sliderimages'));
		}
		

		
	}		
	//-------------------------------------------------------------------------
	public function add()
	{
		$this->rbac->check_operation_access(); // check opration permission	
		$keywords = [];
		if (!empty($this->input->post('keywords'))) {
			foreach ($this->input->post('keywords') as $keyword) {
				$keywords[] = $keyword;
			}
		}	
		
		$data['keywords'] = implode(",", $keywords);
		$data = array(
			'application_name' => $this->input->post('application_name'),
			'timezone' => $this->input->post('timezone'),
			'currency' => $this->input->post('currency'),
			'default_language' => $this->input->post('language'),
			'copyright' => $this->input->post('copyright'),
			'email_from' => $this->input->post('email_from'),
			'smtp_host' => $this->input->post('smtp_host'),
			'smtp_port' => $this->input->post('smtp_port'),
			'smtp_user' => $this->input->post('smtp_user'),
			'smtp_pass' => $this->input->post('smtp_pass'),
			'vision' => $this->input->post('vision'),
			'mission' => $this->input->post('mission'),
			'remita_liveurl' => $this->input->post('remita_liveurl'),
			'remita_testurl' => $this->input->post('remita_testurl'),
			'remita_islive' => $this->input->post('remita_islive'),
			'remita_liveapikey' => $this->input->post('remita_liveapikey'),
			'remita_testapikey' => $this->input->post('remita_testapikey'),
			'remita_liveapitoken' => $this->input->post('remita_liveapitoken'),
			'remita_testapitoken' => $this->input->post('remita_testapitoken'),
			'remita_livemerchantid' => $this->input->post('remita_livemerchantid'),
			'remita_testmerchantid' => $this->input->post('remita_testmerchantid'),
			'fhub_code' => $this->input->post('fhub_code'),
			'fhub_username' => $this->input->post('fhub_username'),
			'fhub_password' => $this->input->post('fhub_password'),
			'fhub_liveurl' => $this->input->post('fhub_liveurl'),
			'fhub_islive' => $this->input->post('fhub_islive'),
			'fhub_testurl' => $this->input->post('fhub_testurl'),
			'sms_senderid' => $this->input->post('sms_senderid'),
			'sms_password' => $this->input->post('sms_password'),
			'sms_username' => $this->input->post('sms_username'),
			'catchphrase' => $this->input->post('catchphrase'),
			'facebook_link' => $this->input->post('facebook_link'),
			'announcement' => $this->input->post('announcement'),
			'seokeywords' => implode(",", $keywords),
			'tagline' => $this->input->post('tagline'),
			'phone1' => $this->input->post('phone1'),
			'phone2' => $this->input->post('phone2'),
			'email1' => $this->input->post('email1'),
			'email2' => $this->input->post('email2'),
			'map' => htmlspecialchars($this->input->post('map')),
			'address' => $this->input->post('address'),
			'twitter_link' => $this->input->post('twitter_link'),
			'whatsapp_link' => $this->input->post('whatsapp_link'),
			'youtube_link' => $this->input->post('youtube_link'),
			'linkedin_link' => $this->input->post('linkedin_link'),
			'instagram_link' => $this->input->post('instagram_link'),
			'recaptcha_secret_key' => $this->input->post('recaptcha_secret_key'),
			'recaptcha_site_key' => $this->input->post('recaptcha_site_key'),
			'recaptcha_lang' => $this->input->post('recaptcha_lang'),
			'created_date' => date('Y-m-d H:i:s'),
			'updated_date' => date('Y-m-d H:i:s'),
		);

		$old_logo = $this->input->post('old_logo');
		$old_favicon = $this->input->post('old_favicon');
		$old_header_image = $this->input->post('old_header_image');
		$bannerimage = null;

		$path="assets/img/";

		if(!empty($_FILES['logo']['name']))
		{
			$this->functions->delete_file($old_logo);

			$result = $this->functions->file_insert($path, 'logo', 'image', '9097152');
			if($result['status'] == 1){
				$data['logo'] = $path.$result['msg'];
			}
			else{
				$this->session->set_flashdata('error', $result['msg']);
				redirect(base_url('admin/general_settings'), 'refresh');
			}
		}
		
		// favicon
		if(!empty($_FILES['favicon']['name']))
		{
			$this->functions->delete_file($old_favicon);

			$result = $this->functions->file_insert($path, 'favicon', 'image', '197152');
			if($result['status'] == 1){
				$data['favicon'] = $path.$result['msg'];
			}
			else{
				$this->session->set_flashdata('error', $result['msg']);
				redirect(base_url('admin/general_settings'), 'refresh');
			}
		}
		if(!empty($_FILES['header_image']['name']))
		{
			$this->functions->delete_file($old_header_image);

			$result = $this->functions->file_insert($path, 'header_image', 'image', '50000000');
			if($result['status'] == 1){
				$data['header_image'] = $path.$result['msg'];
			}
			else{
				$this->session->set_flashdata('error', $result['msg']);
				redirect(base_url('admin/general_settings'), 'refresh');
			}
		}

		if ($_POST['submit']) {
			
			if (empty($this->input->post('remita_islive'))) {
				$data['remita_islive'] = 0;
			}else{
				$data['remita_islive'] = 1;
			}

			if (empty($this->input->post('fhub_islive'))) {
				$data['fhub_islive'] = 0;
			}else{
				$data['fhub_islive'] = 1;
			}
			
		}

		$data = $this->security->xss_clean($data);
		$result = $this->Setting_model->update_general_setting($data);
		if($result){
			$this->session->set_flashdata('success', 'Setting has been changed Successfully!');
			redirect(base_url('admin/general_settings'), 'refresh');
		}
	}

	function banks (){
		$data['banks'] = $this->Common_model->getAll('banks',null,'name','ASC');
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/general_settings/banks', $data);
		$this->load->view('admin/includes/_footer');
	}

	function fhubloanparams (){
		$data['loanparams'] = $this->Common_model->getAll('banks',null,'name','ASC');
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/general_settings/fhubloanparams', $data);
		$this->load->view('admin/includes/_footer');
	}
	function fhubtenures (){
		$token = generate_fhub_token();
		$url = URI.'/loanservice/rest/api/partner/all-tenures/'.$this->settings->fhub_code;
		$response = $this->functions->sendGetRequest($url,['Authorization'=>'Bearer '.$token]);
		$response = json_decode($response);
        if ($response === null && json_last_error() !== JSON_ERROR_NONE) {
           $data['tenures'] = null;
        } else {
            if ($response->responseCode == 200) {
                $data['tenures'] = $response->data;
            }else{
                $data['tenures'] = null;
            }
        }
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/general_settings/fhubtenures', $data);
		$this->load->view('admin/includes/_footer');
	}
	function fhubloanproducts (){

		$token = generate_fhub_token();
		$url = URI.'/loanservice/rest/api/fetch/partner-supported/loan/types/'.$this->settings->fhub_code;
		$response = $this->functions->sendGetRequest($url,['Authorization'=>'Bearer '.$token]);
		$response = json_decode($response);
        if ($response === null && json_last_error() !== JSON_ERROR_NONE) {
           $data['products'] = null;
        } else {
            if ($response->responseCode == 200) {
                $data['products'] = $response->data->supportedLoanTypes;
            }else{
                $data['products'] = null;
            }
        }
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/general_settings/fhubloanproducts', $data);
		$this->load->view('admin/includes/_footer');
	}


	function smstemplates (){
		$data['templates'] = $this->Common_model->getAll('sms_templates',null,'id','DESC');
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/general_settings/smstemplates', $data);
		$this->load->view('admin/includes/_footer');
	}

	function stslsettings (){
		$data = null;
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/general_settings/stslsettings', $data);
		$this->load->view('admin/includes/_footer');
	}


	public function createbank($id=0){	
			
			$this->rbac->check_operation_access();
			if($this->input->post('submit')){

				$id = !empty($this->input->post('id')) ? $this->input->post('id') : $id;
			    $this->form_validation->set_rules('name', 'Name', 'trim|required');
			    if ($id < 1) {
					$this->form_validation->set_rules('code', 'Code', 'trim|required|is_unique[banks.code]');
				}
				$data = array(
					'name' => $this->input->post('name'),
					'code' => $this->input->post('code'),
					'shortname' => $this->input->post('shortname'),
				);
			
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('form_data', $this->input->post());
					$this->session->set_flashdata('error', $data['errors']);
					redirect(base_url('admin/general_settings/banks'),'refresh');
				}else{

					$data = $this->security->xss_clean($data);
					if ($this->Common_model->save($data, $this->input->post('id'),'banks')) {
						$this->session->set_flashdata('success', 'Saved Successfully');
						redirect(base_url('admin/general_settings/banks'));
					}else{
						$this->session->set_flashdata('error', 'Failed');
						redirect(base_url('admin/general_settings/banks'));
					}
					
				}
			}else{
				$data['title'] = 'Create Bank';
				$data['bank'] = $this->Common_model->get_one('banks',$id);
				$this->load->view('admin/general_settings/createbank',$data);
			
		}
	}

	public function createsmstemplate($id=0){	
			
			$this->rbac->check_operation_access();
			if($this->input->post('submit')){

				
			    $this->form_validation->set_rules('name', 'Name', 'trim|required');
			  
					$data = array(
						'name' => $this->input->post('name'),
						'message' => $this->input->post('message'),
						'updatedat' => date('Y-m-d H:i:s'),
					);
			
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('form_data', $this->input->post());
					$this->session->set_flashdata('error', $data['errors']);
					redirect(base_url('admin/general_settings/smstemplates'),'refresh');
				}else{

					$data = $this->security->xss_clean($data);
					if ($this->Common_model->save($data, $this->input->post('id'),'sms_templates')) {
						$this->session->set_flashdata('success', 'Saved Successfully');
						redirect(base_url('admin/general_settings/smstemplates'));
					}else{
						$this->session->set_flashdata('error', 'Failed');
						redirect(base_url('admin/general_settings/smstemplates'));
					}
					
				}
			}else{
				$data['title'] = 'Create Bank';
				$data['smstemplate'] = $this->Common_model->get_one($id,'sms_templates');
				$this->load->view('admin/general_settings/createsmstemplate',$data);
			
		}
	}

		/*--------------------------
	   Email Template Settings
	--------------------------*/

	// ------------------------------------------------------------
	public function email_templates()
	{
		$this->rbac->check_operation_access(); // check opration permission
		if($this->input->post()){
			$this->form_validation->set_rules('subject', 'Email Subject', 'trim|required');
			$this->form_validation->set_rules('content', 'Email Body', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{

				$id = $this->input->post('id');
				
				$data = array(
					'subject' => $this->input->post('subject'),
					'body' => $this->input->post('content'),
					'last_update' => date('Y-m-d H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->Setting_model->update_email_template($data, $id);
				if($result){
					echo "true";
				}
			}
		}
		else
		{
			$data['title'] = '';
			$data['templates'] = $this->Setting_model->get_email_templates();

			$this->load->view('admin/includes/_header');
			$this->load->view('admin/general_settings/email_templates/templates_list', $data);
			$this->load->view('admin/includes/_footer');
		}
	}

	// ------------------------------------------------------------
	// Get Email Template & Related variables via Ajax by ID
	public function get_email_template_content_by_id()
	{
		$id = $this->input->post('template_id');

		$data['template'] = $this->Setting_model->get_email_template_content_by_id($id);
		
		$variables = $this->Setting_model->get_email_template_variables_by_id($id);

		$data['variables'] = implode(',',array_column($variables, 'variable_name'));

		echo json_encode($data);
	}

	//---------------------------------------------------------------
    //
    public function email_preview()
    {
        if($this->input->post('content'))
        {
            $data['content'] = $this->input->post('content');
            $data['head'] = $this->input->post('head');
            $data['title'] = 'Send Email to Subscribers';
            echo $this->load->view('admin/general_settings/email_templates/email_preview', $data,true);
        }
    }

    public function deletefaq($id){

			$this->rbac->check_operation_access(); // check opration permission

			$result = $this->db->delete('faqs', array('id' => $id));
			if($result){
				$this->session->set_flashdata('success', ' Deleted Successfully!');
				redirect(base_url('admin/general_settings/faqs'));
			}
		}
	function assetcategories (){
		$data['categories'] = $this->Common_model->getAll('asset_categories', 'name', 'ASC');
		$data['title'] = 'Asset Categories';
		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/general_settings/assetcategories', $data);
		$this->load->view('admin/includes/_footer');
	}

	public function createassetcategory($id=0){	
			
			$this->rbac->check_operation_access();
			if($this->input->post('submit')){

				$id = !empty($this->input->post('id')) ? $this->input->post('id') : $id;
			    $this->form_validation->set_rules('name', 'Name', 'trim|required');
			
				$data = array(
					'name' => $this->input->post('name'),
					'code' => $this->input->post('code'),
					'created_at' => date('Y-m-d H:i:s'),
				);
			
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('form_data', $this->input->post());
					$this->session->set_flashdata('error', $data['errors']);
					redirect(base_url('admin/general_settings/assetcategories'),'refresh');
				}else{

					$data = $this->security->xss_clean($data);
					if ($this->Common_model->save($data, $this->input->post('id'),'asset_categories')) {
						$this->session->set_flashdata('success', 'Saved Successfully');
						redirect(base_url('admin/general_settings/assetcategories'));
					}else{
						$this->session->set_flashdata('error', 'Failed');
						redirect(base_url('admin/general_settings/assetcategories'));
					}
					
				}
			}else{
				$data['title'] = 'Create Asset Category';
				$data['category'] = $this->Common_model->get_one($id,'asset_categories');
				$this->load->view('admin/general_settings/createassetcategory',$data);
			
		}
	}

	public function deleteassetcategory($id){
		$this->rbac->check_operation_access();
		if ($this->Common_model->delete($id,'asset_categories')) {
			$this->session->set_flashdata('success','Deleted successfully');
			redirect(base_url('admin/general_settings/assetcategories'));
		}else{
			$this->session->set_flashdata('error','Failed to delete');
		    redirect(base_url('admin/general_settings/assetcategories'));
		}
	}

	function assetgroups (){
		$data['groups'] = $this->Common_model->getAll('asset_groups', 'name', 'ASC');
		$data['title'] = 'Asset Groups';
		$this->load->view('admin/includes/_header', $data);
		$this->load->view('admin/general_settings/assetgroups', $data);
		$this->load->view('admin/includes/_footer');
	}

	public function createassetgroup($id=0){	
			
			$this->rbac->check_operation_access();
			if($this->input->post('submit')){

				$id = !empty($this->input->post('id')) ? $this->input->post('id') : $id;
			    $this->form_validation->set_rules('name', 'Name', 'trim|required');
			    $this->form_validation->set_rules('cat_id', 'Category', 'trim|required');
			
				$data = array(
					'name' => $this->input->post('name'),
					'cat_id' => $this->input->post('cat_id'),
					'created_at' => date('Y-m-d H:i:s'),
				);
			
				if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('form_data', $this->input->post());
					$this->session->set_flashdata('error', $data['errors']);
					redirect(base_url('admin/general_settings/assetgroups'),'refresh');
				}else{

					$data = $this->security->xss_clean($data);
					if ($this->Common_model->save($data, $this->input->post('id'),'asset_groups')) {
						$this->session->set_flashdata('success', 'Saved Successfully');
						redirect(base_url('admin/general_settings/assetgroups'));
					}else{
						$this->session->set_flashdata('error', 'Failed');
						redirect(base_url('admin/general_settings/assetgroups'));
					}
					
				}
			}else{
				$data['title'] = 'Create Asset Group';
				$data['group'] = $this->Common_model->get_one($id,'asset_groups');
				$data['categories'] = $this->Common_model->getAll('asset_categories', 'name', 'ASC');
				$this->load->view('admin/general_settings/createassetgroup',$data);
			
		}
	}

	public function deleteassetgroup($id){
		$this->rbac->check_operation_access();
		if ($this->Common_model->delete($id,'asset_groups')) {
			$this->session->set_flashdata('success','Deleted successfully');
			redirect(base_url('admin/general_settings/assetgroups'));
		}else{
			$this->session->set_flashdata('error','Failed to delete');
		    redirect(base_url('admin/general_settings/assetgroups'));
		}
	}

}

?>	
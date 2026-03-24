<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Messaging extends MY_Controller {

		public function __construct(){
			parent::__construct();
			auth_check(); // check login auth
			$this->rbac->check_module_access();
			$this->rbac->check_operation_access();

		}

		public function index(){
			//var_dump(date('Y-m-d H:i:s', '1657265244')); die();

			$data['sms'] = getalldata('messaging');

			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/messaging/sms', $data);
        	$this->load->view('admin/includes/_footer');
		}

		public function sms(){
			//var_dump(date('Y-m-d H:i:s', '1657265244')); die();

			$data['smss'] = getalldata('sms',null,'id','DESC');

			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/messaging/sms', $data);
        	$this->load->view('admin/includes/_footer');
		}

		public function createsms($phone = NULL) {
        $allcustomers = null;
        $recipient = $phone; 
        if($this->input->post('send_message')){
        $this->form_validation->set_rules('message', 'No Message', 'trim|required');
        $this->form_validation->set_rules('template','Template','trim|required');
        if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('form_data', $this->input->post());
				$this->session->set_flashdata('error', $data['errors']);
				redirect(base_url('admin/messaging/createsms'),'refresh');
			}else{
				$message = strip_tags($this->input->post('message'));        
				if ($this->input->post('recipientcateory') == "all") {
					$allcustomers = getalldata('customers');
					if (empty($allcustomers)) {
						$this->session->set_flashdata('error', 'No customers in the system');
						redirect($_SERVER["HTTP_REFERER"]);
					}else{
						foreach ($allcustomers as $customer) {
							$customersphone[] = $customer->phone;
						}
						$recipient = implode(',', $customersphone);
						$response = sendbulksms($message, $recipient);
					}
	    			
	    		}else{
	    				
	    			if (empty($this->input->post('recipient'))) {
		        		$this->session->set_flashdata('error', 'Recipients not selected');
						redirect($_SERVER["HTTP_REFERER"]);
		        	}else{
		    			foreach($this->input->post('recipient') as $customerphone) {
							$selectedcustomersphone[] = $customerphone;
						}			
						$recipient = implode(',', $selectedcustomersphone);
						$response = sendbulksms($message, $recipient);
			    	}
	    		}
	            $data = array(
	            	 'sender' => $this->settings->sms_senderid ,
	            	 'receiver' =>  $recipient,
	            	 'template' => $this->input->post('template'),
	            	 'message' => $message, 
	            	 'date' => date('Y-m-d H:i:s'), 
	            	 'delivery' => ($response->status != 'success') ? 'failed' : 'sent', 
	            	 'createdby' => $this->session->userdata('id'), 
	            	 'deliveryreport' => json_encode($response)
	              );

                if ($response->status == 'success') {
                     $this->session->set_flashdata('success', 'Message Sent');
                     $this->Messaging_model->logSMS($data);
                     redirect($_SERVER["HTTP_REFERER"]);
                }else{
                	log_message('error', $response);
                    $this->session->set_flashdata('error', 'Failed! Could not send. Kindly contact system administrator');
                    $this->Messaging_model->logSMS($data);
                    redirect($_SERVER["HTTP_REFERER"]);

                }
               }
             }else{

             	$data['page_title'] = 'Send New Message ';
                $data['templates'] = getalldata('sms_templates');
                $data['staffs'] = getalldata('staff');
                $data['phone'] = $phone;
                $data['customers'] = getalldata('customers',['onremita'=>1],'id','desc');
                $data['shortcodes'] = getSmsShortcodeTag();
                $this->load->view('admin/includes/_header');
				$this->load->view('admin/messaging/createsms', $data);
				$this->load->view('admin/includes/_footer');
             }  

            
    }
    	
    public function getManualSMSTemplateinfo() {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $type = 'sms';
        // Get users
        $response = $this->Messaging_model->getManualSMSTemplateListSelect2($searchTerm, $type);
        echo json_encode($response);
    }

    public function getManualSMSTemplateMessageboxText() {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $data['template'] = $this->Messaging_model->getManualSMSTemplateById($id, $type);
        echo json_encode($data);
    }

   

	}

?>	
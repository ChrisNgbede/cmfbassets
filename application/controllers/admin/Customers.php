<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Customers extends MY_Controller {

	public function __construct(){

		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		define('API_KEY',($this->settings->remita_islive == 0) ? $this->settings->remita_testapikey : $this->settings->remita_liveapikey);
		define('API_TOKEN',($this->settings->remita_islive == 0) ? $this->settings->remita_testapitoken : $this->settings->remita_liveapitoken);
		define('MERCHANT_ID',($this->settings->remita_islive == 0) ? $this->settings->remita_testmerchantid : $this->settings->remita_livemerchantid);
		$uri = ($this->settings->remita_islive == 0) ? $this->settings->remita_testurl : $this->settings->remita_liveurl;
		define('URI',$uri);
		define('GET_SALARY_HISTORY_URL',$uri.'/remita/exapp/api/v1/send/api/loansvc/data/api/v2/payday/salary/history/ph');
		define('MANDATE_PAYMENT_HISTORY',$uri.'/remita/exapp/api/v1/send/api/loansvc/data/api/v2/payday/loan/payment/history');
		define('DISBURSEMENT_NOTIFICATION_URL',$uri.'/remita/exapp/api/v1/send/api/loansvc/data/api/v2/payday/post/loan');

		
		
	}

	//-----------------------------------------------------------
	public function index(){
		$this->rbac->check_operation_access();
		$filter = [];
		$filter['onremita'] = 1;
		if (!empty($_GET['waiting'])) {
			$filter['onremita'] = 0;
		}
		if (!empty($_GET['suspended'])) {
			$filter['onremita'] = 2;
		}

		if (!empty($_GET['onremita'])) {
			$filter['onremita'] = 1;
		}		
		
		$data['customers'] = getalldata('customers',$filter,'id','DESC');
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/customers/index',$data);
		$this->load->view('admin/includes/_footer');
	}

	public function get_customers_data() {
		$this->rbac->check_operation_access();
		$params['start'] = 1;
		$params['length'] = 20;
		$params['search'] = [];
		$params['order'] = 0;
        $data = $this->Common_model->get_json_data('customers',$params); // Call the method from your model to retrieve data from the database
        echo json_encode($data);
    }


   public function getAllCustomers($params = null){
   	$params['onremita'] = 1;
   	$records['data'] = $this->Customer_model->getAllCustomers($params);
		$data = array();
		$i=0;
		$office = '';
		foreach ($records['data']  as $row) 
		{  
			//$status = ($row['is_active'] == 1)? 'checked': '';

        	$onremita = '';
        	$no_of_searchs = countwhere('customer_successful_search',['customerid'=>$row['remitacustomerid']]); 
            if ($row['onremita'] == 1){
            	$onremita = '<span class="badge badge-success">on remita</span>';
            }elseif($row['onremita'] == 2){
            	$onremita = '<span class="badge badge-info">suspended</span>';
            }elseif($row['onremita'] == 3){
            	$onremita = '<span class="badge badge-secondary">unknown</span>';
            }else{
            	$onremita = '<span class="badge badge-danger">not on remita</span>';
            }
              
             $onremita.='<br><span class="badge badge-warning">'.$no_of_searchs.'<i class="fa fa-search"></i></span>';
             $office = empty($row['office']) ? '' : '<small>('.$row['office'].')</small>' ;
             if (!empty(getbyid($row['office'],'mdas'))) {
              	  $mda = getbyid($row['office'],'mdas');
              	  $department = !empty($mda->department) ? 'Dep: '.$mda->department : '';
	              $agency = !empty($mda->ageny) ? 'Agen: '.$mda->agency : '';
	              $ministry = !empty($mda->ministry) ? 'Min: '.$mda->ministry : '';
	              $office = '('.$ministry.' '.$department.' '.$agency.')';
             }             
                                			 
             $salary = !empty(getby(['phone'=>$row['phone']],'customer_salary_loan')) ? getby(['phone'=>$row['phone']],'customer_salary_loan') : null;
             $sal = !empty($salary) ? json_decode($salary->salary) : null;
             $loans = !empty($salary->loan) ? sizeof(json_decode($salary->loan)) : null;

             
			 $data[]= array(
			 	$row['id'],
				'<a href="'.base_url('admin/customers/salary_loan_details/'.$row['phone']).'" class="text-dark" title="View Customer Profile" >'.$row['fullname'].'</a><br><small class="text-primary">'.$row['remitacustomerid'].' </small>',
				'<a href="'.base_url('admin/customers/search/'.$row['phone']).'" title="click to recheck remita" class="text-dark">'.$row['phone'].'</a>',
				$row['organization'].'<br>'.$office,
				!empty($sal) ? formatMoney($sal[0]->amount) : '<span class="badge badge-danger"> no data </span>',
				!empty($loans) ? $loans : '<span class="badge bg-success">none</span>',
				$onremita,
				formatDate($row['lastchecked']),	
				'<input type="checkbox" name="" class="flat-red" id=customer'.$row['id'].' >'
			);

			 $csvData[]= array(
				$row['fullname'],
				$row['phone'],
				$row['bvn'],
				$row['organization'],
				!empty($sal) ? formatMoney($sal[0]->amount) : 'no data',
				!empty($loans) ? $loans : 'none',
				strip_tags($onremita),
				formatDate($row['lastchecked']),	
				''
			);
		}
		$records['data'] = $data;
		if ( !empty($_GET['export']) && $_GET['export'] == 'csv') {

			    $filename = 'remita_customers_'.strtotime(date('Y-m-d H:i:s')).'.csv'; 
				header("Content-Description: File Transfer"); 
				header("Content-Disposition: attachment; filename=$filename"); 
				header("Content-Type: application/csv; ");
			   // file creation 
				$file = fopen('php://output', 'w');

				$header = array("Name", "Phone", "BVN", "Office", "Salary", "Total Loans", "On Remita", "Last Checked On", ""); 
				fputcsv($file, $header);
				foreach ($csvData as $key=>$line){ 
					fputcsv($file,$line); 
				}
				fclose($file); 
				exit; 
		}
		echo json_encode($records);	
   }

	public function loans(){
			$this->rbac->check_operation_access();
			$filter = [];				
			$data['loans'] = getalldata('loans',$filter,'id','DESC');
			$this->load->view('admin/includes/_header');
			$this->load->view('admin/customers/loans',$data);
			$this->load->view('admin/includes/_footer');
	}


	

	public function search_alt(){
		$this->rbac->check_operation_access();
		$data['customer_searchs'] = getalldata('customer_successful_search',null,'id','DESC',0,4);
		$data['banks'] = getalldata('banks',null,'name','ASC');
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/customers/search_alt',$data);
		$this->load->view('admin/includes/_footer');
	}


	public function salary_loan_details($phone = NULL){
		$this->rbac->check_operation_access();
		$data = null;
		if ($phone) {
			$data['customer'] = getby(['phone'=>$phone],'customers');
			$data['customer_salary_loan'] = getby(['phone'=>$phone],'customer_salary_loan');
			$data['salaries'] = !empty($data['customer_salary_loan']->salary) ? json_decode($data['customer_salary_loan']->salary) : null;
			$data['loans'] = !empty($data['customer_salary_loan']->salary) ? json_decode($data['customer_salary_loan']->loan) : null;
		}
		
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/customers/salary_loan_details',$data);
		$this->load->view('admin/includes/_footer');
	}


	public function createloan(){
		$this->rbac->check_operation_access();
		if (!empty($_GET['phone']) || !empty($_POST['phone'])) {
			$customer = getby(['phone'=>$_GET['phone']],'customers');
			$data['phone'] = empty($_GET['phone']) ? $_POST['phone'] : $_GET['phone'];
			$data['name'] = $customer->fullname;
			$data['bvn'] = $customer->bvn;
			$data['office'] = $customer->organization;
			$data['customerid'] = $customer->remitacustomerid;
			$data['lastchecked'] = $customer->lastchecked;
			$data['loans'] = getalldata('loans',['phone'=>$data['phone']]);
			
		}else{
			$this->session->set_flashdata('error', 'Unauthorized Request');
		    redirect($_SERVER["HTTP_REFERER"]);
		}

		$this->load->view('admin/includes/_header');
		$this->load->view('admin/customers/createloan',$data);
		$this->load->view('admin/includes/_footer');
	}

	public function saveloan(){
		$this->rbac->check_operation_access();


		if (!empty($_POST['createloan'])) {
				
				$this->form_validation->set_rules('phone', 'Customer Phone Number', 'trim|required');
				$this->form_validation->set_rules('principal', 'Loan Principal', 'trim|required|is_numeric');
				$this->form_validation->set_rules('tenor', 'Tenor', 'trim|required|is_numeric');
				$this->form_validation->set_rules('repayment', 'Repayment', 'trim|required|is_numeric');
				$this->form_validation->set_rules('totalrepayment', 'Total Repayment', 'trim|required|is_numeric');

		        if ($this->form_validation->run() == FALSE) {
					$data = array(
						'errors' => validation_errors()
					);
					$this->session->set_flashdata('error', $data['errors']);
					redirect('admin/customers/createloan?phone='.$_POST['phone']);
				}else{
					$customer_has_running_loan = empty(getby(['phone'=>$_POST['phone'],'status'=>'closed'],'loans')) ? false : true;
					if ($customer_has_running_loan) {
						$this->session->set_flashdata('error', 'Customer already has a loan created or running');
						redirect('admin/customers/createloan?phone='.$_POST['phone']);
						die();
					}
					$loanData['phone'] = $_POST['phone'];
					$loanData['loanamount'] = $_POST['principal'];
					$loanData['rate'] = $_POST['rate'];
					$loanData['numberofrepayments'] = $_POST['tenor'];
					$loanData['collectionamount'] = $_POST['repayment'];
					$loanData['totalcollectionamount'] = $_POST['totalrepayment'];
					$loanData['datecreated'] = date('Y-m-d H:i:s');
					$loanData['createdby'] = $this->session->userdata('id');
					$loanData['status'] = 'created';
					$loanData['createdby'] = $this->session->userdata('id');
					$loanData['daterequested'] = date('Y-m-d H:i:s');
					$loanData['requestedby'] = $this->session->userdata('id');
					 
					 $loanData = $this->security->xss_clean($loanData);
					 if ($this->Common_model->save($loanData, null, 'loans')) {
					 	$this->session->set_flashdata('success', 'Loan Succesfully Created');
		    			redirect($_SERVER["HTTP_REFERER"]);
					 }else{
					 	$this->session->set_flashdata('error', 'Error in creating loan');
		    			redirect($_SERVER["HTTP_REFERER"]);
					 }

				}

			}else{
				$this->session->set_flashdata('error', 'Unauthorized Request');
			    redirect($_SERVER["HTTP_REFERER"]);
			}
	}

   public function approveloan($id = null){
   	$this->rbac->check_operation_access();

   	  
   	  $data['loan'] = $this->Common_model->get_one($id,'loans');
   	  $data['customer'] = getby(['phone'=>$data['loan']->phone],'customers');
   	  $this->load->view('admin/customers/approveloan',$data);
   	 
   }

   public function saveapproval(){
   	$this->rbac->check_operation_access();
   	 $loan = $this->Common_model->get_one($this->input->post('loanid'),'loans');
   	 if (!empty($_POST['decline'])) {
   	 	   $loanData = [
		 		
		 		"status" => 'declined',
		 		"approvedby" => $this->session->userdata('id'),
		 		"dateapproved" => date('Y-m-d H:i:s'),
		 		"approvalcomment" => $this->input->post('comment'),
		 	];

		 	$this->Common_model->save($loanData,$loan->id,'loans');
		 	$this->session->set_flashdata('success', 'Loan declined succesfully');
			redirect('admin/customers/loans');
   	
		 }elseif(!empty($_POST['approve'])){
   	 	   if ($this->input->post('phone')) {


			    $requestId = $this->input->post('rid');
				$apiHash = hash("sha512", API_KEY.$requestId.API_TOKEN);
				$authorization = "remitaConsumerKey=".API_KEY.", remitaConsumerToken=".$apiHash;


			    $headers = [
				  'Content-Type' => 'application/json',
				  'API_KEY' => API_KEY,
				  'MERCHANT_ID' => MERCHANT_ID,
				  'REQUEST_ID' => $requestId,
				  'AUTHORIZATION' => $authorization
				];
				
			
				$body = [
				  "authorisationCode"=>$this->input->post('acode'),
				  "phoneNumber"=>$this->input->post('phone'),
				  "authorisationChannel"=> "USSD"
				];
				
				if (100 > wallet_balance($this->session->userdata('id'))) {
					$this->session->set_flashdata('error', "Insufficient wallet balance");
					redirect('admin/customers/createloan?phone='.$_POST['phone']);
					die();
				}
				$url = isset($_POST['altsearch']) ? URI.'/loansvc/data/api/v2/payday/salary/history/provideCustomerDetails' : GET_SALARY_HISTORY_URL; 
				try {
					$response = $this->functions->sendPostRequest($url,$headers,$body);
					$salary_data_response_obj = json_decode($response);
				} catch (Exception $e) {
					log_message('error', $e->getMessage());
					$this->session->set_flashdata('error', 'Network error or service downtime searching salary history');
					redirect('admin/customers/createloan?phone='.$_POST['phone']);
					die();
				}
			
				$customer_exists_by_phone = !empty($customer_by_phone = getby(['phone'=>$this->input->post('phone')],'customers')) ? $customer_by_phone : null;
				$customerWaitingData = [
					'phone'=>$this->input->post('phone'),
					'createdby'=>$this->session->userdata('id'),
					'lastchecked'=>date('Y-m-d H:i:s'),
					'datecreated'=>date('Y-m-d H:i:s'),
					'onremita'=> 2
				];
				if (!empty($salary_data_response_obj)) {
					  if ($salary_data_response_obj->status == "success") {	

					  	//disburemnt call
					  	$requestId = $this->input->post('rid') + 20;
						$apiHash = hash("sha512", API_KEY.$requestId.API_TOKEN);
						$authorization = "remitaConsumerKey=".API_KEY.", remitaConsumerToken=".$apiHash;

					  	$headers = [
						  'Content-Type' => 'application/json',
						  'API_KEY' => API_KEY,
						  'MERCHANT_ID' => MERCHANT_ID,
						  'REQUEST_ID' => $requestId,
						  'AUTHORIZATION' => $authorization
						];

					  	$disbursementRequestBody = [
						  "customerId"=>$salary_data_response_obj->data->customerId,
						  "authorisationCode"=>$this->input->post('acode'),
						  "authorisationChannel"=> "USSD",
						  "phoneNumber"=>$this->input->post('phone'),
						  "accountNumber"=> "2030916850",
						  "currency"=> "NGN",
						  "loanAmount"=> $loan->loanamount,
						  "collectionAmount"=> $loan->collectionamount,
						  "dateOfDisbursement"=> date("d-m-Y H:i:sO"),
						  "dateOfCollection"=> date("d-m-Y H:i:sO"),
						  "totalCollectionAmount"=> $loan->totalcollectionamount,
						  "numberOfRepayments" => $loan->numberofrepayments,
						  "bankCode" => "011",

						];

						try {
							$response = $this->functions->sendPostRequest(DISBURSEMENT_NOTIFICATION_URL,$headers,$disbursementRequestBody);
							$disbrusement_response_obj = json_decode($response);
							if ($disbrusement_response_obj->responseCode == 400) {
								// code...
								$this->session->set_flashdata('error', $disbrusement_response_obj->responseMsg);
								redirect('admin/customers/createloan?phone='.$_POST['phone']);
								die();
							}
						} catch (Exception $e) {
							log_message('error', $e->getMessage());
							$this->session->set_flashdata('error', 'Network error or service downtime disbursing');
							redirect('admin/customers/createloan?phone='.$_POST['phone']);
							die();
						}


					 	$customerData = [
					 		"remitacustomerid" => $salary_data_response_obj->data->customerId,
					 		"fullname" => $salary_data_response_obj->data->customerName,
					 		"organization" => $salary_data_response_obj->data->companyName,
					 		"phone" => $this->input->post('phone'),
					 		"accountno" => $salary_data_response_obj->data->accountNumber,
					 		"bankcode" => $salary_data_response_obj->data->bankCode,
					 		"bvn" => $salary_data_response_obj->data->bvn,
					 		"firstpaymentdate" => $salary_data_response_obj->data->firstPaymentDate,
					 		"originalcustomerid" => $salary_data_response_obj->data->originalCustomerId,
					 		"onremita" => 1,
					 		"lastchecked" => date('Y-m-d H:i:s'),
					 		"checkedby" => $this->session->userdata('id'),
					 		$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
							$this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
					 	];
					  	if (!empty($customer_exists_by_phone)) {
					 		unset($customerData['datecreated']);
					 		unset($customerData['createdby']);
					 	}
					 	if (!empty($salary_data_response_obj->data->salaryPaymentDetails) || !empty($salary_data_response_obj->data->loanHistoryDetails)) {
				 			$salaryLoanData = [
						 	  "phone" => $this->input->post('phone'),
						 	  "customerid" => $customerData['remitacustomerid'],
						 	  "responseid" => $salary_data_response_obj->responseId,
						 	  "salary" => !empty($salary_data_response_obj->data->salaryPaymentDetails) ? json_encode($salary_data_response_obj->data->salaryPaymentDetails) : null,
						 	  "loan" => !empty($salary_data_response_obj->data->loanHistoryDetails) ? json_encode($salary_data_response_obj->data->loanHistoryDetails) : null,
						 	];
					 		
					 		$customer_salary_loan_data = !empty($customer_salary_loan = getby(['customerid'=>$salaryLoanData['customerid'],'phone'=>$salaryLoanData['phone']],'customer_salary_loan')) ? $customer_salary_loan : null;

					 		if (!empty($customer_salary_loan_data)) {
					 			$this->Common_model->saveWhere($salaryLoanData, ['phone'=>$this->input->post('phone')], 'customer_salary_loan');
						 	}else{
						 		$this->Common_model->saveWhere($salaryLoanData, null, 'customer_salary_loan');
						 	}
					 		
					 	}

					 	$apiCallLogData = [
					 		"customerid" => $salary_data_response_obj->data->customerId,
					 		"phone" => $customerData['phone'],
					 		"responseid" => $salary_data_response_obj->responseId,
					 		"requestheader" => json_encode($headers),
					 		"requestbody" => json_encode($body),
					 		"url" => GET_SALARY_HISTORY_URL,
					 		"response" => json_encode($salary_data_response_obj)

					 	];

					 	$salary_history_wallet_data = [
							'reference' => generate_unique_reference(10),
							'creditordebit' => 'dr',
							'amount' => 100,
							'channel' => 'remita-search',
							'balanceafter' => balance_after($this->session->userdata('id'),'dr',100),
							'narration' => 'Remita search charge for '. $customerData['phone'],
							'datecreated' => date('Y-m-d H:i:s'),
							'createdby' => $this->session->userdata('id'),
							'userid' => $this->session->userdata('id')


						];


					 	$disbursement_wallet_data = [
							'reference' => generate_unique_reference(10),
							'creditordebit' => 'dr',
							'amount' => 0,
							'channel' => 'remita-disburse',
							'balanceafter' => balance_after($this->session->userdata('id'),'dr',0),
							'narration' => 'Loan disbursment for '. $customerData['phone'].'_'.$loan->id,
							'datecreated' => date('Y-m-d H:i:s'),
							'createdby' => $this->session->userdata('id'),
							'userid' => $this->session->userdata('id')


						];

					    $this->Common_model->save($salary_history_wallet_data,null,'wallet_transactions');
					    $this->Common_model->save($disbursement_wallet_data,null,'wallet_transactions');
					 	$this->Common_model->save($apiCallLogData, null, 'customer_successful_search');
					 	if (!empty($customer_exists_by_phone)) {
				 			$this->Common_model->saveWhere($customerData, ['phone'=>$customer_exists_by_phone->phone], 'customers');
				 		}else{
				 		 	$this->Common_model->save($customerData, null, 'customers');
				 		}		
					 		


				 		if ($disbrusement_response_obj->status == "success") {
					 			$loanData = [
						 		"customerid" => $salary_data_response_obj->data->customerId,
						 		"authcode" => $disbursementRequestBody['authorisationCode'],
						 		"mandateref" => $disbrusement_response_obj->data->mandateReference,
						 		"transactionref" => generate_unique_reference(10),
						 		"dateofcollection" => $disbursementRequestBody['dateOfCollection'],
						 		"dateofdisbursement" => $disbursementRequestBody['dateOfDisbursement'],
						 		"requestid" => $headers['REQUEST_ID'],
						 		"requestbody" => json_encode($disbursementRequestBody),
						 		"response" => json_encode($disbrusement_response_obj),
						 		"customeraccountno" => $salary_data_response_obj->data->accountNumber,
						 		"customerbankcode" => $salary_data_response_obj->data->bankCode,
						 		"status" => 'disbursed',
						 		"approvedby" => $this->session->userdata('id'),
						 		"dateapproved" => date('Y-m-d H:i:s'),
						 		"approvalcomment" => $this->input->post('comment'),
						 		"disbursedby" => $this->session->userdata('id'),
						 		"datedisbursed" => date('Y-m-d H:i:s'),
						 		'datecreated' => date('Y-m-d H:i:s'),
								'createdby' => $this->session->userdata('id')
						 	];
						 	//die(prettyprint($loanData));
						 	if ($this->Common_model->save($loanData, $loan->id, 'loans')) {
						 		$this->session->set_flashdata('success', 'Loan disbursment was succesful');
								redirect('admin/customers/loans');
						 	}else{
						 		$this->session->set_flashdata('error', 'Loan disbursment was succesful but failed to log');
								redirect('admin/customers/loans');
						 	}

				 		}else{
				 			$this->session->set_flashdata('warning', $disbrusement_response_obj->responseMsg.' on remita');
							redirect('admin/customers/createloan?phone='.$_POST['phone']);
				 		}

					 		

					  }elseif($salary_data_response_obj->responseCode == "7801" || $salary_data_response_obj->responseCode == "7808"){

						 	$onremita = $salary_data_response_obj->responseCode == "7808" ? 2 : 0;
						 	if (empty($customer_exists_by_phone)) {
						 		$this->Common_model->save($customerWaitingData, null, 'customers');
					    	}
						$this->session->set_flashdata('error', $salary_data_response_obj->responseMsg.' on remita');
						redirect('admin/customers/createloan?phone='.$_POST['phone']);
				     }
			    }else{
					$this->Common_model->save($customerWaitingData, null, 'customers');
			    }			
			
		}else{
			$this->session->set_flashdata('error',"Wrong request");
			redirect('admin/customers/createloan?phone='.$_POST['phone']);
		}

   	 }
   }


   public function stoploan($id){
   	$this->rbac->check_operation_access();

   	  $data['loan'] = $this->Common_model->get_one($id,'loans');
   	  $data['customer'] = getby(['phone'=>$data['loan']->phone],'customers');
   	  $this->load->view('admin/customers/stoploan',$data);
   }

   public function savestoploan(){
   	 $this->rbac->check_operation_access();
   	 $loan = $this->Common_model->get_one($this->input->post('loanid'),'loans');

   		if (!empty($_POST['approve']) && !empty($loan->authcode) && !empty($loan->authcode)) {
   			    $customer = getby(['phone'=>$loan->phone],'customers');
   			 	$loanData = [
			 		"status" => 'closed',
			 		"terminator" => $this->session->userdata('id'),
			 		"dateterminated" => date('Y-m-d H:i:s'),
			 		"terminationcomment" => $this->input->post('comment'),
		 		];


			    $requestId = $this->input->post('rid');
				$apiHash = hash("sha512", API_KEY.$requestId.API_TOKEN);
				$authorization = "remitaConsumerKey=".API_KEY.", remitaConsumerToken=".$apiHash;


			    $headers = [
				  'Content-Type' => 'application/json',
				  'API_KEY' => API_KEY,
				  'MERCHANT_ID' => MERCHANT_ID,
				  'REQUEST_ID' => $requestId,
				  'AUTHORIZATION' => $authorization
				];
				
			
				$body = [
				  "authorisationCode"=>$loan->authcode,
				  "customerId"=>$customer->remitacustomerid,
				  "mandateReference"=> $loan->mandateref
				];
				
				$url = URI.'/remita/exapp/api/v1/send/api/loansvc/data/api/v2/payday/stop/loan'; 
				try {
					$response = $this->functions->sendPostRequest($url,$headers,$body);
					$stoploan_response_obj = json_decode($response);
				} catch (Exception $e) {
					log_message('error', $e->getMessage());
					$this->session->set_flashdata('error', 'Network error or service downtime terminating loan');
					redirect('admin/customers/loans');
					die();
				}
			if ($stoploan_response_obj->responseCode == "00") {
				$this->Common_model->save($loanData,$loan->id,'loans');
				$this->session->set_flashdata('success', 'Loan terminated successfuly');
				redirect('admin/customers/loans');
			}else{
				$this->session->set_flashdata('error', $stoploan_response_obj->responseMsg);
				redirect('admin/customers/loans');
			}
		 	
			
   		}else{
   			$this->Common_model->save($loanData,$loan->id,'loans');
		 	$this->session->set_flashdata('success', 'Loan termination failed or loan not found');
   		}

   }

   public function upload(){
   	   $this->rbac->check_operation_access();
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 5120; // 5MB

        $customerData = [];
        $foundData = [];
        $totalCustomersFound = 0;
        $totalCustomersChecked = 0;
        $error = "";

        if (empty($this->input->post('mode'))) {
        	$this->session->set_flashdata('error', 'Unknow Request');
		    redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('csv_file')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
			redirect($_SERVER["HTTP_REFERER"]);
        }else{

	    	 $csvData = file_get_contents($_FILES['csv_file']['tmp_name']);
		     $rows = explode("\n", $csvData);
	         $totalRecords = 0;
	         foreach ($rows as $row) {
	            $values = str_getcsv($row);
	            if (!empty($values)) {
	                $totalRecords++;
	                if (strtolower($values[0]) != "phone") {
	                	$phone_arr[] =  add_leading_zero(replace_leading_234($values[0]));
	                }
	            }
	         }
	         //filter array and remove unwanted values
	         $phoneNos = array_filter($phone_arr, function($value) {
			    return ($value !== '' && $value !== null && $value !== false && $value != '0');
			 });


	         $totalPhoneNos = sizeof($phoneNos);
	         $office = null;

	         if ($this->input->post('office') == "others") {
	         	$office = $this->input->post('other_office');
	         }elseif($this->input->post('office') == "no"){
	         	$office = $this->input->post('office');
	         }else{
	         	$office = $this->input->post('office');
	         }

	         if ($totalPhoneNos*100 > wallet_balance($this->session->userdata('id')) && $this->input->post('mode') == 2) {
				$this->session->set_flashdata('error', 'Wallet has insufficient balance to perform this search');
				redirect($_SERVER["HTTP_REFERER"]);
			 }
	         if (sizeof($phoneNos) > 500) {
	            $this->session->set_flashdata('error', 'Total records must not exceed 500.');
				redirect($_SERVER["HTTP_REFERER"]);
	          }else{
	          	 foreach ($phoneNos as $phone) {
	          	 	$totalCustomersChecked++;
	          	 	$customer = !empty($customer = getalldata('customers',['phone'=>$phone])) ? $customer : null;
	          	 	 if ($this->input->post('mode') == 1) {
				   	  	  
				   	  	  if ($phone != $customer[0]->phone) {
				       	  	  	$customerWaitingData = [
								'phone'=>$phone,
								'createdby'=>$this->session->userdata('id'),
								'lastchecked'=>date('Y-m-d H:i:s'),
								'datecreated'=>date('Y-m-d H:i:s'),
								'onremita'=> 0
							];
				 			$this->Common_model->save($customerWaitingData, null, 'customers');
				   	  	  }
				   	  }elseif($this->input->post('mode') == 2){
				   	  	   $requestId = time();
				   	  	   $response = null;
						   $apiHash = hash("sha512", API_KEY.$requestId.API_TOKEN);
						   $authorization = "remitaConsumerKey=".API_KEY.", remitaConsumerToken=".$apiHash;
				   	  	   $headers = [
							  "Content-Type" => 'application/json',
							  "API_KEY" => API_KEY,
							  "MERCHANT_ID" => MERCHANT_ID,
							  "REQUEST_ID" => $requestId,
							  "AUTHORIZATION" => $authorization,
							];

							$body = [
							  "authorisationCode"=> mt_rand(0, 110123389098),
							  "phoneNumber"=>$phone,
							  "authorisationChannel"=> "USSD"
							];

						
							try {
								$response = $this->functions->sendPostRequest(GET_SALARY_HISTORY_URL,$headers,$body);
								$response_obj = json_decode($response);

								if($response_obj->status == "success"){
								$totalCustomersFound++;
								$customerData = [
							 		"remitacustomerid" => $response_obj->data->customerId,
							 		"fullname" => $response_obj->data->customerName,
							 		"organization" => $response_obj->data->companyName,
							 		"phone" => $phone,
							 		"accountno" => $response_obj->data->accountNumber,
							 		"bankcode" => $response_obj->data->bankCode,
							 		"bvn" => $response_obj->data->bvn,
							 		"office" => $office,
							 		"firstpaymentdate" => $response_obj->data->firstPaymentDate,
							 		"originalcustomerid" => $response_obj->data->originalCustomerId,
							 		"onremita" => 1,
							 		"lastchecked" => date('Y-m-d H:i:s'),
							 		"checkedby" => $this->session->userdata('id'),
							 		$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
									$this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
							 	];

							 	if (!empty($response_obj->data->salaryPaymentDetails) || !empty($response_obj->data->loanHistoryDetails)){
							 			//collect salary and loan data
						 			$salaryLoanData = [
								 	  "phone" => $phone,
								 	  "customerid" => $response_obj->data->customerId,
								 	  "responseid" => $response_obj->responseId,
								 	  "salary" => !empty($response_obj->data->salaryPaymentDetails) ? json_encode($response_obj->data->salaryPaymentDetails) : null,
								 	  "loan" => !empty($response_obj->data->loanHistoryDetails) ? json_encode($response_obj->data->loanHistoryDetails) : null,
								 	];
							 		
							 		$customer_salary_loan_data = !empty($customer_salary_loan = getalldata('customer_salary_loan',['phone'=>$phone])) ? $customer_salary_loan : null;

							 		if (!empty($customer_salary_loan_data)) {
							 			$this->db->update('customer_salary_loan', $salaryLoanData, ['phone'=>$phone]);
								 	}else{
								 		$this->db->insert('customer_salary_loan', $salaryLoanData);
								 	}
							 		
							 	}

							 	$apiCallLogData = [
							 		"customerid" => $response_obj->data->customerId,
							 		"phone" => $phone,
							 		"responseid" => $response_obj->responseId,
							 		"requestheader" => json_encode($headers),
							 		"requestbody" => json_encode($body),
							 		"url" => GET_SALARY_HISTORY_URL,
							 		"response" => json_encode($response_obj)

							 	];

							 	$this->db->insert('customer_successful_search', $apiCallLogData);

								$wallet_data = [
									'reference' => generate_unique_reference(15),
									'creditordebit' => 'dr',
									'amount' => 100,
									'channel' => 'remita-search',
									'balanceafter' => balance_after($this->session->userdata('id'),'dr',100),
									'narration' => 'Remita search charge for '. $phone,
									'datecreated' => date('Y-m-d H:i:s'),
									'createdby' => $this->session->userdata('id'),
									'userid' => $this->session->userdata('id')

								];

								$this->db->insert('wallet_transactions', $wallet_data);

								 if (empty($customer)){
							    	$this->db->insert('customers', $customerData);
							 	}else{

							 		$this->db->update('customers',$customerData,['phone'=>$phone]);
							 	}


							}else{

								$onremita = $response_obj->responseCode == "7808" ? 2 : 1;
						 		$customerWaitingData = [
									'phone'=>$phone,
									'createdby'=>$this->session->userdata('id'),
									'lastchecked'=>date('Y-m-d H:i:s'),
									'onremita'=> $onremita
								];
								$this->db->update('customers', $customerWaitingData, ['phone'=>$phone]);

							}
						}catch (Exception $e) {
							log_message('error', $e->getMessage());
							$error = "Some errors were encountered";
						}
							

				   	  }
					 	          	  
	          	}

		     
		      } 
			    
		      $this->session->set_flashdata('primary', 'Upload Complete. <b>'.$totalCustomersChecked.'</b> Checked...<b>'.$totalCustomersFound.'</b> found on remita').' '.$error;
		      redirect('admin/customers/index');
       	 	
       	 
       	}
   	 		
    }

    public function stslrequests(){
    	$this->rbac->check_operation_access();
		$token = generate_fhub_token();
		$url = URI.'/loanservice/rest/api/partner/loan/applicants/list/'.$this->settings->fhub_code.'/1/5';
		$response = $this->functions->sendGetRequest($url,['Authorization'=>'Bearer '.$token]);
		$response = json_decode($response);
        if ($response === null && json_last_error() !== JSON_ERROR_NONE) {
           $data['loanrequests'] = null;
        } else {
            if ($response->responseCode == 200) {

            	$loanData = [
            		

            	];

            	//  "loanId" => 7,
	            // "loanReference": "LOAN-20230711-PC8GRVU976OZD5I",
	            // "requestedAmount": 80000,
	            // "loanType": "Payday Loan",
	            // "loanStatus": "Disbursed",
	            // "partnerName": "LENDERCODE",
	            // "partnerAvatar": "https://www.google.com",
	            // "dateCreated": "2023-07-11 15:26:00",
	            // "dateRequested": "2023-07-11 15:26:00",
	            // "dateApproved": "2023-07-11 15:27:20",
	            // "disbursementAmount": 80000,
	            // "firstName": "Abdullahi",
	            // "lastName": "Abdulmalik",
	            // "phoneNumber": "+2348160921372"


                $data['loanrequests'] = $response->data;
            }else{
                $data['loanrequests'] = null;
            }
        }
		$this->load->view('admin/includes/_header');
		$this->load->view('admin/general_settings/fhubtenures', $data);
		$this->load->view('admin/includes/_footer');
	}

	public function get_salary_history(){
		$this->rbac->check_operation_access();
		if ($this->input->post('customerphone') || $this->input->post('accountno')) {


			    $requestId = $this->input->post('rid');
				$apiHash = hash("sha512", API_KEY.$requestId.API_TOKEN);
				$authorization = "remitaConsumerKey=".API_KEY.", remitaConsumerToken=".$apiHash;


			    $headers = [
				  'Content-Type' => 'application/json',
				  'API_KEY' => API_KEY,
				  'MERCHANT_ID' => MERCHANT_ID,
				  'REQUEST_ID' => $requestId,
				  'AUTHORIZATION' => $authorization
				];
				
				if (!empty($_POST['altsearch'])) {
					$body = [
					  "authorisationCode"=>$this->input->post('acode'),
					  "firstName"=>"",
					  "lastName"=>"",
					  "middleName"=>"",
					  "accountNumber"=>$this->input->post('accountno'),
					  "bankCode"=>$this->input->post('bank'),
					  "bvn"=>"",
					  "authorisationChannel"=> "USSD"
					];
				}else{
					$body = [
					  "authorisationCode"=>$this->input->post('acode'),
					  "phoneNumber"=>$this->input->post('customerphone'),
					  "authorisationChannel"=> "USSD"
					];
				}
				
				if (100 > wallet_balance($this->session->userdata('id'))) {
					echo json_encode(['status'=>91,"msg"=>"Insufficient wallet balance"]);
					die();
				}
				$url = isset($_POST['altsearch']) ? URI.'/remita/exapp/api/v1/send/api/loansvc/data/api/v2/payday/salary/history/provideCustomerDetails' : GET_SALARY_HISTORY_URL; 
				try {
					$response = $this->functions->sendPostRequest($url,$headers,$body);
					$response_obj = json_decode($response);
				} catch (Exception $e) {
					log_message('error', $e->getMessage());
					echo json_encode(['status'=>91,"msg"=>"Network error or service downtime"]);
					die();
				}
			
				$customer_exists_by_phone = !empty($customer_by_phone = getby(['phone'=>$this->input->post('customerphone')],'customers')) ? $customer_by_phone : null;
				$customerWaitingData = [
					'phone'=>$this->input->post('customerphone'),
					'createdby'=>$this->session->userdata('id'),
					'lastchecked'=>date('Y-m-d H:i:s'),
					'datecreated'=>date('Y-m-d H:i:s'),
					'onremita'=> 2
				];
				if (!empty($response_obj)) {
					  if ($response_obj->status == "success") {				  	
					 	$customerData = [
					 		"remitacustomerid" => $response_obj->data->customerId,
					 		"fullname" => $response_obj->data->customerName,
					 		"organization" => $response_obj->data->companyName,
					 		"phone" => $this->input->post('customerphone'),
					 		"accountno" => $response_obj->data->accountNumber,
					 		"bankcode" => $response_obj->data->bankCode,
					 		"bvn" => $response_obj->data->bvn,
					 		"firstpaymentdate" => $response_obj->data->firstPaymentDate,
					 		"originalcustomerid" => $response_obj->data->originalCustomerId,
					 		"onremita" => 1,
					 		"lastchecked" => date('Y-m-d H:i:s'),
					 		"checkedby" => $this->session->userdata('id'),
					 		$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
							$this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
					 	];
					  	if (!empty($customer_exists_by_phone)) {
					 		unset($customerData['datecreated']);
					 		unset($customerData['createdby']);
					 	}
					 	if (!empty($response_obj->data->salaryPaymentDetails) || !empty($response_obj->data->loanHistoryDetails)) {
				 			$salaryLoanData = [
						 	  "phone" => $this->input->post('customerphone'),
						 	  "customerid" => $customerData['remitacustomerid'],
						 	  "responseid" => $response_obj->responseId,
						 	  "salary" => !empty($response_obj->data->salaryPaymentDetails) ? json_encode($response_obj->data->salaryPaymentDetails) : null,
						 	  "loan" => !empty($response_obj->data->loanHistoryDetails) ? json_encode($response_obj->data->loanHistoryDetails) : null,
						 	];
					 		
					 		$customer_salary_loan_data = !empty($customer_salary_loan = getby(['customerid'=>$salaryLoanData['customerid'],'phone'=>$salaryLoanData['phone']],'customer_salary_loan')) ? $customer_salary_loan : null;

					 		if (!empty($customer_salary_loan_data)) {
					 			$this->Common_model->saveWhere($salaryLoanData, ['customerid'=>$salaryLoanData['customerid']], 'customer_salary_loan');
						 	}else{
						 		$this->Common_model->saveWhere($salaryLoanData, null, 'customer_salary_loan');
						 	}
					 		
					 	}

					 	$apiCallLogData = [
					 		"customerid" => $response_obj->data->customerId,
					 		"phone" => $customerData['phone'],
					 		"responseid" => $response_obj->responseId,
					 		"requestheader" => json_encode($headers),
					 		"requestbody" => json_encode($body),
					 		"url" => GET_SALARY_HISTORY_URL,
					 		"response" => json_encode($response_obj)

					 	];

					 	$wallet_data = [
							'reference' => generate_unique_reference(10),
							'creditordebit' => 'dr',
							'amount' => 100,
							'channel' => 'remita-search',
							'balanceafter' => balance_after($this->session->userdata('id'),'dr',100),
							'narration' => 'Remita search charge for '. $customerData['phone'],
							'datecreated' => date('Y-m-d H:i:s'),
							'createdby' => $this->session->userdata('id'),
							'userid' => $this->session->userdata('id')


						];

						    $this->Common_model->save($wallet_data,null,'wallet_transactions');
						 	$this->Common_model->save($apiCallLogData, null, 'customer_successful_search');
						 	if (!empty($customer_exists_by_phone)) {
					 			$this->Common_model->saveWhere($customerData, ['phone'=>$customer_exists_by_phone->phone], 'customers');
					 		}else{
					 		 	$this->Common_model->save($customerData, null, 'customers');
					 		}		
					 		echo $response;
					  }elseif($response_obj->responseCode == "7801" || $response_obj->responseCode == "7808"){

						 	$onremita = $response_obj->responseCode == "7808" ? 2 : 0;
						 	if (empty($customer_exists_by_phone)) {
						 		$this->Common_model->save($customerWaitingData, null, 'customers');
					    }
						echo $response;  	  
				     }else{
				     	echo $response;
				     }
			    }else{
					$this->Common_model->save($customerWaitingData, null, 'customers');
			    }			
			
		}else{
			echo json_encode(['status'=>"fail","responseMsg"=>"wrong request"]);
		}

	}

	public function fetch_customers() {
		$this->rbac->check_operation_access();
	    $this->load->model('Your_model'); // Load your model

	    $postData = $this->input->post();
	    $result = $this->Your_model->get_data($postData);
	    echo json_encode($result);
	}


	public function get_mandate_payment_history(){
		$this->rbac->check_operation_access();
		if ($this->input->post('mandateref') && $this->input->post('customerid') && $this->input->post('authcode')) {
			$requestId = time();
		    $apiHash = hash("sha512", API_KEY.$requestId.API_TOKEN);
		    $authorization = "remitaConsumerKey=".API_KEY.", remitaConsumerToken=".$apiHash;
		  	   $headers = [
			  'Content-Type' => 'application/json',
			  'API_KEY' => API_KEY,
			  'MERCHANT_ID' => MERCHANT_ID,
			  'REQUEST_ID' => $requestId,
			  'AUTHORIZATION' => $authorization
			];

			$body = [
			  "authorisationCode"=> $this->input->post('authcode'),
			  "customerId"=> $this->input->post('customerid'),
			  "mandateRef"=> $this->input->post('mandateref')
			];
			$response = $this->functions->sendPostRequest(MANDATE_PAYMENT_HISTORY,$headers,$body);
	        $response_obj = json_decode($response);

	        $this->session->set_tempdata('customer',$response_obj,300);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error','Invalid Request');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}
	

	public function add_to_wait(){
		$this->rbac->check_operation_access();
		if ($this->input->post('phone')) {
			$customer_waiting_data = [
				'phone'=>$this->input->post('phone'),
				'createdby'=>$this->session->userdata('id'),
				'lastchecked'=>date('Y-m-d H:i:s')
			];

			$customer_waiting = !empty($customer = getby(['phone'=>$this->input->post('phone')],'customers_waiting')) ? $customer_waiting : null;
			if (empty($customer_waiting)) {
				$this->Common_model->save($customer_data, null, 'customers_waiting');
			}

		}else{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

  	public function get_customer_suggestion() {

        $key = $_REQUEST["name"];
        $suggestion = array();

        $customers = $this->Customer_model->get_customers_suggestion($key);

        foreach ($customers as $customer) {
            $suggestion[] = array("id" => $customer->id, "name" => $customer->name);
        }

        echo json_encode($suggestion);
    }


    function get_customers_suggestions() {
        $key = $_REQUEST["q"];
        $suggestion = array();

        $customers = $this->Customer_model->get_customers_suggestion($key);

        foreach ($customers as $customer) {
            $suggestion[] = array("id" => $customer->name, "name" => $customer->name);
        }

        $suggestion[] = array("id" => "+", "name" => "+ " . "create_new_item");

        echo json_encode($suggestion);
    }

	public function updatenew($id = 0){
		
     	$view_data['customer'] = $this->Common_model->get_one('clients',$id);
     	$id = $this->input->post('customerid');
		
		$customerdata = array(
			'phone' => $this->input->post('phone'),
			'clienttype' => $this->input->post('clienttype'),
			'address' => $this->input->post('address'),
			'email' => $this->input->post('email'),
			$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
			$this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
			
		);
		$data = $this->security->xss_clean($customerdata);
		$customerobj = $this->Customer_model->get_customer_by_id($id);
		if($this->Customer_model->updatecustomer($customerdata, $id)){
			echo json_encode($customerdata);
		}else{

			$this->session->set_flashdata('errors','error occured');
			$return = array('status' => 'error' , 'message' => 'failed to update');
			echo json_encode($return);

		}
	
		
	}
			                	
			                	
}

?>
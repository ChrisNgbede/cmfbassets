<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Asset extends MY_Controller {

		public function __construct(){
			parent::__construct();
			auth_check(); // check login auth
			$this->load->model('admin/common_model', 'Common_model');
			$this->load->model('admin/Activity_model', 'activity_model');
			$this->load->library('mailer');
			$this->load->library('upload');
			$this->load->helper('notification');
			$this->rbac->check_module_access();
			$this->rbac->check_operation_access();

		}

		public function index(){
			$where = [];
			if($this->input->get('category')) $where['category'] = $this->input->get('category');
			if($this->input->get('status')) $where['status'] = $this->input->get('status');
			if($this->input->get('isit') !== null && $this->input->get('isit') !== '') $where['isit'] = $this->input->get('isit');
			if($this->input->get('istagged') !== null && $this->input->get('istagged') !== '') $where['istagged'] = $this->input->get('istagged');

			$data['assets'] = getalldata('assets', $where, 'datecreated','desc');
			

			if (!empty($_GET['export']) && $_GET['export'] == 'csv') {
				foreach ($data['assets'] as $asset) {
					$category = getbyid($asset->category, 'asset_categories');
					$dept = getbyid($asset->department, 'departments');
					$owner = getbyid($asset->owner, 'staff');
					
					$csvData[] = [
						$asset->name,
						$asset->assetcode,
						$dept ? $dept->shortname . '-' . $asset->assetcode . '-' . getbyid($owner->designation, 'designations')->shortname . '-' . date('ym', strtotime($asset->dateacquired)) : $asset->assetcode,
						$category ? $category->name : 'N/A',
						$dept ? $dept->name : 'N/A',
						$owner ? $owner->firstname . ' ' . $owner->lastname : 'N/A',
						ucfirst($asset->status),
						$asset->assetcondition,
						$asset->location,
						$asset->serialno,
						$asset->assetvalue,
						formatMoney(assetCurrentValue($asset->assetvalue, $asset->depreciationstartdate, $asset->depreciationrate, $asset->usefullife)),
						$asset->dateacquired,
						$asset->depreciationmethod,
						$asset->depreciationstartdate,
						$asset->depreciationrate . '%',
						$asset->usefullife . ' Years',
						$asset->supplier,
						$asset->waranty,
						$asset->insurance,
						$asset->description,
						$asset->isit == 1 ? 'YES' : 'NO',
						$asset->ittype,
						$asset->istagged == 1 ? 'YES' : 'NO',
						$asset->taggingofficer ? nameofuser($asset->taggingofficer) : 'N/A',
						$asset->taggingdate,
						$asset->datecreated,
						nameofuser($asset->createdby)
					];
				}
				ob_clean();
				$filename = 'Company_Assets_Export_' . date('Ymd_His') . '.csv';
				header("Content-Description: File Transfer");
				header("Content-Disposition: attachment; filename=$filename");
				header("Content-Type: application/csv; charset=UTF-8");
				
				$file = fopen('php://output', 'w');
				// UTF-8 BOM for Excel compatibility
				fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

				$header = array(
					"Asset Name", "Asset Code", "System Generated Code", "Category", "Department", 
					"Current Owner", "Status", "Condition", "Location", "Serial Number", 
					"Initial Value", "Current Value", "Date Acquired", "Depreciation Method", 
					"Depreciation Start", "Depreciation Rate", "Useful Life", "Supplier", 
					"Warranty", "Insurance", "Description", "Is IT Asset", "IT Asset Type", 
					"Is Tagged", "Tagging Officer", "Tagging Date", "Date Registered", "Registered By"
				);
				fputcsv($file, $header);
				foreach ($csvData as $line) {
					fputcsv($file, $line);
				}
				fclose($file);
				exit;
			}
			$data['staffs'] = getalldata('staff');
			$data['categories'] = getalldata('asset_categories');
			$data['departments'] = getalldata('departments');
			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/asset/list', $data);
        	$this->load->view('admin/includes/_footer');
		}

		public function findcollateral(){
			if ($_POST['nuban']) {
				$collateralData = getalldata('collaterals',['nuban'=>$_POST['nuban']],'id','desc');
				if (empty($collateralData)) {
					$response = [
						'status' => 91,
						'msg' => '<div class="mt-2 alert alert-warning">No collateral found but you can create a one below</div>',
					];
				}else{
					$response = [
						'status' => 0,
						'msg' => 'Create New or Manage',
						'collateralData' => $collateralData,
						// 'collateralList' => $this->load->view('admin/asset/collateralcardlist')
					];
				}
				
				echo json_encode($response);
			}else{
				$response = ['status'=>401,'msg'=>'Request not understood'];
				echo json_encode($response);
			}
		}

		public function listcollateral(){
			$where = [];
			if($this->input->get('status')) $where['status'] = $this->input->get('status');
			if($this->input->get('officer')) $where['officerincharge'] = $this->input->get('officer');
			
			// Date range filtering
			if($this->input->get('from') && $this->input->get('to')) {
				$where['dateregistered >='] = $this->input->get('from') . ' 00:00:00';
				$where['dateregistered <='] = $this->input->get('to') . ' 23:59:59';
			}

			$data['collaterals'] = getalldata('collaterals', $where, 'datecreated', 'desc');

			// Export CSV logic
			if (!empty($_GET['export']) && $_GET['export'] == 'csv') {
				foreach ($data['collaterals'] as $collateral) {
					$officer = getbyid($collateral->officerincharge, 'staff');
					$registered_by = getbyid($collateral->registeredby, 'staff');
					
					$csvData[] = [
						$collateral->name,
						$collateral->customername,
						$collateral->nuban,
						$collateral->phone,
						$collateral->facilityamount,
						$collateral->valuation,
						ucfirst($collateral->status),
						$collateral->dateregistered,
						$officer ? $officer->firstname . ' ' . $officer->lastname : 'N/A',
						$registered_by ? $registered_by->firstname . ' ' . $registered_by->lastname : 'System',
						$collateral->registrationcomment
					];
				}
				ob_clean();
				$filename = 'Collaterals_Export_' . date('Ymd_His') . '.csv';
				header("Content-Description: File Transfer");
				header("Content-Disposition: attachment; filename=$filename");
				header("Content-Type: application/csv; charset=UTF-8");
				
				$file = fopen('php://output', 'w');
				fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

				$header = array(
					"Collateral Name", "Customer Name", "Account Number", "Phone", 
					"Facility Amount", "Valuation", "Status", "Date Registered", 
					"Officer In Charge", "Registered By", "Registration Comment"
				);
				fputcsv($file, $header);
				if (!empty($csvData)) {
					foreach ($csvData as $line) {
						fputcsv($file, $line);
					}
				}
				fclose($file);
				exit;
			}

			$data['staffs'] = getalldata('staff');
			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/asset/listcollateral', $data);
        	$this->load->view('admin/includes/_footer');
		}

		public function collateraldetails($id = 0){
			$data['collateral'] = getbyid($id,'collaterals');
			if(empty($data['collateral']) || (is_object($data['collateral']) && property_exists($data['collateral'], 'id') && empty($data['collateral']->id))) {
				$this->session->set_flashdata('error', 'Collateral not found');
				redirect(base_url('admin/asset/listcollateral'));
			}
			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/asset/collateraldetails', $data);
        	$this->load->view('admin/includes/_footer');
		}
		public function asset_details($id = 0){
			$data['asset'] = getbyid($id,'assets');
			$data['staffs'] = getalldata('staff');
			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/asset/asset_details', $data);
        	$this->load->view('admin/includes/_footer');
		}
	    public function create($id = 0){

		   	$data['asset'] = $this->Common_model->get_one($id,'assets');
		    $id = $this->input->post('id');
			if($this->input->post('save_asset')){
					$this->form_validation->set_rules('name', 'Asset Name', 'trim|required');
					$this->form_validation->set_rules('usefullife', 'Useful Life', 'trim|is_numeric');
					$this->form_validation->set_rules('owner', 'Owner', 'trim|required');
					$this->form_validation->set_rules('department', 'Asset Departmemt', 'trim|required');
					$this->form_validation->set_rules('dateacquired', 'Date Acquired', 'trim|required');
					if (empty($id)) {
						$this->form_validation->set_rules('code', 'Asset Code', 'trim|required|is_unique[assets.assetcode]');
					}else{
						$this->form_validation->set_rules('code', 'Asset Code', 'trim|required');
					}
						if ($this->form_validation->run() == FALSE) {
							$data['errors'] = validation_errors();
							$this->session->set_flashdata('error', $data['errors']);
							
							// Re-load required data for the view
							$data['categories'] = getalldata('asset_categories');
							$data['departments'] = getalldata('departments');
							$data['staffs'] = getalldata('staff');
							$data['asset'] = (object)$this->input->post(); // Pass posted data back
							if(!isset($data['asset']->id)) $data['asset']->id = $id;
							if(!isset($data['asset']->attachment)) {
								$orig = $this->Common_model->get_one($id, 'assets');
								$data['asset']->attachment = $orig->attachment ?? '';
							}

							$this->load->view('admin/includes/_header', $data);
							$this->load->view('admin/asset/create', $data);
							$this->load->view('admin/includes/_footer');
							return; // Stop further execution
						}else{
						
						$id = $this->input->post('id');
						$old_asset = $this->Common_model->get_one($id, 'assets');
						$attachment = $old_asset->attachment;

						if (!empty($_FILES['attachment']['name'])) {
							$config = array(
								'upload_path' => realpath(FCPATH.'uploads'),
								'allowed_types' => "gif|jpg|png|jpeg",
								'encrypt_name' => TRUE,
								'max_size' => "4096", // 4MB
							);
							$this->load->library('upload');
							$this->upload->initialize($config);

							if (!$this->upload->do_upload('attachment')) {
								$data['errors'] = $this->upload->display_errors();
								$this->session->set_flashdata('error', $data['errors']);
								
								// Re-load required data for the view
								$data['categories'] = getalldata('asset_categories');
								$data['departments'] = getalldata('departments');
								$data['staffs'] = getalldata('staff');
								$data['asset'] = (object)$this->input->post();
								// Normalize field names from POST to object properties
								if(isset($data['asset']->code)) $data['asset']->assetcode = $data['asset']->code;
								if(!isset($data['asset']->id)) $data['asset']->id = $id;

								$this->load->view('admin/includes/_header', $data);
								$this->load->view('admin/asset/create', $data);
								$this->load->view('admin/includes/_footer');
								return;
							} else {
								$upload_data = $this->upload->data();
								$attachment = $upload_data['file_name'];
								
								// Delete old image if exists
								if ($id && !empty($old_asset->attachment) && file_exists('./uploads/'.$old_asset->attachment)) {
									unlink('./uploads/'.$old_asset->attachment);
								}
							}
						}

						$data = array(
							'category' => $this->input->post('category'),
							'department' => $this->input->post('department'),
							'isit' => $this->input->post('isit'),
							'ittype' => $this->input->post('ittype'),
							'name' => $this->input->post('name'),
							'usefullife' => $this->input->post('usefullife'),
							'owner' => $this->input->post('owner'),
							'assetcode' => $this->input->post('code'),
							'serialno' => $this->input->post('serialno'),
							'assetvalue' =>  $this->input->post('assetvalue'),
							'attachment' => $attachment,
							'dateacquired' =>  $this->input->post('dateacquired'),
							'depreciationmethod' =>  $this->input->post('depreciationmethod'),
							'depreciationstartdate' =>  $this->input->post('depreciationstartdate'),
							'depreciationrate' =>  $this->input->post('depreciationrate'),
							'location' =>  $this->input->post('location'),
							'assetcondition' =>  $this->input->post('condition'),
							'supplier' =>  $this->input->post('supplier'),
							'status' =>  $this->input->post('id') ? 'pending_approval' : $this->input->post('status'),
							'waranty' =>  $this->input->post('waranty'),
							'insurance' =>  $this->input->post('insurance'),
							'description' =>  $this->input->post('description'),
							$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
							$this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
						);

						if($this->input->post('id')){
							$data['approvedby'] = NULL;
							$data['dateapproved'] = NULL;
							$data['approvalcomment'] = NULL;
						}

						$data = $this->security->xss_clean($data);
						if($last_id = $this->Common_model->save($data,$id,'assets')){
							if($this->input->post('id')){
								$this->activity_model->add_log(10);
							}
							if(empty($id)){
								notify_asset_event($last_id, 'new');
							} else {
								notify_asset_event($id, 'update');
							}
							$this->session->set_flashdata('success', 'Asset has been saved successfully!');
							redirect(base_url('admin/asset'));
						}else{
							$this->session->set_flashdata('error', 'Failed to save');
							redirect(base_url('admin/asset'));
						}
					}
				}else{
					$data['categories'] = getalldata('asset_categories');
					$data['departments'] = getalldata('departments');
					$data['staffs'] = getalldata('staff');
					$this->load->view('admin/includes/_header',$data);
	        		$this->load->view('admin/asset/create',$data);
	        		$this->load->view('admin/includes/_footer');
				}
		}

	
		 public function createcollateral($id = 0){

		   	$data['collateral'] = $this->Common_model->get_one($id,'collaterals');
		    $id = $this->input->post('id');
			if($this->input->post('save_collateral')){
					$this->form_validation->set_rules('name', 'Collateral Name', 'trim|required');
					$this->form_validation->set_rules('nuban', 'Account No', 'trim|required');
					if ($this->form_validation->run() == FALSE) {
						$data['errors'] = validation_errors();
						$this->session->set_flashdata('error', $data['errors']);
						$id = empty($id) ? '' : $id;
						
						// Re-load data
						$data['staffs'] = getalldata('staff');
						$data['collateral'] = (object)$this->input->post();
						if(!isset($data['collateral']->id)) $data['collateral']->id = $id;

						$this->load->view('admin/includes/_header', $data);
						$this->load->view('admin/asset/createcollateral', $data);
						$this->load->view('admin/includes/_footer');
						return;
					}else{
						
						$data = array(
							'name' => $this->input->post('name'),
							'nuban' => $this->input->post('nuban'),
							'officerincharge' => $this->input->post('officerincharge'),
							'description' => $this->input->post('description'),
							'customername' => $this->input->post('customername'),
							'facilityamount' => $this->input->post('facilityamount'),
							'valuation' =>  $this->input->post('valuation'),
							'dateregistered' =>  $this->input->post('dateregistered'),
							'status' => $this->input->post('id') ? 'pending_approval' : ($this->input->post('status') ? $this->input->post('status') : 'pending_approval'),
							$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
							$this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
						);
						
						if($this->input->post('id')){
							$data['approvalby'] = NULL;
							$data['approvaldate'] = NULL;
							$data['approvalcomment'] = NULL;
						}

						 if ($_FILES['image']['size'] > 0) {

				                $this->load->library('upload');
				                $config['upload_path'] = realpath(FCPATH.'uploads');
				                $config['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
				                $config['max_size'] = '';
				                $config['overwrite'] = FALSE;
				                $config['encrypt_name'] = TRUE;
				                $this->upload->initialize($config);

				                if (!$this->upload->do_upload('image')) {
				                    $data['errors'] = $this->upload->display_errors();
				                    $this->session->set_flashdata('error', $data['errors']);
									
									// Re-load data
									$data['staffs'] = getalldata('staff');
									$data['collateral'] = (object)$this->input->post();
									if(!isset($data['collateral']->id)) $data['collateral']->id = $id;

									$this->load->view('admin/includes/_header', $data);
									$this->load->view('admin/asset/createcollateral', $data);
									$this->load->view('admin/includes/_footer');
									return;
				                }

				                $photo = $this->upload->file_name;
				                $data['image_path'] = $photo;

				            }
						if($last_id = $this->Common_model->save($data,$id,'collaterals')){
							if($this->input->post('id')){
								$this->activity_model->add_log(10);
							}
							if(empty($id)){
								notify_collateral_event($last_id, 'new');
							} else {
								notify_collateral_event($id, 'update');
							}
							$this->session->set_flashdata('success', 'Collateral has been saved successfully!');
							redirect(base_url('admin/asset/listcollateral'));
						}else{
							$this->session->set_flashdata('error', 'Failed to save');
							redirect(base_url('admin/asset/listcollateral'));
						}
					}
				}else{
					$data['categories'] = getalldata('asset_categories');
					$data['departments'] = getalldata('departments');
					$data['staffs'] = getalldata('staff');
					$this->load->view('admin/includes/_header',$data);
	        		$this->load->view('admin/asset/createcollateral',$data);
	        		$this->load->view('admin/includes/_footer');
				}
		}

		public function collateralcomment(){

			$this->form_validation->set_rules('comment', 'Comment', 'trim|required');
			$this->form_validation->set_rules('collateralid', 'Collateral', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('error', $data['errors']);
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				
				$data = array(
					'comment' => $this->input->post('comment'),
					'collateralid' => $this->input->post('collateralid'),
					 'created_at' => date('Y-m-d H:i:s'),
					 'commentby' => $this->session->userdata('id')
				);

				$data = $this->security->xss_clean($data);
				if($this->Common_model->save($data,null,'collateralnotes')){
					$this->session->set_flashdata('success', 'Comment saved successfully!');
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error', 'Failed to save');
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
				
		}

		public function editcollateral($id = 0){
		$this->rbac->check_operation_access(); // check opration permission

		 if ($this->input->get('id')) {
            $id = $this->input->get('id');
         }

         $view_data['staffs'] = getalldata('staff');
         $view_data['collateral'] = $this->Common_model->get_one($id,'collaterals');
         $id = $this->input->post('id');
		if($this->input->post('submit')){
		
			$this->form_validation->set_rules('name', 'Collateral Name', 'trim|required');
			$this->form_validation->set_rules('nuban', 'Account No', 'trim|required');

if ($this->form_validation->run() == FALSE) {
$view_data["errors"] = validation_errors();
$this->session->set_flashdata("error", $view_data["errors"]);
$view_data["collateral"] = (object)$this->input->post();
if(!isset($view_data["collateral"]->id)) $view_data["collateral"]->id = $id;

$this->load->view("admin/asset/editcollateral", $view_data);
return;
}			else{
				$data = array(
					'name' => $this->input->post('name'),
					'nuban' => $this->input->post('nuban'),
					'description' => $this->input->post('description'),
					'officerincharge' => $this->input->post('officerincharge'),
					'customername' => $this->input->post('customername'),
					'facilityamount' => $this->input->post('facilityamount'),
					'valuation' =>  $this->input->post('valuation'),
					'dateregistered' =>  $this->input->post('dateregistered'),
					$this->input->post('id') ? 'datemodified' : 'datecreated' => date('Y-m-d H:i:s'),
					$this->input->post('id') ? 'modifiedby' : 'createdby' => $this->session->userdata('id')
				);

				 if ($_FILES['image']['size'] > 0) {

	                $this->load->library('upload');
	                $config['upload_path'] = realpath(FCPATH.'uploads');
	                $config['allowed_types'] = 'jpg|png|jpeg|pdf|docx|doc';
	                $config['max_size'] = '';
	                $config['overwrite'] = FALSE;
	                $config['encrypt_name'] = TRUE;
	                $this->upload->initialize($config);

	                if (!$this->upload->do_upload('image')) {
	                    $view_data['errors'] = $this->upload->display_errors();
	                    $this->session->set_flashdata('error', $view_data['errors']);
						$view_data['collateral'] = (object)$this->input->post();
						if(!isset($view_data['collateral']->id)) $view_data['collateral']->id = $id;
						
						$this->load->view('admin/asset/editcollateral', $view_data);
						return;
	                }

	                $photo = $this->upload->file_name;
	                $data['image_path'] = $photo;

	            }
				$data = $this->security->xss_clean($data);
				
				if($newid = $this->Common_model->save($data,$id,'collaterals')){
					notify_collateral_event($id, 'update');
					$this->session->set_flashdata('success', 'Saved Successfully!');
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('errors', $data['errors']);
					redirect($_SERVER['HTTP_REFERER']);				}
			}
		}
		else{
			
			$this->load->view('admin/asset/editcollateral',$view_data);			
		}
		
	}


	public function collateralapproval($id = 0){
		$this->rbac->check_operation_access(); // check opration permission
		$action = null;
		$status = 'registered';
		$emailRecipient = 'asset@consumermfb.com.ng';
		 if ($this->input->get('id')) {
            $id = $this->input->get('id');
         }
         if ($this->input->get('action')) {
            $action = $this->input->get('action');
         }
         $view_data['collateral'] = $this->Common_model->get_one($id,'collaterals');
         $id = $this->input->post('id');
         
		if($this->input->post('approve')){
			$this->form_validation->set_rules('comment', 'Approval comment', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data = array(
					'errors' => validation_errors()
				);
				$this->session->set_flashdata('errors', $data['errors']);
				redirect($_SERVER['HTTP_REFERER']);
			}
			else{
				$action = $this->input->post('action');
				if ($action == 'approval') {
					$status = 'approved';
					$emailSlug = "collateral-approval";
					$emailRecipient = "nchris@consumermfb.com.ng";
					$data = array(
					'status' => $status,
					'approvalcomment' => $this->input->post('comment'),
					'approvaldate' => date('Y-m-d H:i:s'),
					'approvalby' => $this->session->userdata('id'),
					);
				}elseif($action == "retrieval-request"){
					$status = 'retrieval request';
					$emailSlug = "collateral-retrieval";
					$emailRecipient = "it@consumermfb.com.ng";
					$data = array(
					'status' => $status,
					'retrievalrequestcomment' => $this->input->post('comment'),
					'retrievalrequestdate' => date('Y-m-d H:i:s') ,
					'retrievalrequestby' => $this->session->userdata('id'),					
					);
				}elseif($action == "retrieval"){
					$status = 'retrieved';
					$emailSlug = "collateral-retrieval-approval";
					$emailRecipient = "it@consumermfb.com";
					$data = array(
					'status' => $status,
					'retrievalrequestapprovaldate' => date('Y-m-d H:i:s'),
					'retrievalapprovalcomment' => $this->input->post('comment'),
					'retrievalrequestapprovalby' => $this->session->userdata('id'),
					);
				}


				
				$data = $this->security->xss_clean($data);
				
				if($newid = $this->Common_model->save($data,$this->input->post('collateralid'),'collaterals')){
					$this->load->helper('notification');
					notify_collateral_event($this->input->post('collateralid'), 'status');
					
					$this->session->set_flashdata('success', 'Action was successful!');
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('errors', $data['errors']);
					redirect($_SERVER['HTTP_REFERER']);				}
			}
		}
		else{
			$view_data['action'] = $action;
			$this->load->view('admin/asset/collateralapproval',$view_data);			
		}
		
	}


		public function access($id = null){

				$data['roles'] = getalldata('roles');
				$data['asset'] = $this->Common_model->get_one($id,'asset');
				$data['user'] = getby(['assetid'=>$id],'users');
				$msg = 'Unknown error';
				if ($this->input->post('submit')){
					    $data['user'] = getby(['assetid'=>$this->input->post('assetid')],'users');
					    $data['asset'] = $this->Common_model->get_one($this->input->post('assetid'),'asset');
					   // die(var_dump($data['asset']));
					    $user_data = [
							'admin_role_id' => $this->input->post('role'),
							'username' => $this->input->post('username'),
							'firstname' => $data['asset']->firstname,
							'lastname' => $data['asset']->lastname,
							'email' =>  $data['asset']->email,
							'phone' => $data['asset']->phone,
							'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
							'is_active' => 1,
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
							'assetid' => $this->input->post('assetid')
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
						$this->load->view('admin/asset/access',$data);		
					}
		

		}


	    public function approve(){
            $this->rbac->check_operation_access();
            if($this->input->post('id')){
                $data = [
                    'status' => 'active',
                    'approvedby' => $this->session->userdata('id'),
                    'dateapproved' => date('Y-m-d H:i:s'),
                    'approvalcomment' => $this->input->post('approvalComment')
                ];
                $data = $this->security->xss_clean($data);
                if($this->Common_model->save($data, $this->input->post('id'), 'assets')){
                    notify_asset_event($this->input->post('id'), 'approve');
                    $this->session->set_flashdata('success', 'Asset approved successfully!');
                }else{
                    $this->session->set_flashdata('error', 'Failed to approve asset');
                }
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        public function tag_asset(){
            $this->rbac->check_operation_access();
            $id = $this->input->post('id');
            if($id){
                $data = [
                    'istagged' => $this->input->post('istagged'),
                    'taggingofficer' => $this->input->post('tagging_officer'),
                    'taggingdate' => $this->input->post('tagging_date')
                ];
                $data = $this->security->xss_clean($data);
                if($this->Common_model->save($data, $id, 'assets')){
                    $this->load->helper('notification');
                    notify_asset_event($id, 'tagging');
                    $this->session->set_flashdata('success', 'Asset tagging information updated successfully!');
                }else{
                    $this->session->set_flashdata('error', 'Failed to update tagging information');
                }
                redirect($_SERVER['HTTP_REFERER']);
            }
        }

        public function update_status(){
            $this->rbac->check_operation_access();
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            $notes = $this->input->post('notes');
            
            if($id && $status){
                $data = [
                    'status' => $status,
                    'approvalcomment' => "Status changed to ".ucfirst($status).": ".$notes,
                    'datemodified' => date('Y-m-d H:i:s'),
                    'modifiedby' => $this->session->userdata('id')
                ];
                $data = $this->security->xss_clean($data);
                if($this->Common_model->save($data, $id, 'assets')){
                    $this->load->helper('notification');
                    notify_asset_event($id, 'status');
                    $this->session->set_flashdata('success', 'Asset status updated successfully!');
                }else{
                    $this->session->set_flashdata('error', 'Failed to update asset status');
                }
            }
            redirect($_SERVER['HTTP_REFERER']);
        }

        public function export_template(){
            $this->rbac->check_operation_access();
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=Asset_Bulk_Upload_Template.csv");
            header("Content-Type: application/csv; ");
            $file = fopen('php://output', 'w');
            $header = array("Name", "Asset Code", "Category ID", "Department ID", "Owner ID", "Initial Value", "Date Acquired (YYYY-MM-DD)", "Useful Life (Years)", "Location", "Status (active/inactive/obsolete)", "Condition", "Supplier", "Serial No", "Description");
            fputcsv($file, $header);
            // Add a sample row
            fputcsv($file, ["Sample Laptop", "ASSET-001", "1", "1", "1", "250000", date('Y-m-d'), "5", "Head Office", "active", "New", "Dell Nigeria", "SN123456789", "High performance laptop"]);
            fclose($file);
            exit;
        }

        public function bulk_upload(){
            $this->rbac->check_operation_access();
            if(!empty($_FILES['bulk_file']['name'])){
                $path = $_FILES['bulk_file']['tmp_name'];
                $handle = fopen($path, "r");
                $header = fgetcsv($handle); // Skip header
                
                $count = 0;
                $errors = 0;

                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if(empty($row[0])) continue; // Skip empty rows

                    $data = [
                        'name' => $row[0],
                        'assetcode' => $row[1] ?: 'AUTO-'.rand(1000,9999),
                        'category' => $row[2],
                        'department' => $row[3],
                        'owner' => $row[4],
                        'assetvalue' => $row[5],
                        'dateacquired' => $row[6],
                        'depreciationstartdate' => $row[6], // Default same as acquired
                        'usefullife' => $row[7],
                        'location' => $row[8],
                        'status' => strtolower($row[9]) ?: 'active',
                        'assetcondition' => $row[10],
                        'supplier' => $row[11],
                        'serialno' => $row[12],
                        'description' => $row[13],
                        'datecreated' => date('Y-m-d H:i:s'),
                        'createdby' => $this->session->userdata('id')
                    ];

                    $data = $this->security->xss_clean($data);
                    if($this->Common_model->save($data, null, 'assets')){
                        $count++;
                    } else {
                        $errors++;
                    }
                }
                fclose($handle);
                
                if($count > 0){
                    $this->session->set_flashdata('success', $count . ' assets uploaded successfully!' . ($errors > 0 ? " ($errors failed)" : ""));
                } else {
                    $this->session->set_flashdata('error', 'Bulk upload failed or no valid records found.');
                }
            } else {
                $this->session->set_flashdata('error', 'Please select a valid CSV file.');
            }
            redirect(base_url('admin/asset'));
        }

        public function delete($id = 0)
        {
            $this->rbac->check_operation_access();
            notify_asset_event($id, 'delete');
            if ($this->Common_model->delete($id, 'assets')) {
                $this->session->set_flashdata('success', 'Asset deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete asset');
            }
            redirect(base_url('admin/asset'));
        }

        public function delete_collateral($id = 0)
        {
            $this->rbac->check_operation_access();
            notify_collateral_event($id, 'delete');
            if ($this->Common_model->delete($id, 'collaterals')) {
                $this->session->set_flashdata('success', 'Collateral deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete collateral');
            }
            redirect(base_url('admin/asset/listcollateral'));
        }

	}

?>

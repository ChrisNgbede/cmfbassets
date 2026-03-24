<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Transactions extends MY_Controller {

		public function __construct(){
			parent::__construct();
			auth_check(); // check login auth
			$this->rbac->check_module_access();
			$this->rbac->check_operation_access();

		}

		public function index(){
			//var_dump(date('Y-m-d H:i:s', '1657265244')); die();

			$data['transactions'] = getalldata('wallet_transactions',null,'id','desc');

			$this->load->view('admin/includes/_header');
        	$this->load->view('admin/transactions/index', $data);
        	$this->load->view('admin/includes/_footer');
		}

		public function fund_wallet(){
			if ($this->input->post('submit')) {
				$transation_type = '';
				$msg = 'unknown error';
				if ($this->input->post('type') == 'cr') {
					$transation_type = 'Credit';
				}elseif($this->input->post('type') == 'dr'){
					$transation_type = 'Debit';
				}
				$wallet_data = [
					'reference' => generate_unique_reference(10),
					'creditordebit' => $this->input->post('type'),
					'amount' => $this->input->post('amount'),
					'channel' => 'wallet',
					'balanceafter' => balance_after($this->session->userdata('id'),$this->input->post('type'),$this->input->post('amount')),
					'narration' => empty($this->input->post('narration')) ? $transation_type.' with no narration' : $this->input->post('narration'),
					'datecreated' => date('Y-m-d H:i:s'),
					'createdby' => $this->session->userdata('id'),
					'userid' => $this->input->post('userid')

				];

				if ($this->input->post('type') == "dr" && $this->input->post('amount') > wallet_balance()) {
					echo json_encode(['status'=>91,"msg"=>"Can't debit set amount from amount since it's greater than wallet value"]);
					die();
				}


				$data = $this->security->xss_clean($wallet_data);
				if ($this->Common_model->save($wallet_data,null,'wallet_transactions')) {
					$msg = 'Wallet '.$transation_type.'d successsfuly';
					echo json_encode(['status'=>0,'msg'=>$msg,'balance'=>formatMoney(wallet_balance())]);
				}else{
					$this->session->set_flashdata('error', 'Action Failed');
					echo json_encode(['status'=>91,'msg'=>$msg]);
				}
			}else{
				$data['users'] = getalldata('users');
				$this->load->view('admin/transactions/fund_wallet',$data);		
			}
		}

	}

?>	
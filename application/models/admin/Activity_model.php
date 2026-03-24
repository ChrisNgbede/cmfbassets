<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model{

	public function get_activity_log($filters = []){
		$this->db->select('
			activity_log.id,
			activity_log.activity_id,
			activity_log.user_id,
			activity_log.admin_id,
			activity_log.description,
			activity_log.resource_id,
			activity_log.resource_type,
			activity_log.ip_address,
			activity_log.user_agent,
			activity_log.created_at,
			activity_status.description as status_desc,
			users.username
		');
		$this->db->from('activity_log');
		$this->db->join('activity_status','activity_status.id=activity_log.activity_id');
		$this->db->join('users','users.admin_id=activity_log.admin_id','left');
		
		if (!empty($filters['status'])) {
			$this->db->where('activity_log.activity_id', $filters['status']);
		}
		if (!empty($filters['admin_id'])) {
			$this->db->where('activity_log.admin_id', $filters['admin_id']);
		}
		if (!empty($filters['from'])) {
			$this->db->where('DATE(activity_log.created_at) >=', $filters['from']);
		}
		if (!empty($filters['to'])) {
			$this->db->where('DATE(activity_log.created_at) <=', $filters['to']);
		}

		$this->db->order_by('activity_log.created_at','desc');
		return $this->db->get()->result_array();
	}

	//--------------------------------------------------------------------
	public function add_log($activity, $description = '', $resource_id = NULL, $resource_type = NULL){
		$data = array(
			'activity_id' => $activity,
			'user_id' => ($this->session->userdata('user_id') != '') ? $this->session->userdata('user_id') : 0,
			'admin_id' => ($this->session->userdata('admin_id') != '') ? $this->session->userdata('admin_id') : 0,
			'description' => $description,
			'resource_id' => $resource_id,
			'resource_type' => $resource_type,
			'ip_address' => $this->input->ip_address(),
			'user_agent' => $this->input->user_agent(),
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert('activity_log',$data);
		return true;
	}
	

	
}

?>
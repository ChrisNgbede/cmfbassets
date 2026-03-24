<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model{

	public function get_user_detail(){
		$id = $this->session->userdata('admin_id');
		$query = $this->db->get_where('users', array('admin_id' => $id));
		return $result = $query->row_array();
	}

	public function update_user($data){
		$id = $this->session->userdata('admin_id');
		$this->db->where('admin_id', $id);
		$this->db->update('users', $data);
		return true;
	}

	public function change_pwd($data, $id){
		$this->db->where('admin_id', $id);
		$this->db->update('users', $data);
		return true;
	}

	public function addVideo($data, $id = NULL){
		if (!empty($id)) {
			$this->db->where('id', $id);
			return $this->db->update('videos', $data);
			}
			return $this->db->insert('videos', $data);
	}

	function get_admin_roles()
	{
		$this->db->from('roles');
		$this->db->where('admin_role_status',1);
		$query=$this->db->get();
		return $query->result_array();
	}

	//-----------------------------------------------------
	function get_admin_by_id($id)
	{
		$this->db->from('users');
		//$this->db->join('roles','roles.admin_role_id=users.admin_role_id');
		$this->db->where('admin_id',$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	//-----------------------------------------------------
	function get_all()
	{

		$this->db->from('users');

		//$this->db->join('roles','roles.admin_role_id=users.admin_role_id');

		$this->db->order_by('users.admin_id','desc');

		$query = $this->db->get();

		$module = array();

		if ($query->num_rows() > 0) 
		{
			$module = $query->result_array();
		}

		return $module;
	}

	//-----------------------------------------------------
public function add_admin($data){
	$this->db->insert('users', $data);
	return true;
}

	//---------------------------------------------------
	// Edit Admin Record
public function edit_admin($data, $id){
	$this->db->where('admin_id', $id);
	$this->db->update('users', $data);
	return true;
}

	//-----------------------------------------------------
function change_status()
{		
	$this->db->set('is_active',$this->input->post('status'));
	$this->db->where('admin_id',$this->input->post('id'));
	$this->db->update('users');
} 

	//-----------------------------------------------------
function delete($id)
{		
	$this->db->where('admin_id',$id);
	$this->db->delete('users');
} 

function delete_member($id){
	$this->db->where('id',$id);
	$this->db->delete('supportmembers');

}

function delete_user($id)
{	
	$this->db->where('admin_id',$id); 
	$this->db->delete('users');
} 

function delete_video($id){
	$this->db->delete('videos', array('id'=>$id));
}



}

?>
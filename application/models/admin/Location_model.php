<?php
class Location_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	//-----------------------------------------------------
	public function get_all_countries(){

		$wh =array();

		$query = $this->db->get('countries');
		$SQL = $this->db->last_query();

		if(count($wh)>0)
		{
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
		}
		else
		{
			return $this->datatable->LoadJson($SQL);
		}
	}

	//-----------------------------------------------------
	public function get_all_states(){

		$wh =array();

		$query = $this->db->get('states');
		$SQL = $this->db->last_query();

		if(count($wh)>0)
		{
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
		}
		else
		{
			return $this->datatable->LoadJson($SQL);
		}
	}

	//-----------------------------------------------------
	public function get_all_cities(){

		$wh =array();

		$query = $this->db->get('cities');
		$SQL = $this->db->last_query();

		if(count($wh)>0)
		{
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
		}
		else
		{
			return $this->datatable->LoadJson($SQL);
		}
	}


	//-----------------------------------------------------
	public function add_country($data){

		$result = $this->db->insert('countries', $data);
        return $this->db->insert_id();	
	}

	//-----------------------------------------------------
	public function add_state($data){

		$result = $this->db->insert('states', $data);
        return true;	
	}

	//-----------------------------------------------------
	public function add_city($data){

		$result = $this->db->insert('cities', $data);
        return true;	
	}

	//-----------------------------------------------------
	public function edit_country($data, $id){

		$this->db->where('id', $id);
		$this->db->update('countries', $data);
		return true;

	}

	//-----------------------------------------------------
	public function edit_state($data, $id){

		$this->db->where('id', $id);
		$this->db->update('states', $data);
		return true;

	}

	//-----------------------------------------------------
	public function edit_city($data, $id){

		$this->db->where('id', $id);
		$this->db->update('cities', $data);
		return true;

	}

	//-----------------------------------------------------
	public function get_country_by_id($id){

		$query = $this->db->get_where('countries', array('id' => $id));
		return $result = $query->row_array();
	}

	//-----------------------------------------------------
	public function get_state_by_id($id){

		$query = $this->db->get_where('states', array('id' => $id));
		return $result = $query->row_array();
	}

	//-----------------------------------------------------
	public function get_city_by_id($id){

		$query = $this->db->get_where('cities', array('id' => $id));
		return $result = $query->row_array();
	}

		//------------------------------------------------
	// Get Countries
	function get_countries_list($id=0)
	{
		if($id==0)
		{
			return  $this->db->get('countries')->result_array();	
		}
		else
		{
			return  $this->db->select('id,country')->from('countries')->where('id',$id)->get()->row_array();	
		}
	}	

	//------------------------------------------------
	// Get Cities
	function get_cities_list($id=0)
	{
		if($id==0){
			return  $this->db->get('cities')->result_array();	
		}
		else{
			return  $this->db->select('id,city')->from('cities')->where('id',$id)->get()->row_array();	
		}
	}	

	//------------------------------------------------
	// Get States
	function get_states_list($id=0)
	{
		if($id==0){
			return  $this->db->get('states')->result_array();	
		}
		else{
			return  $this->db->select('id,s')->from('cities')->where('id',$id)->get()->row_array();	
		}
	}
	
}
?>
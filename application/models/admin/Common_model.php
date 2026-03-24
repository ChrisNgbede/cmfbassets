<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model{

	public function get_user_detail(){
		$id = $this->session->userdata('id');
		$query = $this->db->get_where('users', array('id' => $id));
		return $result = $query->row_array();
	}
	//--------------------------------------------------------------------
	public function update($id, $data, $table){

		if($this->db->update($table, $data, array('id' => $id))) {
            return true;
        }
        return false;

	}
	//--------------------------------------------------------------------
	
	function get_all_where($table,$column,$value)
	{
		$this->db->from($table);
		$this->db->where($column,$value);
		$query=$this->db->get();
		return $query->result();
	}

     public function get_json_data($table,$params) {
        $this->db->select('*');
        $this->db->from($table);
        //var_dump($params); die();

        // Apply searching
        if (!empty($params['search']['value'])) {
            $searchValue = $params['search']['value'];
            $this->db->like('fullname', $searchValue);
            $this->db->or_like('phone', $searchValue);
            // Add more columns as needed
        }

        // Apply sorting
        if (!empty($params['order'])) {
            $order = $params['order'][0];
            $this->db->order_by($params['columns'][$order['column']]['data'], $order['dir']);
        }

        // Apply pagination
        if ($params['length'] != -1) {
            $this->db->limit($params['length'], $params['start']);
        }

        $query = $this->db->get();
        return $query->result_array();
    }


    function savecomment($data) {
        
        if ($this->db->insert('postreactions', $data)) {
            return $this->db->insert_id();
        }
        return false;
           
    }

    function savedata($table, $data) {
        
        if ($this->db->insert($table, $data)) {
            return $this->db->insert_id();
        }
        return $this->db->insert($table, $data);
           
    }



    function savepost($data) {
        
        if ($this->db->insert('posts', $data)) {
            return $this->db->insert_id();
        }
        return false;
           
    }
    
	function get_by_id($id, $table)
	{
		$this->db->from($table);
		$this->db->where('id',$id);
		$query=$this->db->get();
		return $query->row_array();
	}

	function get_one($id = 0, $table) {
        return $this->get_one_where(array('id' => $id), $table);
    }

   function addproduct_categories($data, $id = NULL){
        if (!empty($id)) {
            $this->db->where('id', $id);
            return $this->db->update('product_categories', $data);
            }
            return $this->db->insert('product_categories', $data);
    }

    function get_one_where($where = array(),$table) {
        $result = $this->db->get_where($table, $where, 1);
        if ($result->num_rows()) {
            return $result->row();
        } else {
            $db_fields = $this->db->list_fields($table);
            $fields = new stdClass();
            foreach ($db_fields as $field) {
                $fields->$field = "";
            }
            return $fields;
        }
    }

	public function getByID($id, $table) {
        $q = $this->db->get_where($table, array('id' => $id), 1);
        if( $q->num_rows() > 0 ) {
            return $q->row();
        }
        return FALSE;
    }

    public function getPostByID($id) {
        $this->db->select('feedposts.id, feedposts.content');
        $q = $this->db->get_where('feedposts', array('id' => $id), 1);
        if( $q->num_rows() > 0 ) {
            return $q->row();
        }
        return FALSE;
    }

    public function getGroupPostByID($id) {
        $this->db->select('groupfeedposts.id, groupfeedposts.content');
        $q = $this->db->get_where('groupfeedposts', array('id' => $id), 1);
        if( $q->num_rows() > 0 ) {
            return $q->row();
        }
        return FALSE;
    }

    public function getAll($table, $orderbyfield = null, $orderbydirection = null) {
        if($orderbyfield) {
            $this->db->order_by($orderbyfield, $orderbydirection);
        }
        $q = $this->db->get($table);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllWhere($table, $wherefield, $wherevalue = null) {
    	 $this->db->select('*');
    	 if ($wherevalue) {
    	 	 $q = $this->db->get_where($table, array($wherefield => $wherevalue));
    	 }else{
    	 	$q = $this->db->get($table);
    	 }
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

     public function getSupportGroups($status, $isapproved = "pending") {
        $this->db->select('*');
        $q = $this->db->get_where('supportgroups', array('status' => $status, 'isapproved' => $isapproved));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }


    public function getalldatawhere($table,$wherearray = array(), $orderbyfield = null, $orderbydirection = null) {
        if ($orderbyfield) {
            $this->db->order_by($orderbyfield, $orderbydirection);
        }
        $q = $this->db->get_where($table, $wherearray);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getworkscheduleitems($wherearray = array()) {

        $workscheduleitemstable = $this->db->dbprefix('workschedule_items');
        $customerstable = $this->db->dbprefix('customers');
        $workscheduletable = $this->db->dbprefix('workschedule');

        $this->db->select("$workscheduleitemstable.activity, DATE_FORMAT($workscheduleitemstable.duedate,'%d/%m/%Y') as duedate, DATE_FORMAT($workscheduleitemstable.startdate,'%d/%m/%Y') as startdate, $workscheduleitemstable.status, $workscheduleitemstable.has_report, $customerstable.name as customername, $customerstable.email as customeremail, $customerstable.phone as customerphone, $customerstable.address as customeraddress")
        ->join("$customerstable", "$customerstable.id=$workscheduleitemstable.customerid", 'left')
        ->join("$workscheduletable", "$workscheduletable.id=$workscheduleitemstable.workschedule_id", 'left')
        ->order_by("$workscheduleitemstable.duedate", 'desc');
        $q = $this->db->get_where('workschedule_items', $wherearray);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function getAllWhere2($table, $wherefield, $wherevalue = null) {
         $this->db->select('*');
         if ($wherevalue) {
             $q = $this->db->get_where($table, array($wherefield => $wherevalue));
             if ($q->num_rows() > 0) {
                foreach (($q->result()) as $row) {
                    $data[] = $row;
                }
                return $data;
            }
         }
        
        return FALSE;
    }

   public function getdatawhere($table, $where = array()) {
    	 $this->db->select('*');
    	 if ($where) {
    	 	 $q = $this->db->get_where($table, $where);
    	 }else{
    	 	$q = $this->db->get($table);
    	 }
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

      public function get_data_array_from_db($table, $wherefield, $wherevalue = null) {
    	 $this->db->select('*');
    	 if ($wherevalue) {
    	 	 return $this->db->get_where($table, array($wherefield => $wherevalue))->result_array();
    	 }else{
    	 	return $this->db->get($table)->result_array();
    	 }
        return FALSE;
    }


     public function fetch($table, $field = NULL, $value = NULL) {
        $this->db->select('*');
        if ($value) {
            $this->db->where($field, $value);
        }
        $q = $this->db->get($table);

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

	public function get_all_for_json($table){
		$this->db->select('*');
		return $this->db->get($table)->result_array();
	}

    public function getBy($where, $table) {
        $q = $this->db->get_where($table, $where, 1);
        if( $q->num_rows() > 0 ) {
            return $q->row();
        }
        return FALSE;
    }

	//-----------------------------------------------------
	// function get_all()
	// {

	// 	$this->db->from('users');

	// 	$this->db->join('roles','roles.role_id=users.role_id');

	// 	if($this->session->userdata('filter_type')!='')

	// 		$this->db->where('users.role_id',$this->session->userdata('filter_type'));

	// 	if($this->session->userdata('filter_status')!='')

	// 		$this->db->where('users.is_active',$this->session->userdata('filter_status'));


	// 	$filterData = $this->session->userdata('filter_keyword');

	// 	$this->db->like('roles.role_title',$filterData);
	// 	$this->db->or_like('users.firstname',$filterData);
	// 	$this->db->or_like('users.lastname',$filterData);
	// 	$this->db->or_like('users.email',$filterData);
	// 	$this->db->or_like('users.phone',$filterData);
	// 	$this->db->or_like('users.username',$filterData);

	// 	$this->db->where('users.is_supper !=', 1);

	// 	$this->db->order_by('users.id','desc');

	// 	$query = $this->db->get();

	// 	$module = array();

	// 	if ($query->num_rows() > 0) 
	// 	{
	// 		$module = $query->result_array();
	// 	}

	// 	return $module;
	// }

	//-----------------------------------------------------
public function add($data = array(), $table){
	 if ($this->db->insert($table, $data)) {
            return $this->db->insert_id();
        }
        return false;
}

public function change_status($table,$status,$column, $id)
{		
	$this->db->set($column,$status);
	$this->db->where('id',$id);
	$this->db->update($table);
} 


public function get_data() {
    $this->datatables->select('column_name1, column_name2'); // Select the columns you want to display
    $this->datatables->from('your_table_name'); // Specify your table name
    return $this->datatables->generate();
}




//save in database

   function save($data = array(), $id = 0, $table) {
    
        if ($id) {
        	//update
        	
            $where = array("id" => $id);
            if($this->db->update($table, $data, $where)) {
		            return true;
	        }
	        return false;
        } else {
            //insert
	            if ($this->db->insert($table, $data)) {
		            return $this->db->insert_id();
		        }
		        return false;
        }
    }

    function saveWhere($data = array(), $where = [], $table) {
    
        if (!empty($where) && is_array($where)) {
            //update
            if($this->db->update($table, $data, $where)) {
                    return true;
            }
            return false;
        } else {
            //insert
                if ($this->db->insert($table, $data)) {
                    return $this->db->insert_id();
                }
                return false;
        }
    }

    function savelatest($id = 0){
        $this->db->update('products', array('latest' => 1), array('id' => $id));
    }

     function savelatestexists($previousid, $newid){
        $this->db->update('products', array('latest' => 0), array('id' => $previousid));
        $this->db->update('products', array('latest' => 1), array('id' => $new));
    }

    


function savegroupfeed($data) {
    
    if ($this->db->insert('groupfeedposts', $data)) {
        return $this->db->insert_id();
    }
    return false;
       
}

function savelike($data) {
    
    if ($this->db->insert('feedpostsreaction', $data)) {
        return $this->db->insert_id();
    }
    return false;
       
}

function savegrouplike($data) {
    
    if ($this->db->insert('groupfeedpostsreaction', $data)) {
        return $this->db->insert_id();
    }
    return false;
       
}


function savegroupcomment($data) {
    
    if ($this->db->insert('groupfeedpostsreaction', $data)) {
        return $this->db->insert_id();
    }
    return false;
       
}


function savetax($data = array(), $id = 0) {
  
        if ($id) {
            //update
            $where = array("id" => $id);
            if($this->db->update('taxes', $data, $where)) {
                    if ($data['isdefault'] == 1) {
                          $where = array("businessid" => $data['businessid']);
                          $isdefautdata = array('default_tax_rate ' => $data['rate'] );
                          $this->db->update('app_settings', $isdefautdata, $where);
                    }
                    return true;
            }
            return false;
        } else {
            //insert
                if ($this->db->insert('taxes', $data)) {
                     if ($data['isdefault'] == 1) {
                          $where = array("businessid" => $data['businessid']);
                          $isdefautdata = array('default_tax_rate ' => $data['rate'] );
                          $this->db->update('app_settings', $isdefautdata, $where);
                    }
                    return $this->db->insert_id();
                }
                return false;
        }
    }


function savesalessettings($data = array(), $id = 0) {
            //update
            $where = array("businessid" => $id);
            if($this->db->update('app_settings', $data, $where)) {
                    return true;
            }
            return false; 
    }


    function savedesignation($data = array(), $id = 0) {
    
        if ($id) {
        	//update
        	
            $where = array("id" => $id);
            if ($data['reportsto'] == 'self') {
            	$data['reportsto'] = $id;
            }
            if($this->db->update('designations', $data, $where)) {
		            return true;
	        }
	        return false;
        } else {
            //insert
	            if ($this->db->insert('designations', $data)) {
	            	$designationid = $this->db->insert_id();
		            if ($data['reportsto'] == 'self') {
		            	$this->db->update('designations',array('reportsto'=>$designationid),array('id'=>$designationid));
		            }
		            return $designationid;
		        }
		        return false;
        
    }
}


    public function count($field = NULL, $value = NULL, $table) {
        if ($value) {
            $this->db->where($field, $value);
            return $this->db->count_all_results($table);
        } else {
            return $this->db->count_all($table);
        }
    }


 public function countwhere($table, $where = array()) {
    if ($table) {
            $this->db->where($where);
            return $this->db->count_all_results($table);
        } else {
            return $this->db->count_all($table);
        }
    }



//-----------------------------------------------------
 public function delete($id, $table ) {
        if($this->db->delete($table, array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

}

?>
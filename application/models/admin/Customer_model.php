<?php
    class Customer_model extends CI_Model{

        public function add_customer($data){
            $this->db->insert('clients', $data);
            return true;
        }

        //---------------------------------------------------
        // get all clients for server-side datatable processing (ajax based)
        public function get_all_clients(){
            $this->db->select('*');
            $this->db->where('is_admin',0);
            return $this->db->get('clients')->result_array();
        }


        //---------------------------------------------------
        // Get customer detial by ID
        public function get_customer_by_id($id){
            $query = $this->db->get_where('clients', array('id' => $id));
            return $result = $query->row_array();
        }

        public function get_customer_by_name($id){
            $query = $this->db->get_where('clients', array('name' => $id));
            return $result = $query->row_array();
        }


        //---------------------------------------------------
        // Edit customer Record
        public function edit_customer($data, $id){
            $this->db->where('id', $id);
            $this->db->update('clients', $data);
            return true;
        }

        //---------------------------------------------------
        // Change customer status
        //-----------------------------------------------------
        function change_status()
        {       
            $this->db->set('is_active', $this->input->post('status'));
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('clients');
        }



    function get_clients_suggestion($keyword = "") {
        $clients_table = $this->db->dbprefix('clients');

        $keyword = $this->db->escape_str($keyword);

        $sql = "SELECT $clients_table.name, $clients_table.id, $clients_table.phone
        FROM $clients_table
        WHERE $clients_table.name LIKE '%$keyword%'
        LIMIT 10 
        ";
        return $this->db->query($sql)->result();
    }

    public function getAllCustomers($params = null){

        $this->db->select('*');

        if(!empty($params['onremita']))
            $this->db->where('onremita',$params['onremita']);
    
        if(!empty($params['datecreatedfrom']))
            $this->db->where('datecreated >= ',date('Y-m-d', strtotime($params['datecreatedfrom'])));

        if(!empty($params['datecreatedto']))
            $this->db->where('datecreated <= ',date('Y-m-d', strtotime($params['datecreatedto'])));

        $this->db->order_by('id','desc');

        return $this->db->get('customers')->result_array();
    }

    public function updatecustomer($data, $customerid){
            $this->db->where('id', $customerid);
            if ($this->db->update('clients', $data)) {
                return true;
            }
            return false;
        }

    public function getclients() {
        $this->db->select($this->db->dbprefix('clients') . '.id as id, ' . $this->db->dbprefix('clients') . '.name as name,' . $this->db->dbprefix('clients') . '.address as address,' . $this->db->dbprefix('clients') . '.phone as phone,' . $this->db->dbprefix('clients') . '.balance as balance,' . $this->db->dbprefix('clients') . '.email as email,' . $this->db->dbprefix('business') . '.name as business,')
        ->join('business', 'business.id=clients.businessid', 'left');
      
        return $this->db->get('clients')->result_array();
    }       

    }

?>
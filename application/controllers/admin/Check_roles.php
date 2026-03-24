<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Check_roles extends MY_Controller {
    public function index() {
        $fields = $this->db->list_fields('admin_roles');
        echo "Fields in 'admin_roles' table:\n";
        print_r($fields);
        
        $fields = $this->db->list_fields('module');
        echo "\nFields in 'module' table:\n";
        print_r($fields);
    }
}

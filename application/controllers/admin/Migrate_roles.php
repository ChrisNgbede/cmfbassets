<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Migrate_roles extends MY_Controller {
    public function index() {
        $fields = [
            'is_asset_initiator' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_asset_approver' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_asset_tagger' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_collateral_initiator' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_collateral_approver' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_collateral_tagger' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ];
        $this->load->dbforge();
        foreach($fields as $name => $conf) {
            if(!$this->db->field_exists($name, 'roles')) {
                $this->dbforge->add_column('roles', [$name => $conf]);
                echo "Added column: $name\n";
            } else {
                echo "Column already exists: $name\n";
            }
        }
    }
}

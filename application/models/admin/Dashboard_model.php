<?php
	class Dashboard_model extends CI_Model{

		public function get_all_users(){
			return $this->db->count_all('users');
		}
		public function get_active_users(){
			$this->db->where('is_active', 1);
			return $this->db->count_all_results('users');
		}
		public function get_deactive_users(){
			$this->db->where('is_active', 0);
			return $this->db->count_all_results('users');
		}

		public function get_assets_by_category() {
			$this->db->select('asset_categories.name as label, COUNT(assets.id) as value');
			$this->db->from('assets');
			$this->db->join('asset_categories', 'asset_categories.id = assets.category');
			$this->db->group_by('assets.category');
			return $this->db->get()->result_array();
		}

		public function get_assets_by_status() {
			$this->db->select('status as label, COUNT(id) as value');
			$this->db->from('assets');
			$this->db->group_by('status');
			return $this->db->get()->result_array();
		}

		public function get_acquisition_trend() {
			$this->db->select("DATE_FORMAT(dateacquired, '%Y-%m') as month, COUNT(id) as count");
			$this->db->from('assets');
			$this->db->where('dateacquired IS NOT NULL');
            $this->db->where('dateacquired !=', '0000-00-00');
			$this->db->group_by('month');
			$this->db->order_by('month', 'ASC');
			$this->db->limit(6);
			return $this->db->get()->result_array();
		}
	}

?>

<?php
class Big_cluster_model extends CI_Model {

	public function insert($big_cluster_medium_category_id)
	{
		if (!isset($big_cluster_medium_category_id)) {
			return FALSE;
		}
		
		$data = array(
		   'big_cluster_medium_category_id' => $big_cluster_medium_category_id
		);
		
		$this->db->insert('big_cluster', $data);
		return $this->db->insert_id();
	}
	
	public function get($big_cluster_id)
	{
		if (!isset($big_cluster_id)) {
			return FALSE;
		}
		
		$query = $this->db->get_where('big_cluster', array('big_cluster_id' => $big_cluster_id));
		return $query->result();
	}
}
<?php
class Small_cluster_model extends CI_Model {

	public function insert($small_cluster_name, $small_cluster_medium_category_id)
	{
		if (!isset($small_cluster_name)) {
			return FALSE;
		} elseif (!isset($small_cluster_medium_category_id)) {
			return FALSE;
		}
		
		if ($this->db->get_where('small_cluster', array('small_cluster_name' => $small_cluster_name))->num_rows() == 0) {
			$data = array(
			   'small_cluster_name' => $small_cluster_name
			   , 'small_cluster_medium_category_id' => $small_cluster_medium_category_id
			);
			
			$this->db->insert('small_cluster', $data);
		}
		
		$query = $this->db->get_where('small_cluster', array('small_cluster_name' => $small_cluster_name));
		if ($query->num_rows() <= 0) {
			return FALSE;
		}
		return $query->result()[0]->small_cluster_id;
	}
	
	public function get_small_clusters($small_cluster_medium_category_id)
	{
		if (!isset($small_cluster_medium_category_id)) {
			return FALSE;
		}
		
		$query = $this->db->get_where('small_cluster', array('small_cluster_medium_category_id' => $small_cluster_medium_category_id));
		return $query->result();
	}
	
	public function get_all_small_clusters()
	{
		$query = $this->db->get('small_cluster');
		return $query->result();
	}
}
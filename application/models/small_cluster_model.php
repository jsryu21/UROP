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
	
	public function update($small_cluster_id, $big_cluster_id)
	{
		if (!isset($small_cluster_id)) {
			return FALSE;
		} elseif (!isset($big_cluster_id)) {
			return FALSE;
		}
		
		$data = array(
			'big_cluster_id' => $big_cluster_id
		);
		
		$this->db->where('small_cluster_id', $small_cluster_id);
		$this->db->update('small_cluster', $data);
	}
	
	public function get_small_clusters($name, $value)
	{
		if (!isset($name)) {
			return FALSE;
		} elseif (!isset($value)) {
			return FALSE;
		}
		
		$query = $this->db->get_where('small_cluster', array($name => $value));
		return $query->result();
	}
	
	public function get_all_small_clusters()
	{
		$query = $this->db->get('small_cluster');
		return $query->result();
	}
	
	public function get_medium_category_ids()
	{
		$this->db->distinct();
		$this->db->select('small_cluster_medium_category_id');
		$query = $this->db->get('small_cluster');
		return $query->result();
	}
}
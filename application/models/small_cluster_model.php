<?php
class Small_cluster_model extends CI_Model {

	private $DB;

	public function __construct()
	{
		$this->DB = $this->load->database('local_naver', TRUE);
	}
	
	public function insert($small_cluster_name, $small_cluster_medium_category_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($small_cluster_name)) {
			return FALSE;
		} elseif (!isset($small_cluster_medium_category_id)) {
			return FALSE;
		}
		
		if ($this->DB->get_where('small_cluster', array('small_cluster_name' => $small_cluster_name))->num_rows() == 0) {
			$data = array(
			   'small_cluster_name' => $small_cluster_name
			   , 'small_cluster_medium_category_id' => $small_cluster_medium_category_id
			);

			$this->DB->insert('small_cluster', $data); 
		}
		
		$query = $this->DB->get_where('small_cluster', array('small_cluster_name' => $small_cluster_name));
		return $query->result()[0]->small_cluster_id;
	}
	
	public function get_small_clusters($small_cluster_medium_category_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($small_cluster_medium_category_id)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('small_cluster', array('small_cluster_medium_category_id' => $small_cluster_medium_category_id));
		return $query->result();
	}
	
	public function get_all_small_clusters()
	{
		if (!isset($this->DB)) {
			return FALSE;
		}
		
		$query = $this->DB->get('small_cluster');
		return $query->result();
	}
}
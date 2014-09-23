<?php
class Categories_model extends CI_Model {

	private $DB;

	public function __construct()
	{
		$this->DB = $this->load->database('local_naver', TRUE);
	}
	
	public function get_big_categories()
	{
		if (!isset($this->DB)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('categories', array('parent_id' => NULL));
		return $query->result();
	}
	
	public function get_big_categories_id()
	{
		$big_categories_id = array();
		$big_categories = $this->get_big_categories();
		foreach ($big_categories as $key => $value) {
			$big_categories_id[] = $value->id;
		}
		return $big_categories_id;
	}
	
	public function get_parent_id($category_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($category_id)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('categories', array('id' => $category_id));
		return $query->result()[0]->parent_id;
	}
	
	public function get_child_categories($category_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($category_id)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('categories', array('parent_id' => $category_id));
		return $query->result();
	}
	
	public function get_category_id($category_name)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($category_name)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('categories', array('name' => $category_name));
		return $query->result()[0]->id;
	}
	
	public function insert_medium_category_num_small_clusters($medium_category_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($medium_category_id)) {
			return FALSE;
		}
		
		if ($this->DB->get_where('medium_category_num_small_clusters', array('medium_category_id' => $medium_category_id))->num_rows() == 0) {
			$data = array(
			   'medium_category_id' => $medium_category_id
			);

			$this->DB->insert('medium_category_num_small_clusters', $data); 
		}
	}
	
	public function get_medium_category_num_small_clusters($medium_category_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($medium_category_id)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('medium_category_num_small_clusters', array('medium_category_id' => $medium_category_id));
		return $query->result()[0]->num_small_clusters;
	}
	
	public function insert_home_category_num_small_clusters($home_category_name)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($home_category_name)) {
			return FALSE;
		}
		
		if ($this->DB->get_where('home_category_num_small_clusters', array('home_category_name' => $home_category_name))->num_rows() == 0) {
			$data = array(
			   'home_category_name' => $home_category_name
			);

			$this->DB->insert('home_category_num_small_clusters', $data); 
		}
	}
	
	public function get_home_category_num_small_clusters($home_category_name)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($home_category_name)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('home_category_num_small_clusters', array('home_category_name' => $home_category_name));
		return $query->result()[0]->num_small_clusters;
	}
}
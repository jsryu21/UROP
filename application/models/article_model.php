<?php
class Article_model extends CI_Model {

	public function get_articles($category_id, $date, $page)
	{
		if (!isset($category_id)) {
			return FALSE;
		} elseif (!isset($date)) {
			return FALSE;
		} elseif (!isset($page)) {
			return FALSE;
		}
		
		$this->db->from('article_categories');
		$this->db->join('nv_articles', 'article_categories.article_id = nv_articles.id');
		$this->db->where('date_format(service_time,"%Y-%m-%d")', $date);
		$this->db->where('article_categories.category_id', $category_id);
		$this->db->limit(20, $page * 20 - 20);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function get_medium_category_name($article_id)
	{
		if (!isset($article_id)) {
			return FALSE;
		}
		
		$this->db->from('article_categories');
		$this->db->join('categories', 'article_categories.category_id = categories.id');
		$this->db->where('categories.type', 'medium');
		$this->db->where('article_categories.article_id', $article_id);
		$query = $this->db->get();
		
		if ($query->num_rows() <= 0) {
			return FALSE;
		}
		return $query->result()[0]->name;
	}
	
	public function get_medium_category_id($article_id)
	{
		if (!isset($article_id)) {
			return FALSE;
		}
		
		$this->db->from('article_categories');
		$this->db->join('categories', 'article_categories.category_id = categories.id');
		$this->db->where('categories.type', 'medium');
		$this->db->where('article_categories.article_id', $article_id);
		$query = $this->db->get();
		
		if ($query->num_rows() <= 0) {
			return FALSE;
		}
		return $query->result()[0]->id;
	}
	
	public function get_article($article_id)
	{
		if (!isset($article_id)) {
			return FALSE;
		}
		
		$query = $this->db->get_where('nv_articles', array('id' => $article_id));
		return $query->result()[0];
	}
	
	public function get_pc_hotissue1()
	{
		$query = $this->db->get_where('nv_articles', array('pc_hotissue1_title !=' => ''));
		return $query->result();
	}
}
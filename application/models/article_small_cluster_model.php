<?php
class Article_small_cluster_model extends CI_Model {

	public function insert($article_id, $small_cluster_id)
	{
		if (!isset($article_id)) {
			return FALSE;
		} elseif (!isset($small_cluster_id)) {
			return FALSE;
		}
		
		if ($this->db->get_where('article_small_cluster', array('article_id' => $article_id, 'small_cluster_id' => $small_cluster_id))->num_rows() == 0) {
			$data = array(
			   'article_id' => $article_id
			   , 'small_cluster_id' => $small_cluster_id
			);
			
			$this->db->insert('article_small_cluster', $data);
		}
	}
	
	private function get_medium_category_name($article_id)
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
	
	public function get_articles($small_cluster_id)
	{
		if (!isset($small_cluster_id)) {
			return FALSE;
		}
		
		$this->db->from('article_small_cluster');
		$this->db->join('nv_articles', 'article_small_cluster.article_id = nv_articles.id');
		$this->db->where('small_cluster_id', $small_cluster_id);
		$query = $this->db->get();
		$articles = $query->result();
		foreach ($articles as $article) {
			$article->medium_category_name = $this->get_medium_category_name($article->id);
		}
		return $articles;
	}
}
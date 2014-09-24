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
	
	public function get_articles($small_cluster_id)
	{
		if (!isset($small_cluster_id)) {
			return FALSE;
		}
		
		$this->db->from('article_small_cluster');
		$this->db->join('nv_articles', 'article_small_cluster.article_id = nv_articles.id');
		$this->db->where('small_cluster_id', $small_cluster_id);
		$query = $this->db->get();
		return $query->result();
	}
}
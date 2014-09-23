<?php
class Article_small_clusters extends CI_Model {

	private $DB;

	public function __construct()
	{
		$this->DB = $this->load->database('local_naver', TRUE);
	}
	
	public function insert($article_id, $small_cluster_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($article_id)) {
			return FALSE;
		} elseif (!isset($small_cluster_id)) {
			return FALSE;
		}
		
		if ($this->DB->get_where('article_small_clusters', array('article_id' => $article_id, 'small_cluster_id' => $small_cluster_id))->num_rows() == 0) {
			$data = array(
			   'article_id' => $article_id
			   , 'small_cluster_id' => $small_cluster_id
			);

			$this->DB->insert('article_small_clusters', $data); 
		}
	}
	
	public function get_articles($small_cluster_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($small_cluster_id)) {
			return FALSE;
		}
		
		$this->DB->from('article_small_clusters');
		$this->DB->join('nv_articles', 'article_small_clusters.article_id = nv_articles.id');
		$this->DB->where('small_cluster_id', $small_cluster_id);
		$query = $this->DB->get();
		return $query->result();
	}
}
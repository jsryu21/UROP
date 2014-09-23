<?php
class Articles_model extends CI_Model {

	private $DB;

	public function __construct()
	{
		$this->DB = $this->load->database('local_naver', TRUE);
	}
	
	public function get_articles($category_id, $start_date, $end_date, $page)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($category_id)) {
			return FALSE;
		} elseif (!isset($start_date)) {
			return FALSE;
		} elseif (!isset($page)) {
			return FALSE;
		}
		
		$this->DB->from('article_categories');
		$this->DB->join('nv_articles', 'article_categories.article_id = nv_articles.id');
		$this->DB->where('date_format(service_time,"%Y-%m-%d")', $start_date);
		$this->DB->where('article_categories.category_id', $category_id);
		$this->DB->limit(20, $page * 20 - 20);
		$query = $this->DB->get();
		return $query->result();
	}
	
	public function get_articles_1($category_id, $start_date, $end_date, $page)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($category_id)) {
			return FALSE;
		} elseif (!isset($start_date)) {
			return FALSE;
		} elseif (!isset($page)) {
			return FALSE;
		}
		
		$this->DB->from('article_categories');
		$this->DB->join('nv_articles', 'article_categories.article_id = nv_articles.id');
		$this->DB->where('service_time BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
		$this->DB->where('article_categories.category_id', $category_id);
		$this->DB->limit(20, $page * 20 - 20);
		$query = $this->DB->get();
		return $query->result();
	}
	
	public function get_articles_2($category_id, $start_date, $end_date, $page)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($category_id)) {
			return FALSE;
		} elseif (!isset($start_date)) {
			return FALSE;
		} elseif (!isset($page)) {
			return FALSE;
		}
		
		$this->DB->from('article_categories');
		$this->DB->join('nv_articles', 'article_categories.article_id = nv_articles.id');
		$this->DB->where('service_time >=', $start_date);
		$this->DB->where('service_time <', $end_date);
		$this->DB->where('article_categories.category_id', $category_id);
		$this->DB->limit(250, (int)(($page - 1) / 10) * 250);
		$query = $this->DB->get();
		return $query->result();
	}
	
	public function get_articles_3($category_id, $start_date, $end_date, $page)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($category_id)) {
			return FALSE;
		} elseif (!isset($start_date)) {
			return FALSE;
		} elseif (!isset($page)) {
			return FALSE;
		}
		
		$this->DB->from('article_categories');
		$this->DB->join('nv_articles', 'article_categories.article_id = nv_articles.id');
		$this->DB->where('time', $start_date);
		$this->DB->where('article_categories.category_id', $category_id);
		$this->DB->limit(250, (int)(($page - 1) / 10) * 250);
		$query = $this->DB->get();
		return $query->result();
	}
	
	public function get_articles_4($category_id, $day, $page)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($category_id)) {
			return FALSE;
		} elseif (!isset($day)) {
			return FALSE;
		} elseif (!isset($page)) {
			return FALSE;
		}
		
		$this->DB->from('article_categories');
		$this->DB->join('nv_articles', 'article_categories.article_id = nv_articles.id');
		$this->DB->where('day_id', $day);
		$this->DB->where('article_categories.category_id', $category_id);
		$this->DB->limit(250, (int)(($page - 1) / 10) * 250);
		$query = $this->DB->get();
		return $query->result();
	}
	
	public function get_medium_category_name($article_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($article_id)) {
			return FALSE;
		}
		
		$this->DB->from('article_categories');
		$this->DB->join('categories', 'article_categories.category_id = categories.id');
		$this->DB->where('categories.type', 'medium');
		$this->DB->where('article_categories.article_id', $article_id);
		$query = $this->DB->get();
		if ($query->num_rows() > 0) {
			return $query->result()[0]->name;
		} else {
			return FALSE;
		}
	}
	
	public function get_medium_category_id($article_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($article_id)) {
			return FALSE;
		}
		
		$this->DB->from('article_categories');
		$this->DB->join('categories', 'article_categories.category_id = categories.id');
		$this->DB->where('categories.type', 'medium');
		$this->DB->where('article_categories.article_id', $article_id);
		$query = $this->DB->get();
		if ($query->num_rows() > 0) {
			return $query->result()[0]->id;
		} else {
			return FALSE;
		}
	}
	
	public function get_article($article_id)
	{
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($article_id)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('nv_articles', array('id' => $article_id));
		return $query->result()[0];
	}
	
	public function get_pc_hotissue1()
	{
		if (!isset($this->DB)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('nv_articles', array('pc_hotissue1_title !=' => ''));
		return $query->result();
	}
}
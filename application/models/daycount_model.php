<?php
class Daycount_model extends CI_Model {

	private $DB;

	public function __construct()
	{
		$this->DB = $this->load->database('local_naver', TRUE);
	}
	
	public function get_dates()
	{
		$this->DB->select('day');
		$this->DB->order_by("day", "desc");
		$query = $this->DB->get('daycount');
		return $query->result();
	}
}
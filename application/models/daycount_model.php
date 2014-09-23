<?php
class Daycount_model extends CI_Model {
	
	public function get_dates()
	{
		$this->db->select('day');
		$this->db->order_by("day", "desc");
		$query = $this->db->get('daycount');
		return $query->result();
	}
}
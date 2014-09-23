<?php
class Pros_model extends CI_Model {

	public $DB;

	public function __construct()
	{
		$this->DB = $this->load->database('default', TRUE);
	}
	
	public function insert($string) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($string)) {
			return FALSE;
		}
		
		$data = array(
		   'string' => $string
		);

		$this->DB->insert('pros', $data); 
	}
	
	public function get_pros() {
		if (!isset($this->DB)) {
			return FALSE;
		}
		$query = $this->DB->get('pros');
		return $query->result();
	}
}
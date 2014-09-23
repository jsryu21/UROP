<?php
class Relationship_model extends CI_Model {

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

		$this->DB->insert('relationship', $data); 
	}
	
	public function get_relationship($relationship_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($relationship_id)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('relationship', array('relationship_id' => $relationship_id));
		return $query->result()[0]->string;
	}
	
	public function get_relationships() {
		if (!isset($this->DB)) {
			return FALSE;
		}
		$query = $this->DB->get('relationship');
		return $query->result();
	}
}
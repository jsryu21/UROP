<?php
class Agreement_model extends CI_Model {

	public $DB;

	public function __construct()
	{
		$this->DB = $this->load->database('default', TRUE);
	}
	
	public function exists($check_id, $user_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($check_id)) {
			return FALSE;
		} elseif (!isset($user_id)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('agreement', array('check_id' => $check_id, 'user_id' => $user_id));
		return $query->num_rows();
	}
	
	public function insert($check_id, $user_id, $type) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($check_id)) {
			return FALSE;
		} elseif (!isset($user_id)) {
			return FALSE;
		} elseif (!isset($type)) {
			return FALSE;
		}
		
		if ($this->exists($check_id, $user_id) == FALSE) {
			$data = array(
				'check_id' => $check_id,
				'user_id' => $user_id,
				'type' => $type
			);

			$this->DB->insert('agreement', $data);
		}
	}
}
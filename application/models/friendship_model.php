<?php
class Friendship_model extends CI_Model {

	public $DB;

	public function __construct()
	{
		$this->DB = $this->load->database('default', TRUE);
	}
	
	public function exists($one_user_id, $the_other_user_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($one_user_id)) {
			return FALSE;
		} elseif (!isset($the_other_user_id)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('friendship', array('one_user_id' => $one_user_id, 'the_other_user_id' => $the_other_user_id));
		return $query->num_rows() > 0;
	}
	
	public function insert($one_user_id, $the_other_user_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($one_user_id)) {
			return FALSE;
		} elseif (!isset($the_other_user_id)) {
			return FALSE;
		}
		
		if ($this->exists($one_user_id, $the_other_user_id) == FALSE) {
			$data = array(
				'one_user_id' => $one_user_id,
				'the_other_user_id' => $the_other_user_id
			);

			$this->DB->insert('friendship', $data);
		}
	}
	
	public function get_friends($one_user_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($one_user_id)) {
			return FALSE;
		}
		
		$this->DB->from('friendship');
		$this->DB->join('user', 'user.user_id = friendship.the_other_user_id');
		$this->DB->where('one_user_id', $one_user_id);
		$query = $this->DB->get();
		return $query->result();
	}
}
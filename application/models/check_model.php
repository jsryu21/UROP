<?php
class Check_model extends CI_Model {

	public $DB;

	public function __construct()
	{
		$this->DB = $this->load->database('default', TRUE);
	}
	
	public function get_checks($checker_user_id, $checkee_user_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($checker_user_id)) {
			return FALSE;
		} elseif (!isset($checkee_user_id)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('check', array('checker_user_id' => $checker_user_id, 'checkee_user_id' => $checkee_user_id));
		return $query->result();
	}
	
	public function get_all_checks($user_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($user_id)) {
			return FALSE;
		}
		
		$this->DB->from('check');
		$this->DB->join('user', 'user.user_id = check.checker_user_id');
		$this->DB->where('checkee_user_id', $user_id);
		$query = $this->DB->get();
		return $query->result();
	}
	
	public function get_average_rating($user_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($user_id)) {
			return FALSE;
		}
		
		$this->DB->select_avg('rating');
		$query = $this->DB->get_where('check', array('checkee_user_id' => $user_id));
		return $query->result()[0]->rating;
	}
	
	public function agree($check_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($check_id)) {
			return FALSE;
		}
		
		$this->DB->where('check_id', $check_id);
		$this->DB->set('agree', 'agree+1', FALSE);
		$this->DB->update('check');
	}
	
	public function disagree($check_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($check_id)) {
			return FALSE;
		}
		
		$this->DB->where('check_id', $check_id);
		$this->DB->set('disagree', 'disagree+1', FALSE);
		$this->DB->update('check');
	}
	
	public function insert($checker_user_id, $checkee_user_id, $relationship_id, $rating, $pros_1, $pros_2, $pros_3, $cons_1, $cons_2, $cons_3, $comment) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($checker_user_id)) {
			return FALSE;
		} elseif (!isset($checkee_user_id)) {
			return FALSE;
		} elseif (!isset($relationship_id)) {
			return FALSE;
		} elseif (!isset($rating)) {
			return FALSE;
		} elseif (!isset($pros_1)) {
			return FALSE;
		} elseif (!isset($pros_2)) {
			return FALSE;
		} elseif (!isset($pros_3)) {
			return FALSE;
		} elseif (!isset($cons_1)) {
			return FALSE;
		} elseif (!isset($cons_2)) {
			return FALSE;
		} elseif (!isset($cons_3)) {
			return FALSE;
		} elseif (!isset($comment)) {
			return FALSE;
		}
		
		$data = array(
			'checker_user_id' => $checker_user_id,
			'checkee_user_id' => $checkee_user_id,
			'relationship_id' => $relationship_id,
			'rating' => $rating,
			'pros_1' => $pros_1,
			'pros_2' => $pros_2,
			'pros_3' => $pros_3,
			'cons_1' => $cons_1,
			'cons_2' => $cons_2,
			'cons_3' => $cons_3,
			'comment' => $comment
		);

		$this->DB->insert('check', $data);
	}
}
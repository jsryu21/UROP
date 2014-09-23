<?php
class User_model extends CI_Model {

	public $DB;

	public function __construct()
	{
		$this->DB = $this->load->database('default', TRUE);
	}
	
	public function exists($facebook_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($facebook_id)) {
			return FALSE;
		}
		
		$query = $this->DB->get_where('user', array('facebook_id' => $facebook_id));
		return $query->num_rows() > 0;
	}
	
	public function get_user($facebook_id) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($facebook_id)) {
			return FALSE;
		}
		$query = $this->DB->get_where('user', array('facebook_id' => $facebook_id));
		return $query->result()[0];
	}
	
	public function upsert($facebook_id, $gender, $first_name, $last_name, $name, $picture, $email = NULL) {
		if (!isset($this->DB)) {
			return FALSE;
		} elseif (!isset($facebook_id)) {
			return FALSE;
		} elseif (!isset($gender)) {
			return FALSE;
		} elseif (!isset($first_name)) {
			return FALSE;
		} elseif (!isset($last_name)) {
			return FALSE;
		} elseif (!isset($name)) {
			return FALSE;
		} elseif (!isset($picture)) {
			return FALSE;
		}
		// facebook 친구들은 email 정보가 없다.
		
		if ($this->exists($facebook_id)) {
			if (isset($email)) {
				$data = array(
					'gender' => $gender,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'name' => $name,
					'picture' => $picture,
					'email' => $email
				);
			} else {
				$data = array(
					'gender' => $gender,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'name' => $name,
					'picture' => $picture,
				);
			}
			
			$this->DB->where('facebook_id', $facebook_id);
			$this->DB->update('user', $data);
		} else {
			$data = array(
				'facebook_id' => $facebook_id,
				'gender' => $gender,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'name' => $name,
				'picture' => $picture,
				'email' => $email
			);
			
			$this->DB->insert('user', $data);
		}
	}
}
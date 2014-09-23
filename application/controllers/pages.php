<?php

class Pages extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		$this->load->helper('url');
		$this->load->library('facebook');
		$this->load->model('relationship_model');
		$this->load->model('pros_model');
		$this->load->model('cons_model');
		$this->load->model('user_model');
		$this->load->model('friendship_model');
		$this->load->model('check_model');
		$this->load->model('agreement_model');
	}
	
	public function index()
	{
		$current_facebook_id = $this->facebook->get_facebook_id();
		if ($current_facebook_id) {
			$user = $this->facebook->get_user();
			$this->user_model->upsert($user['id'], $user['gender'], $user['first_name'], $user['last_name'], $user['name'], $user['picture']->data->url, $user['email']);
			$redirect_url = $this->session->userdata('redirect_url');
			$this->session->unset_userdata('redirect_url');
			if ($redirect_url) {
				header('Location: '.$redirect_url);
				exit();
			} else {
				header('Location: '.$this->config->item('base_url').'/friends/'.$current_facebook_id);
				exit();
			}
		} else {
			$data['current_facebook_id'] = $current_facebook_id;
			$data['login_url'] = $this->facebook->get_login_url();
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/login', $data);
			$this->load->view('templates/footer', $data);
		}
	}
	
	public function friends($url_facebook_id) {
		// db 조회 후 없는 유저
		if ($this->user_model->exists($url_facebook_id) == FALSE) {		
			header('Location: '.$this->config->item('base_url'));
			exit();
		}
		
		$current_facebook_id = $this->facebook->get_facebook_id();
		if ($current_facebook_id == FALSE) {
			header('Location: '.$this->config->item('base_url'));
			exit();
		} elseif ($url_facebook_id != $current_facebook_id) {
			header('Location: '.$this->config->item('base_url'));
			exit();
		}
		
		$user = $this->user_model->get_user($current_facebook_id);
		$facebook_friends = $this->facebook->get_friends();
		// db 에 페이스북 친구 등록
		foreach ($facebook_friends as $value) {
			$this->user_model->upsert($value->id, $value->gender, $value->first_name, $value->last_name, $value->name, $value->picture->data->url);
			$this->friendship_model->insert($user->user_id, $this->user_model->get_user($value->id)->user_id);
		}
		
		// db 에서 친구 불러오기
		$friends = $this->friendship_model->get_friends($user->user_id);
		foreach ($friends as $value) {
			$value->average_rating = $this->check_model->get_average_rating($value->the_other_user_id);
		}
		
		$data['current_facebook_id'] = $current_facebook_id;
		$data['friends'] = $friends;
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/friends', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function user($url_facebook_id) {
		// db 조회 후 없는 유저
		if ($this->user_model->exists($url_facebook_id) == FALSE) {
			header('Location: '.$this->config->item('base_url'));
			exit();
		}
		$current_facebook_id = $this->facebook->get_facebook_id();
		if ($current_facebook_id == FALSE) {
			// 로그인
			$this->session->set_userdata('redirect_url', $this->config->item('base_url').'/user/'.$url_facebook_id);
			$url_user = $this->user_model->get_user($url_facebook_id);
			
			$checks = $this->check_model->get_all_checks($url_user->user_id);
			$same_gender_sum_ratings = 0;
			$same_gender_num_checks = 0;
			$diff_gender_sum_ratings = 0;
			$diff_gender_num_checks = 0;
			$colleague_sum_ratings = 0;
			$colleague_num_checks = 0;
			foreach ($checks as $value) {
				$relationship = $this->relationship_model->get_relationship($value->relationship_id);
				if ($relationship == '동료') {
					$colleague_sum_ratings += $value->rating;
					++$colleague_num_checks;
				} elseif ($relationship == '친구') {
					if ($value->gender == $url_user->gender) {
						$same_gender_sum_ratings += $value->rating;
						++$same_gender_num_checks;
					} else {
						$diff_gender_sum_ratings += $value->rating;
						++$diff_gender_num_checks;
					}
				} elseif ($relationship == '연인') {
					$diff_gender_sum_ratings += $value->rating;
					++$diff_gender_num_checks;
				}
			}
			
			$data['current_facebook_id'] = $current_facebook_id;
			$data['url_facebook_id'] = $url_facebook_id;
			$data['picture'] = $url_user->picture;
			$data['name'] = $url_user->name;
			$data['num_checks'] = count($checks);
			$data['same_gender_average_rating'] = $same_gender_num_checks == 0 ? 0 : (float)$same_gender_sum_ratings * 10 / $same_gender_num_checks;
			$data['diff_gender_average_rating'] = $diff_gender_num_checks == 0 ? 0 : (float)$diff_gender_sum_ratings * 10 / $diff_gender_num_checks;
			$data['colleague_average_rating'] = $colleague_num_checks == 0 ? 0 : (float)$colleague_sum_ratings * 10 / $colleague_num_checks;
			$data['login_url'] = $this->facebook->get_login_url();
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/user_1', $data);
			$this->load->view('templates/footer', $data);
		} elseif ($url_facebook_id == $current_facebook_id) {
			// 내 프로필
			$user = $this->user_model->get_user($current_facebook_id);
			$checks = $this->check_model->get_all_checks($user->user_id);
			$same_gender_sum_ratings = 0;
			$same_gender_num_checks = 0;
			$diff_gender_sum_ratings = 0;
			$diff_gender_num_checks = 0;
			$colleague_sum_ratings = 0;
			$colleague_num_checks = 0;
			$pros = array();
			$cons = array();
			$comments = array();
			foreach ($checks as $value) {
				$relationship = $this->relationship_model->get_relationship($value->relationship_id);
				if ($relationship == '동료') {
					$colleague_sum_ratings += $value->rating;
					++$colleague_num_checks;
				} elseif ($relationship == '친구') {
					if ($value->gender == $user->gender) {
						$same_gender_sum_ratings += $value->rating;
						++$same_gender_num_checks;
					} else {
						$diff_gender_sum_ratings += $value->rating;
						++$diff_gender_num_checks;
					}
				} elseif ($relationship == '연인') {
					$diff_gender_sum_ratings += $value->rating;
					++$diff_gender_num_checks;
				}
				if (array_key_exists($value->pros_1, $pros)) {
					++$pros[$value->pros_1];
				} else {
					$pros[$value->pros_1] = 1;
				}
				if (array_key_exists($value->pros_2, $pros)) {
					++$pros[$value->pros_2];
				} else {
					$pros[$value->pros_2] = 1;
				}
				if (array_key_exists($value->pros_3, $pros)) {
					++$pros[$value->pros_3];
				} else {
					$pros[$value->pros_3] = 1;
				}
				if (array_key_exists($value->cons_1, $cons)) {
					++$cons[$value->cons_1];
				} else {
					$cons[$value->cons_1] = 1;
				}
				if (array_key_exists($value->cons_2, $cons)) {
					++$cons[$value->cons_2];
				} else {
					$cons[$value->cons_2] = 1;
				}
				if (array_key_exists($value->cons_3, $cons)) {
					++$cons[$value->cons_3];
				} else {
					$cons[$value->cons_3] = 1;
				}
				if ($value->comment != '') {
					$comments[] = $value->comment;
				}
			}
			
			$data['current_facebook_id'] = $current_facebook_id;
			$data['picture'] = $user->picture;
			$data['name'] = $user->name;
			$data['num_checks'] = count($checks);
			$data['same_gender_average_rating'] = $same_gender_num_checks == 0 ? 0 : (float)$same_gender_sum_ratings * 10 / $same_gender_num_checks;
			$data['diff_gender_average_rating'] = $diff_gender_num_checks == 0 ? 0 : (float)$diff_gender_sum_ratings * 10 / $diff_gender_num_checks;
			$data['colleague_average_rating'] = $colleague_num_checks == 0 ? 0 : (float)$colleague_sum_ratings * 10 / $colleague_num_checks;
			$data['pros'] = $pros;
			$data['cons'] = $cons;
			$data['num_comments'] = count($comments);
			$data['comments'] = $comments;
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/user_2', $data);
			$this->load->view('templates/footer', $data);
		} else {
			$user = $this->user_model->get_user($current_facebook_id);
			$url_user = $this->user_model->get_user($url_facebook_id);
			if (count($this->check_model->get_checks($user->user_id, $url_user->user_id)) > 0) {
				// 다른 사람 프로필
				$checks = $this->check_model->get_all_checks($url_user->user_id);
				$same_gender_sum_ratings = 0;
				$same_gender_num_checks = 0;
				$diff_gender_sum_ratings = 0;
				$diff_gender_num_checks = 0;
				$colleague_sum_ratings = 0;
				$colleague_num_checks = 0;
				$pros = array();
				$cons = array();
				$comments = array();
				foreach ($checks as $value) {
					$relationship = $this->relationship_model->get_relationship($value->relationship_id);
					if ($relationship == '동료') {
						$colleague_sum_ratings += $value->rating;
						++$colleague_num_checks;
					} elseif ($relationship == '친구') {
						if ($value->gender == $url_user->gender) {
							$same_gender_sum_ratings += $value->rating;
							++$same_gender_num_checks;
						} else {
							$diff_gender_sum_ratings += $value->rating;
							++$diff_gender_num_checks;
						}
					} elseif ($relationship == '연인') {
						$diff_gender_sum_ratings += $value->rating;
						++$diff_gender_num_checks;
					}
					if (array_key_exists($value->pros_1, $pros)) {
						++$pros[$value->pros_1];
					} else {
						$pros[$value->pros_1] = 1;
					}
					if (array_key_exists($value->pros_2, $pros)) {
						++$pros[$value->pros_2];
					} else {
						$pros[$value->pros_2] = 1;
					}
					if (array_key_exists($value->pros_3, $pros)) {
						++$pros[$value->pros_3];
					} else {
						$pros[$value->pros_3] = 1;
					}
					if (array_key_exists($value->cons_1, $cons)) {
						++$cons[$value->cons_1];
					} else {
						$cons[$value->cons_1] = 1;
					}
					if (array_key_exists($value->cons_2, $cons)) {
						++$cons[$value->cons_2];
					} else {
						$cons[$value->cons_2] = 1;
					}
					if (array_key_exists($value->cons_3, $cons)) {
						++$cons[$value->cons_3];
					} else {
						$cons[$value->cons_3] = 1;
					}
					if ($value->comment != '') {
						$comments[] = $value->comment;
					}
				}
				
				$data['current_facebook_id'] = $current_facebook_id;
				$data['url_facebook_id'] = $url_facebook_id;
				$data['picture'] = $url_user->picture;
				$data['name'] = $url_user->name;
				$data['num_checks'] = count($checks);
				$data['same_gender_average_rating'] = $same_gender_num_checks == 0 ? 0 : (float)$same_gender_sum_ratings * 10 / $same_gender_num_checks;
				$data['diff_gender_average_rating'] = $diff_gender_num_checks == 0 ? 0 : (float)$diff_gender_sum_ratings * 10 / $diff_gender_num_checks;
				$data['colleague_average_rating'] = $colleague_num_checks == 0 ? 0 : (float)$colleague_sum_ratings * 10 / $colleague_num_checks;
				$data['pros'] = $pros;
				$data['cons'] = $cons;
				$data['num_comments'] = count($comments);
				$data['comments'] = $comments;
				
				$this->load->view('templates/header', $data);
				$this->load->view('pages/user_3', $data);
				$this->load->view('templates/footer', $data);
			} else {
				// 평가 기록이 없어서 못보는 상태
				$url_user = $this->user_model->get_user($url_facebook_id);
				
				$data['current_facebook_id'] = $current_facebook_id;
				$data['url_facebook_id'] = $url_facebook_id;
				$data['picture'] = $url_user->picture;
				$data['name'] = $url_user->name;
				
				$this->load->view('templates/header', $data);
				$this->load->view('pages/user_4', $data);
				$this->load->view('templates/footer', $data);
			}
		}
	}
	
	public function detail($url_facebook_id) {
		// db 조회 후 없는 유저
		if ($this->user_model->exists($url_facebook_id) == FALSE) {
			header('Location: '.$this->config->item('base_url'));
			exit();
		}
		$current_facebook_id = $this->facebook->get_facebook_id();
		if ($current_facebook_id == FALSE) {
			// 로그인
			// 프로필 페이지로 redirect
			header('Location: '.$this->config->item('base_url').'/user/'.$url_facebook_id);
			exit();
		} elseif ($url_facebook_id == $current_facebook_id) {
			// 내 프로필
			$user = $this->user_model->get_user($current_facebook_id);
			
			$data['current_facebook_id'] = $current_facebook_id;
			$data['current_user_id'] = $user->user_id;
			$data['user'] = $user;
			$data['checks'] = $this->check_model->get_all_checks($user->user_id);
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/detail', $data);
			$this->load->view('templates/footer', $data);
		} else {
			$user = $this->user_model->get_user($current_facebook_id);
			$url_user = $this->user_model->get_user($url_facebook_id);
			if (count($this->check_model->get_checks($user->user_id, $url_user->user_id)) > 0) {
				// 다른 사람 프로필
				$data['current_facebook_id'] = $current_facebook_id;
				$data['current_user_id'] = $user->user_id;
				$data['user'] = $url_user;
				$data['checks'] = $this->check_model->get_all_checks($url_user->user_id);
				
				$this->load->view('templates/header', $data);
				$this->load->view('pages/detail', $data);
				$this->load->view('templates/footer', $data);
			} else {
				// 평가 기록이 없어서 못보는 상태
				// 프로필 페이지로 redirect
				header('Location: '.$this->config->item('base_url').'/user/'.$url_facebook_id);
				exit();
			}
		}
	}
	
	public function check($url_facebook_id) {
		// db 조회 후 없는 유저
		if ($this->user_model->exists($url_facebook_id) == FALSE) {
			header('Location: '.$this->config->item('base_url'));
			exit();
		}
		$current_facebook_id = $this->facebook->get_facebook_id();
		// 로그인 되어있지 않으면 평가하려는 친구 profile 로 이동
		if ($current_facebook_id == FALSE) {
			header('Location: '.$this->config->item('base_url').'/user/'.$url_facebook_id);
			exit();
		}
		// 스스로 평가는 불가
		if ($url_facebook_id == $current_facebook_id) {
			header('Location: '.$this->config->item('base_url').'/user/'.current_facebook_id);
			exit();
		}
		
		$data['current_facebook_id'] = $current_facebook_id;
		$data['url_user'] = $this->user_model->get_user($url_facebook_id);
		$data['current_user_id'] = $this->user_model->get_user($current_facebook_id)->user_id;
		$data['relationships'] = $this->relationship_model->get_relationships();
		$data['pros'] = $this->pros_model->get_pros();
		$data['cons'] = $this->cons_model->get_cons();
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/check', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function check_submit() {
		$post = $this->input->post();
		if ($post['current_user_id'] == ''
			or $post['url_user_id'] == ''
			or $post['relationship_id'] == ''
			or $post['rating'] == ''
			or $post['pros_1'] == ''
			or $post['pros_2'] == ''
			or $post['pros_3'] == ''
			or $post['cons_1'] == ''
			or $post['cons_2'] == ''
			or $post['cons_3'] == '') {
			header('Location: '.$this->config->item('base_url'));
			exit();
		}
		$this->check_model->insert($post['current_user_id'], $post['url_user_id'], $post['relationship_id'], $post['rating'], $post['pros_1'], $post['pros_2'], $post['pros_3'], $post['cons_1'], $post['cons_2'], $post['cons_3'], $post['comment']);
		$this->friendship_model->insert($post['current_user_id'], $post['relationship_id']);
		if ($post['url_facebook_id'] == '') {
			header('Location: '.$this->config->item('base_url'));
			exit();
		} else {
			header('Location: '.$this->config->item('base_url').'/user/'.$post['url_facebook_id']);
			exit();
		}
	}
	
	public function agree($check_id, $user_id)
	{
		if ($this->agreement_model->exists($check_id, $user_id)) {
			echo '이미 투표하셨습니다.';
		} else {
			$this->agreement_model->insert($check_id, $user_id, 1);
			$this->check_model->agree($check_id);
			echo $check_id;
		}
	}
	
	public function disagree($check_id, $user_id)
	{
		if ($this->agreement_model->exists($check_id, $user_id)) {
			echo '이미 투표하셨습니다.';
		} else {
			$this->agreement_model->insert($check_id, $user_id, 0);
			$this->check_model->disagree($check_id);
			echo $check_id;
		}
	}
	
	public function logout() {
		setcookie('PHPSESSID', '', time()-3600, "/");
		// 세션을 없애려면, 세션 쿠키도 지웁니다.
		// 주의: 이 동작은 세션 데이터뿐이 아닌, 세션 자체를 파괴합니다!
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		
		$this->session->unset_userdata('redirect_url');
		$this->session->unset_userdata('fb_token');
		$this->session->sess_destroy();
		
		// 모든 세션 변수 해제
		$_SESSION = array();
		
		// 마지막으로, 세션 파괴.
		if ( session_status() == PHP_SESSION_NONE or session_status() == PHP_SESSION_ACTIVE ) {
			session_destroy();
		}
		
		header('Location: '.$this->config->item('base_url'));
		exit();
	}
}
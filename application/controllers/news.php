<?php
class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('category_model');
		$this->load->model('article_model');
		$this->load->model('daycount_model');
		$this->load->model('small_cluster_model');
		$this->load->model('article_small_cluster_model');
		$this->load->model('big_cluster_model');
	}

	public function index()
	{
		$big_category_name = $this->input->get('big_category_name');
		$medium_category_name = $this->input->get('medium_category_name');
		$small_category_name = $this->input->get('small_category_name');
		$date = $this->input->get('date');
		$page = $this->input->get('page');
		$article_id = $this->input->get('article_id');
		$big_cluster_id = $this->input->get('big_cluster_id');
		
		$big_categories = $this->make_up_big_categories();
		if ($big_category_name == FALSE) {
			$big_category_id = $big_categories[0]->id;
			$big_category_name = $big_categories[0]->name;
		} else {
			$big_category_id = $this->category_model->get_category_id($big_category_name);
		}
		
		$medium_categories = $this->make_up_medium_categories($big_category_id);
		
		if ($medium_category_name == FALSE) {
			if ($big_category_id == 1) {
				$medium_category_name = '뉴스홈';
			} elseif ($big_category_id == 9) {
				$medium_category_name = '스포츠홈';
			}
		}
		
		if ($medium_category_name == '뉴스홈' or $medium_category_name == '속보' or $medium_category_name == '스포츠홈') {
			if ($article_id == FALSE) {
				$dates = $this->daycount_model->get_old_dates();
				if ($date == FALSE) {
					$date = $dates[0]->day;
				}
				$small_clusters = $this->set_small_clusters($this->small_cluster_model->get_small_clusters('date', $date), $this->category_model->get_medium_category_num_small_clusters_exc($medium_category_name));
			} else {
				// 개별 기사 화면
				$article = $this->article_model->get_article($article_id);
			}
		} elseif ($medium_category_name == 'TV') {
		} elseif ($medium_category_name != FALSE) {
			$medium_category_id = $this->category_model->get_category_id($medium_category_name);
			$small_categories = $this->make_up_small_categories($medium_category_id);
			
			if ($article_id == FALSE && $big_cluster_id == FALSE) {
				$dates = $this->daycount_model->get_dates();
				if ($date == FALSE) {
					$date = $dates[0]->day;
				}
				
				if ($page == FALSE) {
					$page = 1;
				}
				
				if ($small_category_name == FALSE) {
					$small_clusters = $this->set_small_clusters($this->small_cluster_model->get_small_clusters('small_cluster_medium_category_id', $medium_category_id), $this->category_model->get_medium_category_num_small_clusters($medium_category_id));
				}
				function get_time() {
					list($usec, $sec) = explode(" ", microtime());
					return ((float)$usec + (float)$sec);
				}
				
				$articles = $this->article_model->get_articles($small_category_name == FALSE ? $medium_category_id : $this->category_model->get_category_id($small_category_name), $date, $page);
				foreach ($articles as $value) {
					$value->medium_category_name = $this->article_model->get_medium_category_name($value->id);
				}
				$article = NULL;
			} elseif ($article_id == FALSE) {
				$small_clusters = $this->set_small_clusters($this->small_cluster_model->get_small_clusters('big_cluster_id', $big_cluster_id), $this->big_cluster_model->get($big_cluster_id)[0]->big_cluster_num_small_clusters);
			} elseif ($big_cluster_id == FALSE) {
				// 개별 기사 화면
				$article = $this->article_model->get_article($article_id);
			}
		}
		
		$data['big_category_name'] = $big_category_name;
		$data['medium_category_name'] = $medium_category_name;
		$data['small_category_name'] = $small_category_name;
		$data['date'] = $date;
		$data['page'] = $page;
		$data['big_categories'] = $big_categories;
		$data['medium_categories'] = $medium_categories;
		if (isset($small_categories)) {
			$data['small_categories'] = $small_categories;
		}
		if (isset($dates)) {
			$data['dates'] = $dates;
		}
		if (isset($small_clusters)) {
			$data['small_clusters'] = $small_clusters;
		}
		if (isset($articles)) {
			$data['articles'] = $articles;
		}
		if (isset($article)) {
			$data['article'] = $article;
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('news/home', $data);
		$this->load->view('templates/footer', $data);
	}
	
	private function make_up_big_categories() {
		$big_categories = array();
		$big_categories[] = (object) array('id' => '1', 'name' => '뉴스');
		$big_categories[] = (object) array('id' => '9', 'name' => '스포츠');
		return $big_categories;
	}
	
	private function make_up_medium_categories($big_category_id) {
		if ($big_category_id == 1) {
			$medium_categories = array();
			$medium_categories[] = (object) array('name' => '뉴스홈');
			$medium_categories[] = (object) array('name' => '속보');
			$medium_categories = array_merge($medium_categories, $this->category_model->get_child_categories($big_category_id));
			$medium_categories[] = (object) array('name' => 'TV');
			return $medium_categories;
		} elseif ($big_category_id == 9) {
			$medium_categories = array();
			$medium_categories[] = (object) array('name' => '스포츠홈');
			$medium_categories[] = (object) array('name' => '야구');
			$medium_categories[] = (object) array('name' => '축구');
			$medium_categories[] = (object) array('name' => '농구/배구');
			$medium_categories[] = (object) array('name' => '골프');
			$medium_categories[] = (object) array('name' => '스포츠 일반');
			$medium_categories[] = (object) array('name' => 'e스포츠');
			return $medium_categories;
		} else {
			$medium_categories = $this->category_model->get_child_categories($big_category_id);
			return $medium_categories;
		}
	}
	
	private function make_up_small_categories($medium_category_id) {
		if ($medium_category_id == 2) {
			$small_categories = array();
			$small_categories[] = (object) array('name' => '청와대');
			$small_categories[] = (object) array('name' => '국회/정당');
			$small_categories[] = (object) array('name' => '북한');
			$small_categories[] = (object) array('name' => '행정');
			$small_categories[] = (object) array('name' => '국방/외교');
			$small_categories[] = (object) array('name' => '정치 일반');
			return $small_categories;
		} elseif ($medium_category_id == 3) {
			$small_categories = array();
			$small_categories[] = (object) array('name' => '금융');
			$small_categories[] = (object) array('name' => '증권');
			$small_categories[] = (object) array('name' => '기업/재계');
			$small_categories[] = (object) array('name' => '부동산');
			$small_categories[] = (object) array('name' => '글로벌경제');
			$small_categories[] = (object) array('name' => '생활경제');
			$small_categories[] = (object) array('name' => '경제 일반');
			return $small_categories;
		} elseif ($medium_category_id == 4) {
			$small_categories = array();
			$small_categories[] = (object) array('name' => '사건사고');
			$small_categories[] = (object) array('name' => '교육');
			$small_categories[] = (object) array('name' => '노동');
			$small_categories[] = (object) array('name' => '언론');
			$small_categories[] = (object) array('name' => '환경');
			$small_categories[] = (object) array('name' => '인권/복지');
			$small_categories[] = (object) array('name' => '식품/의료');
			$small_categories[] = (object) array('name' => '지역');
			$small_categories[] = (object) array('name' => '인물');
			$small_categories[] = (object) array('name' => '사회 일반');
			return $small_categories;
		} elseif ($medium_category_id == 5) {
			$small_categories = array();
			$small_categories[] = (object) array('name' => '건강정보');
			$small_categories[] = (object) array('name' => '자동차/시승기');
			$small_categories[] = (object) array('name' => '도로/교통');
			$small_categories[] = (object) array('name' => '여행/레저');
			$small_categories[] = (object) array('name' => '음식/맛집');
			$small_categories[] = (object) array('name' => '패션/뷰티');
			$small_categories[] = (object) array('name' => '공연/전시');
			$small_categories[] = (object) array('name' => '책');
			$small_categories[] = (object) array('name' => '종교');
			$small_categories[] = (object) array('name' => '날씨');
			$small_categories[] = (object) array('name' => '생활/문화 일반');
			return $small_categories;
		} elseif ($medium_category_id == 6) {
			$small_categories = array();
			$small_categories[] = (object) array('name' => '아시아/호주');
			$small_categories[] = (object) array('name' => '미국/중남미');
			$small_categories[] = (object) array('name' => '유럽');
			$small_categories[] = (object) array('name' => '중동/아프리카');
			$small_categories[] = (object) array('name' => '세계 일반');
			return $small_categories;
		} elseif ($medium_category_id == 7) {
			$small_categories = array();
			$small_categories[] = (object) array('name' => '모바일');
			$small_categories[] = (object) array('name' => '인터넷/SNS');
			$small_categories[] = (object) array('name' => '통신/뉴미디어');
			$small_categories[] = (object) array('name' => 'IT 일반');
			$small_categories[] = (object) array('name' => '보안/해킹');
			$small_categories[] = (object) array('name' => '컴퓨터');
			$small_categories[] = (object) array('name' => '게임/리뷰');
			$small_categories[] = (object) array('name' => '과학 일반');
			return $small_categories;
		} elseif ($medium_category_id == 8) {
			$small_categories = array();
			$small_categories[] = (object) array('name' => '연예가화제');
			$small_categories[] = (object) array('name' => '방송/TV');
			$small_categories[] = (object) array('name' => '드라마');
			$small_categories[] = (object) array('name' => '영화');
			$small_categories[] = (object) array('name' => '해외 연예');
			return $small_categories;
		} elseif ($medium_category_id == 10 or $medium_category_id == 11 or $medium_category_id == 12 or $medium_category_id == 13 or $medium_category_id == 14 or $medium_category_id == 15) {
		} else {
			$small_categories = $this->category_model->get_child_categories($medium_category_id);
			return $small_categories;
		}
	}
	
	public function set_small_clusters($small_clusters, $num_small_clusters)
	{
		if (count($small_clusters) > $num_small_clusters) {
			$small_clusters = array_splice($small_clusters, 0, $num_small_clusters);
		}
		foreach ($small_clusters as $value) {
			$value->articles = $this->article_small_cluster_model->get_articles($value->small_cluster_id);
			foreach ($value->articles as $article) {
				$article->medium_category_name = $this->article_model->get_medium_category_name($article->id);
			}
			$value->medium_category_name = $this->category_model->get_category_name($value->small_cluster_medium_category_id);
		}
		return $small_clusters;
	}
	
	// cluster가 없을 때 사용하기 위해서 기존의 pc_hotissue1로 cluster를 임시로 생성
	public function create_small_clusters()
	{
		$articles = $this->article_model->get_pc_hotissue1();
		echo count($articles);
		foreach ($articles as $value) {
			$medium_category_id = $this->article_model->get_medium_category_id($value->id);
			if ($medium_category_id != FALSE) {
				$small_cluster_id = $this->small_cluster_model->insert($value->pc_hotissue1_title, $medium_category_id);
				if ($small_cluster_id != FALSE) {
					$this->article_small_cluster_model->insert($value->id, $small_cluster_id);
				}
			}
		}
	}
	
	// cluster 개수를 DB에 기본값세팅
	public function create_num_small_clusters()
	{
		// 중분류마다 보여줄 cluster 개수를 DB에 기본값세팅
		$big_categories = $this->category_model->get_big_categories();
		foreach ($big_categories as $value) {
			$medium_categories = $this->category_model->get_child_categories($value->id);
			foreach ($medium_categories as $value) {
				$this->category_model->insert_medium_category_num_small_clusters($value->id);
			}
		}
		// 보여줄 cluster 개수를 DB에 기본값세팅
		$this->category_model->insert_medium_category_num_small_clusters_exc('뉴스홈');
		$this->category_model->insert_medium_category_num_small_clusters_exc('속보');
		$this->category_model->insert_medium_category_num_small_clusters_exc('스포츠홈');
	}
	
	public function create_big_clusters()
	{
		$medium_category_ids = $this->small_cluster_model->get_medium_category_ids();
		foreach ($medium_category_ids as $medium_category_id) {
			$small_clusters = $this->small_cluster_model->get_small_clusters('small_cluster_medium_category_id', $medium_category_id->small_cluster_medium_category_id);
			$diff = 3;
			for ($i = 0; $i <= $diff; ++$i) {
				if (count($small_clusters) > $i) {
					if (!isset($small_clusters[$i]->big_cluster_id)) {
						$big_cluster_id = $this->big_cluster_model->insert($small_clusters[$i]->small_cluster_medium_category_id);
						$j = $i;
						while (TRUE) {
							$this->small_cluster_model->update($small_clusters[$j]->small_cluster_id, $big_cluster_id);
							$j += $diff;
							if (count($small_clusters) <= $j) {
								break;
							}
						}
					}
				}
			}
		}
	}
}
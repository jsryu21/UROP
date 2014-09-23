<?php
class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('categories_model');
		$this->load->model('articles_model');
		$this->load->model('daycount_model');
		$this->load->model('small_cluster_model');
		$this->load->model('article_small_clusters');
	}

	public function index()
	{
		$big_category_name = $this->input->get('big_category_name');
		$medium_category_name = $this->input->get('medium_category_name');
		$small_category_name = $this->input->get('small_category_name');
		$start_date = $this->input->get('date');
		$page = $this->input->get('page');
		$article_id = $this->input->get('article_id');
		
		$big_categories = array();
		$big_categories[] = (object) array('id' => '1', 'name' => '뉴스');
		$big_categories[] = (object) array('id' => '9', 'name' => '스포츠');
		if ($big_category_name == FALSE) {
			$big_category_id = $big_categories[0]->id;
			$big_category_name = $big_categories[0]->name;
		} else {
			$big_category_id = $this->categories_model->get_category_id($big_category_name);
		}
		
		if ($big_category_id == 1) {
			$medium_categories = array();
			$medium_categories[] = (object) array('name' => '뉴스홈');
			$medium_categories[] = (object) array('name' => '속보');
			$medium_categories = array_merge($medium_categories, $this->categories_model->get_child_categories($big_category_id));
			$medium_categories[] = (object) array('name' => 'TV');
		} elseif ($big_category_id == 9) {
			$medium_categories = array();
			$medium_categories[] = (object) array('name' => '스포츠홈');
			$medium_categories[] = (object) array('name' => '야구');
			$medium_categories[] = (object) array('name' => '축구');
			$medium_categories[] = (object) array('name' => '농구/배구');
			$medium_categories[] = (object) array('name' => '골프');
			$medium_categories[] = (object) array('name' => '스포츠 일반');
			$medium_categories[] = (object) array('name' => 'e스포츠');
		} else {
			$medium_categories = $this->categories_model->get_child_categories($big_category_id);
		}
		
		if ($medium_category_name == FALSE) {
			if ($big_category_id == 1) {
				$medium_category_name = '뉴스홈';
			} elseif ($big_category_id == 9) {
				$medium_category_name = '스포츠홈';
			}
		}
		
		if ($medium_category_name == '뉴스홈' or $medium_category_name == '속보' or $medium_category_name == '스포츠홈') {
			if ($article_id == FALSE) {
				$small_clusters = $this->small_cluster_model->get_all_small_clusters();
				$num_small_clusters = $this->categories_model->get_home_category_num_small_clusters($medium_category_name);
				if (count($small_clusters) > $num_small_clusters) {
					$small_clusters = array_splice($small_clusters, 0, $num_small_clusters);
				}
				foreach ($small_clusters as $value) {
					$value->articles = $this->article_small_clusters->get_articles($value->small_cluster_id);
					foreach ($value->articles as $a) {
						$a->medium_category_name = $this->articles_model->get_medium_category_name($a->id);
					}
				}
			} else {
				// 개별 기사 화면
				$article = $this->articles_model->get_article($article_id);
			}
		} elseif ($medium_category_name == 'TV') {
		} elseif ($medium_category_name != FALSE) {
			$medium_category_id = $this->categories_model->get_category_id($medium_category_name);
			if ($medium_category_id == 2) {
				$small_categories = array();
				$small_categories[] = (object) array('name' => '청와대');
				$small_categories[] = (object) array('name' => '국회/정당');
				$small_categories[] = (object) array('name' => '북한');
				$small_categories[] = (object) array('name' => '행정');
				$small_categories[] = (object) array('name' => '국방/외교');
				$small_categories[] = (object) array('name' => '정치 일반');
			} elseif ($medium_category_id == 3) {
				$small_categories = array();
				$small_categories[] = (object) array('name' => '금융');
				$small_categories[] = (object) array('name' => '증권');
				$small_categories[] = (object) array('name' => '기업/재계');
				$small_categories[] = (object) array('name' => '부동산');
				$small_categories[] = (object) array('name' => '글로벌경제');
				$small_categories[] = (object) array('name' => '생활경제');
				$small_categories[] = (object) array('name' => '경제 일반');
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
			} elseif ($medium_category_id == 6) {
				$small_categories = array();
				$small_categories[] = (object) array('name' => '아시아/호주');
				$small_categories[] = (object) array('name' => '미국/중남미');
				$small_categories[] = (object) array('name' => '유럽');
				$small_categories[] = (object) array('name' => '중동/아프리카');
				$small_categories[] = (object) array('name' => '세계 일반');
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
			} elseif ($medium_category_id == 8) {
				$small_categories = array();
				$small_categories[] = (object) array('name' => '연예가화제');
				$small_categories[] = (object) array('name' => '방송/TV');
				$small_categories[] = (object) array('name' => '드라마');
				$small_categories[] = (object) array('name' => '영화');
				$small_categories[] = (object) array('name' => '해외 연예');
			} elseif ($medium_category_id == 10 or $medium_category_id == 11 or $medium_category_id == 13 or $medium_category_id == 12 or $medium_category_id == 14 or $medium_category_id == 15) {
			} else {
				$small_categories = $this->categories_model->get_child_categories($medium_category_id);
			}
			
			if ($article_id == FALSE) {
				$dates = $this->daycount_model->get_dates();
				if ($start_date == FALSE) {
					$start_date = $dates[0]->day;
				}
				$date = new DateTime($start_date);
				$end_date = $date->add(new DateInterval('P1D'))->format('Y-m-d');
				
				if ($page == FALSE) {
					$page = 1;
				}
				
				if ($small_category_name == FALSE) {
					$small_clusters = $this->small_cluster_model->get_small_clusters($medium_category_id);
					$num_small_clusters = $this->categories_model->get_medium_category_num_small_clusters($medium_category_id);
					if (count($small_clusters) > $num_small_clusters) {
						$small_clusters = array_splice($small_clusters, 0, $num_small_clusters);
					}
					foreach ($small_clusters as $value) {
						$value->articles = $this->article_small_clusters->get_articles($value->small_cluster_id);
						foreach ($value->articles as $a) {
							$a->medium_category_name = $this->articles_model->get_medium_category_name($a->id);
						}
					}
				}
				function get_time() {
					list($usec, $sec) = explode(" ", microtime());
					return ((float)$usec + (float)$sec);
				}
				 
				//$start = get_time();
				//$articles = $this->articles_model->get_articles($small_category_name == FALSE ? $medium_category_id : $this->categories_model->get_category_id($small_category_name), $start_date, $end_date, $page);
				//$end = get_time();
				//$time = $end - $start;
				//echo '<br/>'.$time.'초 걸림';
				//$start = get_time();
				//$articles = $this->articles_model->get_articles_1($small_category_name == FALSE ? $medium_category_id : $this->categories_model->get_category_id($small_category_name), $start_date, $end_date, $page);
				//$end = get_time();
				//$time = $end - $start;
				//echo '<br/>'.$time.'초 걸림';
				//$start = get_time();
				//$articles = $this->articles_model->get_articles_2($small_category_name == FALSE ? $medium_category_id : $this->categories_model->get_category_id($small_category_name), $start_date, $end_date, $page);
				//$end = get_time();
				//$time = $end - $start;
				//echo '<br/>'.$time.'초 걸림';
				//$start = get_time();
				if ($start_date == '2014-03-24') {
					$day = 1;
				} elseif ($start_date == '2014-03-25') {
					$day = 2;
				} elseif ($start_date == '2014-03-25') {
					$day = 3;
				} elseif ($start_date == '2014-03-25') {
					$day = 4;
				} elseif ($start_date == '2014-03-25') {
					$day = 5;
				} elseif ($start_date == '2014-03-25') {
					$day = 6;
				} else {
					$day = 7;
				}
				$articles = $this->articles_model->get_articles_4($small_category_name == FALSE ? $medium_category_id : $this->categories_model->get_category_id($small_category_name), $day, $page);
				//$end = get_time();
				//$time = $end - $start;
				//echo '<br/>'.$time.'초 걸림';
				foreach ($articles as $value) {
					$value->medium_category_name = $this->articles_model->get_medium_category_name($value->id);
				}
			} else {
				// 개별 기사 화면
				$article = $this->articles_model->get_article($article_id);
			}
		}
		
		$data['big_category_name'] = $big_category_name;
		$data['medium_category_name'] = $medium_category_name;
		$data['small_category_name'] = $small_category_name;
		$data['start_date'] = $start_date;
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
		
		$this->load->view('templates/news_header', $data);
		$this->load->view('news/home', $data);
		$this->load->view('templates/news_footer', $data);
	}
	
	public function create_temp_small_cluster()
	{
		$articles = $this->articles_model->get_pc_hotissue1();
		echo count($articles);
		foreach ($articles as $value) {
			$medium_category_id = $this->articles_model->get_medium_category_id($value->id);
			if ($medium_category_id != FALSE) {
				$small_cluster_id = $this->small_cluster_model->insert($value->pc_hotissue1_title, $medium_category_id);
				$this->article_small_clusters->insert($value->id, $small_cluster_id);
			}
		}
	}
	
	public function create_medium_category_num_rows()
	{
		$big_categories = $this->categories_model->get_big_categories();
		foreach ($big_categories as $value) {
			$medium_categories = $this->categories_model->get_child_categories($value->id);
			foreach ($medium_categories as $value) {
				$this->categories_model->insert_medium_category_num_small_clusters($value->id);
			}
		}
		$this->categories_model->insert_home_category_num_small_clusters('뉴스홈');
		$this->categories_model->insert_home_category_num_small_clusters('속보');
		$this->categories_model->insert_home_category_num_small_clusters('스포츠홈');
	}
}
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
		$timespan = $this->input->get('timespan');
		$selected_office = $this->input->get('selected_office');
		$selected_field = $this->input->get('selected_field');
		
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
				$small_cluster_dates = $this->daycount_model->get_old_dates();
				if ($date == FALSE) {
					$date = $small_cluster_dates[0]->day;
				}
				if ($timespan == FALSE) {
					$timespan = 6;
				}
				$small_clusters = $this->set_small_clusters($this->small_cluster_model->get_range_small_clusters('date', $date, (new DateTime($date))->add(new DateInterval('P'.$timespan.'D'))->format('Y-m-d')), $this->category_model->get_medium_category_num_small_clusters_exc($medium_category_name));
			} else {
				// 개별 기사 화면
				$article = $this->article_model->get_article($article_id);
			}
		} elseif ($medium_category_name == 'TV') {
			$offices = $this->make_up_offices();
			$fields = $this->make_up_fields();
			if ($article_id == FALSE) {
				if ($selected_office != FALSE) {
					$articles_dates = $this->daycount_model->get_dates();
					if ($date == FALSE) {
						$date = $articles_dates[0]->day;
					}
					if ($page == FALSE) {
						$page = 1;
					}
					$articles = $this->article_model->get_office_articles($selected_office, $date, $page);
				} elseif ($selected_field != FALSE) {
					$articles_dates = $this->daycount_model->get_dates();
					if ($date == FALSE) {
						$date = $articles_dates[0]->day;
					}
					if ($page == FALSE) {
						$page = 1;
					}
					$articles = $this->article_model->get_field_articles($this->category_model->get_category_id($selected_field), $date, $page);
				} else {
					$count = 4;
					$tv_articles = $this->article_model->get_tv_articles($this->category_model->get_category_id('정치'), $count);
					$tv_articles = array_merge($tv_articles, $this->article_model->get_tv_articles($this->category_model->get_category_id('경제'), $count));
					$tv_articles = array_merge($tv_articles, $this->article_model->get_tv_articles($this->category_model->get_category_id('사회'), $count));
					$tv_articles = array_merge($tv_articles, $this->article_model->get_tv_articles($this->category_model->get_category_id('생활/문화'), $count));
					$tv_articles = array_merge($tv_articles, $this->article_model->get_tv_articles($this->category_model->get_category_id('세계'), $count));
					$tv_articles = array_merge($tv_articles, $this->article_model->get_tv_articles($this->category_model->get_category_id('IT/과학'), $count));
					$tv_articles = array_merge($tv_articles, $this->article_model->get_tv_articles($this->category_model->get_category_id('연예'), $count));
					$tv_articles = array_merge($tv_articles, $this->article_model->get_tv_articles($this->category_model->get_category_id('스포츠'), $count));
					$tv_articles = array_merge($tv_articles, $this->article_model->get_tv_articles($this->category_model->get_category_id('날씨'), $count));
				}
			} else {
				// 개별 기사 화면
				$article = $this->article_model->get_article($article_id);
			}
		} elseif ($medium_category_name != FALSE) {
			$medium_category_id = $this->category_model->get_category_id($medium_category_name);
			$small_categories = $this->make_up_small_categories($medium_category_id);
			
			if ($article_id == FALSE && $big_cluster_id == FALSE) {
				$articles_dates = $this->daycount_model->get_dates();
				if ($date == FALSE) {
					$date = $articles_dates[0]->day;
				}
				
				if ($page == FALSE) {
					$page = 1;
				}
				
				if ($small_category_name == FALSE) {
					$small_clusters = $this->set_small_clusters($this->small_cluster_model->get_small_clusters('small_cluster_medium_category_id', $medium_category_id), $this->category_model->get_medium_category_num_small_clusters($medium_category_id));
				}
				
				$articles = $this->article_model->get_articles($small_category_name == FALSE ? $medium_category_id : $this->category_model->get_category_id($small_category_name), $date, $page);
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
		$data['timespan'] = $timespan;
		$data['selected_office'] = $selected_office;
		$data['selected_field'] = $selected_field;
		if (isset($small_categories)) {
			$data['small_categories'] = $small_categories;
		}
		if (isset($small_cluster_dates)) {
			$data['small_cluster_dates'] = $small_cluster_dates;
		}
		if (isset($articles_dates)) {
			$data['articles_dates'] = $articles_dates;
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
		if (isset($offices)) {
			$data['offices'] = $offices;
		}
		if (isset($fields)) {
			$data['fields'] = $fields;
		}
		if (isset($tv_articles)) {
			$data['tv_articles'] = $tv_articles;
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
	
	private function make_up_offices() {
		$offices = array();
		$offices[] = (object) array('name' => 'KBS TV');
		$offices[] = (object) array('name' => 'MBC TV');
		$offices[] = (object) array('name' => 'MBN');
		$offices[] = (object) array('name' => 'YTN TV');
		$offices[] = (object) array('name' => 'SBS TV');
		$offices[] = (object) array('name' => 'SBS CNBC TV');
		$offices[] = (object) array('name' => 'TV조선');
		$offices[] = (object) array('name' => '연합뉴스 TV');
		$offices[] = (object) array('name' => '채널A');
		$offices[] = (object) array('name' => '한국경제TV');
		$offices[] = (object) array('name' => 'enews24');
		$offices[] = (object) array('name' => 'JTBC TV');
		$offices[] = (object) array('name' => 'KBS 연예');
		$offices[] = (object) array('name' => 'SBS E!');
		$offices[] = (object) array('name' => 'OBS TV');
		return $offices;
	}
	
	private function make_up_fields() {
		$fields = array();
		$fields[] = (object) array('name' => '정치');
		$fields[] = (object) array('name' => '경제');
		$fields[] = (object) array('name' => '사회');
		$fields[] = (object) array('name' => '생활/문화');
		$fields[] = (object) array('name' => '세계');
		$fields[] = (object) array('name' => 'IT/과학');
		$fields[] = (object) array('name' => '연예');
		$fields[] = (object) array('name' => '스포츠');
		$fields[] = (object) array('name' => '날씨');
		return $fields;
	}
	
	public function set_small_clusters($small_clusters, $num_small_clusters)
	{
		if (count($small_clusters) > $num_small_clusters) {
			$small_clusters = array_splice($small_clusters, 0, $num_small_clusters);
		}
		foreach ($small_clusters as $small_cluster) {
			$small_cluster->articles = $this->article_small_cluster_model->get_articles($small_cluster->small_cluster_id);
			$small_cluster->medium_category_name = $this->category_model->get_category_name($small_cluster->small_cluster_medium_category_id);
		}
		return $small_clusters;
	}
	
	// cluster가 없을 때 사용하기 위해서 기존의 pc_hotissue1로 cluster를 임시로 생성
	public function create_small_clusters()
	{
		$articles = $this->article_model->get_pc_hotissue1();
		foreach ($articles as $article) {
			$medium_category_id = $this->article_model->get_medium_category_id($article->id);
			if ($medium_category_id != FALSE) {
				$small_cluster_id = $this->small_cluster_model->insert($article->pc_hotissue1_title, $medium_category_id);
				if ($small_cluster_id != FALSE) {
					$this->article_small_cluster_model->insert($article->id, $small_cluster_id);
				}
			}
		}
	}
	
	// cluster 개수를 DB에 기본값세팅
	public function create_num_small_clusters()
	{
		// 중분류마다 보여줄 cluster 개수를 DB에 기본값세팅
		$big_categories = $this->category_model->get_big_categories();
		foreach ($big_categories as $big_category) {
			$medium_categories = $this->category_model->get_child_categories($big_category->id);
			foreach ($medium_categories as $medium_category) {
				$this->category_model->insert_medium_category_num_small_clusters($medium_category->id);
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
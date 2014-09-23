<div class="container">
	<div class="big_categories">
	<?php
		foreach ($big_categories as $value) {
			if ($value->name == $big_category_name) {
				echo '<a href="/index.php/news?big_category_name='.$value->name.'" class="text-muted big_category_selected"><strong>'.$value->name.'</strong></a>';
			}
		}
		foreach ($big_categories as $value) {
			if ($value->name != $big_category_name) {
				echo '<a href="/index.php/news?big_category_name='.$value->name.'" class="text-muted big_category">'.$value->name.'</a>';
			}
		}
	?>
	</div>
	<!-- Static navbar -->
	<?php
		if (count($medium_categories) > 0) {
	?>
	<div class="medium_categories">
		<div class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="navbar-collapse collapse">
				<?php
					echo '<ul class="nav navbar-nav">';
					foreach ($medium_categories as $value) {
						if ($value->name == $medium_category_name) {
							echo '<li class="active"><a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$value->name.'" class="text-muted">'.$value->name.'</a></li>';
						} else {
							echo '<li><a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$value->name.'" class="text-muted">'.$value->name.'</a></li>';
						}
					}
					echo '</ul>';
				?>
				</div><!--/.nav-collapse -->
			</div><!--/.container-fluid -->
		</div>
	</div>
	<?php
		}
	?>

	<!-- Example row of columns -->
	<div class="row">
	<?php
		if (isset($small_categories)) {
			echo '<div class="col-lg-2">';
			echo '<h4><strong>'.$medium_category_name.'</strong></h4>';
			foreach ($small_categories as $value) {
				if ($small_category_name != FALSE and $value->name == $small_category_name) {
					echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$value->name.'" class="text-primary"><h5><strong>'.$value->name.'</strong></h5></a>';
				} else {
					echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$value->name.'" class="text-muted"><h5>'.$value->name.'</h5></a>';
				}
			}
			echo '</div>';
			echo '<div class="col-lg-10">';
		} else {
			echo '<div class="col-lg-12">';
		}
		if (isset($small_clusters)) {
			echo '<div class="small_clusters">';
			foreach ($small_clusters  as $value) {
				echo '<div class="small_cluster">';
				echo '<div class="small_cluster_top_article">';
				echo '<div class="article_title"><a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$value->articles[0]->medium_category_name.'&article_id='.$value->articles[0]->id.'"><h4><strong>'.$value->articles[0]->title1.'</strong></h4></a></div>';
				$dom = new DOMDocument();
				libxml_use_internal_errors(true);
				$dom->loadHTML('<?xml encoding="utf-8" ?>'.$value->articles[0]->content);
				if ($value->articles[0]->type == 'photo') {
					if ($dom->getElementsByTagName('img')->length > 0) {
						$img = $dom->getElementsByTagName('img')->item(0);
						echo '<div class="article_photo"><img src="'.$img->attributes->getNamedItem("src")->value.'" alt="..." class="img-thumbnail" /></div>';
					}
				}
				echo '<div class="article_content"><span class="stripped_article_content">'.mb_substr(strip_tags($value->articles[0]->content), 0, 100).'…</span>';
				$service_time = new DateTime($value->articles[0]->service_time);
				echo '<span class="article_time">'.$service_time->format('m-d h:m').'</span>';
				echo '<span class="article_office text-danger">'.$value->articles[0]->office_name.'</span>';
				echo '</div><!-- article_content -->';
				echo '</div><!-- small_cluster_top_article -->';
				for ($i = 1; $i < min(count($value->articles), $value->small_cluster_num_articles); ++$i) {
					echo '<div class="small_cluster_article"><img src="http://static.news.naver.net/image/news/2009/ico_list_sub2.gif" /><small>';
					echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$value->articles[$i]->medium_category_name.'&article_id='.$value->articles[$i]->id.'"><span class="article_title">'.$value->articles[$i]->title1.'</span></a>';
					$service_time = new DateTime($value->articles[$i]->service_time);
					echo '<span class="article_time">'.$service_time->format('m-d h:m').'</span>';
					echo '<span class="article_office text-danger">'.$value->articles[$i]->office_name.'</span>';
					echo '</small></div>';
				}
				echo '<div class="small_cluster_view_large_cluster"><img src="http://static.news.naver.net/image/news/2009/ico_list_sub2.gif" /><a href=""><span class="text-muted">더보기</span></a></div>';
				echo '<hr />';
				echo '</div><!-- small_cluster -->';
			}
			echo '</div><!-- small_clusters -->';
		}
		if (isset($articles)) {
			$start_page = (int)(($page - 1) / 10) * 10 + 1;
			foreach (array_slice($articles, ($page - $start_page) * 25, 25) as $value) {
				echo '<div class="article">';
				if ($small_category_name != FALSE) {
					echo '<div class="article_title"><a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&article_id='.$value->id.'"><h4><strong>'.$value->title1.'</strong></h4></a></div>';
				} elseif ($medium_category_name != FALSE) {
					echo '<div class="article_title"><a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&article_id='.$value->id.'"><h4><strong>'.$value->title1.'</strong></h4></a></div>';
				} elseif ($value->medium_category_name != FALSE) {
					echo '<div class="article_title"><a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$value->medium_category_name.'&article_id='.$value->id.'"><h4><strong>'.$value->title1.'</strong></h4></a></div>';
				} else {
					echo '<div class="article_title"><a href="/index.php/news?big_category_name='.$big_category_name.'&article_id='.$value->id.'"><h4><strong>'.$value->title1.'</strong></h4></a></div>';
				}
				$dom = new DOMDocument();
				libxml_use_internal_errors(true);
				$dom->loadHTML('<?xml encoding="utf-8" ?>'.$value->content);
				if ($value->type == 'photo') {
					if ($dom->getElementsByTagName('img')->length > 0) {
						$img = $dom->getElementsByTagName('img')->item(0);
						echo '<div class="article_photo"><img src="'.$img->attributes->getNamedItem("src")->value.'" alt="..." class="img-thumbnail" /></div>';
					}
				}
				echo '<div class="article_content"><span class="stripped_article_content">'.mb_substr(strip_tags($value->content), 0, 100).'…</span>';
				$service_time = new DateTime($value->service_time);
				echo '<span class="article_time">'.$service_time->format('m-d h:m').'</span>';
				echo '<span class="article_office text-danger">'.$value->office_name.'</span>';
				echo '</div>';
				echo '</div><!-- article -->';
			}
			echo '<div class="articles_pages">';
			if ($start_page != 1) {
				$prev_page = $start_page - 1;
				if ($small_category_name != FALSE) {
					echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&date='.$date.'&page='.$prev_page.'" class="text-muted">< 이전</a>';
				} else if ($medium_category_name != FALSE) {
					echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$date.'&page='.$prev_page.'" class="text-muted">< 이전</a>';
				} else {
					echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&date='.$date.'&page='.$prev_page.'" class="text-muted">< 이전</a>';
				}
			}
			$end_page = $start_page + (int)ceil(count($articles) / 25) - 1;
			for ($p = $start_page; $p <= $end_page; ++$p) {
				if ($p == $page) {
					if ($small_category_name != FALSE) {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&date='.$date.'&page='.$p.'" class="text-danger"><strong>'.$p.'</strong></a>';
					} else if ($medium_category_name != FALSE) {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$date.'&page='.$p.'" class="text-danger"><strong>'.$p.'</strong></a>';
					} else {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&date='.$date.'&page='.$p.'" class="text-danger"><strong>'.$p.'</strong></a>';
					}
				} else {
					if ($small_category_name != FALSE) {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&date='.$date.'&page='.$p.'" class="text-muted">'.$p.'</a>';
					} else if ($medium_category_name != FALSE) {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$date.'&page='.$p.'" class="text-muted">'.$p.'</a>';
					} else {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&date='.$date.'&page='.$p.'" class="text-muted">'.$p.'</a>';
					}
				}
			}
			if ($end_page - $start_page == 9) {
				$next_page = $end_page + 1;
				if ($small_category_name != FALSE) {
					echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&date='.$date.'&page='.$next_page.'" class="text-muted">다음 ></a>';
				} else if ($medium_category_name != FALSE) {
					echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$date.'&page='.$next_page.'" class="text-muted">다음 ></a>';
				} else {
					echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&date='.$date.'&page='.$next_page.'" class="text-muted">다음 ></a>';
				}
			}
			echo '</div><!-- articles_pages -->';
			echo '<div class="articles_dates">';
			foreach ($dates as $value) {
				if ($value->day == $date) {
					if ($small_category_name != FALSE) {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&date='.$value->day.'" class="text-danger"><strong>'.$value->day.'</strong></a>';
					} else if ($medium_category_name != FALSE) {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$value->day.'" class="text-danger"><strong>'.$value->day.'</strong></a>';
					} else {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&date='.$value->day.'" class="text-danger"><strong>'.$value->day.'</strong></a>';
					}
				} else {
					if ($small_category_name != FALSE) {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&date='.$value->day.'" class="text-muted">'.$value->day.'</a>';
					} else if ($medium_category_name != FALSE) {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$value->day.'" class="text-muted">'.$value->day.'</a>';
					} else {
						echo '<a href="/index.php/news?big_category_name='.$big_category_name.'&date='.$value->day.'" class="text-muted">'.$value->day.'</a>';
					}
				}
			}
			echo '</div><!-- dates -->';
		} elseif (isset($article)) {
			echo '<div class="article_title"><h4>'.$article->title1.'</h4></div>';
			echo '<span class="article_time">'.$article->service_time.'</span>';
			echo '<span class="article_origin_url"><a href="'.$article->origin_url.'" target="_blank">아웃링크</a></span>';
			echo '<span class="article_scrap_count">스크랩수 : '.$article->scrap_count.'</span>';
			echo '<span class="article_reply_count">댓글수 : '.$article->reply_count.'</span>';
			echo '<div class="article_content">'.$article->content.'</div>';
			echo '<div class="article_reporter">'.$article->reporter.' 기자</div>';
			if ($article->outlink1_title != '' or $article->outlink2_title != '' or $article->outlink3_title != '' or $article->outlink4_title != '' or $article->outlink5_title != '') {
				echo '<div class="article_outlink"><h4>관련기사</h4>';
				if ($article->outlink1_title != '') {
					echo '<div class="article_outlink1">';
					echo '<a href="'.$article->outlink1_url.'" target="_blank">'.$article->outlink1_title.'</a>';
					echo '</div>';
				}
				if ($article->outlink2_title != '') {
					echo '<div class="article_outlink2">';
					echo '<a href="'.$article->outlink2_url.'" target="_blank">'.$article->outlink2_title.'</a>';
					echo '</div>';
				}
				if ($article->outlink3_title != '') {
					echo '<div class="article_outlink3">';
					echo '<a href="'.$article->outlink3_url.'" target="_blank">'.$article->outlink3_title.'</a>';
					echo '</div>';
				}
				if ($article->outlink4_title != '') {
					echo '<div class="article_outlink4">';
					echo '<a href="'.$article->outlink4_url.'" target="_blank">'.$article->outlink4_title.'</a>';
					echo '</div>';
				}
				if ($article->outlink5_title != '') {
					echo '<div class="article_outlink5">';
					echo '<a href="'.$article->outlink5_url.'" target="_blank">'.$article->outlink5_title.'</a>';
					echo '</div>';
				}
				echo '</div>';
			}
		}
		?>
		</div><!-- col-lg-10 or col-lg-12 -->
	</div><!-- row -->
</div> <!-- /container -->
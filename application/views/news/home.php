<div class="container">
	<div class="big_categories">
	<?php
		foreach ($big_categories as $big_category) {
			if ($big_category->name == $big_category_name) {
				$url = '/index.php/news?big_category_name='.$big_category->name;
				echo '<a href="'.$url.'" class="text-muted big_category_selected">'.$big_category->name.'</a>';
			}
		}
		foreach ($big_categories as $big_category) {
			if ($big_category->name != $big_category_name) {
				$url = '/index.php/news?big_category_name='.$big_category->name;
				echo '<a href="'.$url.'" class="text-muted big_category">'.$big_category->name.'</a>';
			}
		}
	?>
	</div>
	<!-- Static navbar -->
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
				<ul class="nav navbar-nav">
				<?php
					foreach ($medium_categories as $medium_category) {
						$url = '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category->name;
						if ($medium_category->name == $medium_category_name) {
							echo '<li class="active"><a href="'.$url.'" class="text-muted">'.$medium_category->name.'</a></li>';
						} else {
							echo '<li><a href="'.$url.'" class="text-muted">'.$medium_category->name.'</a></li>';
						}
					}
				?>
				</ul>
			</div><!--/.nav-collapse -->
		</div><!--/.container-fluid -->
	</div>
	<!-- Example row of columns -->
	<div class="row">
	<?php
		if (isset($small_categories)) {
			echo '<div class="small_categories">';
			echo '<div class="medium_category_name">'.$medium_category_name.'</div>';
			foreach ($small_categories as $small_category) {
				$url = '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category->name;
				if ($small_category_name != FALSE and $small_category->name == $small_category_name) {
					echo '<a href="'.$url.'" class="text-primary">'.$small_category->name.'</a><br />';
				} else {
					echo '<a href="'.$url.'" class="text-muted">'.$small_category->name.'</a><br />';
				}
			}
			echo '</div>';
			echo '<div class="with_small_categories">';
		} else {
			echo '<div class="without_small_categories">';
		}
		if (isset($small_clusters)) {
			echo '<div class="small_clusters">';
			function small_cluster_article_url($big_category_name, $small_cluster, $index) {
				return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$small_cluster->articles[$index]->medium_category_name.'&article_id='.$small_cluster->articles[$index]->id;
			}
			foreach ($small_clusters  as $small_cluster) {
			?>
				<div>
					<div>
						<div class="article_title">
							<a href="<?=small_cluster_article_url($big_category_name, $small_cluster, 0)?>"><?=$small_cluster->articles[0]->title1?></a>
						</div>
						<?php
							$dom = new DOMDocument();
							libxml_use_internal_errors(true);
							$dom->loadHTML('<?xml encoding="utf-8" ?>'.$small_cluster->articles[0]->content);
							if ($small_cluster->articles[0]->type == 'photo') {
								if ($dom->getElementsByTagName('img')->length > 0) {
									$img = $dom->getElementsByTagName('img')->item(0);
									echo '<div class="article_photo"><img src="'.$img->attributes->getNamedItem("src")->value.'" alt="..." class="img-thumbnail" /></div>';
								}
							}
						?>
						<div>
							<span class="stripped_article_content"><?=mb_substr(strip_tags($small_cluster->articles[0]->content), 0, 100)?>...</span>
							<?php
								$service_time = new DateTime($small_cluster->articles[0]->service_time);
								echo '<span class="article_time">'.$service_time->format('m-d h:m').'</span>';
								echo '<span class="text-danger">'.$small_cluster->articles[0]->office_name.'</span>';
							?>
						</div>
					</div>
					<?php
						for ($i = 1; $i < min(count($small_cluster->articles), $small_cluster->small_cluster_num_articles); ++$i) {
							echo '<div class="small_cluster_article"><img src="http://static.news.naver.net/image/news/2009/ico_list_sub2.gif" /><small>';
							echo '<a href="'.small_cluster_article_url($big_category_name, $small_cluster, $i).'"><span class="small_cluster_article_title">'.$small_cluster->articles[$i]->title1.'</span></a>';
							$service_time = new DateTime($small_cluster->articles[$i]->service_time);
							echo '<span class="article_time">'.$service_time->format('m-d h:m').'</span>';
							echo '<span class="text-danger">'.$small_cluster->articles[$i]->office_name.'</span>';
							echo '</small></div>';
						}
					?>
					<div class="small_cluster_view_large_cluster">
						<img src="http://static.news.naver.net/image/news/2009/ico_list_sub2.gif" />
						<a href=""><span class="text-muted">더보기</span></a>
					</div>
					<hr />
				</div>
			<?
			}
			echo '</div><!-- small_clusters -->';
		}
		if (isset($articles)) {
			$start_page = (int)(($page - 1) / 10) * 10 + 1;
			foreach (array_slice($articles, ($page - $start_page) * 25, 25) as $value) {
				echo '<div class="article">';
				if ($small_category_name != FALSE) {
					$url = '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&article_id='.$value->id;
				} elseif ($medium_category_name != FALSE) {
					$url = '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&article_id='.$value->id;
				} elseif ($value->medium_category_name != FALSE) {
					$url = '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$value->medium_category_name.'&article_id='.$value->id;
				} else {
					$url = '/index.php/news?big_category_name='.$big_category_name.'&article_id='.$value->id;
				}
				echo '<div class="article_title"><a href="'.$url.'">'.$value->title1.'</a></div>';
				$dom = new DOMDocument();
				libxml_use_internal_errors(true);
				$dom->loadHTML('<?xml encoding="utf-8" ?>'.$value->content);
				if ($value->type == 'photo') {
					if ($dom->getElementsByTagName('img')->length > 0) {
						$img = $dom->getElementsByTagName('img')->item(0);
						echo '<div class="article_photo"><img src="'.$img->attributes->getNamedItem("src")->value.'" alt="..." class="img-thumbnail" /></div>';
					}
				}
				echo '<div><span class="stripped_article_content">'.mb_substr(strip_tags($value->content), 0, 100).'…</span>';
				$service_time = new DateTime($value->service_time);
				echo '<span class="article_time">'.$service_time->format('m-d h:m').'</span>';
				echo '<span class="text-danger">'.$value->office_name.'</span>';
				echo '</div>';
				echo '</div><!-- article -->';
			}
			function page_url($small_category_name, $big_category_name, $medium_category_name, $date, $page) {
				if ($small_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&date='.$date.'&page='.$page;
				} else if ($medium_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$date.'&page='.$page;
				} else {
					return '/index.php/news?big_category_name='.$big_category_name.'&date='.$date.'&page='.$page;
				}
			}
			echo '<div class="articles_pages">';
			if ($start_page != 1) {
				$prev_page = $start_page - 1;
				$url = page_url($small_category_name, $big_category_name, $medium_category_name, $date, $prev_page);
				echo '<a href="'.$url.'" class="text-muted">< 이전</a>';
			}
			$end_page = $start_page + (int)ceil(count($articles) / 25) - 1;
			for ($p = $start_page; $p <= $end_page; ++$p) {
				$url = page_url($small_category_name, $big_category_name, $medium_category_name, $date, $p);
				if ($p == $page) {
					echo '<a href="'.$url.'" class="text-danger">'.$p.'</a>';
				} else {
					echo '<a href="'.$url.'" class="text-muted">'.$p.'</a>';
				}
			}
			if ($end_page - $start_page == 9) {
				$next_page = $end_page + 1;
				$url = page_url($small_category_name, $big_category_name, $medium_category_name, $date, $next_page);
				echo '<a href="'.$url.'" class="text-muted">다음 ></a>';
			}
			echo '</div><!-- articles_pages -->';			
			function date_url($small_category_name, $big_category_name, $medium_category_name, $date) {
				if ($small_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&date='.$date;
				} else if ($medium_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$date;
				} else {
					return '/index.php/news?big_category_name='.$big_category_name.'&date='.$date;
				}
			}
			echo '<div class="articles_dates">';
			foreach ($dates as $value) {
				$url = date_url($small_category_name, $big_category_name, $medium_category_name, $value->day);
				if ($value->day == $date) {
					echo '<a href="'.$url.'" class="text-danger">'.$value->day.'</a>';
				} else {
					echo '<a href="'.$url.'" class="text-muted">'.$value->day.'</a>';
				}
			}
			echo '</div><!-- dates -->';
		} elseif (isset($article)) {
			echo '<div class="article_title">'.$article->title1.'</div>';
			echo '<span class="article_time">'.$article->service_time.'</span>';
			echo '<span class="article_origin_url"><a href="'.$article->origin_url.'" target="_blank">아웃링크</a></span>';
			echo '<span class="article_scrap_count">스크랩수 : '.$article->scrap_count.'</span>';
			echo '<span>댓글수 : '.$article->reply_count.'</span>';
			echo '<div>'.$article->content.'</div>';
			echo '<div>'.$article->reporter.' 기자</div>';
			if ($article->outlink1_title != '' or $article->outlink2_title != '' or $article->outlink3_title != '' or $article->outlink4_title != '' or $article->outlink5_title != '') {
				echo '<div class="article_outlink">관련기사';
				if ($article->outlink1_title != '') {
					echo '<div><a href="'.$article->outlink1_url.'" target="_blank">'.$article->outlink1_title.'</a></div>';
				}
				if ($article->outlink2_title != '') {
					echo '<div><a href="'.$article->outlink2_url.'" target="_blank">'.$article->outlink2_title.'</a></div>';
				}
				if ($article->outlink3_title != '') {
					echo '<div><a href="'.$article->outlink3_url.'" target="_blank">'.$article->outlink3_title.'</a></div>';
				}
				if ($article->outlink4_title != '') {
					echo '<div><a href="'.$article->outlink4_url.'" target="_blank">'.$article->outlink4_title.'</a></div>';
				}
				if ($article->outlink5_title != '') {
					echo '<div><a href="'.$article->outlink5_url.'" target="_blank">'.$article->outlink5_title.'</a></div>';
				}
				echo '</div>';
			}
		}
		?>
		</div><!-- col-lg-10 or col-lg-12 -->
	</div><!-- row -->
</div> <!-- /container -->
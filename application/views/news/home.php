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
				if ($small_category_name != FALSE && $small_category->name == $small_category_name) {
					echo '<a href="'.$url.'" class="text-primary">'.$small_category->name.'</a><br />';
				} else {
					echo '<a href="'.$url.'" class="text-muted">'.$small_category->name.'</a><br />';
				}
			}
			echo '</div>';
			echo '<div class="with_small_categories">';
		} elseif (isset($offices) && isset($fields)) {
			?>
			<div class="small_categories">
				<div class="medium_category_name">
					<?=$medium_category_name?>
					<hr />
				</div>
				<div class="offices">
					언론사별
					<hr />
					<?php
						foreach ($offices as $office) {
							$url = '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_office='.$office->name;
							if ($selected_office != FALSE && $office->name == $selected_office) {
								?>
								<a href="<?=$url?>" class="text-strong"><?=$office->name?></a><br />
								<?php
							} else {
								?>
								<a href="<?=$url?>" class="text-muted"><?=$office->name?></a><br />
								<?php
							}
						}
					?>
				</div>
				<hr />
				<div class="fields">
					분야별
					<hr />
					<?php
						foreach ($fields as $field) {
							$url = '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_field='.$field->name;
							if ($selected_field != FALSE && $field->name == $selected_field) {
								?>
								<a href="<?=$url?>" class="text-strong"><?=$field->name?></a><br />
								<?php
							} else {
								?>
								<a href="<?=$url?>" class="text-muted"><?=$field->name?></a><br />
								<?php
							}
						}
					?>
				</div>
				<hr />
			</div><!-- offices_fields -->
			<div class="with_small_categories">
			<?php
		} else {
			echo '<div class="without_small_categories">';
			if (isset($small_cluster_dates)) {
				echo '<div class="small_cluster_dates">';
				foreach ($small_cluster_dates as $small_cluster_date) {
					$url = '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$small_cluster_date->day.'&timespan='.$timespan;
					$cluster_date = (new DateTime($small_cluster_date->day))->format('n월 j일(l)');
					if ($small_cluster_date->day == $date) {
						echo '<a href="'.$url.'" class="text-strong">'.$cluster_date.'</a>';
					} else {
						echo '<a href="'.$url.'" class="text-muted">'.$cluster_date.'</a>';
					}
				}
				echo '</div><!-- small_cluster_dates -->';
				echo '<div class="small_cluster_dates_timespan">';
				echo '<select id="dynamic_select">';
				$url = '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$date.'&timespan=';
				echo '<option '.($timespan == 6 ? 'selected' : '').' value="'.$url.'6">T + 6</option>';
				echo '<option '.($timespan == 12 ? 'selected' : '').' value="'.$url.'12">T + 12</option>';
				echo '<option '.($timespan == 18 ? 'selected' : '').' value="'.$url.'18">T + 18</option>';
				echo '<option '.($timespan == 24 ? 'selected' : '').' value="'.$url.'24">T + 24</option>';
				echo '</select>';
				echo '</div><!-- small_cluster_dates_timespan -->';
				echo '<div class="small_cluster_dates_hr">';
				echo '<hr />';
				echo '</div><!-- small_cluster_dates_hr -->';
			}
		}
		if (isset($small_clusters)) {
			echo '<div class="small_clusters">';
			function small_cluster_article_url($big_category_name, $small_cluster, $index)
			{
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
						<a href="/index.php/news?big_category_name=<?=$big_category_name?>&medium_category_name=<?=$small_cluster->medium_category_name?>&big_cluster_id=<?=$small_cluster->big_cluster_id?>"><span class="text-muted">더보기</span></a>
					</div>
					<hr />
				</div>
			<?
			}
			echo '</div><!-- small_clusters -->';
		}
		if (isset($articles)) {
			if ($selected_office != FALSE) {
				?>
				<div class="selected_office">
					<?=$selected_office?>
					<hr />
				</div><!-- selected_office -->
				<?php
			}
			if ($selected_field != FALSE) {
				?>
				<div class="selected_field">
					<?=$selected_field?>
					<hr />
				</div><!-- selected_field -->
				<?php
			}
			$start_page = (int)(($page - 1) / 10) * 10 + 1;
			function article_url($small_category_name, $selected_office, $selected_field, $big_category_name, $medium_category_name, $article)
			{
				if ($small_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&article_id='.$article->id;
				} elseif ($selected_office != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_office='.$selected_office.'&article_id='.$article->id;
				} elseif ($selected_field != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_field='.$selected_field.'&article_id='.$article->id;
				} elseif ($medium_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&article_id='.$article->id;
				} elseif ($article->medium_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$article->medium_category_name.'&article_id='.$article->id;
				} else {
					return '/index.php/news?big_category_name='.$big_category_name.'&article_id='.$article->id;
				}
			}
			foreach (array_slice($articles, ($page - $start_page) * 25, 25) as $article) {
				echo '<div class="article">';
				$url = article_url($small_category_name, $selected_office, $selected_field, $big_category_name, $medium_category_name, $article);
				echo '<div class="article_title"><a href="'.$url.'">'.$article->title1.'</a></div>';
				$dom = new DOMDocument();
				libxml_use_internal_errors(true);
				$dom->loadHTML('<?xml encoding="utf-8" ?>'.$article->content);
				if ($article->type == 'photo') {
					if ($dom->getElementsByTagName('img')->length > 0) {
						$img = $dom->getElementsByTagName('img')->item(0);
						echo '<div class="article_photo"><img src="'.$img->attributes->getNamedItem("src")->value.'" alt="..." class="img-thumbnail" /></div>';
					}
				}
				echo '<div><span class="stripped_article_content">'.mb_substr(strip_tags($article->content), 0, 100).'…</span>';
				$service_time = new DateTime($article->service_time);
				echo '<span class="article_time">'.$service_time->format('m-d h:m').'</span>';
				echo '<span class="text-danger">'.$article->office_name.'</span>';
				echo '</div>';
				echo '</div><!-- article -->';
			}
			function page_url($small_category_name, $selected_office, $selected_field, $big_category_name, $medium_category_name, $date, $page)
			{
				if ($small_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&date='.$date.'&page='.$page;
				} elseif ($selected_office != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_office='.$selected_office.'&date='.$date.'&page='.$page;
				} elseif ($selected_field != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_field='.$selected_field.'&date='.$date.'&page='.$page;
				} elseif ($medium_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$date.'&page='.$page;
				} else {
					return '/index.php/news?big_category_name='.$big_category_name.'&date='.$date.'&page='.$page;
				}
			}
			echo '<div class="articles_pages">';
			if ($start_page != 1) {
				$prev_page = $start_page - 1;
				$url = page_url($small_category_name, $selected_office, $selected_field, $big_category_name, $medium_category_name, $date, $prev_page);
				echo '<a href="'.$url.'" class="text-muted">< 이전</a>';
			}
			$end_page = $start_page + min((int)ceil(count($articles) / 25) - 1, 9);
			for ($p = $start_page; $p <= $end_page; ++$p) {
				$url = page_url($small_category_name, $selected_office, $selected_field, $big_category_name, $medium_category_name, $date, $p);
				if ($p == $page) {
					echo '<a href="'.$url.'" class="text-danger">'.$p.'</a>';
				} else {
					echo '<a href="'.$url.'" class="text-muted">'.$p.'</a>';
				}
			}
			if ($end_page - $start_page == 9) {
				$next_page = $end_page + 1;
				$url = page_url($small_category_name, $selected_office, $selected_field, $big_category_name, $medium_category_name, $date, $next_page);
				echo '<a href="'.$url.'" class="text-muted">다음 ></a>';
			}
			echo '</div><!-- articles_pages -->';
			function date_url($small_category_name, $selected_office, $selected_field, $big_category_name, $medium_category_name, $date)
			{
				if ($small_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&date='.$date;
				} elseif ($selected_office != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_office='.$selected_office.'&date='.$date;
				} elseif ($selected_field != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_field='.$selected_field.'&date='.$date;
				} elseif ($medium_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&date='.$date;
				} else {
					return '/index.php/news?big_category_name='.$big_category_name.'&date='.$date;
				}
			}
			echo '<div class="articles_dates">';
			foreach ($articles_dates as $articles_date) {
				$url = date_url($small_category_name, $selected_office, $selected_field, $big_category_name, $medium_category_name, $articles_date->day);
				if ($articles_date->day == $date) {
					echo '<a href="'.$url.'" class="text-danger">'.$articles_date->day.'</a>';
				} else {
					echo '<a href="'.$url.'" class="text-muted">'.$articles_date->day.'</a>';
				}
			}
			echo '</div><!-- articles_dates -->';
		} elseif (isset($tv_articles)) {
			?>
			<div class="tv_articles">
			<?php			
			function article_url($small_category_name, $selected_office, $selected_field, $big_category_name, $medium_category_name, $article)
			{
				if ($small_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&small_category_name='.$small_category_name.'&article_id='.$article->id;
				} elseif ($selected_office != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_office='.$selected_office.'&article_id='.$article->id;
				} elseif ($selected_field != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_field='.$selected_field.'&article_id='.$article->id;
				} elseif ($medium_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&article_id='.$article->id;
				} elseif ($article->medium_category_name != FALSE) {
					return '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$article->medium_category_name.'&article_id='.$article->id;
				} else {
					return '/index.php/news?big_category_name='.$big_category_name.'&article_id='.$article->id;
				}
			}
			for ($i = 0; $i < 9; ++$i) {
				?>
				<div class="field">
				<?php
				$field = $fields[$i];
				$url = '/index.php/news?big_category_name='.$big_category_name.'&medium_category_name='.$medium_category_name.'&selected_field='.$field->name;
				?>
				<a href="<?=$url?>" class="text-muted"><?=$field->name?></a>
				<img src="http://static.news.naver.net/image/news/2009/ico_arrow_3x6_4.gif" /><br />
				<?php
				for ($j = 0; $j < 4; ++$j) {
					?>
					<div class="tv_article">
					<?php
					$tv_article = $tv_articles[$i * 4 + $j];
					$url = article_url($small_category_name, $selected_office, $selected_field, $big_category_name, $medium_category_name, $tv_article);
					$dom = new DOMDocument();
					libxml_use_internal_errors(true);
					$dom->loadHTML('<?xml encoding="utf-8" ?>'.$tv_article->content);
					if ($dom->getElementsByTagName('img')->length > 0) {
						$img = $dom->getElementsByTagName('img')->item(0);
						?>
						<div class="tv_article_photo">
							<a href="<?=$url?>"><img src="<?=$img->attributes->getNamedItem("src")->value?>" class="img-rounded" /></a>
						</div>
						<?php
					} else {
						?>
						<div class="tv_article_photo">
							<a href="<?=$url?>"><img src="http://www.cantando.com/Content/images/NoImage.gif" class="img-rounded" /></a>
						</div>
						<?php
					}
					?>
					<?=$tv_article->title1?>
					</div><!-- tv_article -->
					<?php
				}
				?>
				</div><!-- field -->
				<?php
			}
			?>
			</div><!-- tv_articles -->
			<?php
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
</div><!-- /container -->
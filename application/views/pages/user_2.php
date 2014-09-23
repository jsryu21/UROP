<div class="container">
	<div class="user_invitation_ment"><h3>친구들을 checkee로 초대해 당신의 매력과 단점을 체크해보세요.</h3></div>
	<div class="user_invitation_url">
		<div class="user_invitation_url_box"><input type="text" size="70" value="<?=$this->config->item('base_url').'/user/'.$current_facebook_id?>" /></div>
		<div class="user_invitation_url_copy_button"><input type="button" value="복사" onclick="copyToClipboard('<?=$this->config->item('base_url').'/user/'.$current_facebook_id?>')" /></div>
		<div class="user_invitation_url_facebook_share_button"><div class="fb-share-button" data-href="<?=$this->config->item('base_url').'/user/'.$current_facebook_id?>" data-type="button"></div></div>
	</div>
	<div class="user_my_checks_ment"><h3>내가 받은 평가</h3></div>
	<div class="user_img"><img src="<?=$picture?>" /></div>
	<div class="user_brief">
		<div class="user_ment">
			<div class="user_name"><?=$name?>를  <?=(int)$num_checks?>명이 평가함</div>
		</div>
		<div class="user_average_rating">
			<div class="user_average_rating_same_gender">동성친구<span class="starRating"><span style="width:<?=$same_gender_average_rating?>%"><?=$same_gender_average_rating?>점</span></span></div>
			<div class="user_average_rating_diff_gender">이성친구 및 연인<span class="starRating"><span style="width:<?=$diff_gender_average_rating?>%"><?=$diff_gender_average_rating?>점</span></span></div>
			<div class="user_average_rating_collegue">동료<span class="starRating"><span style="width:<?=$colleague_average_rating?>%"><?=$colleague_average_rating?>점</span></span></div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-md-6">
			<div class="user_pros_ment">매력</div>
			<?php
				foreach ($pros as $key => $value) {
					$font_size = (int)$value + 5;
			?>
				<span class="user_pros_element"><font size="<?=$font_size?>"><?=$key?></font></span>
			<?php
				}
			?>
		</div>
		<div class="col-xs-6 col-md-6">
			<div class="user_cons_ment">단점</div>
			<?php
				foreach ($cons as $key => $value) {
					$font_size = (int)$value + 5;
			?>
				<span class="user_cons_element"><font size="<?=$font_size?>"><?=$key?></font></span>
			<?php
				}
			?>
		</div>
	</div>
	<div class="user_comments">
		<div class="user_comments_ment">한줄평(<?=(int)$num_comments?>)</div>
		<div class="user_comments_elements">
		<?php
			foreach ($comments as $value) {
		?>
			<div class="user_comments_element">"<?=$value?>"</div>
		<?php
			}
		?>
		</div>
		<div class="user_comments_more"><a href="/index.php/detail/<?=$current_facebook_id?>" class="btn btn-primary">더 자세히 보기</a></div>
	</div>
</div>
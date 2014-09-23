<img src="<?=$picture?>" /><?=$name?><a href="/index.php/check/<?=$url_facebook_id?>"><button type="button">평가하기</button></a>
<div class="container">
	<div class="user_img"><img src="<?=$picture?>" /></div>
	<div class="user_brief">
		<div class="user_ment">
			<div class="user_name"><?=$name?>를  <?=(int)$num_checks?>명이 평가함</div>
			<div class="user_check_button"><a href="/index.php/check/<?=$url_facebook_id?>" class="btn btn-primary">평가하기</a></div>
		</div>
		<div class="user_average_rating">
			<div class="user_average_rating_same_gender">동성친구<span class="starRating"><span style="width:<?=$same_gender_average_rating?>%"><?=$same_gender_average_rating?>점</span></span></div>
			<div class="user_average_rating_diff_gender">이성친구 및 연인<span class="starRating"><span style="width:<?=$diff_gender_average_rating?>%"><?=$diff_gender_average_rating?>점</span></span></div>
			<div class="user_average_rating_collegue">동료<span class="starRating"><span style="width:<?=$colleague_average_rating?>%"><?=$colleague_average_rating?>점</span></span></div>
		</div>
	</div>
	<div class="user_greeting_header">
		<h4>CHECK-IN</h4>
	</div>
	<div class="user_greeting_body">
		평가를 남기고 좀 더 알아보세요!
	</div>
</div>
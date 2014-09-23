<div class="container">
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
	<div class="user_greeting_header">
		<h4>CHECK-IN</h4>
	</div>
	<div class="user_greeting_body">
		친구가 어떤은 평가, 궁금하신가요?<br />
		다른 사람들이 남긴 체크에는 단점, 매력, 사적인 정보 등이 포함되어 있습니다.<br />
		로그인 한 뒤, 친구를 체크하세요!
	</div>
	<div class="user_facebook_login_img">
		<a href="<?=$login_url?>"><img src="https://www.socialfunch.org/resources/images/button_facebook_login.png" /></a>
	</div>
	<div class="user_main_img">
		<img src="http://www.babynamespedia.com/a/v/0/Checkee.00.png" />
	</div>
</div>
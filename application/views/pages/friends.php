<div class="container">
	<div style="height: 240px;background-color: #333333;">
		<div style="padding-top: 50px;padding-left: 100px;padding-bottom: 30px;"><h3><span style="color: white;">나를 잘 아는 친구들, 내가 좋아하는 친구들을 Checkee로 초대하세요.</span></h3></div>
		<div style="text-align: center;">
			<img src="/images/2-1.png" onclick="
			FB.ui(
			{
				method: 'share',
				href: '<?=$this->config->item('base_url').'/user/'.$current_facebook_id?>'
			}, function(response){});" />
			<input style="height: 52px;" type="text" size="60" value="<?=$this->config->item('base_url').'/user/'.$current_facebook_id?>" />
			<img src="/images/2-2.png" onclick="copyToClipboard('<?=$this->config->item('base_url').'/user/'.$current_facebook_id?>')" />
		</div>
	</div>
	<?php
		if (count($friends) > 0) {
	?>
	<div class="friends_list_ment">
		<h3>Checkee를 사용하는 친구들입니다. 어떤 사람인지 체크해주세요.</h3>
	</div>
	<?php
		foreach ($friends as $key => $value) {
			$average_rating = $value->average_rating * 10;
	?>
	<div class="friends_list_element">
		<div class="friends_list_element_img"><img src="<?=$value->picture?>" /></div>
		<div class="friends_list_element_name"><a href="/index.php/user/<?=$value->facebook_id?>"><?=$value->name?></a></div>
		<div class="friends_list_element_average_rating"><span class="starRating"><span style="width:<?=$average_rating?>%"><?=$average_rating?>점</span></span></div>
	</div>
	<?php
		}
		}
	?>
</div>
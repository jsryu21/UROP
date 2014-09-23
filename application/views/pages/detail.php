<div class="container">
	<div class="detail_ment"><h3><?=$user->name?> > 한줄평(<?=count($checks)?>)</h3></div>
	<?php
		foreach ($checks as $value) {
			$rating = $value->rating * 10;
	?>
		<div class="detail_element">
			<div class="detail_element_content">
				<div class="detail_element_content_img"><img src="<?=$user->picture?>" /></div>
				<div class="detail_element_content_core">
					<div>
						<div class="detail_element_name"><?=$value->last_name?>모 씨 (<?=$this->relationship_model->get_relationship($value->relationship_id)?>)</div>
						<div class="detail_element_updated"><?=$value->updated?></div>
					</div>
					<div>
						<div class="detail_element_rating"><span class="starRating"><span style="width:<?=$rating?>%"><?=$rating?>점</span></span></div>
						<div class="detail_element_pros">
							<span class="detail_element_pros_element"><?=$value->pros_1?></span>
							<span class="detail_element_pros_element"><?=$value->pros_2?></span>
							<span class="detail_element_pros_element"><?=$value->pros_3?></span>
						</div>
						<div class="detail_element_cons">
							<span class="detail_element_cons_element"><?=$value->cons_1?></span>
							<span class="detail_element_cons_element"><?=$value->cons_2?></span>
							<span class="detail_element_cons_element"><?=$value->cons_3?></span>
						</div>
					</div>
					<?php
						if ($value->comment != '') {
					?>
					<div class="detail_element_comment"><?=$value->comment?></div>
					<?php
						}
					?>
				</div>
			</div>
			<div class="detail_element_vote">
				<div class="detail_element_vote_yes">
					<div class="detail_element_vote_yes_img"><img id="<?=$value->check_id?>" src="http://www.estien.com/images/heart.gif" /></div>
					<div class="detail_element_vote_yes_count"><?=$value->agree?></div>
				</div>
				<div class="detail_element_vote_no">
					<div class="detail_element_vote_no_img"><img id="<?=$value->check_id?>" src="http://www.dongbusonsa.com/images/common/btn/btns_laylkclose.gif" /></div>
					<div class="detail_element_vote_no_count"><?=$value->disagree?></div>
				</div>
			</div>
		</div>
	<?php
		}
	?>
</div>
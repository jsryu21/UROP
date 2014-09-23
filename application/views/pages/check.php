<div class="container">
<form action="/index.php/check_submit" method="post">
<input type="hidden" name="url_user_id" value="<?=$url_user->user_id?>" />
<input type="hidden" name="url_facebook_id" value="<?=$url_user->facebook_id?>" />
<input type="hidden" name="current_user_id" value="<?=$current_user_id?>" />
평판을 남긴 뒤, 다른 평판들도 자세하게 확인할 수 있습니다.<br />
<img src="<?=$url_user->picture?>" />[필수]<?=$url_user->name?>는 나의
<select name="relationship_id">
<?php
	foreach ($relationships as $relationship) {
		echo '<option value="'.$relationship->relationship_id.'">'.$relationship->string.'</option>';
	}
?>
</select>
입(였습)니다.<br />
total
<?php
	for ($i = 0; $i <= 10; ++$i) {
		echo '<input type="radio" name="rating" value="'.$i.'" />';
	}
?>
<br />
[필수]지인을 표현할 수 있는 단어를 박스에서 3개씩 고르거나, 직접 입력해주세요<br />
<?php
	foreach ($pros as $p) {
		echo '<div class="pros">'.$p->string.'</div>';
	}
?>
<input type="text" name="pros_1" />
<input type="text" name="pros_2" />
<input type="text" name="pros_3" />
<?php
	foreach ($cons as $c) {
		echo '<div class="cons">'.$c->string.'</div>';
	}
?>
<input type="text" name="cons_1" />
<input type="text" name="cons_2" />
<input type="text" name="cons_3" /><br />
한줄평<input type="text" name="comment" size="80" value="" /><br />
<input type="submit" value="평판 제출" />
</form>
</div>
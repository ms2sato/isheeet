<h2>Editing <span class='muted'>Introduction</span></h2>
<br>

<?php echo render('introduction/_form'); ?>
<p>
	<?php echo Html::anchor('introduction/view/'.$introduction->id, 'View'); ?> |
	<?php echo Html::anchor('introduction', 'Back'); ?></p>

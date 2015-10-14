<h2>Editing <span class='muted'>Introduction</span></h2>
<br>

<?php echo render('introducer/introduction/_form'); ?>
<p>
	<?php echo Html::anchor('introducer/introduction/view/'.$introduction->id, 'View'); ?> |
	<?php echo Html::anchor('introducer/introduction', 'Back'); ?></p>

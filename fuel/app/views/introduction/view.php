<h2>Viewing <span class='muted'>#<?php echo $introduction->id; ?></span></h2>

<p>
	<strong>Introducer id:</strong>
	<?php echo $introduction->introducer_id; ?></p>
<p>
	<strong>Catchphrase:</strong>
	<?php echo $introduction->catchphrase; ?></p>
<p>
	<strong>Body:</strong>
	<?php echo $introduction->body; ?></p>
<p>
	<strong>Image key:</strong>
	<?php echo $introduction->image_key; ?></p>

<?php echo Html::anchor('introduction', 'Back'); ?>

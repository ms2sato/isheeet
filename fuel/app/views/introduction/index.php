<h2>Listing <span class='muted'>Introductions</span></h2>
<br>
<?php if ($introductions): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Introducer id</th>
			<th>Catchphrase</th>
			<th>Body</th>
			<th>Image</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($introductions as $item): ?>		<tr>

			<td><?php echo $item->introducer_id; ?></td>
			<td><?php echo $item->catchphrase; ?></td>
			<td><?php echo $item->body; ?></td>
			<td>
				<div class="card" style="background-image: url(/upload/<?php echo $item->image_key ?>)">
				</div>

			</td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?php echo Html::anchor('introduction/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Introductions.</p>

<?php endif; ?>

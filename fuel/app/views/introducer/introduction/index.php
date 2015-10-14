<h2>Listing <span class='muted'>Introductions</span></h2>
<br>
<?php if ($introductions): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Introducer id</th>
			<th>Cachphrase</th>
			<th>Body</th>
			<th>Image key</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($introductions as $item): ?>		<tr>

			<td><?php echo $item->introducer_id; ?></td>
			<td><?php echo $item->cachphrase; ?></td>
			<td><?php echo $item->body; ?></td>
			<td><?php echo $item->image_key; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?php echo Html::anchor('introducer/introduction/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>
						<?php echo Html::anchor('introducer/introduction/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-default btn-sm')); ?>
						<?php echo Html::anchor('introducer/introduction/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>					</div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Introductions.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('introducer/introduction/create', 'Add new Introduction', array('class' => 'btn btn-success')); ?>

</p>

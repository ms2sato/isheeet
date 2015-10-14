<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Introducer id', 'introducer_id', array('class'=>'control-label')); ?>

				<?php echo Form::input('introducer_id', Input::post('introducer_id', isset($introduction) ? $introduction->introducer_id : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Introducer id')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Cachphrase', 'cachphrase', array('class'=>'control-label')); ?>

				<?php echo Form::input('cachphrase', Input::post('cachphrase', isset($introduction) ? $introduction->cachphrase : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Cachphrase')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Body', 'body', array('class'=>'control-label')); ?>

				<?php echo Form::textarea('body', Input::post('body', isset($introduction) ? $introduction->body : ''), array('class' => 'col-md-8 form-control', 'rows' => 8, 'placeholder'=>'Body')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Image key', 'image_key', array('class'=>'control-label')); ?>

				<?php echo Form::input('image_key', Input::post('image_key', isset($introduction) ? $introduction->image_key : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Image key')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>
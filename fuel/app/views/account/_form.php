<?php echo Form::open(array("class"=>"form-horizontal")); ?>
	<?php echo \Form::csrf(); ?>
	<fieldset>
    <div class="form-group">
			<?php echo Form::label('名前', 'name', array('class'=>'control-label')); ?>
      <?php echo Form::input('name', Input::post('name', isset($account) ? $account->name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'名前')); ?>
		</div>
    <div class="form-group">
			<?php echo Form::label('e-mail', 'email', array('class'=>'control-label')); ?>
      <?php echo Form::input('email', Input::post('name', isset($account) ? $account->email : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'e-mail')); ?>
		</div>
    <div class="form-group">
			<?php echo Form::label('パスワード', 'password', array('class'=>'control-label')); ?>
      <?php echo Form::password('password', Input::post('password', ''), array('class' => 'col-md-4 form-control')); ?>
		</div>
		<div class="form-group">
			<?php echo Form::label('プロフィール', 'profile', array('class'=>'control-label')); ?>
      <?php echo Form::textarea('profile', Input::post('profile', isset($account) ? $account->profile : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'プロフィール', 'rows'=>"5")); ?>
		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>

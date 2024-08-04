<?php View()->layout('admin::layouts.dashboard'); ?>

<?php View()->section('page_title'); ?>
<?php _e('Change Password'); ?>
<?php View()->close('page_title'); ?>

<?php View()->section('main_content'); ?>

<div class="row">
	<div class="col-md-8">
		<div class="card shadow mb-4">
		    <div class="card-header py-3">
		      <h6 class="m-0 font-weight-bold text-primary">Change password</h6>
		    </div>
		    <div class="card-body">
				
				<?php Form::patch(url('change_password_update')); ?>

					<div class="form-group">
						<?php Form::label('old_password', 'Old Password'); ?>
	                  	<?php $error = get_error('old_password') ? 'is-invalid' : false;
	                   Form::password('old_password',[
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'Old Password',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('old_password'); ?>

					</div>

					<div class="form-group">
						<?php Form::label('new_password', 'New Password'); ?>
	                  	<?php $error = get_error('new_password') ? 'is-invalid' : false;
	                   Form::password('new_password',[
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'New Password',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('new_password'); ?>
					</div>

					<div class="form-group">
						<?php Form::label('confirm_password', 'Confirm Password'); ?>
	                  	<?php $error = get_error('confirm_password') ? 'is-invalid' : false;
	                   Form::password('confirm_password',[
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'Confirm Password',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('confirm_password'); ?>	
					</div>

					<?php Form::button('Submit', ['class' => 'btn btn-primary']); ?>
				<?php Form::close(); ?> 
		    </div>
		  </div>
	  </div>
  </div>


<?php View()->close('main_content'); ?>

<?php View()->exe(); ?>
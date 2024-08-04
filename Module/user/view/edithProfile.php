<?php View()->layout('admin::layouts.dashboard'); ?>

<?php View()->section('page_title'); ?>
<?php _e('Edith profile'); ?>
<?php View()->close('page_title'); ?>

<?php View()->section('main_content'); ?>

<div class="row">
	<div class="col-md-8">
		<div class="card shadow mb-4">
		    <div class="card-header py-3">
		      <h6 class="m-0 font-weight-bold text-primary">Edith profile</h6>
		    </div>
		    <div class="card-body">
				
				<?php Form::patch(url('edit_profile_update')); ?>

					<div class="form-group">
						<?php Form::label('first_name', 'First name'); ?>
	                  	<?php $error = get_error('first_name') ? 'is-invalid' : false;
	                   Form::text('first_name', '',[
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'First name',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('first_name'); ?>

					</div>

					<div class="form-group">
						<?php Form::label('last_name', 'New Password'); ?>
	                  	<?php $error = get_error('last_name') ? 'is-invalid' : false;
	                   Form::text('last_name', '', [
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'New Password',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('last_name'); ?>
					</div>

					<div class="form-group">
						<?php Form::label('display_name', 'Display name'); ?>
	                  	<?php $error = get_error('display_name') ? 'is-invalid' : false;
	                   Form::text('display_name', '', [
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'Display name',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('display_name'); ?>	
					</div>

					<div class="form-group">
						<?php Form::label('username', 'Username'); ?>
	                  	<?php $error = get_error('username') ? 'is-invalid' : false;
	                   Form::text('username', '', [
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'Username',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('username'); ?>	
					</div>

					<div class="form-group">
						<?php Form::label('email', 'Email'); ?>
	                  	<?php $error = get_error('email') ? 'is-invalid' : false;
	                   Form::email('email', '', [
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'Email',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('email'); ?>	
					</div>

					<div class="form-group">
						<?php Form::label('modile', 'Modile number'); ?>
	                  	<?php $error = get_error('modile') ? 'is-invalid' : false;
	                   Form::text('modile', '', [
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'Modile number',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('modile'); ?>	
					</div>

					<div class="form-group">
						<?php Form::label('password', 'Password'); ?>
	                  	<?php $error = get_error('password') ? 'is-invalid' : false;
	                   Form::password('password', [
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'Password',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('password'); ?>	
					</div>

					<div class="form-group">
						<?php Form::label('confirm_password', 'Confirm Password'); ?>
	                  	<?php $error = get_error('confirm_password') ? 'is-invalid' : false;
	                   Form::password('confirm_password', [
	                      'class' => 'form-control form-control-user '.$error,
	                      'placeholder' => 'Confirm Password',
	                    ]); ?>
	                  	<?php Form::bootstrap_field_error('password'); ?>	
					</div>

					<?php Form::button('Submit', ['class' => 'btn btn-primary']); ?>
				<?php Form::close(); ?> 
		    </div>
		  </div>
	  </div>
  </div>


<?php View()->close('main_content'); ?>

<?php View()->exe(); ?>
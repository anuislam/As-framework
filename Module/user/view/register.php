<?php get_view_part('inc.header'); ?>

<?php get_view_part('inc.navbar'); ?>


    <div class="container">







<div class="text-center">
    <h1 class="h4 text-gray-900 mb-4"><?php _e('Welcome to our website!'); ?></h1>
</div>


        <div class="row justify-content-center">
            <div class="col-md-4"> 



<?php Form::put(url('register_action'), ['class' => 'user']); ?>

   <div class="form-group">

      <?php Form::label('first_name', __('First name'), [
                                'class' => 'form-label'
                            ]); ?>
      <?php  $error = get_error('first_name') ? 'is-invalid' : false; ?>
      <?php Form::text('first_name', field_data('first_name'), [
         'class'        => 'form-control form-control-user '. $error,
         'placeholder'  => __('First name'),
      ]); ?>
      <?php Form::bootstrap_field_error('first_name'); ?>

   </div>

   <div class="form-group">
      <?php Form::label('last_name', __('Last name'), [
                                'class' => 'form-label'
                            ]); ?>
      <?php  $error = get_error('last_name') ? 'is-invalid' : false; ?>
      <?php Form::text('last_name', field_data('last_name'), [
         'class'        => 'form-control form-control-user '. $error,
         'placeholder'  => __('Last name'),
      ]); ?>
      <?php Form::bootstrap_field_error('last_name'); ?>

   </div>

   <div class="form-group">
      <?php Form::label('username', __('Username'), [
                                'class' => 'form-label'
                            ]); ?>
      <?php  $error = get_error('username') ? 'is-invalid' : false; ?>
      <?php Form::text('username', field_data('username'), [
         'class'        => 'form-control form-control-user '. $error,
         'placeholder'  => __('Username'),
      ]); ?>
      <?php Form::bootstrap_field_error('username'); ?>

   </div>
   
   <div class="form-group">
      <?php Form::label('email', __('Enter Email Address...'), [
                                'class' => 'form-label'
                            ]); ?>
      <?php  $error = get_error('email') ? 'is-invalid' : false; ?>
      <?php Form::email('email', field_data('email'), [
         'class'        => 'form-control form-control-user '. $error,
         'placeholder'  => __('Enter Email Address...'),
      ]); ?>
      <?php Form::bootstrap_field_error('email'); ?>

   </div>

   <div class="form-group">
      <?php Form::label('password', __('Password'), [
                                'class' => 'form-label'
                            ]); ?>
      <?php  $error = get_error('password') ? 'is-invalid' : false; ?>
      <?php Form::password('password', [
         'class'        => 'form-control form-control-user '. $error,
         'placeholder'  => __('Password'),
      ]); ?>
      <?php Form::bootstrap_field_error('password'); ?>

   </div>

   <div class="form-group">
      <?php Form::label('confirm_password', __('Confirm Password'), [
                                'class' => 'form-label'
                            ]); ?>
      <?php  $error = get_error('confirm_password') ? 'is-invalid' : false; ?>
      <?php Form::password('confirm_password', [
         'class'        => 'form-control form-control-user '. $error,
         'placeholder'  => __('Confirm Password'),
      ]); ?>
      <?php Form::bootstrap_field_error('confirm_password'); ?>

   </div>
   <div class="form-group">
      <?php Form::label('mobile', __('Mobile number'), [
                                'class' => 'form-label'
                            ]); ?>
      <?php  $error = get_error('mobile') ? 'is-invalid' : false; ?>
      <?php Form::text('mobile', field_data('mobile'), [
         'class'        => 'form-control form-control-user '. $error,
         'placeholder'  => __('Mobile number'),
      ]); ?>
      <?php Form::bootstrap_field_error('mobile'); ?>
   </div>
   <?php Form::button(__('Register'), ['class' => 'btn btn-primary btn-user btn-block mt-3']); ?>
   <hr>
   
 <?php get_view_part('user::socialLogInbutton'); ?>


<?php Form::close(); ?>
   </div>
</div>


   <hr>
   <div class="text-center">
       <a class="small" href="<?php echo url('login'); ?>"><?php _e('Login'); ?></a>
   </div>
   <div class="text-center">
       <a class="small" href="<?php echo url('forgot_password'); ?>"><?php _e('Forgot Password?'); ?></a>
   </div>






    </div>



<?php get_view_part('inc.footer'); ?>
<?php get_view_part('inc.header'); ?>

<?php get_view_part('inc.navbar'); ?>

<div class="text-center">
    <h1 class="h4 text-gray-900 mb-4"><?php _e('Reset Your Password?'); ?></h1>
</div>

<?php Form::patch(url('reset_password_action'), ['class' => 'user']); ?>
   <input type="hidden"  value="<?php echo Input::get('email'); ?>" name="email"> 
   <input type="hidden"  value="<?php echo Input::get('token'); ?>" name="token">
   <div class="form-group">

      <?php  $error = get_error('password') ? 'is-invalid' : false; ?>
      <?php Form::password('password', [
         'class'        => 'form-control form-control-user '. $error,
         'placeholder'  => __('New password'),
      ]); ?>
      <?php Form::bootstrap_field_error('password'); ?>

   </div>
   <div class="form-group">

      <?php  $error = get_error('confirm_password') ? 'is-invalid' : false; ?>
      <?php Form::password('confirm_password', [
         'class'        => 'form-control form-control-user '. $error,
         'placeholder'  => __('Confirm password'),
      ]); ?>
      <?php Form::bootstrap_field_error('confirm_password'); ?>

   </div>
      <?php Form::button(__('Reset Password'), ['class' => 'btn btn-primary btn-user btn-block']); ?>
   <hr>
   
<?php get_view_part('user::socialLogInbutton'); ?>
 
<?php Form::close(); ?>

   <hr>
   <div class="text-center">
       <a class="small" href="<?php echo url('login'); ?>"><?php _e('Login?'); ?></a>
   </div>
   <div class="text-center">
       <a class="small" href="<?php echo url('register'); ?>"><?php _e('Create an Account!'); ?></a>
   </div>


<?php get_view_part('inc.footer'); ?>
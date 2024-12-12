<?php get_view_part('inc.header'); ?>

<?php get_view_part('inc.navbar'); ?>

<div class="text-center">
    <h1 class="h4 text-gray-900 mb-4"><?php _e('Forgot Password?'); ?></h1>
    <p class="mb-4">
        <?php _e("We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!"); ?>
    </p>

</div>

<?php Form::patch(url('forgot_password_action'), ['class' => 'user']); ?>

    <div class="form-group">

      <?php  $error = get_error('user') ? 'is-invalid' : false; ?>
      <?php Form::text('user', field_data('user'), [
         'class'        => 'form-control form-control-user '. $error,
         'placeholder'  => __('Username or Email Address...'),
      ]); ?>
      <?php Form::bootstrap_field_error('user'); ?>

    </div>


    <?php Form::button(__('Send me'), ['class' => 'btn btn-primary btn-user btn-block mt-3']); ?>
    
    <hr>
    
    <?php get_view_part('user::socialLogInbutton'); ?>

<?php Form::close(); ?>

   <hr>
   <div class="text-center">
       <a class="small" href="<?php echo url('login'); ?>"><?php _e('Login'); ?></a>
   </div>
   <div class="text-center">
       <a class="small" href="<?php echo url('register'); ?>"><?php _e('Create an Account!'); ?></a>
   </div>

<?php get_view_part('inc.footer'); ?>
<?php get_view_part('inc.header'); ?>

<?php get_view_part('inc.navbar'); ?>




    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">        
                <?php Form::post(url('login_action')); ?>


                   <div class="form-group mb-3">

                      <?php  $error = get_error('user') ? 'is-invalid' : false; ?>
                      <?php Form::label('user', __('Email address...'), [
                                'class' => 'form-label'
                            ]); ?>
                      <?php Form::email('user', field_data('user'),[
                         'class'        => 'form-control form-control-user '. $error,
                         'placeholder'  => __('Email address...'),
                      ]); ?>
                      <?php Form::bootstrap_field_error('user'); ?>

                   </div>

                   <div class="form-group mb-3">

                      <?php  $error = get_error('password') ? 'is-invalid' : false; ?>
                      <?php Form::label('password', __('Password'), [
                                'class' => 'form-label'
                            ]); ?>
                      <?php Form::password('password', [
                         'class'        => 'form-control form-control-user '. $error,
                         'placeholder'  => __('Password'),
                      ]); ?>
                      <?php Form::bootstrap_field_error('password'); ?>

                   </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                        <label class="form-check-label" for="remember_me">Remember me</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>

                <?php Form::close(); ?>
            </div> 
        </div>
    </div>



<?php get_view_part('inc.footer'); ?>
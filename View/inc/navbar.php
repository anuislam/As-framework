    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
          <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">

            <i class="fas fa-code bi me-2" width="40" height="32"></i>

            <span class="fs-4">As-framework</span>
          </a>

          <ul class="nav nav-pills">
            <?php if (Auth::check()) : ?>


              <li class="nav-item">
                  <a href="<?php echo url('profile'); ?>" class="nav-link">

                    <?php echo User()->display_name; ?>

                  </a>
              </li>

              <li class="nav-item">
                  <a href="<?php echo url('profile'); ?>" class="nav-link">
                    <?php Form::delete('logout'); ?>
                    <button type="submit">logout</button>
                    <?php Form::close(); ?>
                  </a>

              </li>
              <li class="nav-item">
                <a href="<?php echo url('profile'); ?>">
                  <img src="<?php echo gravatar(User()->email, 50) ?>" alt="<?php echo User()->display_name; ?>" class="img-thumbnail rounded-circle" width="50" height="50">
                </a>
              </li>



            <?php else: ?>
              <li class="nav-item">
                  <a href="<?php echo url('login'); ?>" class="nav-link">Login</a>
              </li>
              <li class="nav-item">
                  <a href="<?php echo url('register'); ?>" class="nav-link">Register</a>
              </li>     
            <?php endif; ?>
              
          </ul>
        </header>
    </div>
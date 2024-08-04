<?php defined("APP_PATH") || die('Direct access not permitted!!!'); ?>

<div class="text-center">
    <div class="error mx-auto" data-text="404"><?php echo $page_content_title; ?></div>
    <p class="lead text-gray-800 mb-5"><?php echo $page_content; ?></p>
    <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
    <a href="<?php echo url('index'); ?>">← Back to Dashboard</a>
</div>
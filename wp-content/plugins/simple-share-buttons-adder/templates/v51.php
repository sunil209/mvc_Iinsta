<div class="navbar-social-icons js-social-icons">
  <?php foreach ($template_data->buttons_array as $name => $button): ?>
    <?php if ($name === 'buffer'): ?>
      <a target="_blank" rel="noreferer noopener" href="<?= $button->share_link; ?>" class="navbar-social-item navbar-social-icon-svg icon-<?= $name; ?> <?= $button->class; ?>">
        <img class="navbar-social-icon-svg-mobile" src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-buffer-grey.svg" alt="">
        <img class="navbar-social-icon-svg-desktop" src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-buffer-black.svg" alt="">
      </a>
    <?php elseif ($name === 'linkedin'): ?>
      <a target="_blank" rel="noreferer noopener" href="<?= $button->share_link; ?>" class="navbar-social-item navbar-social-icon-svg icon-<?= $name; ?> <?= $button->class; ?>">
        <img class="navbar-social-icon-svg-mobile" src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-linkedin-grey.svg" alt="">
        <img class="navbar-social-icon-svg-desktop" src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-linkedin-black.svg" alt="">
      </a>
    <?php elseif ($name === 'twitter'): ?>
      <a target="_blank" rel="noreferer noopener" href="<?= $button->share_link; ?>" class="navbar-social-item navbar-social-icon-svg icon-<?= $name; ?> <?= $button->class; ?>">
        <img class="navbar-social-icon-svg-mobile" src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-twitter-grey.svg" alt="">
        <img class="navbar-social-icon-svg-desktop" src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-twitter-black.svg" alt="">
      </a>
    <?php elseif ($name === 'facebook'): ?>
      <a target="_blank" rel="noreferer noopener" href="<?= $button->share_link; ?>" class="navbar-social-item navbar-social-icon-svg icon-<?= $name; ?> <?= $button->class; ?>">
        <img class="navbar-social-icon-svg-mobile" src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-facebook-grey.svg" alt="">
        <img class="navbar-social-icon-svg-desktop" src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-facebook-black.svg" alt="">
      </a>
    <?php endif; ?>
  <?php endforeach; ?>
</div>

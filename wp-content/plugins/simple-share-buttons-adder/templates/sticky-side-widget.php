<div class="js-social-icons" data-layout="row center-right">
  <span class="navbar-social-title" data-self="lg-show"><?= __('Share'); ?></span>
  <?php foreach ($template_data->buttons_array as $name => $button): ?>
    <?php if ($name === 'buffer'): ?>
      <a target="_blank" rel="noreferer noopener" href="<?= $button->share_link; ?>" class="navbar-social-icon icon icon-<?= $name; ?>"></a>
    <?php elseif ($name === 'linkedin'): ?>
      <a target="_blank" rel="noreferer noopener" href="<?= $button->share_link; ?>" class="navbar-social-icon icon icon-<?= $name; ?>-bg <?= $button->class; ?>"></a>
    <?php else: ?>
      <a target="_blank" rel="noreferer noopener" href="<?= $button->share_link; ?>" class="navbar-social-icon icon icon-<?= $name; ?> <?= $button->class; ?>"></a>
    <?php endif; ?>
  <?php endforeach; ?>
</div>
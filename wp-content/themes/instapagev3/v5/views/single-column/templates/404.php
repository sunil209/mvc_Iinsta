<?php
use \Instapage\Classes\Factory;
use Instapage\Classes\Component;

if (!headers_sent()) {
  header('HTTP/1.0 404 Not Found');
}

Component::render('v51/document-start');
Component::render('v51/navbar',
  [
    'isSticky' => true,
    'desktopNavbarMenu' => Component::fetch('v51/navbar-menu', ['btnClass'=> 'btn-cta', 'items' => getV5Menu('v5-top-menu')])
  ]
);
?>

<div class="v7 v7-content page-404">
  <img class="page-404-image" src="<?= get_template_directory_uri() . '/v5/assets/images/404-closed-door.png'; ?>">
  <div>
    <div class="page-404-title">
      <?= __('404'); ?>
    </div>
    <div class="h1">
      <?= __('Looks Like You\'re Lost'); ?>
    </div>
    <div class="page-404-description v7-mt-20 v7-mb-30">
      <?= __('The Page You Are Looking For Is Not Available!'); ?>
    </div>
    <?php
      Component::render('button', ['text' => __('Take me home'), 'url' => get_home_url(), 'class' => 'v7-btn v7-btn-cta']);
    ?>
  </div>
</div>
<?php Component::render('v51/document-end'); ?>

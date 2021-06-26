<?php
use \Instapage\Classes\Component;
use \Instapage\Classes\Factory;

$page = getV5Page();
/* @var  $model \Instapage\Models\SiteMap */
$model = Factory::getModel($page);
$siteMap = $model->getSiteMap();

Component::render('v51/document-start');
Component::render('v51/navbar',
[
  'menuClass' => 'navbar-white',
  'desktopNavbarMenu' => Component::fetch('v51/navbar-menu', ['btnClass'=> 'btn-cta', 'items' => getV5Menu('v5-top-menu')]),
  'mobileNavbarMenu' => Component::fetch('v51/navbar-menu', 'mobile', ['items' => getV5Menu('v5-top-menu'), 'mobileClass' => 'navbar-white'])
  ]);
  Component::render('v51/header', [
    'headerText' => __('Instapage Sitemap'),
    'headerClass' => 'header-section-sitemap hero-section-light is-small',
    'slot2' => Component::fetch('v51/search', ['placeholder' => 'Search...'])
  ]);
?>
<div class="content sitemap js-search-content">
  <?php
    foreach ($siteMap as $siteMapSection):
    /* @var $siteMapSection \Instapage\Models\SiteMap\SiteMapSection */
  ?>
    <div class="sitemap-item">
      <h3><?= $siteMapSection->sectionName ?></h3>
      <ul>
        <?php foreach ($siteMapSection->items as $item): ?>
        <li data-search="<?= esc_attr($item->title) ?>" class="js-search-element"><a href="<?= $item->url ?>" class="sitemap-link"><?= $item->title ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endforeach; ?>
</div>
<?php
Component::render('cta-section', ['isGlobalAcf' => true, 'isMarginOmitted' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');

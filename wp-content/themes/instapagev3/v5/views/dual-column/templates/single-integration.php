<?php
use Instapage\Classes\Factory;
use Instapage\Classes\Component;
global $post;
$page = getV5Page();
$model = Factory::getModel($page);
$model->disableRobotsAndRemoveCanonical($post);
$benefits = $model->getBenefits($post->ID);
$testimonial = $model->getTestimonial($post->ID);
$postRelatedTax = get_the_terms($post->ID, $model->relatedTaxonomy);
if (!empty($postRelatedTax)) {
  $categoryUrl = '#term-'. $postRelatedTax[0]->slug;
}
$videoBox = new Instapage\Components\v51\Video\Controller(['url' => get_the_post_video_url()]);
$videoBox->renderDelayed();

$menuItems = [
  ['title' => __('Login'), 'url' => URL_INSTAPAGE_LOGIN, 'classes' => []],
  ['title' => __('Sign Up Now'), 'url' => URL_INSTAPAGE_SIGNUP, 'classes' => ['btn']]
];

Component::render('v51/document-start');
Component::render(
  'v51/navbar',
  [
    'menuClass' => 'navbar-white',
    'desktopNavbarMenu' => Component::fetch('v51/navbar-menu', ['btnClass'=> 'btn-cta', 'items' => $menuItems, 'stickToRight' => true]),
    'mobileNavbarMenu' => Component::fetch('v51/navbar-menu', 'mobile', ['items' => $menuItems]),
  ]
);
?>
<div class="content breadcrumbs division-top division-bottom-small">
  <span class="breadcrumb">
    <a href="<?= get_post_type_archive_link('integration'); ?>"><?= __('Integrations'); ?></a>
  </span>
  <?php if (!empty($postRelatedTax)): ?>
    <span class="breadcrumb">
      <a href="<?= get_post_type_archive_link('integration') . $categoryUrl; ?>"><?= __('Category'); ?></a>
    </span>
  <?php endif; ?>
  <span class="breadcrumb">
    <a href="#"><?= get_the_title(); ?></a>
  </span>
</div>
<?php
Component::render('v51/header', 'left', ['headerClass' => 'hero-section-single-integration']);
?>

<main class="content division template-dual-column">
  <!-- Content -->
  <section class="division-bottom-small">
    <?php the_content();
    if (has_post_video(get_the_ID())): ?>
    <div class="division-top-small">
      <a href="<?= get_the_post_video_url(); ?>" class="link-cta link-cta-big js-video-trigger" data-video-id="<?= $videoBox->getComponentID(); ?>">
        <i class="material-icons icon-label">play_arrow</i>
        <?= __('see how it works'); ?>
      </a>
    </div>
    <?php endif; ?>
    <hr>
    <h3 class="division-bottom-xsmall"><?= __('Key Benefits'); ?></h3>
    <?php
    Component::render('v51/lists');
    ?>
  </section>
  <!-- Sidebar -->
  <div class="sidebar">
    <?php Component::render('v51/related-links'); ?>
    <div class="community">
      <h3><?= __('Community'); ?></h3>
      <ul>
        <li class="related-link-wrapper">
          <a href="<?= URL_INSTAPAGE_HELP . '/community/topics/360000626671-Account'; ?>" class="related-link" target="_blank"><?= __('Account'); ?></a>
        </li>
        <li class="related-link-wrapper">
          <a href="<?= URL_INSTAPAGE_HELP . '/community/topics/360000622472-Builder'; ?>" class="related-link" target="_blank"><?= __('Builder'); ?></a>
        </li>
      </ul>
    </div>
    <hr>
    <div class="help-center">
      <h3><?= __('Help Center'); ?></h3>
      <ul>
        <li class="related-link-wrapper">
          <a href="<?= URL_INSTAPAGE_HELP; ?>" class="related-link" target="_blank"><?= __('Learn More'); ?></a>
        </li>
      </ul>
    </div>
  </div>
</main>
<?php
Component::render('v51/cta-section', 'in-row', ['class' => 'hero-section-light section-darker']);
Component::render('v51/footer');
Component::render('v51/document-end');

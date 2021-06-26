<?php
use Instapage\Classes\Component;

$menuItems = [
  ['title' => __('Login'), 'url' => URL_INSTAPAGE_LOGIN, 'classes' => ['link-cta']],
  ['title' => __('Sign up'), 'url' => URL_INSTAPAGE_SIGNUP, 'classes' => ['btn']]
];
Component::render('v51/document-start');
Component::render(
  'v51/navbar',
  [
    'isSticky' => true,
    'desktopNavbarMenu' => Component::fetch('v51/navbar-menu', ['btnClass'=> 'btn-cta', 'items' => $menuItems, 'stickToRight' => true]),
    'mobileNavbarMenu' => Component::fetch('v51/navbar-menu', 'mobile', ['items' => $menuItems])
  ]
);
?>

<section class="division division-sticky content is-narrow">
  <?php Component::render('v51/social-bar', ['title' => get_the_title()]); ?>
  <article class="blog-post-page editable-content single-podcast">
    <?php if (have_posts()): ?>
      <?php while (have_posts()): the_post(); ?>
        <header>
          <h1 class="post-item-title"><?php the_title(); ?></h1>
          <small class="podcast-single-autor"><?= get_field('guests_position') . __(' of ') . get_field('guests_company_name') ?></small>
          <?php if (has_post_thumbnail()): ?>
            <?php if (!has_post_video(get_the_ID())): ?>
              <?php $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'listing-size'); ?>
              <?php if (is_array($thumb)): ?>
              <img class="image-featured podcast-single-image" src="<?= $thumb[0]; ?>" srcset="<?= getPostThumbnailSrcSet(get_the_ID()); ?>"/>
            <?php endif; ?>
            <?php else: ?>
              <?php the_post_thumbnail('listing-size'); ?>
            <?php endif; ?>
          <?php endif; ?>
        </header>
        <?php if (get_field('soundcloud_embed_code')): ?>
          <section class="podcast-soundcloud-player">
            <?= getPodcastSoundcloudEmbed($post_id); ?>
          </section>
        <?php endif; ?>
        <div class="blog-post-body">
          <?php the_content(); ?>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <h1 class="tousubheading"><?php __('Nothing found', 'instapage'); ?></h1>
    <?php endif; ?>
  </article>
</section>
<?php
Component::render('cta-section', ['isGlobalAcf' => true, 'isMarginOmitted' => true]);
Component::render('v51/footer', ['class' => 'main-footer-social-bar']);
Component::render('v51/document-end');

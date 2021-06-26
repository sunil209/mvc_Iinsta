<?php
use \Instapage\Classes\Factory;
use \Instapage\Classes\Component;
use \Instapage\Classes\Amp\Amp;

global $post, $amp;
setup_postdata($post);

ob_start();
the_content();
$postContent = ob_get_contents();
ob_end_clean();

$page = getV5Page();
$model = Factory::getModel($page);
$postCategories = displayPostCategoriesWithLinks(get_the_ID());
$authorPattern = (hasAuthorPosts(get_the_author_meta('ID'))) ? '%1$s <time datetime="%2$s">%2$s</time> %3$s <a href="%4$s">%5$s</a>' : '%1$s <time datetime="%2$s">%2$s</time> %3$s %5$s';

Component::render(
  'amp/document-start',
  [
    'components' => [
      'iframe' => has_post_video(get_the_ID()) || (stripos($postContent, 'iframe') !== false),
      'analytics' => true,
      'socialShare' => true,
      'ampVideo' => true,
      'accordion' => true
    ],
    'cssFile' => 'amp/single.css',
    'structuredData' => $model->getStructuredData()
  ]
);
Component::render(
  'amp/header',
  [
    'components' => [
      'analytics' => true,
      'socialShare' => true
    ]
  ]
);
?>
<article class="blog-post-page division division-sticky content editable-content" data-layout="column center-left">
  <header>
    <h1><?php the_title(); ?></h1>
    <small>
      <?=
        sprintf(
          $authorPattern,
          __('Last updated on'),
          ((!empty($postCategories)) && (stripos($postCategories, 'instapage-updates') !== false)) ? get_the_date() : the_modified_date(null, null, null, false),
          __('by'),
          get_author_posts_url(get_the_author_meta('ID')),
          get_the_author()
        );
      ?>
      <?= (!empty($postCategories)) ? sprintf('%1$s %2$s', __('in'), $postCategories) : ''; ?>
    </small>
    <?php if (has_post_video(get_the_ID())): ?>
      <div class="video-responsive video-featured">
        <?php Component::render('amp/iframe-video', ['url' => get_the_post_video_url(), 'width' => 700, 'height' => 395]); ?>
      </div>
    <?php elseif (has_post_thumbnail(get_the_ID())) : ?>
      <div class="image-featured">
        <amp-img layout="responsive" <?= getV5Dimensions(get_the_ID()); ?> src="<?= getV5Src(get_the_ID()); ?>" srcset="<?= getV5SrcSet(get_the_ID()); ?>" />
      </div>
    <?php endif; ?>
  </header>
  <div class="blog-post-body">
    <?= $amp->filter(do_shortcode($postContent)); ?>
  </div>
</article>
<?php
Component::render('cta-section', [
    'title' => __('Turn More Ad Clicks into Conversions'),
    'subtitle' => __('Try the world\'s first Post-Click Automation™ solution today. Start a trial or schedule a demo to learn more about the Enterprise plan.'),
    'buttons' => [
        [
            'text' => __('Get Started'),
            'url' => URL_INSTAPAGE_SIGNUP,
            'class' => 'v7-btn-white v7-btn-large v7-btn-cta'
        ],
        [
            'text' => __('REQUEST A DEMO'),
            'url' => get_home_url() . '/enterprise-demo-request',
            'class' => 'v7-btn-large v7-btn-ghost'
        ]
    ]
]);
Component::render('amp/footer');
Component::render('amp/document-end');

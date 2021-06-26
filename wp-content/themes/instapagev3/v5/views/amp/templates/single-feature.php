<?php
use Instapage\Classes\Component;

$menuItems = [
  ['title' => __('Back to all features'), 'url' => get_post_type_archive_link('feature'), 'classes' => ['back-link']],
  ['title' => __('Login'), 'url' => URL_INSTAPAGE_LOGIN, 'classes' => []],
  ['title' => __('Sign up now'), 'url' => URL_INSTAPAGE_SIGNUP, 'classes' => ['btn']]
];

Component::render(
  'amp/document-start',
  [
    'components' => [
      'iframe' => true,
      'analytics' => true,
      'bind' => true,
      'accordion' => true
    ],
    'cssFile' => 'amp/single-feature.css'
  ]
);
Component::render(
  'amp/navbar',
  [
    'headerImage' => getSeoPageHeaderBackground(),
    'navbarMenu' => Component::fetch('v51/navbar-menu', 'mobile', ['items' => $menuItems]),

    'components' => [
      'analytics' => true
    ],
    'navigation' => true
  ]
);
Component::render(
  'v51/header',
  [
    'featuredImage' => getAcfVar('big_icon', '', $post->ID),
    'headerText' => get_the_title(),
    'subHeaderText' => $post->post_excerpt,
    'headerClass' => 'main-header-single-' . $page
  ]
);
?>
<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    <main>
      <section class="content division is-narrow">
        <?php if (has_post_video(get_the_ID())): ?>
          <div class="video-responsive video-featured">
            <?php Component::render('amp/iframe-video', ['url' => get_the_post_video_url(), 'width' => 700, 'height' => 395]); ?>
          </div>
        <?php elseif (has_post_thumbnail(get_the_ID())) : ?>
          <div class="featured-image">
            <amp-img layout="responsive" <?= getV5Dimensions(get_the_ID()); ?> src="<?= getV5Src(get_the_ID()); ?>" srcset="<?= getV5SrcSet(get_the_ID()); ?>" />
          </div>
        <?php endif; ?>
        <div class="main-text">
          <?php the_content(); ?>
        </div>
      </section>
      <?php if (count($benefits) > 1): ?>
        <?php Component::render('amp/benefits-section', ['layout' => 'one-row', 'section' => 'section-darker', 'benefits' => $benefits]); ?>
      <?php endif; ?>
    </main>
  <?php endwhile; ?>
<?php endif; ?>
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

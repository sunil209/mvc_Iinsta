<?php
use Instapage\Classes\Factory;
use Instapage\Classes\Component;
use Instapage\Models\DictionaryTerm;

$menuItems = [
  ['title' => __('Back to dictionary'), 'url' => get_post_type_archive_link('dictionary-term'), 'classes' => ['back-link']],
  ['title' => __('Login'), 'url' => URL_INSTAPAGE_LOGIN, 'classes' => []],
  ['title' => __('Try Instapage'), 'url' => URL_INSTAPAGE_SIGNUP, 'classes' => ['btn']]
];

Component::render(
  'amp/document-start',
  [
    'components' => [
      'iframe' => true,
      'analytics' => true,
      'bind' => true,
      'socialShare' => true,
      'accordion' => true
    ],
    'cssFile' => 'amp/marketing-dictionary.css'
  ]
);

Component::render(
  'amp/navbar',
  [
    'headerImage' => getSeoPageHeaderBackground(),
    'navbarMenu' => Component::fetch('v51/navbar-menu', 'mobile', ['items' => $menuItems]),

    'components' => [
      'analytics' => true,
      'socialShare' => true
    ],
    'navigation' => true
  ]
);

Component::render(
  'v51/header',
  [
    'headerText' => get_the_title(),
    'subHeaderText' => get_field('definition'),
    'headerClass' => 'main-header-dictionary'
  ]
);
?>
<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    <?php $postID = get_the_ID(); ?>
    <?php if ($videoUrl = get_field('video_url')): ?>
      <section class="division">
        <div class="dictionary-video">
          <?php Component::render('amp/iframe-video', ['url' => getVideoURL($postID), 'width' => 700, 'height' => 395]); ?>
        </div>
      </section>
    <?php endif; ?>
    <?php if ($tweetContent = get_field('tweet_content')): ?>
      <section class="section-darker">
        <?php Component::render('v51/click-to-tweet', $clickToTweet); ?>
      </section>
    <?php endif; ?>
    <?php if (get_field('google_trends_keywords')): ?>
      <section class="division-header content division-top">
        <span class="heading-secondary"><?= __('Global Search Trend'); ?></span>
        <?= $trendsChart ?>
      </section>
    <?php endif; ?>
    <?php Component::render('v51/related-terms', ['items' => getDictionaryRelatedTerms($postID)]); ?>
  <?php endwhile; ?>
<?php else: ?>
  <p><?= __('Nothing found', 'instapage'); ?></p>
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
?>
<?php
Component::render('amp/footer');
Component::render('amp/document-end');

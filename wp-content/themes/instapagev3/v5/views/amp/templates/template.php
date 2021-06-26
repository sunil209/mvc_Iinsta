<?php
use \Instapage\Classes\Factory;
use \Instapage\Classes\Component;
use \Instapage\Classes\Templates\ClassTemplates;
use \Instapage\Helpers\StringHelper;
use \Instapage\Helpers\HtmlHelper;

$model = Factory::getModel('landing-page-templates');
$categories = $model->getCategories();
$template = $model->getTemplate(ClassTemplates::getCurrentTemplateSlug(), true);
$similarTemplates  = $model->getSimilarTemplates($template, 4);
$imgSizeMobile = $model->getImageSize($template->mobile_image);
$imgSizeDesktop = $model->getImageSize($template->desktop_image);
add_filter('wp_title', function() use ($template) { return $template->name; }, 20, 0);
add_filter('body_class', function($classes) {
  if (is_array($classes)) {
    $excludedClasses = ['home'];

    return array_diff($classes, $excludedClasses);
  }

  return $classes;
});

Component::render(
  'amp/document-start',
  [
    'components' => [
      'iframe' => true,
      'analytics' => true,
      'bind' => true,
      'accordion' => true
    ],
    'cssFile' => 'amp/single-template.css',
    'canonical' => ClassTemplates::getCanonicalUrl()
  ]
);
Component::render(
  'amp/navbar-mobile',
  [
    'headerImage' => getSeoPageHeaderBackground(),
    'isSticky' => true,
    'components' => [
      'analytics' => true
    ],
    'navigation' => true
  ]
);
?>
<main>
  <div class="section-darker">
    <div class="content template-page-header">
      <div class="division content is-narrow template-page-header-content">
        <?php foreach ($categories as $category): ?>
          <?php foreach ($template->categories as $templateCategory): ?>
            <?php if ($category['id'] === $templateCategory): ?>
              <a href="<?= home_url($model->archiveSlug) . $category['url']; ?>" class="label"><?= $category['name']; ?></a>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endforeach; ?>
        <h1 class="template-page-header-title"><?= $template->name; ?></h1>
        <p><?= $template->description; ?></p>
        <a class="btn btn-cta" href="<?= URL_INSTAPAGE ?>/templates/index/<?= $template->page; ?>?skip_preview=<?= $template->skip_preview; ?>"><?= __('Use this template'); ?></a>
      </div>
      <a class="btn btn-rounded template-page-header-arrow template-page-header-next" href="<?= home_url($template->next->slug); ?>"><i class="material-icons">keyboard_arrow_right</i></a>
      <a class="btn btn-rounded template-page-header-arrow" href="<?= home_url($template->previous->slug); ?>"><i class="material-icons">keyboard_arrow_left</i></span></a>
    </div>
  </div>

  <section class="content division template-page-amp">
    <?php Component::render(
      'amp/img',
      [
        'src' => $template->desktop_image,
        'srcset' => $template->desktop_image_retina,
        'width' => $imgSizeDesktop[0],
        'height' => $imgSizeDesktop[1],
        'alt' => esc_attr($template->name),
        'class' => esc_attr('template-page-img-desktop'),
        'layout' => esc_attr('responsive')
      ]
    ); ?>
    <div class="template-page-mobile">
      <div class="template-page-mobile-img">
        <?php Component::render(
          'amp/img',
          [
            'src' => $template->mobile_image,
            'width' => $imgSizeMobile[0],
            'height' => $imgSizeMobile[1],
            'alt' => esc_attr($template->name),
            'class' => esc_attr('template-page-img')
          ]
        ); ?>
      </div>
    </div>
  </section>
  <section class="content division">
    <div class="division-header">
      <h2><?= __('Similar Templates'); ?></h2>
    </div>
    <div class="template-page-similar">
      <?php foreach ($similarTemplates as $similarTemplate): ?>
        <div class="tile panel">
          <a href="<?= home_url($similarTemplate->slug); ?>">
            <?php Component::render(
              'amp/img',
              [
                'src' => $similarTemplate->website_image,
                'width' => 392,
                'height' => 260,
                'alt' => esc_attr($similarTemplate->name),
                'class' => __('img-fullwidth'),
                'layout' => __('responsive')
              ]
            ); ?>
          </a>
          <div class="panel-block">
            <a href="<?= home_url($similarTemplate->slug); ?>" class="heading-quaternary link-chameleon"><?= $similarTemplate->name; ?></a>
            <p class="template-page-text"><?= StringHelper::truncate($similarTemplate->description, 100); ?></p>
            <a href="<?= home_url($similarTemplate->slug); ?>" class="panel-link-bottom link-cta link-cta-big"><?= __('View template'); ?></a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

</main>

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

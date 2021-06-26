<?php
use Instapage\Classes\Factory;
use Instapage\Classes\Component;
use Instapage\Helpers\HtmlHelper;

global $post, $amp;
setup_postdata($post);

ob_start();
the_content();
$postContent = ob_get_contents();
ob_end_clean();

$page = getV5Page();
$model = Factory::getModel($page);
$benefits = $model->getBenefits();
$companyData = $model->getCompanyData();

$menuItems = [
  ['title' => __('Back to customer stories'), 'url' => get_post_type_archive_link('customer-stories'), 'classes' => ['back-link']],
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
      'accordion' => true
    ],
    'cssFile' => 'amp/case-study.css'
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
    'headerText' => get_the_title(),
    'subHeaderText' => get_field('definition'),
    'headerClass' => 'main-header-dictionary'
  ]
);

Component::render(
  'amp/benefits-section',
  [
    'layout' => 'one-row',
    'section' => 'section-darker',
    'benefits' => $benefits
  ]
);
?>
<main class="content is-narrow division">
  <?php if (!empty($companyData['companyLogo']) && is_array($companyData['companyLogo'])): ?>
    <div>
      <amp-img width="<?= $companyData['companyLogo']['width']; ?>" height="<?= $companyData['companyLogo']['height']; ?>" class="detailed-description-logo" src="<?= $companyData['companyLogo']['url']; ?>"
        <?php
        if (!empty($companyData['companyLogo']['url']) && !empty($companyData['companyLogoRetina']['url'])) {
          echo HtmlHelper::renderSrcSet(
            [
              '1x' => $companyData['companyLogo']['url'],
              '2x' => $companyData['companyLogoRetina']['url']
            ]
          );
        }
        ?>
        alt="<?= esc_attr(@$companyData['companyName']); ?>">
    </div>
  <?php endif; ?>
  <div class="detailed-description">
    <?php if (!empty($companyData['companyName'])): ?>
      <div class="detailed-description-box">
          <strong><?= __('Name:'); ?></strong>
          <span><?= esc_html($companyData['companyName']); ?></span>
      </div>
    <?php endif; ?>
    <?php if (!empty($companyData['companyEmployees'])): ?>
      <div class="detailed-description-box">
          <strong><?= __('Employees:'); ?></strong>
          <span><?= esc_html($companyData['companyEmployees']); ?></span>
      </div>
    <?php endif; ?>
    <?php if (!empty($companyData['companyLocation'])): ?>
      <div class="detailed-description-box">
          <strong><?= __('Location:'); ?></strong>
          <span><?= esc_html($companyData['companyLocation']); ?></span>
      </div>
    <?php endif; ?>
  </div>
  <div class="editable-content ">
    <?= $amp->filter(do_shortcode($postContent)); ?>
  </div>
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
?>
<?php
Component::render('amp/footer');
Component::render('amp/document-end');

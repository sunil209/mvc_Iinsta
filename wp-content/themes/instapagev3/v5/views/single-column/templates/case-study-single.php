<?php
use \Instapage\Classes\Factory;
use \Instapage\Classes\Component;
use \Instapage\Helpers\HtmlHelper;

$page = getV5Page();
$model = Factory::getModel($page);
$companyData = $model->getCompanyData();

Component::render('v51/document-start');
Component::render('v51/navbar', [
    'menuClass' => 'navbar-white'
]);
Component::render('header');
?>
<?php Component::render('benefits-section', [
    'benefitsClass' => 'v7-case-study-single is-narrow'
]); ?>
<main class="v7-content is-narrow v7-mt-80 v7-mb-80">
  <?php if (!empty($companyData['companyLogo']) && is_array($companyData['companyLogo'])): ?>
    <div class="detailed-description-logo-wrapper">
    <?php if (!empty($companyData['companyUrl'])) : ?>
      <a href="<?= esc_url($companyData['companyUrl']); ?>" target="_blank">
    <?php endif; ?>
        <img class="img-responsive" src="<?= $companyData['companyLogo']['url']; ?>"
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
    <?php if (!empty($companyData['companyUrl'])) : ?>
      </a>
    <?php endif; ?>
    </div>
  <?php endif; ?>
  <div class="v7 detailed-description">
    <?php if (!empty($companyData['companyName'])): ?>
      <div class="detailed-description-box">
          <strong class="detailed-description-text"><?= __('Name:'); ?></strong>
          <span class="detailed-description-text"><?= $companyData['companyName']; ?></span>
      </div>
    <?php endif; ?>
    <?php if (!empty($companyData['companyEmployees'])): ?>
      <div class="detailed-description-box">
          <strong class="detailed-description-text"><?= __('Employees:'); ?></strong>
          <span class="detailed-description-text"><?= $companyData['companyEmployees']; ?></span>
      </div>
    <?php endif; ?>
    <?php if (!empty($companyData['companyLocation'])): ?>
      <div class="detailed-description-box">
          <strong class="detailed-description-text"><?= __('Location:'); ?></strong>
          <span class="detailed-description-text"><?= $companyData['companyLocation']; ?></span>
      </div>
    <?php endif; ?>
  </div>
  <div class="v7-editable-content ">
    <?php the_content(); ?>
  </div>
</main>
<?php
Component::render('cta-section', ['isGlobalAcf' => true, 'isMarginOmitted' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');

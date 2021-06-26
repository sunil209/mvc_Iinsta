<?php

/**
 * Template file. Template params are stored in $params array
 *
 * @param string  $title    Title of workable section
 * @param array   $jobs     Grouped $jobs Array contining groups of grouped jobs by the key
 *                array     Jobs inside specific group
 *
 */
use Instapage\Classes\Component;

$defaultVisibleGroup = 'Department';
?>

<section class="workable v7-mt-80 v7-content" data-self="sm-only-full">
  <?php Component::dumbRender('division-header', [
    'title' => $title,
    'class' => 'v7-mb-40 v7-mb-md-50'
  ]); ?>

  <div class="workable-container" id="workable">
    <div class="workable-sort-by">
      <h3 class="workable-sort-by-label tb-hidden">Sort by</h3>
      <ul class="workable-sorting-list">
        <?php foreach ($jobs as $groupedBy => $groupedJobs) : ?>
          <li
            class="js-filter-single2 workable-sorting-list-item"
            data-category="<?= esc_attr($groupedBy) ?>"
            data-scroll="250"
            <?= $groupedBy === $defaultVisibleGroup ? 'data-state="active"' : '' ?>
          >
            <?= esc_html($groupedBy) ?>
          </li>
        <?php endforeach ?>
      </ul>
    </div>
    <div class="js-filter-group2 fade slow-effect">
    <?php foreach ($jobs as $groupedBy => $groupedJobs) : ?>
      <ul
      class="js-filter-element2 <?= $groupedBy !== $defaultVisibleGroup ? 'v7-is-hidden' : '' ?>"
      data-filter="<?= esc_attr($groupedBy) ?>"
      >
        <?php foreach ($groupedJobs->get() as $grupingKey => $jobs) : ?>
          <li class="js-expand-item expand-item workable-jobs-group">
            <header class="accordion-header workable-group-head js-expand-trigger">
              <h3 class="workable-group-head-title"><?= esc_html($grupingKey) ?></h3>
              <span class="workable-jobs-counter"><?= count($jobs) ?></span>
              <i class="material-icons accordion-icon expand-icon">keyboard_arrow_down</i>
            </header>
            <div class="accordion-body group-body expand-content">
              <ul class="v7-mt-30 workable-jobs-list">
                <?php foreach ($jobs as $job) : /* @var $job \Instapage\Entities\JobOffer */ ?>
                  <li class="workable-job-entry">
                    <h4 class="workable-job-title"><?= esc_html($job->title) ?></h4>
                    <a href="<?= esc_url($job->workableURL) ?>" title="<?= esc_attr($job->title) ?>" class="workable-view-job" target="_blank">
                      <?= __('View job') ?>
                    </a>
                  </li>
                <?php endforeach ?>
              </ul>
            </div>
          </li>
        <?php endforeach ?>
      </ul>
    <?php endforeach ?>
    </div>
  </div>
  <h5 class="v7-mt-40 v7-mt-md-50 workable-footnote">
    <?= __('Don’t see the job you’re looking for? Use the form below to drop us a note.') ?>
  </h5>
</section>

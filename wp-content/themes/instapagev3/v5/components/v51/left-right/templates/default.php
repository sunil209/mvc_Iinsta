<?php
/**
 * Template file. Template params are stored in $params array
 * $title              - Section title
 * $layout             - Master layout of left/right sections
 * $class              - Class for whole seciton
 * $items              - associative array of sections to be displayed
 *  ['title']          - Section header
 *  ['id']             - Section ID
 *  ['imgClass]        - ImageC class
 *  ['image']          - Section image
 *  ['imageRetina']    - Section image (@2x)
 *  ['text']           - Content text
 *  ['text_alignment'] - Content text alignment
 *  ['name']           - Quote author
 *  ['avatar']         - Quote author avatar
 *  ['avatarRetina']   - Quote author avatar (@2x)
 *  ['url']            - Url
 *  ['playButton']     - Play button
 *  ['logo']           - Company logo image
 *  ['layout']         - Layout of current left right section
 *  ['newBadge']      - "New" badge for the left-right
 * $attributes         - associative array of attributes
 */

use \Instapage\Helpers\HtmlHelper;
use \Instapage\Classes\Component;

?>
<section class="<?= (isset($class) && !empty($class)) ? $class : ''; ?>">
  <?php if (!empty($title)): ?>
    <header class="division-top division-header">
      <h2><?= $title; ?></h2>
    </header>
  <?php endif; ?>
  <?php if (isset($items) && !empty($items) && is_array($items)): $ordinalNumber = 0;?>
    <?php
      foreach ($items as $item):
        $layoutSelection = !empty($item['layout'])
                           ? $item['layout']
                           : (!empty($layout) ? $layout : null);
        $ordinalNumber++;
        $videoBox = new Instapage\Components\v51\Video\Controller(['url' => $item['playButton']]);
        $videoBox->renderDelayed();
    ?>
    <div class="left-right-section" id="<?= !empty($item['id']) ? esc_attr($item['id']) : '' ?>">
        <?php if ($layoutSelection === 'video'): ?>
          <div class="left-right-img-box left-right-img-box-<?= $ordinalNumber ?> left-right-column">
            <img class="left-right-img left-right-img-video" src="<?= $item['image']; ?>" <?= HtmlHelper::renderSrcSet(['1x' => $item['image'], '2x' => $item['imageRetina']]); ?> alt="<?= esc_attr($item['title']); ?>">
            <video muted class="js-video-autoplay lg-tb-hidden left-right-img left-right-video video-normal lazyload">
              <source src="<?= $item['video']; ?>" type="video/mp4">
            </video>
            <div class="loader md-visible"></div>
            <video muted class="js-video-autoplay left-right-img left-right-video video-retina lazyload">
              <source src="<?= $item['videoRetina']; ?>" type="video/mp4">
            </video>
          </div>
        <?php else: ?>
          <div class="left-right-img-box left-right-img-box-<?= $ordinalNumber ?> left-right-column">
            <img
              class="left-right-img lazyload"
              data-src="<?= $item['image']; ?>"
              <?=
                HtmlHelper::renderSrcSet(
                  [
                    '1x' => $item['image'],
                    '2x' => $item['imageRetina']
                  ],
                  'data-srcset'
                );
              ?>
              alt="<?= esc_attr($item['title']); ?>"
            >
            <div class="loader"></div>
          </div>
        <?php endif; ?>

        <div class="<?= esc_attr($item['textAlignment']); ?> left-right-column <?= 'left-right-text-' . $ordinalNumber ?>" >
          <?php if (!empty($item['newBadge']) && $item['newBadge'] === true): ?>
            <img class="left-right-badge" src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-new.svg" alt="<?= __('New'); ?>">
          <?php endif; ?>
          <?php if (!empty($class)): ?>
            <h2><?= $item['title']; ?></h2>
          <?php endif; ?>
          <p><?= $item['text']; ?></p>
          <?php if (!empty($item['name'])): ?>
            <?php Component::render('v51/avatar', ['info' => $item['name'], 'image' => $item['avatar'], 'imageRetina' => $item['avatarRetina']]); ?>
          <?php endif; ?>
          <?php if (!empty($item['url'])): ?>
            <a href="<?= $item['url'] ?>" class="btn <?= !empty($btnClass) ? esc_attr($btnClass) : 'btn-ghost-cta is-small'; ?>">
              <?= __('LEARN MORE'); ?>
            </a>
          <?php endif; ?>
          <?php if (!empty($item['playButton'])): ?>
            <a href="<?= $item['playButton'] ?>" class="btn btn-ghost-cta btn-play js-video-trigger" data-video-id="<?= $videoBox->getComponentID(); ?>">
              <i class="material-icons icon-label">play_arrow</i>
              <?= __('SEE HOW IT WORKS'); ?>
            </a>
          <?php endif; ?>
          <?php if (!empty($item['logo'])): ?>
            <img class="left-right-logo lazyload" data-src="<?= $item['logo']['url']; ?>" alt="<?= esc_attr($item['logo']['alt']); ?>">
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</section>

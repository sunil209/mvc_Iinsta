<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $groupID  ID of accordion group. Usually used in cojunction with `sidebar` component
 * @param string $headline Name of accordion group
 * @param array  $items    An array of single accordions: ['title', 'icon', 'url', 'excerpt', 'isOpen', 'videoEmbedCode', 'attributes']
 *
 * @example Usage
 * Component::render(
 *   'v51/accordion',
 *   [
 *     'groupID' => 'example-accordion',
 *     'headline' => __('Example accordion'),
 *     'items' => [
 *       [
 *         'title' => __('Lorem ipsum'),
 *         'icon' => 'https://instapage.com/wp-content/uploads/2016/04/icon-widgets-1.svg',
 *         'url' => 'https://instapage.com/',
 *         'excerpt' => __('Lorem ipum dolor sit amet...'),
 *         'isOpen' => true,
 *         'attributes' => [
 *           'data-some-attribute' => 'with-value'
 *         ]
 *       ],
 *       [
 *         'title' => __('Lorem ipsum 2'),
 *         'icon' => 'https://instapage.com/wp-content/uploads/2016/04/icon-widgets-1.svg',
 *         'url' => 'https://instapage.com/',
 *         'excerpt' => __('Lorem ipum dolor sit amet...'),
 *         'attributes' => [
 *           'data-some-attribute' => 'with-value'
 *         ]
 *       ]
 *     ]
 *   ]
 * );
 * @endexample
 */
use Instapage\Helpers\HtmlHelper;
?>

<div id="<?= esc_attr($groupID); ?>">
  <?php if (!empty($headline)): ?>
    <header class="division-header">
      <h3><?= $headline; ?></h3>
    </header>
  <?php endif; ?>
  <?php if (!empty($items)): ?>
    <?php foreach ($items as $item): ?>
      <div data-search="<?= esc_attr($item['title']); ?>" class="accordion panel panel-floating panel-block expand-item expand-trigger js-expand-item js-expand-trigger js-search-element <?= isset($item['icon']) ? 'has-icon' : ''; ?>" <?php if (isset($item['isOpen']) && $item['isOpen']): ?>data-state="open"<?php endif; ?> <?= isset($item['attributes']) ? HtmlHelper::renderAttributes($item['attributes']) : ''; ?>>
        <header class="accordion-header">
          <?php if (!empty($item['icon'])): ?>
            <img class="icon-svg is-small" src="<?= $item['icon']; ?>" alt="<?= esc_attr($item['title']); ?>">
          <?php endif; ?>
          <h4>
            <?= $item['title']; ?>
          </h4>
          <i class="material-icons accordion-icon expand-icon">keyboard_arrow_down</i>
        </header>
        <div class="accordion-body expand-content <?= !(isset($isEditable)) ? 'editable-content' : ''; ?>">
          <p><?= $item['excerpt']; ?></p>
          <?php if (!empty($item['videoEmbedCode'])): ?>
            <span class="load-wrapper is-hidden">
              <?= $item['videoEmbedCode']; ?>
            </span>
          <?php endif; ?>
          <?php if (!empty($item['url'])): ?>
            <a href="<?= $item['url']; ?>" class="btn btn-ghost-cta is-small"><?= __('Learn more'); ?></a>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

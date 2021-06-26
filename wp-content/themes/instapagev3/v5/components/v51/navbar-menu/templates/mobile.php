<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array $items      An array with data to loop over: ['url', 'title', 'classes', 'child_nodes']
 * @param array $attributes Associative array of attributes
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;
?>

<?php if (!empty($items)): ?>
  <div class="navbar-menu" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
    <?php foreach ($items as $item): ?>
      <?php if ((is_array($item['child_nodes'])) && (!empty($item['child_nodes']))): ?>
        <div class="expand-item js-expand-item js-navbar-menu-top-level-mobile" data-collapse="all">
          <!-- EXPANDABLE OPTION HEADER -->
          <header class="expand-trigger js-expand-trigger navbar-menu-option">
            <?php if (!empty($item['url'])): ?>
              <a href="<?= $item['url']; ?>"><?= __($item['title']); ?></a>
              <i class="material-icons expand-icon">keyboard_arrow_down</i>
            <?php else: ?>
              <span><?= __($item['title']); ?></span><i class="material-icons expand-icon">keyboard_arrow_down</i>
            <?php endif; ?>
          </header>
          <!-- EXPANDABLE MENU -->
          <div class="expand-content">
            <?php if (getLayout($item) === 'single'): ?>
              <?php foreach ($item['child_nodes'] as $item): ?>
              <?php $image = wp_get_attachment_image_url($item['thumbnail_id'], $item['image_size']); ?>
                <a href="<?= $item['url']; ?>" class="navbar-submenu-option <?= implode(' ', $item['classes']); ?>">
                <i class="material-icons dropdown-option-icon">
                  <img src="<?= $image; ?>" alt="<?= esc_attr($item['title']); ?>">
                </i>
                <?= esc_html($item['title']); ?></a>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="navbar-submenu-deeper">
                <?php foreach ($item['child_nodes'] as $item): ?>
                  <span class="navbar-submenu-title"><?= __($item['title']); ?></span>
                  <?php if ((is_array($item['child_nodes'])) && (!empty($item['child_nodes']))): ?>
                    <?php foreach ($item['child_nodes'] as $item): ?>
                      <?php $image = wp_get_attachment_image_url($item['thumbnail_id'], $item['image_size']); ?>
                      <a href="<?= $item['url']; ?>" class="navbar-submenu-option <?= implode(' ', $item['classes']); ?>">
                      <i class="material-icons dropdown-option-icon">
                        <img src="<?= $image; ?>" alt="<?= esc_attr($item['title']); ?>">
                      </i>
                      <?= esc_html($item['title']); ?></a>
                    <?php endforeach; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      <?php else: ?>
        <?php if (in_array('btn', $item['classes'])): ?>
        <div class="navbar-menu-option navbar-menu-option-btn">
          <?php
            Component::render(
                'v51/button',
                ['text' => $item['title'], 'url' => $item['url'], 'class' => 'btn is-small btn-cta']
            );
          ?>
        </div>
        <?php else : ?>
            <?php
              $key = 'login';
              $class = 'navbar-menu-option';
              $class = strpos($item['url'], $key) ? $class.' md-visible' : $class;
              Component::render(
                  'v51/button',
                  ['text' => $item['title'], 'url' => $item['url'], 'class' => $class]
              );
            ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

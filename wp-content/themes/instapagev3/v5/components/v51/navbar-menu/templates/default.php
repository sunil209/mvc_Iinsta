<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $btnClass     CSS class for v51/button
 * @param bool   $stickToRight Set to "true" if you don't want navbar menu to be justified
 * @param array  $items        An array with data to loop over: ['url', 'title', 'classes', 'child_nodes']
 * @param array  $attributes   Associative array of attributes
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;
?>

<?php if (!empty($items)): ?>
  <ul class="list-horizontal <?php if (isset($stickToRight)): ?>stick-to-right<?php endif; ?> <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>">
  <?php foreach ($items as $item):
    // chudo-163 hide middle navigation
    if (get_field('is_navigation_hidden', $contextID ?? false) === true && !in_array('btn', $item['classes'])) {
      continue;
    }
    if ($item['title'] === 'Login'): ?>
    </ul>
    <ul class="list-horizontal navbar-login-options" <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>>
    <?php endif;
      if ((is_array($item['child_nodes'])) && (!empty($item['child_nodes']))): ?>
        <li class="list-option js-navbar-menu-top-level">
          <div class="dropdown">
            <?php if (!empty($item['url'])): ?>
              <a href="<?= $item['url']; ?>" class="dropdown-trigger <?= implode(' ', $item['classes']); ?>">
                <span class="dropdown-text"><?= __($item['title']); ?></span>
              </a>
            <?php else: ?>
              <span class="dropdown-trigger <?= implode(' ', $item['classes']); ?>">
                <span class="dropdown-text"><?= __($item['title']); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" class="navbar-menu-icon-inline">
                  <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
                  <path fill="none" d="M0 0h24v24H0V0z"/>
                </svg>
              </span>
            <?php endif; ?>
            <?php if (getLayout($item) === 'multi'): ?>
              <div class="dropdown-list with-icons dropdown-two-columns">
                <?php foreach ($item['child_nodes'] as $item): ?>
                  <div class="dropdown-column">
                    <h5 class="dropdown-list-title"><?= __($item['title']); ?></h5>
                    <?php if ((is_array($item['child_nodes'])) && (!empty($item['child_nodes']))) : ?>
                        <?php foreach ($item['child_nodes'] as $item) : ?>
                            <?php Component::render('v51/navbar-menu-item', ['item' => $item]); ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div class="dropdown-list with-icons">
                <?php foreach ($item['child_nodes'] as $item) : ?>
                    <?php Component::render('v51/navbar-menu-item', ['item' => $item]); ?>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </li>
      <?php else: ?>
        <?php if (in_array('btn', $item['classes'])): ?>
          <li>
            <?php Component::render('v51/button', ['text' => __($item['title']), 'url' => $item['url'], 'class' => 'btn is-small js-navbar-btn ' . $btnClass]); ?>
          </li>
        <?php elseif (in_array('back-link', $item['classes'])): ?>
          <li class="list-option">
            <?php Component::render('v51/button', ['icon' => 'keyboard_arrow_left', 'text' => __($item['title']), 'url' => $item['url']]); ?>
          </li>
        <?php else: ?>
          <li class="list-option">
            <?php Component::render('v51/button', ['text' => __($item['title']), 'url' => $item['url']]); ?>
          </li>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

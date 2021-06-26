<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $class                    Additional search classes
 * @param string $placeholder              Search input placeholder
 */
?>

<div
  role="search"
  class="v7-search-component <?= $class ?? '' ?>">
  <input
    class="v7-search-input js-search"
    placeholder="<?= esc_attr($placeholder ?? ' ') ?>"
    type="text"
    name="search">
  <span role="icon" class="material-icons v7-search-icon">search</span>
</div>

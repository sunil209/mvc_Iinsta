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
  class="search-component <?= isset($class) ? $class : ''; ?>">
  <input
    class="search-input js-search"
    placeholder="<?= isset($placeholder) ? esc_attr($placeholder) : ' '; ?>"
    type="text"
    name="search">
  <span role="icon" class="material-icons search-icon">search</span>
  <ul class="v7-autocomplete-suggestions js-suggestions is-hidden"></ul>
</div>

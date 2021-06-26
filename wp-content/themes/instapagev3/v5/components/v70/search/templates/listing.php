<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $class                    Additional search classes
 * @param string $placeholder              Search input placeholder
 * @param string $postType                 Holds information  what postType should be searched
 */
?>
<form
    role="search"
    method="get"
    class="v7-search-component <?= $class ?? '' ?>"
    action="<?= site_url(); ?>"
>
    <input
        class="v7-search-input"
        placeholder="<?= esc_attr($placeholder ?? ' ') ?>"
        type="text"
        name="s"
        value="<?= esc_attr($value ?? '') ?>"
        autocomplete="off"
    >
    <input
        type="hidden"
        name="post_type"
        value="<?= esc_attr($postType); ?>"
    >
    <button type="submit" class="material-icons v7-search-icon v7-search-btn">search</button>
</form>

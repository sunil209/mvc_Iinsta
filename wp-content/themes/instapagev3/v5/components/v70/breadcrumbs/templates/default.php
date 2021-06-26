<?php
 /**
 * Template file. Template params are stored in $params array
 *
 * @param array $items    An array of terms, each containing:
 *        string title
 *        string url
 *
 * @example Usage
 * Component::render('breadcrumbs', ['items' => $breadCrumbsItems]);
 * @endexample
 */
?>

<div class="v7-breadcrumbs-wrapper v7-mb-10">
    <?php foreach ($items as $item) : ?>
        <a class="v7-breadcrumb" href="<?= esc_url($item['url'] ?? ''); ?>"><?= esc_html($item['title'] ?? ''); ?></a>
    <?php endforeach; ?>
</div>

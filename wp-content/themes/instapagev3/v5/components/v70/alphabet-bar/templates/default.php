<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array $items    An array of letters, each containing:
 *        string content   Text
 *        string url       URL
 *
 * @example Usage
 * Component::render('alphabet-bar', ['items' => $barItems]);
 * @endexample
 */
?>
<section class="js-navbar js-sidebar v7-alphabet-bar">
    <ul class="v7-alphabet-bar-content">
        <?php foreach ($items as $item) : ?>
        <li>
            <a class="v7-alphabet-bar-letter" href="<?= esc_url($item['url']); ?>">
                <?= esc_html($item['content']); ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</section>

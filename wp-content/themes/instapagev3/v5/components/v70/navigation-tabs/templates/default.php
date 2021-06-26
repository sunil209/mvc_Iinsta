<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $postsType             An array of navtabs, each containing:
 *               string $postsType      Type of given post
 *
 * @example Usage
 * Component::render('navigation-tabs');
 * @endexample
 */

use Instapage\Components\v70\PostsBrowser\PostTypes;
?>

<ul class="v7-navigation-tabs v7-mt-40">
    <?php $i = 0;
    foreach ($allPosts as $postsType => $posts) : ?>
        <li
            data-posts-browser="<?= $i ?>"
            class="js-v7-posts-browser-navigation-item v7-navigation-tabs-item h5"
            <?= $i === 0 ? 'data-state="active"' : '' ?>
        >
            <?= esc_html(PostTypes::getLabel($postsType) ?? '') ?>
        </li>
        <?php $i++;
    endforeach; ?>
</ul>

<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string    $title              Title of quick links block
 * @param array     $links              Array containing links inside quick link block
 *                  string href         Anchor href of current quick link
 *                  string title        Title of current quick link
*                   array  attributes   Standard array with attributes for html tags used by
 *                                      HtmlHelper::renderAttributes
 *
 *
 * @example Basic example
 * Component::render('v51/quickLinks', [
 *      'links' => [
 *          [
 *              'href' => '#id',
 *              'title' => 'Basic anchor inside page',
 *          ],
 *          [
 *              'href' => '#id2',
 *              'title' => 'Basic second anchor inside page',
 *          ]
 *      ]
 * ]);
 * @endexample
 *
 */

use \Instapage\Helpers\HtmlHelper;

if (empty($links) || !is_array($links)) {
    return;
}
?>

<div class="quick-links panel panel-block">
    <h5><?= esc_html($title) ?? __('Quick Links') ?></h5>
    <ol class="quick-links-list">
        <?php foreach ($links as $link) : ?>
        <li class="level-1">
            <a
                href="<?= esc_url($link['href'] ?? '') ?>"
                <?= HtmlHelper::renderAttributes($link['attributes'] ?? []) ?>
            >
                <?= esc_html($link['title'] ?? '') ?>
            </a>
        </li>
        <?php endforeach ?>
    </ol>
</div>

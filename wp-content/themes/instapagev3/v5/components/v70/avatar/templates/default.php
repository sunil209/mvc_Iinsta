<?php
/**
 * Template file. Template params are stored in $params array
 * $authorName  - a name of the author
 * $authorID    - an ID of the author
 * $disableLink - boolean for not showing a link to author
 */

use \Instapage\Helpers\HtmlHelper;

if (empty($authorID) || !is_int($authorID)) {
    return;
}
?>

<?php if ($disableLink) : ?>
    <div class="v7-avatar">
<?php else : ?>
    <a href="<?= get_author_posts_url($authorID) ?>" class="v7-avatar v7-btn-flat-black">
<?php endif; ?>
    <img
        class="v7-avatar-profile" src="<?= get_avatar_url($authorID, ['size' => 40]) ?>"
        <?= HtmlHelper::renderSrcSet(
            [
                '1x' => get_avatar_url($authorID, ['size' => 40]),
                '2x' => get_avatar_url($authorID, ['size' => 80])
            ]
        ); ?>
        alt="<?= esc_attr($authorName) ?>"
    >
    <span class="v7-avatar-title small"><?= __('by') . ' ' . esc_html($authorName) ?></span>
<?php if ($disableLink) : ?>
    </div>
<?php else : ?>
    </a>
<?php endif; ?>

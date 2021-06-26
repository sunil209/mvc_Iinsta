<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param int     $authorID    author's ID
 * @param string  $authorName  author's name
 * @param bool    $disableLink if true, there will be `<div>` instead of `<a>`
 *
 * @example Without link
 * Component::render(
 *   'v51/avatar',
 *   'v50',
 *   [
 *     'authorID' => 5,
 *     'authorName' => 'Tyson Quick',
 *     'disableLink' => true
 *   ]
 * );
 * @endexample
 *
 * @example With link
 * Component::render(
 *   'v51/avatar',
 *   'v50',
 *   [
 *     'authorID' => 28,
 *     'authorName' => 'Oliver Armstrong',
 *   ]
 * );
 * @endexample
 */

use \Instapage\Helpers\HtmlHelper;

$disableLink = (isset($disableLink) && $disableLink);
?>

<?php if ($disableLink): ?>
  <div class="avatar">
<?php else: ?>
  <a href="<?= get_author_posts_url($authorID); ?>" class="avatar link-chameleon">
<?php endif; ?>
<img class="avatar-profile" src="<?= get_avatar_url($authorID, ['size' => 30]); ?>" <?= HtmlHelper::renderSrcSet(['1x' => get_avatar_url($authorID, ['size' => 30]), '2x' => get_avatar_url($authorID, ['size' => 60])]); ?>>
<small>by <?= $authorName; ?></small>
<?php if ($disableLink): ?>
  </div>
<?php else: ?>
  </a>
<?php endif; ?>

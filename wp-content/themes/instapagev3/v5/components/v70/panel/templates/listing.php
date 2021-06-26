<?php
/**
 * Listing panel variant.
 * Template params are stored in $params array
 *
 * @param array   $image             Image.
 * @param array   $image_retina      Retina image.
 * @param string  $title             Title of the post.
 * @param string  $link              Link to the post.
 * @param string  $excerpt           Excerpt to show in the panel.
 * @param array   $postCategories    Array containg categories of rendered post.
 * @param integer $authorID          ID of post author.
 * @param string  $authorName        Name of post author.
 * @param boolean $disableLink       Disable link for author?
 * @param string  $moreText          Text for link to the post.
 * @param string  $singleViewTarget  Set target of anchors in tile.
 * @param boolean $isFeaturedArticle Returns true if post was chosen via ACF Featured Blog Article
 *
 * @example Default
 *  Component::render('panel', 'listing, $params);
 *
 * @endexample
 *
 */

use \Instapage\Classes\Component;

?>

<div class="v7-box v7-box-vertical <?= !empty($link) ? 'v7-box-clickable' : '' ?> v7-panel-layout">
    <?php
    if (isset($timezone)) :
        Component::render('countdown', [
            'url' => $link,
            'timezone' => $timezone,
            'timer' => $timer
        ]);
    else :
        ?>
            <a
                href=" <?= esc_url($link) ?>"
                class="v7-panel-image-link <?= $isSoundcloud ? 'v7-panel-image-overlay js-player-trigger' : '' ?>"
            >
        <?php
        Component::render(
            'v51/lazy-image',
            [
                'imageClass' => 'v7-panel-image',
                'imageRegularURL' => $image[0],
                'imageRetinaURL' => $image_retina[0],
                'width' => $image[1],
                'height' => $image[2],
                'alt' => $title,
                'constrainMaxWidth' => true
            ]
        );
        ?>
        <?php if (!empty($isSoundcloud)) : ?>
        <span class="v7-btn v7-btn-round v7-btn-round-white">
            <svg class="v7-btn-play-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
                <path d="M0 0h24v24H0z" fill="none"/>
            </svg>
        </span>
        <?php endif; ?>
        </a>
    <?php endif; ?>
    <div class="v7-box-copy v7-panel-copy">
        <?php if (!empty($postCategories[0])) : ?>
            <a href="<?= get_term_link($postCategories[0]) ?>" class="v7-panel-label v7-pb-10 v7-btn-flat-black">
                <?= esc_html($postCategories[0]->name) ?>
            </a>
        <?php endif; ?>
        <h4 class="v7-panel-title">
            <a href="<?= esc_url($link) ?>" <?= $isTargetBlank ? 'target="_blank"' : ''; ?> class="v7-btn-flat-black">
                <?= esc_html($title) ?>
            </a>
        </h4>
        <?php if (!$isFeaturedArticle) : ?>
            <p class="v7-panel-text"><?= esc_html($excerpt) ?></p>
        <?php endif;
        if ($isAuthor === true) :
            ?>
            <div class="v7-pt-20 v7-pt-md-30 v7-panel-footer">
                <?php
                Component::render(
                    'avatar',
                    [
                        'authorID' => $authorID,
                        'authorName' => $authorName,
                        'disableLink' => $disableLink
                    ]
                );
        endif;

        $attributes = [];
        if ($isTargetBlank) {
            $attributes['target'] = '_blank';
        }

        Component::render(
            'button',
            [
                'text' => $moreText,
                'url' => $link,
                'class' => 'v7-panel-cta v7-btn v7-btn-flat',
                'icon' => $isVideoButton,
                'attributes' => $attributes
            ]
        );
        if (!empty($isSoundcloud)) :
            Component::render('soundcloud');
        endif;
        if ($isAuthor === true) : ?>
            </div>
        <?php endif; ?>
    </div>
</div>

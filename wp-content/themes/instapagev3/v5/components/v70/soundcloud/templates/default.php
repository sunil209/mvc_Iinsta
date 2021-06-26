<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @example Default
 * Component::render('soundcloud');
 * @endexample
 */
?>
<?php if (get_field('soundcloud_embed_code')): ?>
    <div class="v7-soundcloud js-player-wrapper">
        <div class="v7-soundcloud-player v7-content">
            <?= '<p class="v7-soundcloud-track"' . getPodcastSoundcloudEmbed() . '</p>'; ?>
            <div class="v7-soundcloud-close js-player-close">
                <i class="material-icons">close</i>
            </div>
        </div>
    </div>
<?php endif; ?>

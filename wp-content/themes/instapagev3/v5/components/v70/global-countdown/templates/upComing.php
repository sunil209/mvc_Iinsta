<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array $upcoming
 *
 * @example Global coundown using panel section
 * Component::render('global-countdown');
 * @endexample
 */

use \Instapage\Classes\Component;

if (!$upcoming['showCountdown'] || empty($upcoming['timer'])) {
    return;
}
?>
<section class="v7 v7-mt-80">
    <?php
    Component::dumbRender(
        'division-header',
        [
            'title' => 'Coming Soon',
            'class' => 'v7-mb-40 v7-mb-md-50 v7-countdown-heading'
        ]
    ); ?>
    <div class="v7-content">
        <div class="v7-countdown-grid">
            <div class="v7-content-coutdown-wrapper">
                <div class="v7-countdown-date">
                        <?php 
                            if (isset($upcoming['timezone'])) :
                                Component::render('countdown', [
                                    'url' => $upcoming['link'],
                                    'timezone' => $upcoming['timezone'],
                                    'timer' => $upcoming['timer']
                                ]);
                            endif;
                        ?>
                    </div>
                <div class="v7-countdown-webinar-info">
                        <?php if( isset( $upcoming['logo'] ) && !empty( $upcoming['logo'] ) ): ?>
                            <div class="v7-webinar-type">
                                <?php
                                    Component::render(
                                        'v51/image',
                                        [
                                            'image' => $upcoming['logo'],
                                            'class' => 'img-responsive v7-mx-auto',
                                            'onlyLazyImageClass' => true
                                        ]
                                    );  
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if( isset($upcoming['title']) && !empty( $upcoming['title'] ) ): ?>
                            <h2 class="v7-webinar-title"><?= $upcoming['title'] ?? '' ?></h2>
                        <?php endif; ?>

                        <?php if( isset($upcoming['excerpt']) && !empty( $upcoming['excerpt'] ) ): ?>
                            <p class="v7-panel-text v7-webinar-description"><?= $upcoming['excerpt'] ?? '' ?></p>
                        <?php endif; ?>

                        <?php if( isset($upcoming['moreText']) && !empty( $upcoming['moreText'] ) ): ?>
                            <a href="<?= $upcoming['link'] ?? '#' ?>" class="v7-btn v7-panel-cta v7-btn v7-btn-flat v7-webinar-cta">
                                <span class="v7-btn-text">
                                    <span class="v7-btn-copy"><?= $upcoming['moreText'] ?? '' ?></span>
                                </span>
                            </a>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

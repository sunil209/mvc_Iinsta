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
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]
    ); ?>
    <div class="v7-content v7-single-panel-container">
        <?php Component::render('panel', 'listing', $upcoming); ?>
    </div>
</section>

<a class="v7-countdown" href="<?= esc_attr($link); ?>">
    <div class="v7-countdown-wrapper text-center js-countdown">
        <div class="v7-countdown-title"><?= __('Upcoming Session'); ?></div>
        <div class="v7-countdown-text js-countdown-date-time" data-countdown="<?= $timer['seconds'] ?>">
        <?=  $timer['date'] . ' ' . $timezone; ?>
        </div>
        <div class="v7-countdown-numbers-wrapper text-center">
            <div class="v7-countdown-numbers v7-countdown-days js-countdown-days"></div>
            <div class="v7-countdown-numbers v7-countdown-hours js-countdown-hours"></div>
            <div class="v7-countdown-numbers v7-countdown-minutes js-countdown-minutes"></div>
            <div class="v7-countdown-numbers v7-countdown-seconds js-countdown-seconds"></div>
        </div>
    </div>
</a>

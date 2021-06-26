<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string quote
 * @param string author
 * @param string url
 *
 * @example Usage
 * Component::render('tweet', ['content' => $clickToTweet]);
 * @endexample
 */

if (empty($quote)) {
    return;
}

?>
<section class="v7 v7-mt-80 v7-mt-md-100 container">
    <div class="row">
        <div class="text-center col-sm-12 col-xl-10 offset-xl-1">
            <div class="v7-tweet">
                <h3 class="h1"><?= esc_html($quote ?? ''); ?></h3>
            </div>
            <p class="v7-tweet-author v7-mt-20 v7-mb-30 v7-pb-30"><?= esc_html($author ?? ''); ?></p>
            <a href="<?= esc_url($url ?? ''); ?>" class="v7-btn v7-btn-small v7-btn-cta">
                <img src="<?= get_template_directory_uri() . '/v5/components/v70/tweet/images/tweeter.svg' ?>" alt="Twitter icon">
                <?= __('tweet this') ?>
            </a>
        </div>
    </div>
</section>

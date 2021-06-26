<?php
 /**
 * Template file. Template params are stored in $params array
 *
 * @param array $items    An array of terms, each containing:
 *        string name
 *        string url
 *
 * @example Usage
 * Component::render('related-terms', ['items' => $dictionaryRelatedTerms]);
 * @endexample
 */

use Instapage\Classes\Component;
?>
<section class="v7 container v7-mt-80">
    <?php Component::render('division-header', [
        'title' => __('Related Terms'),
        'class' => 'v7-mb-40 v7-mb-md-50'
    ]); ?>

    <div class="text-center row">
        <div class="col-sm-12 col-lg-10 offset-lg-1">
            <?php foreach ($items as $item) : ?>
            <a href="<?= esc_url($item['url'] ?? '') ?>" class="v7-btn v7-btn-ghost-grey fx-ripple-effect">
                <span class="v7-btn-text">
                    <span class="v7-btn-copy"><?= esc_html($item['name'] ?? '') ?></span>
                </span>
            </a>
            <?php  endforeach; ?>
        </div>
    </div>
</section>

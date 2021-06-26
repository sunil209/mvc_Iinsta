<?php
 /**
 * Template file. Template params are stored in $params array
 *
 * @param array $items    An array of terms, each containing:
 *        string letter   Section main letter
 *        string url
 *        string title
 *        bool hasVideo
 *
 * @example Usage
 * Component::render('alphabet-list', ['items' => $listingItems]);
 * @endexample
 */
?>

<section class="container js-search-content" data-self="sm-only-full">
    <?php foreach ($items as $letter => $terms) : ?>
        <div id="<?= esc_attr(strtoupper($letter) ?? '') ?>" class="v7-pt-20 v7-mt-10">
            <h2 class="v7-alphabet-list-letter"><?= esc_html($letter) ?></h2>

            <div class="row no-gutters-sm">
            <?php foreach ($terms as $term) : ?>
                <div
                    class="js-search-element col-sm-12 col-lg-6 col-xl-4"
                    data-search="<?= esc_attr($term['title'] ?? '') ?>"
                >
                    <a class="v7-alphabet-list-panel fx-ripple-effect" href="<?= esc_url($term['url'] ?? ''); ?>">
                        <?= esc_html($term['title'] ?? ''); ?>
                        <?php if ($term['hasVideo']) : ?>
                            <i class="v7-alphabet-list-play material-icons">play_arrow</i>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach; ?>
            </div>
        </div>

    <?php endforeach; ?>
</section>

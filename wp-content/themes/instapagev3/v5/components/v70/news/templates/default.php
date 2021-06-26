<?php
 /**
 * Template file. Template params are stored in $params array
 *
 * @param string $sectionTitle
 * @param string $sectionSubtitle
 * @param array $resources      An array of news, each containing:
 *        string title
 *        string url
 *        string subtitle
 *        string date
 *
 * @example Usage
 * Component::render('news');
 * @endexample
 */

use \Instapage\Classes\Component;

if (empty($news) || !is_array($news) || empty($news[0])) {
    return;
}
?>

<section class="v7 v7-mt-80">
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]);
    }
    ?>
    <div class="container">
        <div class="row text-center-md">

            <?php foreach ($news as $singleNews) : ?>
                <div class="v7-news v7-mb-30 col-sm-12 col-lg-4">
                    <h4 class="v7-heading-basic v7-text-cta">
                        <?= esc_html($singleNews['source'] ?? '') ?>
                    </h4>
                    <a
                        class="h3 v7-heading-large v7-btn-flat-black v7-mt-10 v7-mb-10"
                        target="_blank"
                        href="<?= esc_url($singleNews['link'] ?? '') ?>"
                    >
                        <?= esc_html($singleNews['title'] ?? '') ?>
                    </a>
                    <span class="v7-news-date v7-heading-small v7-text-grey">
                        <?= esc_html($singleNews['date'] ?? '') ?>
                    </span>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>

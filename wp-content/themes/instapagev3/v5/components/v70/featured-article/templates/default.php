<?php
/**
 * Listing featured article within a single panel.
 * Template file. Template params are stored in $params array
 *
 * @param string sectionTitle       Main section title
 * @param string sectionSubtitle    Text under section title
 * @param array  featuredArticles   An array of articles
 *
 * @example Basic usage
 * Component::render('featured-article');
 * @endexample
 */

use Instapage\Classes\Component;

if (empty($featuredArticles) || !is_array($featuredArticles)) {
    return;
}
?>

<section class="v7 v7-content v7-mt-80">
    <?php Component::render('division-header', [
        'title' => $sectionTitle,
        'subtitle' => $sectionSubtitle,
        'class' => 'v7-mb-40 v7-mb-md-50'
    ]); ?>
    <?php if (count($featuredArticles) > 1) : ?>
        <div
            class="js-slick-container v7-featured-articles-slider js-v7-featured-articles-slider"
            data-slick-preset="featuredArticles"
        >
    <?php endif ?>
        <?php foreach ($featuredArticles as $featuredArticle) : ?>
            <div class="v7-single-panel-container">
                <?php Component::render('panel', 'listing', $featuredArticle); ?>
            </div>
        <?php endforeach ?>
    <?php if (count($featuredArticles) > 1) : ?>
        </div>
    <?php endif ?>
</section>

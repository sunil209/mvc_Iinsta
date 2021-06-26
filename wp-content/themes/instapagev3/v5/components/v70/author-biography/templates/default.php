<?php
/**
 * Parametrs for this component's view
 *
 * @param string    $authorName
 * @param string    $authorBiography
 * @param string    $authorURL
 * @param array     $authorPhoto
 *                  string regular      Regular author photo URL
 *                  string retina       Retina author photo URL
 *
 * Component's model so usage is simple:
 *
 * @example Basic ACF example
 * Component::render('author-biography');
 * @endexample
 */

use Instapage\Helpers\HtmlHelper;

if (empty($authorName)
    || empty($authorBiography)
    || empty($authorURL)
    || empty($authorPhoto['regular'])
) {
    return;
}
?>
<figure class="v7 v7-author v7-mt-30 v7-mt-md-40">
    <img
        data-src="<?= esc_url($authorPhoto['regular']) ?>"
        class="lazyload v7-author-photo"
        alt="<?= esc_attr($authorName) ?>"
        <?php
        if (!empty($authorPhoto['retina'])) {
            echo HtmlHelper::renderSrcSet(
                [
                    '1x' => $authorPhoto['regular'],
                    '2x' => $authorPhoto['retina'],
                ],
                'data-srcset'
            );
        }
        ?>
    >
    <figcaption class="v7-author-info">
        <h3 class="v7-author-name">
            <span class="v7-author-introduction"><?= __('by') ?></span>
            <a class="v7-btn-flat-black" href="<?= esc_url($authorURL) ?>">
                <?= esc_html($authorName) ?>
            </a>
        </h3>
        <p class="v7-author-description"><?= esc_html($authorBiography) ?></p>
    </figcaption>
</figure>


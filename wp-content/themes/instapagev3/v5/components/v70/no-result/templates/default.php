<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $listingTitle      Title of the section passed to division-header component.
 * @param string $listingSubtitle   Subtitle of the section passed to division-header component.
 */

use Instapage\Classes\Component;
?>

<section class="v7-content v7-mt-80">
    <img
        class="v7-box v7-no-results-icon"
        src="<?= get_template_directory_uri(); ?>/v5/assets/images/icon-no-result.svg"
        alt="<?= __('No Results Icon'); ?>"
    >
    <?php Component::render(
        'division-header',
        [
            'doNotCache' => true,
            'title' => $listingTitle,
            'subtitle' => $listingSubtitle,
            'class' => 'v7-listing-title v7-mt-50 v7-mb-20 v7-mb-md-30'
        ]
    ); ?>
</section>

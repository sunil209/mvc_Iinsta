<?php
use \Instapage\Helpers\HtmlHelper;
use \Instapage\Classes\Component;

?>

<header class="v7 v7-header-wrapper">
    <div
        class="
            v7-header v7-header-solid
            <?= esc_attr($headerClass) ?? '' ?>
            <?= $isLayoutCenter ? 'v7-header-center' : '' ?>
            <?= $isLayoutShort ? 'v7-header-short' : '' ?>
        ">
        <?php
        if ($isLandingPageTemplate) {
            Component::render(
                'header-content',
                'landing-page-template',
                $headerContent
            );
        } else {
            Component::render(
                'header-content',
                [
                    'label' => $label,
                    'title' => $title,
                    'subtitle' => $subtitle,
                    'buttons' => $buttons,
                    'image' => $image,
                    'imageRetina' => $imageRetina,
                    'isTextDark' => true,
                ]
            );
        }
        ?>
    </div>
</header>

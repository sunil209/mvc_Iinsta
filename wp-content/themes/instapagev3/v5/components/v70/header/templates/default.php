<?php
use \Instapage\Helpers\HtmlHelper;
use \Instapage\Classes\Component;

?>

<header class="v7 v7-header-wrapper <?= esc_attr($headerWrapperClass) ?? '' ?>">
    <div
        class="
            v7-header v7-header-dark
            <?= $headerClass ?? '' ?>
            <?= $isLayoutCenter ? 'v7-header-center' : '' ?>
            <?= $isLayoutShort ? 'v7-header-short' : '' ?>
            <?= $isLayoutLight ? 'v7-header-light' : '' ?>
        "
    >
        <?php
        if ($isImageBackground) {
            if ($isMultipleImage && !in_array(false, $multipleImageOptions)) :
                Component::dumbRender('responsive-picture', ['images' => $multipleImageOptions]);
            elseif (!empty($image['url'])) :
                echo HtmlHelper::renderHeaderImg($image['id'], 'v7-header-bg-img', $title);
            endif;
        }
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
                    'title' => $title,
                    'subtitle' => $subtitle,
                    'headerSlotTop' => $headerSlotTop,
                    'headerSlot' => $headerSlot,
                    'scrollToSelector' => $scrollToSelector,
                    'buttons' => $buttons,
                    'image' => $image,
                    'imageRetina' => $imageRetina,
                    'isImageBackground' => $isImageBackground,
                    'featuredIcon' => $featuredIcon
                ]
            );
        }
        ?>
    </div>
</header>

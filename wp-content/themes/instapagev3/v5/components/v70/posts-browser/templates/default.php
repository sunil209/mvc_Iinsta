<?php
/**
 * Template params are stored in $params array
 *
 * @param array  $postTypesLabels   Array of post types labels.
 * @param array  $allPosts          Array of four newest posts per post type, to be passed to Panel component.
 *
 * @example Default
 *  Component::render('posts-browser');
 *
 * @endexample
 *
 */
use Instapage\Classes\Component;
use Instapage\Components\v70\PostsBrowser\PostTypes;

?>

<section class="v7 v7-content v7-mt-80">
    <div class="v7-posts-browser-navigation-wrapper">
        <div class="v7-posts-browser-header-wrapper">
        <?php Component::dumbRender('division-header', [
            'title' => $postTypesLabels[0]['name'],
            'class' => 'js-v7-posts-browser-header v7-mb-20 v7-mb-md-30'
        ]);
        Component::render(
            'dropdown',
            'posts-browser-navigation',
            ['title' => PostTypes::getLabel('post'), 'icon' => true, 'options' => $postTypesLabels]
        );
        ?>
        </div>
        <?php Component::render('navigation-tabs', ['allPosts' => $allPosts]);?>
    </div>
    <div class="v7-posts-browser-slider js-v7-posts-browser-slider">
        <?php foreach ($allPosts as $postsType => $posts) : ?>
        <div class="v7-posts-browser-slide v7 v7-double-panel-container">
            <?php /** @var WP_Post $post */
            foreach ($posts as $post) :
                Component::render(
                    'panel',
                    'listing',
                    array_merge($listingModel->getListingData($post))
                );
            endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

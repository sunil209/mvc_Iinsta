<?php
use \Instapage\Classes\Component;

$postID = get_the_ID();
$postCategories = displayPostCategoriesWithLinks($postID);
$menuItems = getV5Menu('v5-top-menu');

Component::render('v51/document-start');
Component::render(
    'v51/navbar',
    [
        'isSticky' => true,
        'menuClass' => 'navbar-white',
        'desktopNavbarMenu' => Component::fetch(
            'v51/navbar-menu',
            [
                'btnClass'=> 'btn-cta',
                'items' => $menuItems
            ]
        ),
        'mobileNavbarMenu' => Component::fetch(
            'v51/navbar-menu',
            'mobile',
            [
                'items' => $menuItems
            ]
        )
    ]
);
?>
<section class="content is-narrow division-sticky">
<?php Component::render('v51/social-bar', ['title' => get_the_title()]); ?>
<article class="blog-post-page editable-content v7-editable-content">
    <header>
        <h1><?php the_title();?></h1>
        <small>
        <?php
            $pattern = (hasAuthorPosts(get_the_author_meta('ID'))) ?
                '%1$s <time datetime="%2$s">%2$s</time> %3$s <a href="%4$s">%5$s</a>' :
                '%1$s <time datetime="%2$s">%2$s</time> %3$s %5$s';
        ?>
        <?= sprintf(
            $pattern,
            __('Last updated on'),
            ((!empty($postCategories)) && (stripos($postCategories, 'instapage-updates') !== false)) ?
                get_the_date() :
                the_modified_date(null, null, null, false),
            __('by'),
            get_author_posts_url(get_the_author_meta('ID')),
            get_the_author()
        ); ?>
        <?= (!empty($postCategories)) ? sprintf('%1$s %2$s', __('in'), $postCategories) : ''; ?>
        </small>
        <?php if (has_post_video($postID)) : ?>
            <div class="video-featured">
            <div class="loader"></div>
            <?php the_post_thumbnail('v5-single-size'); ?>
            </div>
        <?php elseif (has_post_thumbnail($postID)) : ?>
            <img class="image-featured" src="<?= getV5Src($postID); ?>" srcset="<?= getV5SrcSet($postID); ?>"/>
        <?php endif; ?>
    </header>
  <div class="blog-post-body">
    <?php the_content(); ?>
  </div>
</article>
<?php Component::render('author-biography') ?>
</section>
<?php
Component::render('cta-section', ['contextID' => $contextID]);
Component::render('v51/footer', ['class' => 'main-footer-social-bar']);
Component::render('v51/document-end');

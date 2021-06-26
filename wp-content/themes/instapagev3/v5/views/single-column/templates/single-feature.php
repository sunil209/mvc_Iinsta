<?php
use Instapage\Classes\Component;

$menuItems = [
  ['title' => __('Back to all features'), 'url' => get_post_type_archive_link('feature'), 'classes' => ['back-link']],
  ['title' => __('Login'), 'url' => URL_INSTAPAGE_LOGIN, 'classes' => []],
  ['title' => __('Sign Up Now'), 'url' => URL_INSTAPAGE_SIGNUP, 'classes' => ['btn']]
];

Component::render('v51/document-start');
Component::render(
    'v51/navbar',
    [
        'menuClass' => 'navbar-button-ghost',
        'desktopNavbarMenu' => Component::fetch(
            'v51/navbar-menu',
            [
                'btnClass' => 'btn-white',
                'items' => $menuItems,
                'stickToRight' => true
            ]
        ),
        'mobileNavbarMenu' => Component::fetch('v51/navbar-menu', 'mobile', ['items' => $menuItems])
    ]
);
Component::render(
    'header',
    [
        'featuredIcon' => getAcfVar('big_icon', '', $post->ID),
        'title' => get_the_title(),
        'subtitle' => $post->post_excerpt,
        'headerWrapperClass' => 'v7-section-darker',
        'headerClass' => 'v7-header-single-feature',
        'isLayoutCenter' => true
    ]
);
?>
<main>
    <div class="v7-section-darker">
        <section class="v7-content v7-pt-100 is-narrow">
            <?php if (has_post_video($ID)) : ?>
            <div class="loader-wrapper">
                <div class="loader"></div>
                <?php the_post_thumbnail('v5-single-size'); ?>
            </div>
            <?php elseif (has_post_thumbnail($ID)) : ?>
                <img
                    class="img-responsive"
                    src="<?= getV5Src($ID); ?>"
                    srcset="<?= getV5SrcSet($ID); ?>"
                    alt="<?= get_the_title(); ?>"
                >
            <?php endif; ?>
            <div class="v7-mt-50 v7-pb-100 text-center">
                <?php the_content(); ?>
            </div>
        </section>
    </div>
    <?php Component::render(
        'benefits-section',
        [
            'benefits' => $benefits,
            'layout' => 'no_tiles',
            'class' => 'v7-product-page v7-single-feature'
        ]
    ); ?>
</main>
<?php
Component::render('cta-section', ['isGlobalAcf' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');

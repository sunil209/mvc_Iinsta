<?php

use \Instapage\Classes\Factory;
use \Instapage\Classes\Component;
use \Instapage\Models\SeoPage;

global $post, $amp;

Component::render(
    'amp/document-start',
    [
        'components' => [
            'iframe'    => true,
            'analytics' => true,
            'bind'      => true,
            'accordion' => true
        ],
        'cssFile'    => 'amp/seo.css'
    ]
);
Component::render(
    'amp/navbar',
    [
        'headerImage' => $backgroundImage,
        'navbarMenu'  => Component::fetch('v51/navbar-menu', 'mobile', ['items' => $menuItems]),

        'components' => [
            'analytics' => true
        ],
        'navigation' => true,
        'cssFile'    => 'amp/seo.css'
    ]
);
Component::render(
    'v51/header',
    [
        'headerText'  => getSeoSectionHeader(),
        'headerClass' => 'header-section-seo'
    ]
);
?>
    <main>
        <article>
            <?php if (have_posts()):
                while (have_posts()) : the_post();
                    Component::render('amp/benefits-section', [
                        'layout'   => 'without-titles',
                        'title'    => __('Why should you read this guide?'),
                        'benefits' => $benefits
                    ]); ?>
                    <div class="content division is-narrow editable-content page-single-post">
                        <?php Component::dumbRender('v51/quick-links', [
                            'links' => SeoPage::mapChaptersToQuickLinks($seoPageChapters)
                        ]); ?>
                        <?php
                        foreach ($seoPageChapters as $chapterNumber => $seoPageChapter) :
                            $post = $seoPageChapter;
                            setup_postdata($seoPageChapter->ID);
                            ?>
                            <h2
                                id="chapter-<?= $chapterNumber + 1 ?>"
                                class="scroll-to-with-navbar-offset"
                            >
                                <?php the_title(); ?>
                            </h2>
                            <div class="is-hidden">
                                <?= __('Last updated on') . ' ' . the_modified_date(null, null, null, false); ?>
                            </div>
                            <?php
                            ob_start();
                            the_content();
                            $postContentChapter = ob_get_clean();
                            echo $amp->filter(do_shortcode($postContentChapter));
                            ?>
                        <?php endforeach ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="content">
                    <h2><?= __('Nothing found', 'instapage'); ?></h2>
                </div>
            <?php endif; ?>
        </article>
    </main>
<?php
Component::render('cta-section', [
    'title' => __('Turn More Ad Clicks into Conversions'),
    'subtitle' => __('Try the world\'s first Post-Click Automation™ solution today. Start a trial or schedule a demo to learn more about the Enterprise plan.'),
    'buttons' => [
        [
            'text' => __('Get Started'),
            'url' => URL_INSTAPAGE_SIGNUP,
            'class' => 'v7-btn-white v7-btn-large v7-btn-cta'
        ],
        [
            'text' => __('REQUEST A DEMO'),
            'url' => get_home_url() . '/enterprise-demo-request',
            'class' => 'v7-btn-large v7-btn-ghost'
        ]
    ]
]);
Component::render('amp/footer');
Component::render('amp/document-end');

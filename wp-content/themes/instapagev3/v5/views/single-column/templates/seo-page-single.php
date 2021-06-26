<?php

use \Instapage\Classes\Component;
use \Instapage\Models\SeoPage;

global $post;

Component::render(
    'v51/document-start',
    [
        'headerImage' => $backgroundImage,
    ]
);
Component::render(
    'v51/navbar',
    [
        'desktopNavbarMenu' => Component::fetch('v51/navbar-menu',
            ['btnClass' => 'btn-ghost', 'items' => $menuItems, 'stickToRight' => true]),
        'mobileNavbarMenu'  => Component::fetch('v51/navbar-menu', 'mobile', ['items' => $menuItems]),
    ]
);
Component::render('v51/header', [
    'headerText'  => getSeoSectionHeader(),
    'headerClass' => 'header-section-seo'
]);

?>
    <main>
        <article>
            <?php if (have_posts()):
                while (have_posts()) : the_post();
                    Component::render('v51/benefits-section', [
                        'section'  => 'section-darker',
                        'layout'   => 'without-titles',
                        'title'    => 'Why should you read this guide?',
                        'benefits' => $benefits
                    ]); ?>
                    <div class="is-hidden">
                        <?= __('Last updated on') . ' ' . the_modified_date(null, null, null, false); ?>
                    </div>
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
                            <?php the_content(); ?>
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

<?php Component::render('cta-section', ['isGlobalAcf' => true, 'isMarginOmitted' => true]); ?>
<?php Component::render('v51/footer'); ?>
<?php Component::render('v51/document-end');

<?php
use Instapage\Classes\Component;
use Instapage\Models\DictionaryTerm;

Component::render('v51/document-start');
Component::render('v51/navbar', ['menuClass' => 'navbar-white']);
Component::render(
    'header',
    [
        'title' => $termDefinition['title'] ?? '',
        'subtitle' => $termDefinition['subtitle'] ?? '',
        'isLayoutCenter' => true,
        'isLayoutLight' => true,
        'headerSlotTop' => Component::fetch('breadcrumbs', ['items' => $breadCrumbsItems ?? []])
    ]
);
?>
<div>
    <?php Component::render('v51/social-bar', ['title' => $termDefinition['title'] ?? '']);
    if (!empty($video)) : ?>
        <section class="container" data-self="sm-only-full">
            <div class="row no-gutters-sm">
                <div class="v7-dictionary-video col-sm-12 col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                    <?= $video; ?>
                </div>
            </div>
        </section>
    <?php endif;
    Component::render('tweet', $clickToTweet ?? ''); ?>
    <section class="v7-content v7-mt-80 v7-mt-md-100">
        <?php
        if (!empty($trendsChart)) {
            Component::render('division-header', [
                'title' => __('Global Search Trend'),
                'class' => 'v7 v7-mb-40 v7-mb-md-50'
            ]);
            echo $trendsChart;
        }
        ?>
    </section>
    <?php Component::render('related-terms', ['items' => $dictionaryRelatedTerms ?? []]); ?>
</div>
<?php
Component::render('cta-section', ['isGlobalAcf' => true, 'backgroundDark' => true]);
Component::render('v51/footer', ['class' => 'main-footer-social-bar']);
Component::render('v51/document-end');

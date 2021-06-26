<?php
use \Instapage\Classes\Factory;
use \Instapage\Classes\Component;
use \Instapage\Helpers\StringHelper;

Component::render('v51/document-start');
Component::render('v51/navbar', ['menuClass' => 'navbar-button-ghost']);
?>
<main>
    <?php foreach ($categories as $category) :
        foreach ($template->categories as $templateCategory) :
            if ($category['id'] === $templateCategory) :
                $headerContent = [
                    'title' => $template->name,
                    'subtitle' => $template->description,
                    'label' => $category['name'],
                    'labelUrl' => home_url($archiveSlug) . $category['url'],
                    'prevTemplate' => home_url($archiveSlug . '/' . $template->previous->slug),
                    'nextTemplate' => home_url($archiveSlug . '/' . $template->next->slug),
                    'buttonText' => __('Use this layout'),
                    'buttonUrl' =>
                    URL_INSTAPAGE
                    . '/templates/index/'
                    . $template->page
                    . '?skip_preview'
                    . $template->skip_preview
                ];
                Component::render(
                    'header',
                    'solid',
                    [
                        'headerClass' => 'is-dark',
                        'isLayoutCenter' => true,
                        'isLandingPageTemplate' => true,
                        'headerContent' => $headerContent
                    ]
                );
            endif;
        endforeach;
    endforeach;

    Component::render(
        'filter',
        'landing-page-template',
        [
            'template' => get_object_vars($template),
            'filters' => [
                [
                    'filter' => 'desktop',
                    'visibility' => true
                ],
                [
                    'filter' => 'mobile',
                    'visibility' => false
                ]
            ]
        ]
    ); ?>
    <section class="v7 v7-mt-80 v7-mb-80">
        <?php Component::dumbRender('division-header', [
                'title' => __('Similar layouts'),
                'class' => 'v7-mb-40 v7-mb-md-50 '
        ]); ?>
        <div class="v7-content v7-panel-container">
            <?php foreach ($similarTemplates as $similarTemplate) :
                Component::render(
                    'panel',
                    [
                        'image' => ['url' => $similarTemplate->thumbnail_image],
                        'layout' => 'bigHeading',
                        'title' => $similarTemplate->name,
                        'text' => StringHelper::truncate($similarTemplate->description, 100),
                        'moreText' => __('View layout'),
                        'url' => home_url($similarTemplate->slug)
                    ]
                );
            endforeach; ?>
        </div>
    </section>

</main>
<?php
Component::render('cta-section', ['isGlobalAcf' => true, 'isMarginOmitted' => true]);
Component::render('v51/footer');
Component::render('v51/document-end');

<?php
use Instapage\Classes\Factory;
use Instapage\Classes\Component;

Component::render('v51/document-start', ['contextID' => $contextID]);
Component::render('v51/navbar', ['contextID' => $contextID]);
Component::render(
    'header',
    [
      'contextID' => $contextID,
      'headerSlot' => Component::fetch('search', 'shadow', ['placeholder' => 'Search...'])
    ]
);
//Topbar
Component::render('tiles', ['contextID' => $contextID, 'layout' => 'features']);
?>

<section class="v7 v7-mt-50 v7-content text-center v7-is-hidden js-search-heading">
    <h2 class="h1">Search Results for “<span class="js-search-keyword"></span>”:</h2>
</section>
<main class="v7-content v7-mt-50 v7-template-dual-column">
    <!-- Sidebar -->
    <?php
    Component::render(
        'sidebar',
        [
            'title' => __('Categories'),
            'options' => $categories,
            'sidebarClass' => 'js-sidebar',
            'sidebarMobile' => Component::fetch('select', [
                'options' => $categories,
                'title' => __('All Categories'),
                'selectClass' => 'v7-sidebar-select',
                'name' => 'all-categories'])
        ]
    );
    //Content
    Component::render(
        'accordion',
        [
            'accordions' => $accordions,
            'isEditable' => true,
            'sectionClass' => 'v7-template-dual-column-right'
        ]
    ); ?>
</main>
<?php
Component::render('cta-section', ['contextID' => $contextID ]);
?>
<?php Component::render('v51/footer'); ?>
<?php Component::render('v51/document-end');

<?php
use Instapage\Classes\Component;

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('header');
?>

<main class="v7-content v7-mt-50 v7-template-dual-column">
    <?php
    // Sidebar
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
                'name' => 'all-categories'
            ])
        ]
    );
    //Content
    Component::render('accordion', ['accordions' => $accordions, 'isEditable' => true]);
    ?>
</main>
<?php
Component::render('cta-section');
Component::render('v51/footer');
Component::render('v51/document-end');

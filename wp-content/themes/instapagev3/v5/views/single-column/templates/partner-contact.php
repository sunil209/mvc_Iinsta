<?php
use \Instapage\Classes\Factory;
use \Instapage\Classes\Component;

/** @var \Instapage\Models\PartnerContact $model */
$model = Factory::getModel(getV5Page());
$response = $model->handleFormSubmit();

Component::render('v51/document-start');
Component::render(
    'v51/navbar',
    [
        'menuClass' => 'navbar-white',
        'mobileNavbarMenu' => Component::fetch(
            'v51/navbar-menu',
            'mobile',
            ['mobileClass' => 'navbar-white']
        )
    ]
);
?>

<section class="container v7-mt-70 v7-mb-30 v7-mb-xl-50 v7-pt-70">
    <div class="row no-gutters">
        <?php Component::render(
            'benefits-section',
            'side-column',
            [
                'gridClasses' => 'col-12 col-md-8 col-lg-6'
            ]
        );
        Component::render(
            'form',
            'partner-contact',
            [
                'title' => 'Send Us a message',
                'response' => $response,
                'nonceTokenName' => $model->getNonceTokenName()
            ]
        ); ?>
    </div>
</section>
<?php
Component::render('v51/footer');
Component::render('v51/document-end');

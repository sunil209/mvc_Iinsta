<?php
use \Instapage\Classes\Component;
use \Instapage\Components\V70\Modal\Controller as ModalComponent;
use \Instapage\Classes\Factory;
use \Instapage\Classes\Forms\FormResponse;

$response = (new Instapage\Models\Contact)->handleFormSubmit();
$officeSelect = [
    '' => '',
    'Poland' =>  '',
    'United States' =>  '',
    'Romania' =>  ''
];

Component::render('v51/document-start');
?>

<style type="text/css">
    .p-20 {
        padding: 20px;
    }

    .color-sample {
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }

    .mb-30 {
        margin-bottom: 30px;
    }
</style>

<section class="v7-mt-80 v7-content text-center v7" style="display:flex;justify-content:space-around;flex-wrap:wrap;">
    <div class="p-20">
        <div class="color-sample" style="background-color:#2d67f7;"></div>
        <p>$color_ocean</p>
        <p>#2d67f7</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#3d84fe;"></div>
        <p>$color_sky</p>
        <p>#3d84fe</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#00c0f7;"></div>
        <p>$color_aqua</p>
        <p>#00c0f7</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#6f4ff6;"></div>
        <p>$color_purple</p>
        <p>#6f4ff6</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#00d4ae;"></div>
        <p>$color_mint</p>
        <p>#00d4ae</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#ffd739;"></div>
        <p>$color_orange</p>
        <p>#ffd739</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#ff6f61;"></div>
        <p>$color_red</p>
        <p>#ff6f61</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#273245;"></div>
        <p>$color_dark</p>
        <p>#273245</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#45536b;"></div>
        <p>$color_slate</p>
        <p>#45536b</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#8b98a9;"></div>
        <p>$color_grey</p>
        <p>#8b98a9</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#bacee4;"></div>
        <p>$color_fog</p>
        <p>#bacee4</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#e7f1fa;"></div>
        <p>$color_ice</p>
        <p>#e7f1fa</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#ebf2fa;"></div>
        <p>$color_snow</p>
        <p>#ebf2fa</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#f7fbff;"></div>
        <p>$color_quartz</p>
        <p>#f7fbff</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#ffffff;border:1px solid black;"></div>
        <p>$color_white</p>
        <p>#ffffff</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#0d2187;"></div>
        <p>$color_royal</p>
        <p>#0d2187</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#0d2999;"></div>
        <p>$color_navy</p>
        <p>#0d2999</p>
    </div>
    <div class="p-20">
        <div class="color-sample" style="background-color:#104ada;"></div>
        <p>$color_blue</p>
        <p>#104ada</p>
    </div>
</section>

<?php
Component::render(
    'form',
    'multistep',
    [
        'response' => $response,
        'officeSelect' => $officeSelect,
    ]
);
Component::render('v51/carousel', 'single');
?>

<section class="v7-mt-80 v7-content v7">
    <div class="v7-pt-40 v7-pt-md-50">
        <h1>H1 Lorem ipsum dolor sit amet, consectetur adi.</h1>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h2>H2 Lorem ipsum dolor sit amet, consectetur adi.</h2>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h3>H3 Lorem ipsum dolor sit amet, consectetur adi.</h3>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h4>H4 Lorem ipsum dolor sit amet, consectetur adi.</h4>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h5>H5 Lorem ipsum dolor sit amet, consectetur adi.</h5>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <p>Paragraph Lorem ipsum dolor sit amet, consectetur adi.</p>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <p class="small">Paragraph Small Lorem ipsum dolor sit amet, consectetur adi.</p>
    </div>
</section>

<section class="v7-mt-80 v7-content text-center v7">
    <div class="v7-pt-40 v7-pt-md-50">
        <h1>H1 Lorem ipsum dolor sit amet, consectetur adi.</h1>
        <p>Dramatically increase your conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution, you can create precisely targeted post-click experiences as quickly as you do ads.</p>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h2>H2 Lorem ipsum dolor sit amet, consectetur adi.</h2>
        <p>Dramatically increase your conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution, you can create precisely targeted post-click experiences as quickly as you do ads.</p>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h3>H3 Lorem ipsum dolor sit amet, consectetur adi.</h3>
        <p>Dramatically increase your conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution, you can create precisely targeted post-click experiences as quickly as you do ads.</p>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h4>H4 Lorem ipsum dolor sit amet, consectetur adi.</h4>
        <p>Dramatically increase your conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution, you can create precisely targeted post-click experiences as quickly as you do ads.</p>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h5>H5 Lorem ipsum dolor sit amet, consectetur adi.</h5>
        <p>Dramatically increase your conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution, you can create precisely targeted post-click experiences as quickly as you do ads.</p>
    </div>
</section>

<section class="v7-mt-80 v7-content is-narrow text-center v7">
    <div class="v7-pt-40 v7-pt-md-50">
        <h1>H1 Lorem ipsum dolor sit amet, consectetur adi.</h1>
        <p class="small">Dramatically increase your conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution, you can create precisely targeted post-click experiences as quickly as you do ads.</p>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h2>H2 Lorem ipsum dolor sit amet, consectetur adi.</h2>
        <p class="small">Dramatically increase your conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution, you can create precisely targeted post-click experiences as quickly as you do ads.</p>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h3>H3 Lorem ipsum dolor sit amet, consectetur adi.</h3>
        <p class="small">Dramatically increase your conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution, you can create precisely targeted post-click experiences as quickly as you do ads.</p>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h4>H4 Lorem ipsum dolor sit amet, consectetur adi.</h4>
        <p class="small">Dramatically increase your conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution, you can create precisely targeted post-click experiences as quickly as you do ads.</p>
    </div>
    <div class="v7-pt-40 v7-pt-md-50">
        <h5>H5 Lorem ipsum dolor sit amet, consectetur adi.</h5>
        <p class="small">Dramatically increase your conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution, you can create precisely targeted post-click experiences as quickly as you do ads.</p>
    </div>
</section>

<section class="v7-mt-80 v7-content is-narrow text-center v7">
    <div class="v7-pt-40 v7-pt-md-50">
        <h2 class="mb-30">Button CTA</h2>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-cta v7-btn-large js-modal-trigger', 'attributes' => ['data-modal-id' => 'js-pricing-plans']]); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-cta']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-cta v7-btn-small']); ?>
    </div>

    <div class="v7-pt-40 v7-pt-md-50">
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-cta v7-btn-large']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-cta']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-cta v7-btn-small']); ?>
    </div>

    <div class="v7-pt-40 v7-pt-md-50">
        <h2 class="mb-30">Button Ghost CTA</h2>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-ghost-cta v7-btn-large']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-ghost-cta']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-ghost-cta v7-btn-small']); ?>
    </div>

    <div class="v7-pt-40 v7-pt-md-50">
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-ghost-cta v7-btn-large']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-ghost-cta']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-ghost-cta v7-btn-small']); ?>
    </div>

    <div class="v7-pt-40 v7-pt-md-50">
        <h2 class="mb-30">Button Flat</h2>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-flat v7-btn-large']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-flat']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-flat v7-btn-small']); ?>
    </div>

    <div class="v7-pt-40 v7-pt-md-50">
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-flat v7-btn-large']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-flat']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-flat v7-btn-small']); ?>
    </div>

    <h2 class="mb-30">Button White</h2>
    <div class="v7-pt-40 v7-pt-md-50" style="background-color:#2d67f7">
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-white v7-btn-large']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-white']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'class' => 'v7-btn-white v7-btn-small']); ?>
    </div>

    <div class="v7-pt-40 v7-pt-md-50" style="background-color:#2d67f7">
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-white v7-btn-large']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-white']); ?>
        <?php Component::render('v70/button', ['text' => __('SIGN UP NOW'), 'url' => '#', 'icon' => 'play_arrow', 'class' => 'v7-btn-white v7-btn-small']); ?>
    </div>
</section>

<?php
$modal = new ModalComponent(['sectionClass' => 'js-pricing-plans', 'modalSlot' => Component::fetch('pricing-plans')]);
$modal->renderDelayed();
Component::render('v70/testimonials-slider');
Component::render(
    'background-gradient',
    [
        'isBackgroundGradient' => true,
        'backgroundGradientPosition' => 'overlap',
        'backgroundGradientClass' => 'v7-feature-tile-background'
    ]
);
Component::render('feature-repeater', 'tile');
Component::render('feature', ['class' => 'v7-mt-md-60']);
Component::render('feature', 'grid', ['class' => 'v7-mt-md-60']);

$tiles = [
    [
        'image' => WP_CONTENT_URL . '/uploads/2019/03/personalization-icons.svg',
        'title' => 'Personalization',
        'url' => 'http://example.com',
        'moreText' => 'more Info'
    ],
    [
        'image' => WP_CONTENT_URL . '/uploads/2019/03/creation-icons.svg',
        'title' => 'Creation',
        'url' => 'http://example.com',
        'moreText' => 'more Info'
    ],
    [
        'image' => WP_CONTENT_URL . '/uploads/2019/03/experimentation-icons.svg',
        'title' => 'Experimentation',
        'url' => 'http://example.com',
        'moreText' => 'more Info'
    ],
    [
        'image' => WP_CONTENT_URL . '/uploads/2019/03/collaboration-icons.svg',
        'title' => 'Collaboration',
        'url' => 'http://example.com',
        'moreText' => 'more Info'
    ],
    [
        'image' => WP_CONTENT_URL . '/uploads/2019/03/velocity-icons.svg',
        'title' => 'Velocity',
        'url' => 'http://example.com',
        'moreText' => 'more Info'
    ],
    [
        'image' => WP_CONTENT_URL . '/uploads/2019/03/all-products-icons.svg',
        'title' => 'All Products',
        'url' => 'http://example.com',
        'moreText' => 'more Info'
    ]
];
Component::render('tiles', ['tiles' => $tiles, 'sectionTitle' => 'Lorem Ipsum', 'sectionSubtitle' => 'Dramatically increase your
conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution,
you can create precisely targeted post-click experiences as quickly as you do ads.', 'layout' => 'two']);

Component::render('tiles', ['layout' => 'four', 'class' => 'v7-tiles-colored']);

Component::render('tiles', get_field('tile_layout') ?? 'default');

Component::render('expandable-tiles');

Component::render('patterned-tiles');

Component::render('engagement-box');

Component::render('panel-section', ['sectionClass' => 'v7-section-ocean', 'divisionClass' => 'white']);

Component::render('panel-section', ['sectionTitle' => 'Lorem Ipsum', 'sectionSubtitle' => 'Dramatically increase your
conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution,
you can create precisely targeted post-click experiences as quickly as you do ads.']);

Component::render('panel-section', ['sectionTitle' => 'Lorem Ipsum', 'sectionSubtitle' => 'Dramatically increase your
conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution,
you can create precisely targeted post-click experiences as quickly as you do ads.']);

Component::render('panel-section', ['sectionTitle' => 'Lorem Ipsum', 'sectionSubtitle' => 'Dramatically increase your
conversions by sending targeted ads to personalized post-click experiences. With our Personalization Solution,
you can create precisely targeted post-click experiences as quickly as you do ads.']);

$listing = [
    'image' => [
        'https://storage.googleapis.com/website-production/uploads/2018/01/marketing-teams.jpg',
        '570',
        '285'
    ],
    'image_retina' => [
        'https://storage.googleapis.com/website-production/uploads/2018/01/marketing-teams@2x.jpg'
    ],
    'title' => 'It’s Official: AMP Landing Pages Now Available in Instapage',
    'excerpt' => 'Back in February we announced our partnership with Google to develop
    Accelerated Mobile Pages (AMP) functionality in the recent version of our product.',
    'postCategories' =>  get_the_category(125893),
    'link' => 'https://instapage.com/blog/personalization',
    'isTargetBlank' => false,
    'authorName' => 'John Doe',
    'authorID' => 103,
    'moreText' => 'Read more'
  ];

Component::render('featured-article');
Component::render('left-right');
?>


<section class="v7-content v7-mt-80">
    <div class="v7 v7-double-panel-container">
        <?php
        Component::render('panel', 'listing', $listing);
        Component::render('panel', 'listing', $listing);
        Component::render('panel', 'listing', $listing);
        Component::render('panel', 'listing', $listing);
        ?>
    </div>
</section>

<section class="v7-content v7-mt-80">
    <?php
    Component::render(
        'avatar',
        [
            'image' => 'https://instapage.com/wp-content/uploads/2018/01/random-user-image-m-43.jpg',
            'authorName' => 'John Doe',
            'authorID' => 103
        ]
    );
    ?>
    <?php
    Component::render(
        'avatar',
        [
            'image' => 'https://instapage.com/wp-content/uploads/2018/01/random-user-image-m-43.jpg',
            'authorName' => 'John Doe',
            'authorID' => 103,
            'disableLink' => true
        ]
    );
    ?>
</section>

<section class="v7-content v7-mt-70 v7-mb-30 v7-mb-xl-50 v7-pt-70">
    <div class="row no-gutters">
        <?php Component::render(
            'benefits-section',
            'side-column'
        );?>
        <div class="col-12 col-md-8 col-lg-5 offset-lg-1 v7-mx-auto"></div>
    </div>
</section>
<?php
Component::render('benefits-section', 'inline');
Component::render('benefits-section', ['class' => 'v7-benefits-downloadable']);
Component::render('benefits-section');
Component::render('benefits-section', 'jumbo-tiles');
Component::render('benefits-section', ['class' => 'v7-benefits-downloadable']);
Component::render('benefits-section', 'list');
Component::render('benefits-section', 'list');
Component::render('v70/product-features-slider');
Component::render('filter');
?>

<section class="v7-content v7-mt-80">
<?php
$categories =  [
    [
        'id' => 'term-amp',
        'name' => 'AMP',
        'url' => 'https://localhost/category/amp',
    ],
    [
        'id' => 'term-affiliate-insights',
        'name' => 'Affiliate Insights',
        'url' => 'https://localhost/category/affiliate-insights',
    ],
    [
        'id' => 'term-ab-split-testing',
        'name' => 'A/B Split Testing',
        'url' => 'https://localhost/category/ab-split-testing',
    ],
    [
        'id' => 'term-advertising',
        'name' => 'Advertising',
        'url' => 'https://localhost/category/advertising',
    ],
    [
        'id' => 'term-google-ads',
        'name' => 'Google Ads',
        'url' => 'https://localhost/category/google-ads',
    ],
    [
        'id' => 'term-conversion-optimization',
        'name' => 'Conversion Optimization',
        'url' => 'https://localhost/category/conversion-optimization',
    ],
    [
        'id' => 'term-facebook-advertising',
        'name' => 'Facebook Advertising',
        'url' => 'https://localhost/category/facebook-advertising',
    ],
    [
        'id' => 'term-instapage-updates',
        'name' => 'Instapage Updates',
        'url' => 'https://localhost/category/instapage-updates',
    ],
    [
        'id' => 'term-landing-page-examples',
        'name' => 'Landing Page Examples',
        'url' => 'https://localhost/category/landing-page-examples',
    ],
    [
        'id' => 'term-lead-generation',
        'name' => 'Lead Generation',
        'url' => 'https://localhost/category/lead-generation',
    ],
    [
        'id' => 'term-marketing-agency-tips',
        'name' => 'Marketing Agency Tips',
        'url' => 'https://localhost/category/marketing-agency-tips',
    ],
    [
        'id' => 'term-marketing-personalization',
        'name' => 'Marketing Personalization',
        'url' => 'https://localhost/category/marketing-personalization',
    ],
];
Component::render('dropdown', ['title' => 'All Categories', 'icon' => true, 'options' => $categories]);
?>
</section>

<?php
Component::render('cta-section', [
    'backgroundBrightBlue' => true,
    'title' => 'Get Started Now',
    'subtitle' => 'Try the most powerful all-in-one landing page solution today. Start a 14-day free trial,
    no credit card required, or schedule a demo to learn more about the Enterprise plan.',
    'buttons' => [
        ['text' => 'START FOR FREE', 'url' => '#', 'class' => 'v7-btn-white v7-btn-large', 'video' => false],
        ['text' => 'REQUEST DEMO', 'url' => '#', 'class' => 'v7-btn-ghost v7-btn-large', 'video' => false]
    ]
]);
Component::render('cta-section', [
    'title' => 'Get Started Now',
    'subtitle' => 'Try the most powerful all-in-one landing page solution today. Start a 14-day free trial,
    no credit card required, or schedule a demo to learn more about the Enterprise plan.',
    'buttons' => [
        ['text' => 'START FOR FREE', 'url' => '#', 'class' => 'v7-btn-white v7-btn-large', 'video' => false],
        ['text' => 'REQUEST DEMO', 'url' => '#', 'class' => 'v7-btn-ghost v7-btn-large', 'video' => false]
    ]
]);
Component::render('header', 'solid', ['headerClass' => 'is-dark']);
Component::render('logos', ['logosSpacing' => 'v7-pt-sm-60 v7-pt-md-100']);
Component::render('header', 'solid');
Component::render('logos', ['logosSpacing' => 'v7-pt-sm-60 v7-pt-md-30']);
Component::render('header');
?>

<section class="v7 v7-mt-80 v7-pt-80 v7-pb-80 v7-pb-xl-100 v7-bg-royal">
    <div class="container">
        <div class="v7-grid-topfold-helper row">
            <div class="col-12 col-lg-6">
                <?php Component::render('division-header', ['class' => 'white text-left-lg v7-mt-lg-80 v7-mt-xl-100']);
                Component::render('logos', 'grid', ['logosSpacing' => 'v7-pt-50']); ?>
            </div>
            <div class="v7-mt-sm-only-20 v7-mt-md-only-50 col-12 col-lg-5 offset-lg-1">
                <div style="height: 600px" class="v7-box v7-py-30 v7-px-30">Form placeholder</div>
            </div>
        </div>
    </div>
</section>

<section class="v7-mt-80">
    <?php Component::render('header'); ?>
</section>

<section class="v7-mt-80 v7-content">
    <?php
    Component::render(
        'form',
        'contact',
        [
            'title' => 'Send Us a Message',
            'response' => $response,
            'nonceTokenName' => 'contact'
        ]
    );
    ?>
</section>

<section class="v7-mt-80">
    <?php Component::render('header', ['headerClass' => 'v7-header-short']); ?>
</section>

<section class="v7-mt-80">
    <?php Component::render('header', ['headerClass' => 'v7-header-center']); ?>
</section>

<?php
$listCore = [
    [
        'feature' => 'Post-Click Experience Creation',
        'is_active_core' => true
    ],
    [
        'feature' => 'Analytics Suite ',
        'is_active_core' => true
    ],
    [
        'feature' => 'Robust Integration Ecosystem',
        'is_active_core' => true
    ],
    [
        'feature' => 'Responsive Pages for all Devices',
        'is_active_core' => true
    ]
];
$listEnterprise = [
    [
        'feature' => 'Scalable Page Creation with Global Blocks',
        'is_active_enterprise' => true
    ],
    [
        'feature' => 'Personalization Experience Manager',
        'is_active_enterprise' => true
    ],
    [
        'feature' => 'Customer Success & Professional Services',
        'is_active_enterprise' => true
    ],
    [
        'feature' => 'Enterprise-Level Security Features',
        'is_active_enterprise' => true
    ]
];
?>

<?php
Component::render('image-repeater', 'four-columns');
Component::render('lists');
Component::render('image-repeater');
Component::render('lists', ['class' => 'v7-checklist-background']);
Component::render('posts-browser');

$accordions = [
    [
        'groupID' => 'term-advertising',
        'headline' => __('Example accordion'),
        'items' => [
            [
                'title' => __('Conversion Analytics Solution'),
                'icon' => 'https://storage.googleapis.com/website-production/uploads/2017/09/Artboard-2.svg',
                'url' => 'https://instapage.com/',
                'videoEmbedCode' => '
                <div class="video-responsive-wrapper">
                <div class="video-responsive video-instapage-app">
                <div class="loader"></div>
                <iframe allowfullscreen="" class="lazy lazyloaded"
                data-src="https://fast.wistia.net/embed/iframe/3ik9vsn6ir?dnt=1"
                title="AdWords and Analytics Integrations Video" allowtransparency="true"
                frameborder="0" scrolling="no"
                name="wistia_embed" mozallowfullscreen="" webkitallowfullscreen=""
                oallowfullscreen="" msallowfullscreen="" width="500" height="281">
                </iframe>
                <script class="lazy lazyload" data-src="https://fast.wistia.net/assets/external/E-v1.js" async="">
                </script>
                </div>
                </div>
                ',
                'excerpt' => __('Directly integrate with Google AdWords and Analytics for easier attribution and make
                 real-time cost-per-visitor and cost-per-lead metrics visible right in the Instapage platform. Then,
                 pass lead metadata down to your CRM or marketing automation system.')

            ],
            [
                'title' => __('Conversion Analytics Solution'),
                'icon' => 'https://storage.googleapis.com/website-production/uploads/2017/09/Artboard-2.svg',
                'excerpt' => __('Directly integrate with Google AdWords and Analytics for easier attribution and make
                 real-time cost-per-visitor and cost-per-lead metrics visible right in the Instapage platform. Then,
                 pass lead metadata down to your CRM or marketing automation system.')
            ]
        ]
    ],
    [
        'groupID' => 'term-enterprise',
        'headline' => __('Example accordion'),
        'items' => [
            [
                'title' => __('Conversion Analytics Solution'),
                'icon' => 'https://storage.googleapis.com/website-production/uploads/2017/09/Artboard-2.svg',
                'excerpt' => __('Directly integrate with Google AdWords and Analytics for easier attribution and make
                 real-time cost-per-visitor and cost-per-lead metrics visible right in the Instapage platform. Then,
                 pass lead metadata down to your CRM or marketing automation system.')

            ],
            [
                'title' => __('Conversion Analytics Solution'),
                'icon' => 'https://storage.googleapis.com/website-production/uploads/2017/09/Artboard-2.svg',
                'excerpt' => __('Directly integrate with Google AdWords and Analytics for easier attribution and make
                 real-time cost-per-visitor and cost-per-lead metrics visible right in the Instapage platform. Then,
                 pass lead metadata down to your CRM or marketing automation system.')

            ],
            [
                'title' => __('Conversion Analytics Solution'),
                'icon' => 'https://storage.googleapis.com/website-production/uploads/2017/09/Artboard-2.svg',
                'excerpt' => __('Directly integrate with Google AdWords and Analytics for easier attribution and make
                 real-time cost-per-visitor and cost-per-lead metrics visible right in the Instapage platform. Then,
                 pass lead metadata down to your CRM or marketing automation system.')

            ],
            [
                'title' => __('Conversion Analytics Solution'),
                'icon' => 'https://storage.googleapis.com/website-production/uploads/2017/09/Artboard-2.svg',
                'excerpt' => __('Directly integrate with Google AdWords and Analytics for easier attribution and make
                 real-time cost-per-visitor and cost-per-lead metrics visible right in the Instapage platform. Then,
                 pass lead metadata down to your CRM or marketing automation system.')

            ],
            [
                'title' => __('Conversion Analytics Solution'),
                'icon' => 'https://storage.googleapis.com/website-production/uploads/2017/09/Artboard-2.svg',

                'excerpt' => __('Directly integrate with Google AdWords and Analytics for easier attribution and make
                 real-time cost-per-visitor and cost-per-lead metrics visible right in the Instapage platform. Then,
                 pass lead metadata down to your CRM or marketing automation system.')

            ],
            [
                'title' => __('Conversion Analytics Solution'),
                'icon' => 'https://storage.googleapis.com/website-production/uploads/2017/09/Artboard-2.svg',
                'excerpt' => __('Directly integrate with Google AdWords and Analytics for easier attribution and make
                 real-time cost-per-visitor and cost-per-lead metrics visible right in the Instapage platform. Then,
                 pass lead metadata down to your CRM or marketing automation system.')

            ],
            [
                'title' => __('Conversion Analytics Solution'),
                'icon' => 'https://storage.googleapis.com/website-production/uploads/2017/09/Artboard-2.svg',
                'excerpt' => __('Directly integrate with Google AdWords and Analytics for easier attribution and make
                 real-time cost-per-visitor and cost-per-lead metrics visible right in the Instapage platform. Then,
                 pass lead metadata down to your CRM or marketing automation system.')

            ],
            [
                'title' => __('Conversion Analytics Solution'),
                'icon' => 'https://storage.googleapis.com/website-production/uploads/2017/09/Artboard-2.svg',
                'excerpt' => __('Directly integrate with Google AdWords and Analytics for easier attribution and make
                 real-time cost-per-visitor and cost-per-lead metrics visible right in the Instapage platform. Then,
                 pass lead metadata down to your CRM or marketing automation system.')
            ]
        ]
    ]
];
$categories = [
    [
        'id' => 'term-advertising',
        'name' => 'Advertising ',
        'url' => '#term-advertising'
    ],
    [
        'id' => 'term-instapage-builder ',
        'name' => 'Instapage Builder ',
        'url' => '#term-instapage-builder'
    ],
    [
        'id' => 'term-design',
        'name' => 'Design',
        'url' => '#term-design'
    ],
    [
        'id' => 'term-lead-capture',
        'name' => 'Lead Capture ',
        'url' => '#term-lead-capture'
    ],
    [
        'id' => 'term-optimization',
        'name' => 'Optimization ',
        'url' => '#term-optimization'
    ],
    [
        'id' => 'term-integrations-publishing',
        'name' => 'Integrations & Publishing ',
        'url' => '#term-integrations-publishing'
    ],
    [
        'id' => 'term-team-agency-management ',
        'name' => 'Team & Agency Management ',
        'url' => '#term-team-agency-management'
    ],
    [
        'id' => 'term-security-support ',
        'name' => 'Security & Support ',
        'url' => '#term-security-support'
    ],
    [
        'id' => 'term-enterprise',
        'name' => 'Enterprise ',
        'url' => '#term-enterprise'
    ]
];
?>
<main class="v7-content v7-mt-80 v7-template-dual-column">
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
                'name' => 'all-categories'
                ])
        ]
    );

    Component::render('accordion', ['accordions' => $accordions, 'isEditable' => true]);
    ?>
</main>
<div class="v7-content">
    <?php Component::render('accordion'); ?>
</div>
<div class="v7-content">
    <?php Component::render('accordion', ['isEditable' => true]); ?>
</div>

<?php
//Component::render('v51/workable');
Component::render('v51/document-end');

<?php
use \Instapage\Classes\Component;
use \Instapage\Classes\Factory;
use \Instapage\Helpers\StringHelper;
use \Instapage\Helpers\HtmlHelper;

$leftRightNormal = [
  [
    'title' => __('Intuitive Builder with Advanced Design Features'),
    'text' => __('Build fully customizable, mobile responsive landing pages quickly without a developer. Design to your clients brand guidelines with custom fonts, inline CSS editor, and advanced design features like alignment, grouping and distribution.'),
    'image' => get_template_directory_uri() . '/v5/assets/images/intuitive-builder-with-advanced.jpg',
    'imageRetina' => get_template_directory_uri() . '/v5/assets/images/retina/intuitive-builder-with-advanced@2x.jpg',
    'textAlignment' => 'left-right-text'
  ],
  [
    'title' => __('A/B Split Testing and Ongoing Optimization'),
    'text' => __('Build multiple variations of your landing page and split test them to optimize for higher conversions. Offer ongoing optimization services to keep your clients for longer.'),
    'image' => get_template_directory_uri() . '/v5/assets/images/a_b-split-testing-and.jpg',
    'imageRetina' => get_template_directory_uri() . '/v5/assets/images/retina/a_b-split-testing-and@2x.jpg',
    'textAlignment' => 'left-right-text'
  ],
];
$benefits = [
  ['name' => __('Proven Results'), 'description' => __('Earn 50% revenue share on the first payment and 30% lifetime revenue share on all self-serve plans. Plus, earn significant commission on enterprise plans.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/case.svg'],
  ['name' => __('Reliable Tracking'), 'description' => __('Maximize your brand equity by partnering with the leaders in post-click optimization.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/cup.svg'],
  ['name' => __('Long Cookie Duration with<br>Active Retargeting'), 'description' => __('Get the credit you deserve with our 120-day cookie duration and active retargeting campaigns.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/target.svg'],
  ['name' => __('Proven Results'), 'description' => __('Profit more with our high conversion rate, strong earnings per click, and great customer lifetime value.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/speed.svg'],
  ['name' => __('Reliable Tracking'), 'description' => __('Accumulate more referrals with the highly-accurate tracking software we\'ve implemented.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/graph.svg'],
  ['name' => __('Free To Join'), 'description' => __('It\'s free to join our partner community and only takes minutes to sign up and start promoting.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/shakehand.svg'],
];
$benefits2 = [
  ['description' => __('Plus, earn significant commission on enterprise plans and other.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/case.svg'],
  ['description' => __('Maximize your brand equity by partnering with the leaders in post-click optimization.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/cup.svg'],
  ['description' => __('Get the credit you deserve with our 120-day cookie duration and active retargeting campaigns.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/target.svg'],
  ['description' => __('Profit more with our high conversion rate, strong earnings per click, and great customer lifetime value.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/speed.svg']
];
$benefits3 = [
  ['name' => __('Proven Results'), 'description' => __('Profit more with our high conversion rate, strong earnings per click, and great customer lifetime value.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/speed.svg'],
  ['name' => __('Reliable Tracking'), 'description' => __('Accumulate more referrals with the highly-accurate tracking software we\'ve implemented.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/graph.svg'],
  ['name' => __('Free To Join'), 'description' => __('It\'s free to join our partner community and only takes minutes to sign up and start promoting.'), 'icon' => get_template_directory_uri() . '/v5/assets/images/shakehand.svg'],
];
$barItems = [
  ['class' => '', 'content' => __('A'), 'url' => '#A'],
  ['class' => '', 'content' => __('B'), 'url' => '#B'],
  ['class' => '', 'content' => __('C'), 'url' => '#C']
];
$barList = [
  ['type' => 'letter-tag', 'title' => __('A'), 'url' => '#A'],
  ['type' => 'term', 'title' => __('A Example single dictionary'), 'url' => '#', 'hasVideo' => true],
  ['type' => 'term', 'title' => __('A Example single dictionary'), 'url' => '#'],
  ['type' => 'term', 'title' => __('A Example single dictionary'), 'url' => '#'],
  ['type' => 'letter-tag', 'title' => __('B'), 'url' => '#B'],
  ['type' => 'term', 'title' => __('B Example single dictionary'), 'url' => '#'],
  ['type' => 'term', 'title' => __('B Example single dictionary'), 'url' => '#', 'hasVideo' => true],
  ['type' => 'term', 'title' => __('B Example single dictionary'), 'url' => '#', 'hasVideo' => true],
  ['type' => 'letter-tag', 'title' => __('C'), 'url' => '#C'],
  ['type' => 'term', 'title' => __('C Example single dictionary'), 'url' => '#'],
  ['type' => 'term', 'title' => __('C Example single dictionary'), 'url' => '#', 'hasVideo' => true],
  ['type' => 'term', 'title' => __('C Example single dictionary'), 'url' => '#', 'hasVideo' => true]
];

Component::render('v51/document-start');
Component::render('v51/navbar',
  [
    'isSticky' => true,
    'desktopNavbarMenu' => Component::fetch('v51/navbar-menu', ['btnClass'=> 'btn-cta', 'items' => getV5Menu('v5-top-menu')])
  ]
);

Component::render('v51/header', get_field('layout'));
?>
<style>
.description h2 {
  height: 70px;
  padding-left: 25px;
  margin-bottom: 25px;
  position: relative;
}
.description h2:before {
  content: '';
  display: table;
  width: 6px;
  background-color: #1565c0;
  height: 100%;
  position: absolute;
  top: -14px;
  left: 0;
  height: 70px;
}
.link-cta {
  margin-bottom: 10px;
  display: block;
}
.checkbox-icon.icon.icon-check {
  margin: 3px 7px 0 0;
}
.description + .contact-us-modal {
  top: 0;
}
.listing-img {
  background: grey;
  height: 100%;
}
</style>

<div class="description content division-top">
  <h4>Header left</h4>
  <a class="link-cta" href="https://instapage.com/post-click-optimization" target="_blank">Example</a>
</div>
<?php
Component::render(
  'v51/header',
  'left',
  [
    'headerClass' => 'header-section-left',
    'headerText' => __('Post-Click Optimization™'),
    'subHeaderText' => __('Everything between the click and conversion'),
    'headerSideImage' => 'https://storage.googleapis.com/website-production/uploads/2018/09/image-1.jpg'
  ]
);
?>

<div class="description content division-top">
  <h4>Header tall</h4>
  <a class="link-cta" href="https://instapage.com/products/enterprise" target="_blank">Example</a>
</div>
<?php
Component::render(
  'v51/header',
  'tall',
  [
    'headerClass' => 'header-section-enterprise',
    'headerText' => __('Meet the Advertising Conversion Cloud'),
    'subHeaderText' => __('Our Enterprise Solution is the most powerful way to create, personalize, and optimize post-click experiences at scale.'),
    'videoText' => __('Watch video')
  ]
);
?>

<hr>

<div class="description content division-top">
  <h2>Typography</h2>
</div>
<div class="content">
  <h1>H1 + paragraph</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
  <br><br>
  <h2>H2 + paragraph</h2>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
  <br><br>
  <h3>H3 + paragraph</h3>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
  <br><br>
  <h4>H4 + paragraph</h4>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
  <br><br>
  <h5>H5 + paragraph</h5>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
  <br><br>
  <h6>H6 + paragraph</h6>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
</div>

<hr>

<div class="description content division-top">
  <h2>Accordion</h2>
</div>
<div class="description content division-top">
  <h4>Default </h4>
  <a class="link-cta" href="https://instapage.com/pricing" target="_blank">Example</a>
  <br>
</div>
<div class="content is-narrow">
  <div class="accordion-group">
    <?php
    Component::render(
    'v51/accordion',
    [
      'items' => [
        [
          'title' => __('What is included in the free trial?'),
          'excerpt' => __('The 14-day free trial offers you access to all the features in the Team & Agency plan, plus 2,500 unique visitors.'),
        ],
        [
          'title' => __('Is the free trial really free?'),
          'excerpt' => __('Yes. It’s completely free; no credit card required.'),
          'url' => 'https://instapage.com/',
          'excerpt' => __('Lorem ipum dolor sit amet...'),
        ],
      ]
    ]);
    ?>
  </div>
</div>

<hr>

<div class="description content division-top">
  <h2>Avatar</h2>
</div>

<div class="description content">
  <h4>Avatar author </h4>
  <a class="link-cta" href="https://instapage.com/blog" target="_blank">Example</a>
  <?php
  Component::render(
    'v51/avatar',
    'author',
    [
      'authorID' => 1,
      'authorName' => 'Oliver Armstrong'
    ]
  );
  ?>
</div>

<div class="description content division-top">
  <h4>Avatar default</h4>
  <a class="link-cta" href="https://instapage.com/" target="_blank">Example</a>
  <?php
  Component::render(
    'v51/avatar',
    [
      'image' => 'https://instapage.com/wp-content/uploads/2018/01/random-user-image-m-43.jpg',
      'info' => 'Digital Services Manager, NetSearch Digital Marketing'
    ]
  );
  ?>
</div>

<hr>

<div class="description content division-top">
  <h2>Benefit Section</h2>
</div>

<div class="description content division-top">
  <h4>Default </h4>
  <a class="link-cta" href="https://instapage.com/pricing" target="_blank">Example</a>
  <br>
</div>
<?php
Component::render('v51/benefits-section', ['title' => __('Example Title'), 'benefits' => $benefits]);
?>

<div class="description content division-top">
  <h4>Without Titles </h4>
  <a class="link-cta" href="https://instapage.com/products/team-collaboration" target="_blank">Example</a>
  <br>
</div>
<?php
Component::render('v51/benefits-section', ['layout' => 'without-titles', 'title' => __('Example Title'), 'benefits' => $benefits2, 'columnCount' => 3]);
?>

<div class="description content division-top">
  <h4>One row </h4>
  <a class="link-cta" href="https://instapage.com/products/team-collaboration" target="_blank">Example</a>
  <br>
</div>
<?php
Component::render('v51/benefits-section', 'one-row', ['layout' => 'one-row', 'title' => __('Example Title'), 'benefits' => $benefits3]);
?>

<hr>

<div class="description content division-top">
  <h2>Carousel</h2>
</div>
<div class="description content division-top">
  <h4>Default</h4>
  <a class="link-cta" href="https://instapage.com/careers" target="_blank">Example (see 'Meet our people')</a>
</div>

<hr>

<div class="description content division-top">
  <h2>CTA Section</h2>
</div>
<div class="description content division-top">
  <h4>Default </h4>
  <br>
</div>
<?php
Component::render(
  'v51/cta-section',
  [
    'title' => __('Get Started Now'),
    'subtitle' => __('Try the most powerful all-in-one landing page solution today. Start a 14-day free trial, no credit card required, or schedule a demo to learn more about the Enterprise plan.'),
    'slot' =>
      '<div class="btn-group">' .
        Component::fetch('v51/button', ['text' => __('Start Free Trial'), 'url' => URL_INSTAPAGE_SIGNUP, 'class' => 'btn btn-cta']) .
        Component::fetch('v51/button', ['text' => __('Schedule Demo'), 'url' => get_home_url() . '/enterprise-demo-request', 'class' => 'btn btn-ghost']) .
      '</div>'
  ]
);
?>
<div class="description content division-top">
  <h4>Light </h4>
  <br>
</div>
<?php
Component::render(
  'v51/cta-section',
  [
    'class' => 'hero-section-light section-darker',
    'title' => __('Get Started Now'),
    'subtitle' => __('Try the most powerful all-in-one landing page solution today. Start a 14-day free trial, no credit card required, or schedule a demo to learn more about the Enterprise plan.'),
    'slot' =>
      '<div class="btn-group">' .
        Component::fetch('v51/button', ['text' => __('Start Free Trial'), 'url' => URL_INSTAPAGE_SIGNUP, 'class' => 'btn btn-cta']) .
        Component::fetch('v51/button', ['text' => __('Schedule Demo'), 'url' => get_home_url() . '/enterprise-demo-request', 'class' => 'btn btn-ghost-cta']) .
      '</div>'
  ]
);
?>

<hr>

<div class="description content division-top">
  <h2>Footer</h2>
</div>
<?php
Component::render('v51/footer');
?>

<hr>

<div class="description content division-top">
  <h2>Form elements</h2>
</div>
<div class="contact-us-modal">
  <?php require_once(get_template_directory() . '/v5/views/parts/modal-success.php'); ?>
  <form method="post" action=""  autocomplete="off" class="contact-form-body js-form-validation" novalidate>
    <div class="js-nonce" data-nonce-name="contact"></div>
    <input type="hidden" name="action" value="form-success" />
    <header class="division-header">
      <h3><?= __('Form elements'); ?></h3>
    </header>
    <div>
        <div class="input">
          <input type="text" value="" placeholder=" " name="first-name" data-required-message="Please enter your first name" class="input-field" required>
          <label class="input-label"><?= __('Input field'); ?></label>
          <span class="input-info">
            <span><?= __('Please enter your first name'); ?></span>
            <span class="material-icons input-warning">warning</span>
          </span>
          <div class="input-bar"></div>
        </div>
        <div class="select-container">
          <select class="select js-select input-field" name="contact-us-topic" data-required-message="Select field" data-placeholder="<?= __('Select field'); ?>" required>
            <option value=""></option>
            <option value="General Question"><?= __('General Question'); ?></option>
            <option value="Payments and billing"><?= __('Payments and billing'); ?></option>
            <option value="Integrations"><?= __('Integrations'); ?></option>
            <option value="Bug"><?= __('Bug'); ?></option>
            <option value="Publishing"><?= __('Publishing'); ?></option>
            <option value="Technical Question"><?= __('Technical Question'); ?></option>
            <option value="Analytics"><?= __('Analytics'); ?></option>
          </select>
          <span class="input-info">
            <span><?= __('Please select a topic'); ?></span>
            <span class="material-icons input-warning">warning</span>
          </span>
        </div>
        <div class="input">
          <textarea type="text" placeholder=" " value="" name="message" data-required-message="Textarea field" class="input-field" required></textarea>
          <label class="input-label"><?= __('Textarea field'); ?></label>
          <span class="input-info">
            <span><?= __('Please enter your message'); ?></span>
            <span class="material-icons input-warning">warning</span>
          </span>
          <div class="input-bar"></div>
        </div>
        <div class="checkbox-container">
        <label class="checkbox-label">
          <input type="checkbox" class="checkbox js-filter-checkbox" data-state="hidden" data-category="category">
          <span class="checkbox-icon icon icon-check"></span>
          <span class="checkbox-description">
            Checkbox field
          </span>
        </label>
      </div>
    </div>
    <div class="btn-group">
      <button type="submit" class="btn btn-cta contact-form-button"><?= __('Submit button'); ?></button>
    </div>
  </form>
</div>

<hr>

<div class="description content division-top">
  <h2>Left-right</h2>
</div>

<div class="description content division-top">
  <h4>Default </h4>
  <a class="link-cta" href="https://instapage.com/" target="_blank">Example</a>
</div>
<?php
Component::render('v51/left-right', ['class' => 'left-right-even', 'items' => $leftRightNormal]);
?>

<div class="description content division-top">
  <h2>Lists</h2>
  <br>
</div>

<div class="description content division-top">
  <h4>Default </h4>
  <a class="link-cta" href="https://instapage.com/enterprise-benefits" target="_blank">Example</a>
  <br>
</div>
<div class="content">
<?php
Component::render(
  'v51/lists',
  [
    'items' => [
      ['text' => 'List item 1'],
      ['text' => 'List item 2'],
      ['text' => 'List item 3'],
      ['text' => 'List item 4'],
      ['text' => 'List item 5'],
      ['text' => 'List item 6']
    ]
  ]
);
?>
</div>

<hr>

<div class="description content division-top">
  <h2>Related Terms</h2>
</div>
<?php
Component::render('v51/related-terms', ['items' => getDictionaryRelatedTerms(23041)]);
?>

<hr>

<div class="description content division-top">
  <h2>Search</h2>
  <br>
</div>
<div class="content">
<?php
Component::render('v51/search', ['placeholder' => 'Search...']);
?>
</div>

<hr>

<div class="description content division-top">
  <h2>Slider</h2>
  <a class="link-cta" href="https://instapage.com/" target="_blank">Example</a>
  <br>
</div>
<?php
Component::render(
  'v51/slider',
  [
    'class' => 'testimonial-slider js-slick-container',
    'items' => [
      Component::fetch('v51/button', ['text' => __('First slide'), 'url' => 'http://example.com/', 'class' => 'btn btn-cta']),
      Component::fetch('v51/button', ['text' => __('Second slide'), 'url' => 'http://example.com/', 'class' => 'btn btn-cta']),
      Component::fetch('v51/button', ['text' => __('Third slide'), 'url' => 'http://example.com/', 'class' => 'btn btn-cta']),
      Component::fetch('v51/button', ['text' => __('Fourth slide'), 'url' => 'http://example.com/', 'class' => 'btn btn-cta']),
      Component::fetch('v51/button', ['text' => __('Fifth slide'), 'url' => 'http://example.com/', 'class' => 'btn btn-cta']),
    ],
    'attributes' => ['data-slick-preset' => 'sliderTestimonial']
  ]
);
?>

<hr>

<div class="description content division-top">
  <h2>Tiles</h2>
</div>

<div class="description content division-top">
  <h4>With logo </h4>
  <a class="link-cta" href="https://instapage.com/agency-partners/lucid-agency" target="_blank">Example</a>
  <br>
</div>

<div class="description content division-top">
  <h4>With Icon </h4>
  <a class="link-cta" href="https://instapage.com/" target="_blank">Example</a>
  <br>
</div>

<hr>

<div class="description content division-top">
  <h2>Alphabet bar</h2>
</div>
<?php
Component::render('v51/alphabet-bar', ['items' => $barItems]);
?>

<hr>

<div class="description content division-top">
  <h2>Alphabet list</h2>
</div>
<?php
Component::render('v51/alphabet-list', ['items' => $barList]);
?>

<hr>

<div class="description content division-top">
  <h2>Workable</h2>
  <a class="link-cta" href="https://instapage.com/careers" target="_blank">Example</a>
</div>
<?php
Component::render('v51/workable');
?>

<?php
Component::render('v51/document-end');

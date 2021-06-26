<?php
use \Instapage\Classes\Factory;
use \Instapage\Classes\Component;
use \Instapage\Components\V51\Modal\Controller as ModalComponent;

$model = Factory::getModel(getV5Page());

Component::render('v51/document-start');
Component::render('v51/navbar');
Component::render('v51/header', get_field('layout'));

// MODAL HTML
$html = <<<'HTML'
<span class="modal-close js-modal-close material-icons">close</span>
<h3 class="modal-title">Frequently Asked Questions</h3>
<dl class="faq">
  <dt class="faq-term">Who can participate in the Instapage Affiliate program?</dt>
  <dd class="faq-description">Anyone! It’s free to join and open to all. Whether you’re sharing Instapage with friends or clients, run a large website, produce an opt-in email newsletter or anything in between, we’d love for you to join us. </dd>
  <dt class="faq-term">How are referrals I send to Instapage tracked?</dt>
  <dd class="faq-description">After you enroll as an affiliate, you’ll receive your own unique link to share with others. When a customer purchases a plan through your referral link, you’ll receive credit and earn the commission.</dd>
  <dt class="faq-term">What happens when someone I refer clicks on my unique link, doesn’t purchase right away, but then purchases later on?</dt>
  <dd class="faq-description">A “cookie” will be stored on their computer, and if they purchase within 120 days of clicking on your link, you’ll still receive the credit.</dd>
  <dt class="faq-term">How many people can I refer? How much can I earn?</dt>
  <dd class="faq-description">The sky’s the limit! You can refer as many people as you’d like. We don’t put a cap on how much you can earn.</dd>
  <dt class="faq-term">When am I paid?</dt>
  <dd class="faq-description">We know it’s important to pay out our affiliates as quickly as possible. We aim to pay commissions within 35 days of your referral purchasing a plan.</dd>
  <dt class="faq-term">What do I do after I join?</dt>
  <dd class="faq-description">Check your email. It will include all the instructions and resources you need to get started.</dd>
</dl>
<p>For more inrofmation, please refer to our <a href="https://ambassador-api.s3.amazonaws.com/uploads/marketing/3795/2017_08_01_15_31_53.pdf" class="link-cta">Affiliate Program Terms and Conditions</a><br>or contact us.</p>
HTML;

$modal = new ModalComponent(['html' => $html, 'attributes' => ['class' => 'js-modal modal modal-text']]);
$modal->renderDelayed();

Component::render(
  'v51/benefits-section',
  [
    'subtitle' => __('Marketers all over the world are looking for a marketing solution like Instapage to increase their conversions and return on their ad spend. Profit by being the one to share Instapage with them.'),
    'layout' => 'two-columns',
    'panels' => true,
    'whiteBackground' => true,
    'slot' => Component::fetch('v51/button', ['text' => __('Become an affiliate today'), 'url' => 'https://affiliates.instapage.com', 'class' => 'btn btn-cta is-large', 'attributes' => ['data-modal-id' => $modal->getComponentID()]])
  ]
);
Component::render('v51/left-right', ['title' => __('We Help You With Resources'), 'class' => 'left-right-odd']);
Component::render('v51/cta-section',
  [
    'slot' =>
      '<div class="btn-group">' .
        Component::fetch('v51/button', ['text' => __('Get started'), 'url' => URL_INSTAPAGE_SIGNUP, 'class' => 'btn btn-cta']) .
        Component::fetch('v51/button', ['text' => __('Request a demo'), 'url' => get_home_url() . '/enterprise-demo-request', 'class' => 'btn btn-ghost']) .
      '</div>
      <p class="hero-section-text hero-section-text-bottom">Questions? Click <a class="js-modal-trigger" data-modal-id="' . $modal->getComponentID() . '">here</a> to find out more on our FAQ page.</p>'
  ]
);
Component::render('v51/footer');
Component::render('v51/document-end');

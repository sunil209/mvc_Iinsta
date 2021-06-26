<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $title           Name of form
 * @param array  $response        Form state
 * @param string $nonceTokenName  Nonce token name
 *
 * @example Usage
 * Component::render(
 *   'form',
 *   'partner-contact',
 *   [
 *     'title' => 'Send Us a Message',
 *     'response' => $response,
 *     'nonceTokenName' => $model->getNonceTokenName()
 *   ]
 * );
 * @endexample
 */

use \Instapage\Classes\Component;
use \Instapage\Classes\Forms\FormResponse;
?>

<div class="v7 v7-partner-form-wrapper v7-mx-auto col-12 col-md-8 col-lg-5 offset-lg-1">
    <?php
    if (isset($response['status'])) {
        Component::render('v51/form-message', $response);
    }
    ?>
    <form method="post" autocomplete="off" class="v7-p-40 v7-shadow-1 v7-partner-form js-form-validation" novalidate>
        <div class="js-nonce" data-nonce-name="<?= $nonceTokenName ?>"
            <?php if (FormResponse::isError($response)) : ?>
            data-nonce-autocomplete="true"
            <?php endif; ?>
        ></div>
        <h2 class="text-center v7-pb-40 v7-pb-md-30"><?= esc_html($title) ?></h2>
        <?php
        Component::render(
            'input',
            [
                'value' => $response['fields']['first-name'],
                'name' => 'first-name',
                'requiredMessage' => 'Please enter your first name',
                'required' => true,
                'label' => 'First Name*'
            ]
        );
        Component::render(
            'input',
            [
                'value' => $response['fields']['last-name'],
                'name' => 'last-name',
                'requiredMessage' => 'Please enter your last name',
                'required' => true,
                'label' => 'Last Name*'
            ]
        );
        Component::render(
            'input',
            [
                'type' => 'email',
                'value' => $response['fields']['email'],
                'name' => 'email',
                'requiredMessage' => 'Please enter your business email address',
                'invalidMessage' => 'Please enter your business email address',
                'required' => true,
                'label' => 'Email*',
                'businessEmailValidation' => true
            ]
        );
        Component::render(
            'input',
            [
                'value' => $response['fields']['company'],
                'name' => 'company',
                'requiredMessage' => 'Please enter your company name',
                'invalidMessage' => 'Please enter your valid company name',
                'required' => true,
                'label' => 'Company*'
            ]
        );
        Component::render(
            'input',
            [
                'value' => $response['fields']['website'],
                'name' => 'website',
                'requiredMessage' => 'Please enter website address',
                'invalidMessage' => 'Please enter valid website address',
                'required' => true,
                'label' => 'Website*'
            ]
        );
        Component::render(
            'textarea',
            [
                'value' => $response['fields']['message'],
                'name' => 'message',
                'requiredMessage' => 'Please enter your message',
                'required' => true,
                'label' => 'Message*'
            ]
        );
        Component::render(
            'input',
            'checkbox',
            [
                'label' => '
                    I agree to the
                    <a href="' . get_home_url() . '/privacy-policy" class="v7-checkbox-link">
                        Instapage Privacy Policy
                    </a>',
                'name' => 'policy-agreement',
                'requiredMessage' => 'You have to agree with our privacy policy',
                'required' => true,
                'checked' => $response['fields']['policy-agreement'] === 'checked'
            ]
        );
        ?>
        <button type="submit" class="v7-btn v7-btn-cta v7-btn-submit v7-mt-40 fx-ripple-effect">
            <?= __('Contact us') ?>
        </button>
    </form>
</div>

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
 *   'careers,
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

<div class="v7">
    <?php
    if (isset($response['status'])) {
        Component::render('v51/form-message', $response);
    }
    ?>
    <form method="post" action="" autocomplete="off" class="v7-form-careers js-form-validation v7-mt-30" novalidate>
        <div class="js-nonce" data-nonce-name="<?= $nonceTokenName ?>"
            <?php if (FormResponse::isError($response)) : ?>
            data-nonce-autocomplete="true"
            <?php endif; ?>
        ></div>
        <input type="hidden" name="action" value="form-success">
        <?php
        Component::render(
            'input',
            [
                'value' => $response['fields']['name-and-surname'],
                'name' => 'name-and-surname',
                'requiredMessage' => 'Please enter your name',
                'required' => true,
                'label' => 'Name'
            ]
        );
        Component::render(
            'input',
            [
                'type' => 'email',
                'value' => $response['fields']['work-email'],
                'name' => 'work-email',
                'requiredMessage' => 'Please enter your email',
                'invalidMessage' => 'Please enter valid email',
                'required' => true,
                'label' => 'Email Address'
            ]
        );
        Component::render(
            'input',
            [
                'type' => 'url',
                'value' => $response['fields']['linkedin-profile'],
                'name' => 'linkedin-profile',
                'requiredMessage' => 'Please enter your LinkedIn profile URL',
                'invalidMessage' => 'Please enter valid LinkedIn profile URL',
                'required' => true,
                'label' => 'LinkedIn Profile'
            ]
        );
        Component::render(
            'textarea',
            [
                'value' => $response['fields']['message'],
                'name' => 'message',
                'requiredMessage' => 'Please enter your message',
                'required' => true,
                'label' => 'Message'
            ]
        );
        Component::render(
            'input',
            'radio',
            [
                'sectionLabel' => 'Send to',
                'name' => 'send-to',
                'response' => $response,
                'radios' =>
                [
                    [
                        'value' => 'us',
                        'label' => 'United States'
                    ],
                    [
                        'value' => 'pl',
                        'label' => 'Poland'
                    ],
                    [
                        'value' => 'ro',
                        'label' => 'Romania'
                    ]
                ]
            ]
        );
        Component::render(
            'input',
            'checkbox',
            [
                'label' =>
                    __('By clicking I confirm I\'ve read ') .
                    '<a
                        href="https://storage.googleapis.com/website-production/uploads/2019/09/Information-clause-career-page.pdf"
                        class="v7-checkbox-link"
                        target="_blank"
                    >' .
                            __('Instapage PII policy') .
                    '</a>',
                'name' => 'policy-agreement',
                'requiredMessage' => __('You have to confirm that you\'ve read our PII policy'),
                'required' => false,
                'checked' => $response['fields']['policy-agreement'] === 'checked',
                'sectionClass' => 'js-gdpr-info v7-is-hidden',
                'id' => 'pl',
            ]
        );
        ?>
        <button type="submit" class="v7-btn v7-btn-cta v7-btn-submit v7-mt-20 fx-ripple-effect">
            <?= __('Submit') ?>
        </button>
    </form>
</div>


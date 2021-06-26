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
 *   'contact,
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

<div class="v7 v7-contact-form-wrapper">
    <div class="v7-contact-form-graphic v7-is-hidden-lg">
        <h2 class="white"><?= __('Drop us a line, we\'d love<br>to hear from you.') ?></h2>
        <p class="white"><?= __('We\'ll get back to you as soon as we can.') ?></p>
    </div>
    <?php
    if (isset($response['status'])) {
        Component::render('v51/form-message', $response);
    }
    ?>
    <form method="post" action="" autocomplete="off" class="v7-contact-form js-form-validation" novalidate>
        <div class="js-nonce" data-nonce-name="<?= $nonceTokenName ?>"
            <?php if (FormResponse::isError($response)) : ?>
            data-nonce-autocomplete="true"
            <?php endif; ?>
        ></div>
        <input type="hidden" name="action" value="form-success">
        <h2 class="text-center v7-pb-40 v7-pb-md-30"><?= esc_html($title) ?></h2>
        <?php
        Component::render(
            'input',
            [
                'value' => $response['fields']['first-name'],
                'name' => 'first-name',
                'requiredMessage' => 'Please enter your first name',
                'required' => true,
                'label' => 'First Name'
            ]
        );
        Component::render(
            'input',
            [
                'value' => $response['fields']['last-name'],
                'name' => 'last-name',
                'requiredMessage' => 'Please enter your last name',
                'required' => true,
                'label' => 'Last Name'
            ]
        );
        Component::render(
            'input',
            [
                'type' => 'email',
                'value' => $response['fields']['work-email'],
                'name' => 'work-email',
                'requiredMessage' => 'Please enter work email',
                'invalidMessage' => 'Please enter valid work email',
                'required' => true,
                'label' => 'Email Address'
            ]
        );
        ?>
        <div class="select-container">
            <select
                class="select js-select v7-input-field js-v7-input-field"
                name="contact-us-topic"
                data-required-message="<?= esc_attr(__('Please select a topic')); ?>"
                data-placeholder="<?= __('Select a Topic'); ?>"
                required
            >
                <?php foreach ($response['fields']['contact-us-topic'] as $option => $selected) : ?>
                <option <?= $selected; ?> value="<?= esc_attr($option); ?>"><?= esc_html($option); ?></option>
                <?php endforeach; ?>
            </select>
            <span class="v7-input-info js-v7-input-info">
                <span><?= __('Please select a topic'); ?></span>
                <span class="material-icons input-warning">warning</span>
            </span>
        </div>
        <div class="select-container">
            <select
                class="select js-select v7-input-field js-v7-input-field"
                name="office-select"
                data-required-message="<?= esc_attr(__('Please select an office')); ?>"
                data-placeholder="<?= __('Select Office'); ?>"
                required
            >
                <?php foreach ($response['fields']['office-select'] as $option => $selected) : ?>
                <option <?= $selected; ?> value="<?= esc_attr($option); ?>"><?= esc_html($option); ?></option>
                <?php endforeach; ?>
            </select>
            <span class="v7-input-info js-v7-input-info">
                <span><?= __('Please select an office'); ?></span>
                <span class="material-icons input-warning">warning</span>
            </span>
        </div>
        <?php
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
            <?= __('Send Your Message') ?>
        </button>
    </form>
</div>


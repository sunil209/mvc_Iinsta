<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $response        Form state
 * @param string $nonceTokenName  Nonce token name
 *
 * @example Usage
 * Component::render(
 *   'form',
 *   'multistep',
 *   [
 *     'response' => $response,
 *     'nonceTokenName' => $model->getNonceTokenName()
 *   ]
 * );
 * @endexample
 */

use \Instapage\Classes\Component;
use \Instapage\Classes\Forms\FormResponse;

if (isset($response['status'])) {
    Component::render('v51/form-message', $response);
}

$maxStep = 3;
?>

<div class="v7-mt-sm-only-20 v7-mt-md-only-50 col-12 col-lg-6 col-xl-5 offset-xl-1"">

    <form
        method="post"
        action=""
        autocomplete="off"
        class="
            v7-form-multistep v7-form-multistep-vertical js-form-validation js-multistep-form
            v7-shadow-1 v7-p-30 v7-p-md-50 text-center
        "
        data-multistep-form-name="Enteprise demo request"
        novalidate
    >
        <?php Component::render('attribution-tracker'); ?>

        <div class="js-nonce" data-nonce-name="<?= $nonceTokenName; ?>"
            <?php if (FormResponse::isError($response)) : ?>
            data-nonce-autocomplete="true"
            <?php endif; ?>
        ></div>

        <div class="v7-position-relative">

            <fieldset class="js-form-fieldset v7-form-multistep-fieldset">
                <input type="hidden" name="action" value="form-success">
                <h2 class="v7-pb-15 v7-pb-md-20"><?= __('Get a personalized demo'); ?></h2>
                <?php Component::render('step-indicator', ['currentStep' => 1, 'maxStep' => $maxStep]) ?>
                <div class="select-container">
                    <select
                        class="select js-select v7-input-field js-v7-input-field"
                        name="use-case-select"
                        data-required-message="<?= __('Please select an option'); ?>"
                        data-placeholder="<?= __('Primary Use Case*'); ?>"
                        required
                    >
                        <?php foreach ($response['fields']['use-case-select'] as $option => $selected) : ?>
                        <option <?= esc_attr($selected); ?> value="<?= esc_attr($option); ?>">
                            <?= esc_html($option); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label class="select-label"><?= __('Primary Use Case*'); ?></label>
                    <span class="v7-input-info js-v7-input-info">
                        <span><?= __('Please select an option'); ?></span>
                        <span class="material-icons input-warning">warning</span>
                    </span>
                </div>
                <div class="select-container">
                    <select
                        class="select js-select v7-input-field js-v7-input-field"
                        name="marketing-channel-select"
                        data-required-message="<?= __('Please select an option'); ?>"
                        data-placeholder="<?= __('Primary Marketing Channel*'); ?>"
                        required
                    >
                        <?php foreach ($response['fields']['marketing-channel-select'] as $option => $selected) : ?>
                        <option <?= esc_attr($selected); ?> value="<?= esc_attr($option); ?>">
                            <?= esc_html($option); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label class="select-label"><?= __('Primary Marketing Channel*'); ?></label>
                    <span class="v7-input-info js-v7-input-info">
                        <span><?= __('Please select an option'); ?></span>
                        <span class="material-icons input-warning">warning</span>
                    </span>
                </div>
                <?php
                Component::render(
                    'input',
                    [
                        'value' => $response['fields']['company'],
                        'name' => 'company',
                        'requiredMessage' => 'Please enter your company name',
                        'required' => true,
                        'label' => 'Company*'
                    ]
                );
                ?>
                <div class="select-container">
                    <select
                        class="select js-select v7-input-field js-v7-input-field"
                        name="company-size-select"
                        data-required-message="<?= __('Please select an option'); ?>"
                        data-placeholder="<?= __('Company Size*'); ?>"
                        required
                    >
                        <?php foreach ($response['fields']['company-size-select'] as $option => $selected) : ?>
                        <option <?= esc_attr($selected); ?> value="<?= esc_attr($option); ?>">
                            <?= esc_html($option); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label class="select-label"><?= __('Company Size*'); ?></label>
                    <span class="v7-input-info js-v7-input-info">
                        <span><?= __('Please select an option'); ?></span>
                        <span class="material-icons input-warning">warning</span>
                    </span>
                </div>
                <button
                    type="button"
                    class="v7-btn v7-btn-cta v7-btn-submit v7-mt-15 fx-ripple-effect js-multistep-btn"
                >
                    <?= __('Next step'); ?>
                </button>
            </fieldset>

            <fieldset class="js-form-fieldset v7-form-multistep-fieldset is-invisible">
                <input type="hidden" name="action" value="form-success">
                <h2 class="v7-pb-15 v7-pb-md-20"><?= __('You’re almost there'); ?></h2>
                <?php Component::render('step-indicator', ['currentStep' => 2, 'maxStep' => $maxStep]) ?>
                <div class="select-container">
                    <select
                        class="select js-select v7-input-field js-v7-input-field"
                        name="job-select"
                        data-required-message="<?= __('Please select an option'); ?>"
                        data-placeholder="<?= __('Job title*'); ?>"
                        required
                    >
                        <?php foreach ($response['fields']['job-select'] as $option => $selected) : ?>
                        <option <?= esc_attr($selected); ?> value="<?= esc_attr($option); ?>">
                            <?= esc_html($option); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label class="select-label"><?= __('Job title*'); ?></label>
                    <span class="v7-input-info js-v7-input-info">
                        <span><?= __('Please select an option'); ?></span>
                        <span class="material-icons input-warning">warning</span>
                    </span>
                </div>
                <div class="select-container">
                    <select
                        class="select js-select v7-input-field js-v7-input-field"
                        name="seniority-select"
                        data-required-message="<?= __('Please select an option'); ?>"
                        data-placeholder="<?= __('Seniority*'); ?>"
                        required
                    >
                        <?php foreach ($response['fields']['seniority-select'] as $option => $selected) : ?>
                        <option <?= esc_attr($selected); ?> value="<?= esc_attr($option); ?>">
                            <?= esc_html($option); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label class="select-label"><?= __('Seniority*'); ?></label>
                    <span class="v7-input-info js-v7-input-info">
                        <span><?= __('Please select an option'); ?></span>
                        <span class="material-icons input-warning">warning</span>
                    </span>
                </div>
                <div class="select-container">
                    <select
                        class="select js-select v7-input-field js-v7-input-field"
                        name="industry-select"
                        data-required-message="<?= __('Please select an option'); ?>"
                        data-placeholder="<?= __('Industry*'); ?>"
                        required
                    >
                        <?php foreach ($response['fields']['industry-select'] as $option => $selected) : ?>
                        <option <?= esc_attr($selected); ?> value="<?= esc_attr($option); ?>">
                            <?= esc_html($option); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label class="select-label"><?= __('Industry*'); ?></label>
                    <span class="v7-input-info js-v7-input-info">
                        <span><?= __('Please select an option'); ?></span>
                        <span class="material-icons input-warning">warning</span>
                    </span>
                </div>
                <?php
                Component::render(
                    'textarea',
                    [
                        'value' => $response['fields']['message'],
                        'name' => 'message',
                        'label' => 'How can we help you achieve your goals?'
                    ]
                );
                ?>
                <button
                    type="button"
                    class="v7-btn v7-btn-cta v7-btn-submit v7-mt-15 fx-ripple-effect js-multistep-btn"
                >
                    <?= __('Next step'); ?>
                </button>
            </fieldset>

            <fieldset class="js-form-fieldset v7-form-multistep-fieldset is-invisible">
                <input type="hidden" name="action" value="form-success">
                <h2 class="v7-pb-15 v7-pb-md-20"><?= __('One last thing'); ?></h2>
                <?php Component::render('step-indicator', ['currentStep' => 3, 'maxStep' => $maxStep]) ?>
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
                ?>
                <?php
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
                ?>
                <?php
                Component::render(
                    'input',
                    [
                        'type' => 'email',
                        'value' => $response['fields']['email'],
                        'name' => 'email',
                        'requiredMessage' => 'Please enter your business email address',
                        'invalidMessage' => 'Please enter your business email address',
                        'required' => true,
                        'label' => 'Work Email*',
                        'businessEmailValidation' => true
                    ]
                );
                ?>
                <?php
                Component::render(
                    'input',
                    [
                        'value' => $response['fields']['phone-number'],
                        'name' => 'phone-number',
                        'requiredMessage' => 'Please enter your phone number',
                        'required' => true,
                        'label' => 'Phone number*'
                    ]
                );
                ?>
                <?php Component::render('button', 'with-loading-state', [
                    'text' => __('REQUEST DEMO'),
                    'class' => 'v7-mt-15'
                ]); ?>
            </fieldset>

        </div>

        <p class="v7-heading-small v7-multistep-vertical-footnote">
            <?= __('Looking for support?') ?>
            <a class="v7-btn-flat v7-text-underlined" href="<?= URL_INSTAPAGE_HELP ?>" target="_blank">
                <?= __('Contact us here') ?>
            </a>
        </p>
    </form>
</div>

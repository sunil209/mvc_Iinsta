<?php

use Instapage\Classes\Component;

?>

<section class="v7 v7-form-password-wrapper">
    <div class="v7-content">
        <form
            action="<?= esc_url(site_url('wp-login.php?action=postpass', 'login_post')) ?>"
            method="post"
            class="v7-form-password js-form-validation"
            autocomplete="off"
            novalidate
        >
            <h2><?= __('Protected') ?></h2>
            <p class="v7-mb-20"><?= __('To view this protected page, enter the password below:') ?></p>
            <?php
                Component::render(
                    'input',
                    [
                        'type' => 'password',
                        'name' => 'post_password',
                        'requiredMessage' => 'Please enter password',
                        'required' => true,
                        'label' => 'Password'
                    ]
                );
            ?>
            <button type="submit" class="v7-btn v7-btn-cta v7-btn-submit v7-mt-20 fx-ripple-effect">
                <?= __('Submit') ?>
            </button>
        </form>
    </div>
</section>

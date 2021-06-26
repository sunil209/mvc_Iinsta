<?php
if (empty($email) || empty($address)) {
    return;
}

$pageMessage = 'Any questions about this ' . $pageTitle . '<br>should be addressed to: ';
?>

<section class="v7 v7-content v7-mt-80 text-center">
    <img
        class="v7-box v7-no-results-icon"
        src="<?= get_template_directory_uri() ?>/v5/assets/images/icon-no-result.svg" alt="No Results Icon"
    >
    <h3 class="h1 v7-mt-50"><?= __('Questions?') ?></h3>
    <p class="v7-mb-50">
        <?= $pageMessage ?>
        <a
            href="mailto:<?= esc_attr($email) ?>?subject=Instapage%20Website%20Question"
            class="v7-text-cta"
        >
            <?= esc_html($email) ?>
        </a>
    </p>
    <h3 class="v7-mb-20"><?= __('Or By Mail To:') ?></h3>
    <strong class="v7-mt-5"><?= __('Instapage Inc.') ?></strong>
    <?php foreach ($address as $addressLine) : ?>
        <p class="v7-mt-5"><?= esc_html($addressLine) ?></p>
    <?php endforeach; ?>
</section>

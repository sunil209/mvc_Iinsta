<?php
/**
 * Template file. Template params are stored in $params array
 * $text             - list elements text
 * $class            - list styling class
 */
use \Instapage\Classes\Component;

if (empty($lists) || !is_array($lists)) {
    return;
}
?>

<section class="v7 v7-mt-80">
    <?php
    if (!empty($sectionTitle)) {
        Component::dumbRender('division-header', [
            'title' => $sectionTitle,
            'subtitle' => $sectionSubtitle,
            'class' => 'v7-mb-40 v7-mb-md-50'
        ]);
    }
    ?>

    <ul class="
        v7-content v7-list v7-checklist
        <?= $layout === 'extended' ? 'v7-list-extended' : 'v7-list-horizontal-wide'; ?>
        <?= esc_attr($class) ?? ''; ?>
    ">
        <?php foreach ($lists as $list) : ?>
            <li>
                <?php if (!empty($list['label'])) : ?>
                    <span class="v7-list-label"><?= esc_html($list['label']); ?></span>
                <?php endif; ?>
                <?php if (!empty($list['url'])) : ?>
                    <a class="v7-list-link v7-btn v7-btn-flat" href="<?= esc_attr($list['url']); ?>" target="_blank">
                <?php endif; ?>
                <?= esc_html($list['text']); ?>
                <?php if (!empty($list['url'])) : ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

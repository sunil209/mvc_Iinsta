<?php
/**
 * Template file. Template params are stored in $params array
 * @param array $list          - List elements containing:
 *        bool is_active         Is feature included in a plan
 *        string feature         Feature name
 *        string feature_tooltip Feature tooltip
 * @param string $class        - List styling class
 */
use \Instapage\Classes\Component;

if (empty($lists) || !is_array($lists)) {
    return;
}
?>

<ul class="v7-list v7-card-list <?= esc_attr($class) ?? ''; ?>">
    <?php foreach ($lists as $list) : ?>
        <li <?= !$list['is_active_core'] && $class === 'v7-card-list-core' ? 'class="v7-list-removed"' : ''; ?>>
            <?php if (!$list['is_active_core'] && $class === 'v7-card-list-core') : ?>
                <i class="material-icons v7-list-remove-sign">remove</i>
            <?php else : ?>
                <i class="material-icons v7-list-check-sign">check</i>
            <?php endif; ?>
            <?= esc_html($list['feature']); ?>
            <?php if (!empty($list['feature_tooltip'])) {
                Component::render('tooltip', [
                    'tooltipText' => $list['feature_tooltip']
                ]);
            } ?>
        </li>
    <?php endforeach; ?>
</ul>

<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $plansPackages   Array of packages: title, column_1, column_2
 * @param string $plansHeader     Component title
 * @param array  $plansColumns    Array of columns names
 * @param array  $plansButtons    Array of footer buttons
 *
 * @example Usage
 * Component::render('pricing-plans');
 * @endexample
 */

use \Instapage\Classes\Component;

if (empty($plansPackages) || !is_array($plansPackages) || empty($plansPackages[0])) {
    return;
}
?>

<header class="v7-modal-header">
    <div class="v7-modal-header-wrapper">
        <div class="v7-content v7-modal-header-content">
            <div class="v7-list-highlight-copy">
                <h2 class="v7-modal-header-title"><?= esc_html($plansHeader) ?></h2>
            </div>
            <div class="v7-list-highlight-copy"></div>
            <div class="v7-list-highlight-copy">
                <?php Component::render('button', $plansHeaderButton[0]); ?>
            </div>
            <i class="material-icons v7-modal-header-icon js-modal-close">close</i>
        </div>
    </div>
    <?php if (!empty($plansColumns)) : ?>
        <div class="v7-list-highlight-category">
            <div class="v7-content v7-list-highlight">
                <?php foreach ($plansColumns as $column) : ?>
                    <p class="v7-list-highlight-copy"><?= esc_html($column['column_name']) ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</header>
<?php if (!empty($plansPackages)) : ?>
    <ul>
        <?php foreach ($plansPackages as $package) : ?>
            <li class="v7-list-highlight-row">
                <div class="v7-content v7-list-highlight">
                    <p class="xsmall v7-list-highlight-copy"><?= esc_html($package['title']) ?></p>
                    <?php if ($package['column_1']) : ?>
                        <div class="v7-list-highlight-copy">
                            <img 
                                class=" v7-list-highlight-check" 
                                src="<?= get_template_directory_uri() . '/v5/components/v70/lists/img/icon-check.svg' ?>" 
                                alt="Check icon"
                            >
                        </div>
                    <?php else : ?>
                        <i class="material-icons v7-list-highlight-copy v7-list-highlight-uncheck">•</i>
                    <?php endif; ?>
                    <?php if ($package['column_2']) : ?>
                        <div class="v7-list-highlight-copy">
                            <img 
                                class=" v7-list-highlight-check" 
                                src="<?= get_template_directory_uri() . '/v5/components/v70/lists/img/icon-check.svg' ?>" 
                                alt="Check icon"
                            >
                        </div>
                    <?php else : ?>
                        <i class="material-icons v7-list-highlight-copy v7-list-highlight-uncheck">•</i>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (!empty($plansButtons)) : ?>
    <div class="v7-content v7-list-highlight v7-list-highlight-footer">
        <div class="v7-list-highlight-copy"></div>
        <div class="v7-list-highlight-copy">
            <?php Component::render('button', $plansButtons[0]); ?>
        </div>
        <div class="v7-list-highlight-copy">
            <?php if (!empty($plansButtons[1])) : ?>
                <?php Component::render('button', $plansButtons[1]); ?>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

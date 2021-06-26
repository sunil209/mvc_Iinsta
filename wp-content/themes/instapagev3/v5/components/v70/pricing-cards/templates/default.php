<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $cards          An array of pricing cards, each containing:
 *               array header           Title section of a card:
 *                  string title            Card's title
 *                  string subtitle         Card's subtitle
 *               array price_section    An array of sections with price details:
 *                  string price            Price, numeric or string
 *                  string plan             Type of a pricing plan
 *                  string plan_tooltip     Tooltip for that plan
 *               array button           An array passed to a button component:
 *                  string text             Button's text
 *                  string url              Button's url
 *                  string class            Button's CSS classes
 * @param array $features        An array of features included in each plan containing:
 *                  string feature                  Feature name
 *                  bool is_active_core             Is feature included in a core plan
 *                  bool is_active_enterprise       Is feature included in a enterprise plan
 *
 * @example Usage
 * Component::render('pricing-cards');
 * @endexample
 */

use \Instapage\Classes\Component;

if (empty($cards) || !is_array($cards)) {
    return;
}
?>
<section class="v7 v7-content v7-pricing-cards-section">
    <div class="v7-pricing-cards-wrapper">
    <?php foreach ($cards as $key => $card) : ?>
        <div class="v7-pricing-card js-expand-card <?= $isExpanded ? 'v7-pricing-card-expanded' : '' ?>">
            <header class="text-center">
                <h2 class="v7-pricing-header"><?= esc_html($card['header']['title']);?></h2>
                <p class="v7-pricing-subtitle"><?= esc_html($card['header']['subtitle']);?></p>
            </header>
            <hr class="v7-mt-30 v7-mb-30 v7-pricing-line">
            <div class="v7-price-section text-center">
                <?php if (count($card['price_section']) > 1) : ?>
                    <h1 class="
                        v7-mb-20 v7-headline-huge
                        v7-is-transparent
                        <?= is_numeric($card['price_section'][0]['price']) ? 'v7-price' : ''; ?>
                    ">
                        <?=
                            is_numeric($card['price_section'][1]['price']) ?
                            '<span class="v7-price-currency">$</span>' :
                            '';
                        ?>
                        <?= esc_html($card['price_section'][0]['price']);?>
                    </h1>
                    <h1 class="
                        v7-mb-20 v7-headline-huge
                        <?= is_numeric($card['price_section'][1]['price']) ? 'v7-price' : ''; ?>
                    ">
                        <?=
                            is_numeric($card['price_section'][1]['price']) ?
                            '<span class="v7-price-currency">$</span>' :
                            '';
                        ?>
                        <?= esc_html($card['price_section'][1]['price']);?>
                    </h1>
                    <?php Component::render('toggle-options', ['toggleOptions' => $card['price_section']]); ?>
                <?php else : ?>
                    <h1 class="v7-mb-20"><?= esc_html($card['price_section'][0]['price']);?></h1>
                    <span class="v7-pricing-plan"><?= esc_html($card['price_section'][0]['billing']);?></span>
                <?php endif; ?>
            </div>
            <hr class="v7-mt-30 v7-mb-30 v7-pricing-line">
            <?php
                $listClass = ($key === 0 ? 'v7-card-list-core' : 'v7-card-list-enterprise');
                Component::render('lists', 'card-list', ['lists' => $features, 'class' => $listClass]);
            ?>
            <?php Component::render('button', $card['button']) ?>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="v7-pricing-cards-trigger v7-mt-20 <?= $isExpanded ? 'v7-is-hidden ' : '' ?>">
        <a href="#" class="v7-btn v7-btn-flat v7-btn-small js-expand-card-link">
            <span><?= __('SEE ALL FEATURES'); ?></span>
            <i class="material-icons v7-material-icons">keyboard_arrow_down</i>
        </a>
    </div>
    <div class="v7-pricing-cards-buttons-wrapper <?= $isExpanded ? 'no-offset' : '' ?>">
        <?php Component::render('button', $cards[0]['button']) ?>
        <?php Component::render('button', $cards[1]['button']) ?>
    </div>

    <?php
    if (!empty($button)) {
        Component::render(
            'buttons-group',
            [
                'class' => 'v7-pt-10 v7-pt-md-0',
                'buttons' => [$button]
            ]
        );
    }
    ?>
</section>

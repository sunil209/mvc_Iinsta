<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $items                 An array of accordions, each containing:
 *               string title           Title of accordion
 *               string icon            Url for icon in accordion title
 *               string url             Link to item shown in accordion
 *               string excerpt         Excerpt of accordion's item
 *               bool   isOpen          Should accordion be open on entry
 *               string videoEmbedCode  Video for accordion item
 *
 * @example Usage
 * Component::render('accordion');
 * @endexample
 */
use Instapage\Classes\Component;
use Instapage\Helpers\HtmlHelper;

if (empty($accordions) || !is_array($accordions)) {
    return;
}
?>

<?php if (!empty($sectionTitle)) : ?>
<section
    class="v7 v7-mt-80 v7-accordions-group <?= esc_attr($sectionClass) ?>"
>
    <?php Component::dumbRender('division-header', [
        'title' => $sectionTitle,
        'subtitle' => $sectionSubtitle,
        'class' => 'v7-mb-40 v7-mb-md-50'
    ]);
else : ?>
<section class="v7 v7-accordions-group js-search-content <?= esc_attr($sectionClass) ?>">
<?php endif;
foreach ($accordions as $accordion) :
    echo '<div
        id="' . esc_attr($accordion['groupID'] ?? '') .
        '" class="v7-accordions-group-wrapper ' . esc_attr($groupClass) . '">';
    if (!empty($accordion['headline'])) :
        echo '<h2 class="v7-pb-30 ' .
            'v7-accordion-headline">' .
            esc_html($accordion['headline'] ?? '') .
            '</h2>';
    endif;
    foreach ($accordion['items'] as $item) :
        ?>
    <div 
        class="
            v7-accordion
            <?= !empty($item['icon']) ? 'v7-accordion-layout v7-accordion-list' : 'v7-accordion-simplified'; ?>
            v7-box v7-box-clickable
            js-search-element
            <?= $item['is_open'] ? 'v7-accordion-open' : '' ?>
        "
        data-search="<?= esc_attr($item['title'] ?? ''); ?>"
        <?= isset($item['attributes']) ? HtmlHelper::renderAttributes($item['attributes']) : ''; ?>
    >
        <?php Component::dumbRender('accordion-header', ['item' => $item]);
        Component::dumbRender('accordion-body', [
            'item' => $item,
            'isEditable' => $isEditable
        ]); ?>
    </div>
        <?php
    endforeach;
    echo '</div>';
endforeach; ?>
</section>

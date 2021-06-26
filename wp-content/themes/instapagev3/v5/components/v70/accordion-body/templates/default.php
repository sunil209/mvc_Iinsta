<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $item                  One accordion item containing:
 *               string url             Link to item shown in accordion
 *               string excerpt         Excerpt of accordion's item
 *               string videoEmbedCode  Video for accordion item
 *
 * @example Usage
 * Component::render('accordion-body', ['item' => $item, 'isEditable' => $isEditable]);
 * @endexample
 */
use Instapage\Classes\Component;

if (empty($item) && !is_array($item)) {
    return;
}
?>

<div class="
    v7-accordion-body
    <?= isset($isEditable) ? 'v7-editable-accordion' : ''; ?>
    <?= !empty($item['videoEmbedCode']) ? 'v7-accordion-video' : ''; ?>
">
    <?php if (isset($isEditable)) : ?>
        <?= $item['excerpt'] ?>
    <?php else : ?>
        <p class="v7-accordion-paragraph"><?= $item['excerpt'] ?></p>
    <?php endif; ?>
    <?php
    if (!empty($item['videoEmbedCode'])) :
        echo '<span class="load-wrapper v7-is-hidden"> ' . $item['videoEmbedCode'] . '</span>';
    endif;
    if (!empty($item['url'])) :
        Component::render('button', [
            'url' => $item['url'],
            'text' => __('Learn more'),
            'class' => 'v7-btn-flat v7-mt-30'
        ]);
    endif; ?>
</div>

<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string  $sectionClass   Class for section
 * @param string  $modalSlot      Place to add content for modal
 *
 * @example Example without prefix
 * Component::render('modal');
 * @endexample
 */
?>

<section class="v7 v7-modal-wrapper js-modal <?= esc_attr($sectionClass) ?>" data-state="hidden">
    <?php if (!empty($modalSlot)) : ?>
        <?= $modalSlot; ?>
    <?php endif; ?>
</section>

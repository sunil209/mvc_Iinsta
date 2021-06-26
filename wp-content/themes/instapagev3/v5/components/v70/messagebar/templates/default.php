<?php
if ($isOn !== true) {
    return;
}
?>
<div class="message-bar-wrapper js-message-bar-wrapper" style="display:none;">
    <div class="message-bar-title message-bar-title-desktop">
        <p>
            <?= esc_html($title) ?>
        </p>
        <input type="hidden" name="messagebar-hash" value="<?= md5($title) ?>" />
    </div>

    <a
        class="js-btn-message-bar btn-message-bar v7-btn v7-btn-white v7-btn-small fx-ripple-effect"
        href="<?= esc_url($button['url']) ?>"
        target="_blank"
    >
        <span class="v7-btn-text">
            <?= esc_html($button['text']) ?>
        </span>
    </a>
</div>

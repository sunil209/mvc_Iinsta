<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $text              Text to be displayed between tags
 * @param string $url               Url to link button
 * @param mixed  $class             Button classes
 * @param string icon               Material icon code
 * @param bool   $isDownloadable    Adds 'download' prop to link
 * @param array  $attributes        Associative array of attributes
 *
 * @example Basic usage
 * Component::render('v70/button', ['text' => __('Lorem ipsum']), 'url' => 'http://example.com/'];
 * @endexample
 *
 * @example Advanced usage
 * Component::render(
 *   'v70/button',
 *   [
 *     'text' => __('Lorem ipsum'),
 *     'url' => 'http://example.com/',
 *     'class' => 'btn-cta',
 *     'attributes' => [
 *       'data-some-attribute' => 'with-value'
 *     ]
 *   ]
 * );
 * @endexample
 */
use Instapage\Classes\Component;
use Instapage\Helpers\HtmlHelper;

if ($video ?? null === true) {
    $video = new Instapage\Components\v51\Video\Controller(['url' => $url]);
    $video->renderDelayed();
    $attributes['data-video-id'] = $video->getComponentID();
}
?>

<?php if (!empty($url)) : ?>
    <a
        href="<?= esc_url($url); ?>"
        <?php
        if (strpos($url, 'enterprise-demo-request') !== false) {
            // Please be really careful when editing this component,
            // this can change GA Events (GA Event cannot be deleted or altered)
            Component::render(
                'generic/ga-event-dispatcher',
                [
                    'category' => 'Button',
                    'label' => ($text ?? '') . ' [path: ' . Component::getComponentsRenderTree()->getCurrentRenderPath() . ']'
                ]
            );
        }
        ?>
        class="
            v7-btn <?= esc_attr($class); ?>
            <?= preg_match('/v7-btn-cta|v7-btn-ghost-cta|v7-btn-white|v7-btn-ghost/i', $class) == 1 ? ' fx-ripple-effect' : ''; ?>
        "
        <?= $isDownloadable ? 'download' : ''; ?>
        <?= !empty($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>
    >

    <span class="v7-btn-text">
        <?php if ($icon === 'play_arrow') : ?>
        <svg class="v7-btn-play-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path d="M8 5v14l11-7z"/>
            <path d="M0 0h24v24H0z" fill="none"/>
        </svg>
        <?php elseif (!empty($icon)) : ?>
            <i class="material-icons icon-label"><?= $icon; ?></i>
        <?php endif; ?>
        <span class="v7-btn-copy"><?= str_replace(' ', '&nbsp;', $text); ?></span>
        <?php if ($iconRight) : ?>
            <svg
            class="v7-btn-icon-right"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                <path fill="none" d="M0 0h24v24H0V0z"/>
            </svg>
        <?php endif; ?>
    </span>
    </a>
<?php endif; ?>

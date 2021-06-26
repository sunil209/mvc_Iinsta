<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $text       Text to be displayed between tags
 * @param string $url        Url to link button
 * @param mixed  $class      Button classes
 * @param string icon        Material icon code
 * @param array  $attributes Associative array of attributes
 *
 * @example Basic usage
 * Component::render('v51/button', ['text' => __('Lorem ipsum']), 'url' => 'http://example.com/'];
 * @endexample
 *
 * @example Advanced usage
 * Component::render(
 *   'v51/button',
 *   [
 *     'text' => __('Lorem ipsum'),
 *     'url' => 'http://example.com/',
 *     'class' => 'btn btn-cta',
 *     'attributes' => [
 *       'data-some-attribute' => 'with-value'
 *     ]
 *   ]
 * );
 * @endexample
 */

use Instapage\Helpers\HtmlHelper;
use Instapage\Classes\Component;

?>

<?php if (!empty($text) && !empty($url)): ?>
    <a
        href="<?= $url; ?>"
        <?php
        if (strpos($url, 'enterprise-demo-request') !== false) {
            // Please be really careful when editing this component,
            // this can change GA Events (GA Event cannot be deleted or altered)
            Component::render(
                'generic/ga-event-dispatcher',
                [
                    'category' => 'Button',
                    'label' => $text . ' [path: ' . Component::getComponentsRenderTree()->getCurrentRenderPath() . ']'
                ]
            );
        }
        ?>
        class="
          <?= esc_attr($class); ?>
          <?= preg_match('/btn/i', $class) === 1 ? ' fx-ripple-effect' : ''; ?>
        "
        <?= isset($attributes) ? HtmlHelper::renderAttributes($attributes) : ''; ?>
    >
        <?php if ($icon === 'play_arrow'): ?>
            <svg class="btn-play-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
                <path d="M0 0h24v24H0z" fill="none"/>
            </svg>
        <?php elseif (isset($icon)): ?>
            <i class="material-icons icon-label"><?= $icon; ?></i>
        <?php endif; ?>
        <?= $text; ?>
    </a>
<?php endif; ?>

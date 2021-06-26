<?php
use \Instapage\Classes\Amp\Amp;
use \Instapage\Classes\Amp\AmpContentFilter;
use \Instapage\Classes\Component;

global $amp;
$amp = new \Instapage\Classes\Amp\Amp();

add_action('wp_ajax_nopriv_amp_landing_page_xhr', 'ampLandingPageXHR');
add_action('wp_ajax_amp_landing_page_xhr', 'ampLandingPageXHR');

function ampLandingPageXHR() {
  if (!headers_sent()) {
    header('AMP-Access-Control-Allow-Source-Origin: ' . $_SERVER['DESIRED_ROOT']);
  }

  $nonceName = 'amp-landing-page';

  if (
    isset($_GET['__amp_source_origin']) &&
    !empty($_GET['__amp_source_origin']) &&
    ($_GET['__amp_source_origin'] === $_SERVER['DESIRED_ROOT']) &&
    !headers_sent()
  ) {
    header('AMP-Redirect-To: ' . $_POST['redirect']);
    header('Access-Control-Expose-Headers: AMP-Redirect-To, AMP-Access-Control-Allow-Source-Origin');

    $url = $_POST['original_action'];
    unset($_POST['original_action'], $_POST['action']);
    $_POST = array_map('stripslashes', $_POST);
    $data = wp_remote_post(
      $url,
      [
        'timeout' => 45,
        'redirection' => 0,
        'sslverify' => false,
        'body' => $_POST
      ]
    );
    echo json_encode((is_wp_error($data)) ? 'ERROR' : 'OK');
  } else {
    echo json_encode('ERROR');
  }
  wp_die();
}

function isAmp() {
  global $amp;
  return $amp->isEnabled();
}

add_filter('do_shortcode_tag', function (string $output, string $tag, $attr, array $m) {
  if ($tag !== 'video') {
    return $output;
  }

  if (!isAmp()) {
    return $output;
  }

  // if we're on AMP version of page and we're generating video shortcode then use amp-video tag
  return Component::fetch('amp/amp-video', [
    'src' => $attr['mp4'] ?? null,
    'height' => $attr['height'] ?? null,
    'width' => $attr['width'] ?? null
  ]);
}, 10, 4);

$amp->registerFilter(new AmpContentFilter('iframe', function($input) {
  return AmpContentFilter::regexCallback($input, '#<iframe(?:.*?)></iframe>#si', function($matches) {
    if ((isset($matches[0])) && (!empty($matches[0]))) {
      $properties = ['src', 'width', 'height', 'class', 'title', 'layout', 'sandbox'];
      foreach ($properties as $property) {
        preg_match('#' . $property . '="(.*?)"#si', $matches[0], ${$property . 'Matches'});
        $$property = ((isset(${$property . 'Matches'}[1])) && (!empty(${$property . 'Matches'}[1]))) ? ${$property . 'Matches'}[1] : null;
      }

      $layout = 'responsive';
      $width = 700;
      $height = 395;

      if (!isset($sandbox) || empty($sandbox)) {
        $sandbox = 'allow-scripts allow-same-origin allow-popups allow-presentation';
      }

      $component = Component::fetch('amp/iframe', call_user_func_array('compact', $properties));
      return AmpContentFilter::regexReplace($matches[0], '#<iframe(.*?)></iframe>#si', $component);
    }
  });
}));

$amp->registerFilter(new AmpContentFilter('img', function($input) {
  return AmpContentFilter::regexCallback($input, '#<img(?:.*?)>#si', function($matches) {
    if ((isset($matches[0])) && (!empty($matches[0]))) {
      $properties = ['src', 'srcset', 'width', 'height', 'class', 'alt', 'layout'];
      foreach ($properties as $property) {
        preg_match('#' . $property . '="(.*?)"#si', $matches[0], ${$property . 'Matches'});
        $$property = ((isset(${$property . 'Matches'}[1])) && (!empty(${$property . 'Matches'}[1]))) ? ${$property . 'Matches'}[1] : null;
      }

      $layout = 'responsive';

      // Adjustments
      $class = str_replace('size-full', 'size-' . $layout, $class);
      $alt = str_replace('$', 'USD', $alt);

      $component = Component::fetch('amp/img', call_user_func_array('compact', $properties));

      if (substr($src, -10) === '/giphy.gif') {
        $class = 'align-center size-responsive contain';
        $layout = 'fill';
        $component = '<div class="contain-container">' . Component::fetch('amp/img', call_user_func_array('compact', $properties)) . '</div>';
      }

      return AmpContentFilter::regexReplace($matches[0], '#<img(.*?)>#si', $component);
    }
  });
}));

$amp->registerFilter(new AmpContentFilter('font', function($input) {
  return AmpContentFilter::regexCallback($input, '#<font(?:.*?)>(.*?)</font>#si', function($matches) {
    if ((isset($matches[0])) && (!empty($matches[0]))) {
      return AmpContentFilter::regexReplace($matches[0], '#<font(.*?)>(.*?)</font>#si', $matches[1]);
    }
  });
}));

$amp->registerFilter(new AmpContentFilter('script', function($input) {
  return AmpContentFilter::regexCallback($input, '#<script(?:.*?)>(?:.*?)</script>#si', function($matches) {
    if ((isset($matches[0])) && (!empty($matches[0]))) {
      return AmpContentFilter::regexReplace($matches[0], '#<script(.*?)>(.*?)</script>#si', '');
    }
  });
}));

$amp->registerFilter(new AmpContentFilter('globalAttributesWithOptionalValue', function($input) {
  return AmpContentFilter::regexReplace($input, '#(?:\s+)(?<name>allowtransparency|webkitallowfullscreen|mozallowfullscreen|oallowfullscreen|msallowfullscreen|marginwidth|marginheight+)(=(?<quote>[\'"]{1})(?<value>[a-z0-9:;,_%"“”\'\-\#\$\\/\.\s]+)\g{3})?#i', '');
}));

$amp->registerFilter(new AmpContentFilter('globalAttributesWithRequiredValue', function($input) {
  return AmpContentFilter::regexReplace($input, '#(?:\s+)(?<name>name|rel|style|target|scrolling|shape+)=(?<quote>[\'"]{1})(?<value>[a-z0-9:;,_%"“”\'\-\#\$\\\/\.\s]+)\g{quote}#i', '');
}));

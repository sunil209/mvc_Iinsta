<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param string $headerClass   CSS class for <header> container, ignored if $headerImage is set
 * @param string $headerSize    Variants of header section height: ['full']
 * @param string $headerImage   Url of image to be used instead of css class
 * @param string $headerText    Text to be displayed as <h1>
 * @param string $subHeaderText Text to be displayed as <p>, just below <h1>
 * @param string $buttonText    Header cta button text
 * @param string $buttonUrl     Header cta button url
 * @param string $videoUrl      Header video url
 * @param string $videoText     Header video text
 * @param string $slot          Header cta buttons custom HTML snippet
 * @param array  $attributes    Associative array of attributes
 * @param bool   $sliderContext Decide is this instance of header compononet used in slider context?
 * @param string $scrollToSelector  Header scroll arrow id selector
 */

use Instapage\Helpers\HtmlHelper;
use \Instapage\Classes\Component;

$sliderContext = isset($sliderContext) && $sliderContext === true ? true : false;
$headerLogos = (!empty($headerLogos)) ? $headerLogos : getAcfVar('logos', '', $params['contextID']);
$headerSize = (isset($headerSize)) ? 'is-' . $headerSize : '';
$scrollToSelector = (!empty($scrollToSelector)) ? $scrollToSelector : '';

?>
<!-- MAIN HEADER -->
<header class="hero-section-light header-section <?= empty($headerImage) ? $headerClass : ''; ?>">
  <!-- MAIN HEADER HERO -->
  <section class="content hero-section-column-wrapper">
    <div class="hero-section-column">
      <h1><?= __($headerText); ?></h1>
      <?php if ((!empty($subHeaderText)) && $sliderContext === false): ?>
        <h4 class="hero-section-text-left"><?= __($subHeaderText); ?></h4>
      <?php endif; ?>
      <?php if (!empty($buttons) && is_array($buttons) && count($buttons) >=2): ?>
        <div class="btn-group">
      <?php endif; ?>
        <?php
        foreach ($buttons as $buttonParams) {
          if ($buttonParams['video'] ?? null === true) {
            $video = new Instapage\Components\v51\Video\Controller(['url' => $buttonParams['url']]);
            $video->renderDelayed();
            $buttonParams['attributes']['data-video-id'] = $video->getComponentID();
          }
          Component::render('v51/button', $buttonParams);
        }
        ?>
      <?php if (!empty($buttons) && is_array($buttons) && count($buttons) >=2): ?>
        </div>
      <?php endif; ?>
    </div>
    <?php if (!empty($headerSideImage)): ?>
      <div class="hero-section-column">
        <img class="hero-section-image" src="<?= $headerSideImage; ?>" <?= HtmlHelper::renderSrcSet(['1x' => $headerSideImage, '2x' => $headerSideImageRetina]); ?> alt="Header image">
      </div>
    <?php endif; ?>
  </section>
</header>

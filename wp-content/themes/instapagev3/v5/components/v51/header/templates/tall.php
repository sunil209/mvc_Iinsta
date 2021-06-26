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
<header class="hero-section header-section header-section-tall <?= ((!is_404()) && (empty($headerImage))) ? $headerClass : ''; ?> <?= $headerSize; ?>">
  <?php if (!empty($headerImage) && $sliderContext === true): ?>
    <img src="<?= $headerImage; ?>" class="hero-slider-img" />
  <?php endif; ?>
  
  <!-- MAIN HEADER HERO -->
  <section class="hero-section-intro content">
    <?php if (!empty($featuredImage)): ?>
      <div class="hero-icon-container">
        <?php if (isAmp()): ?>
          <amp-img
            alt="<?= (!empty($headerText)) ? esc_attr($headerText) : ''; ?>"
            src="<?= esc_url($featuredImage); ?>"
            width="50"
            height="50">
          </amp-img>
        <?php else: ?>
          <img class="hero-icon" src="<?= esc_url($featuredImage); ?>" alt="<?= (!empty($headerText)) ? esc_attr($headerText) : ''; ?>">
        <?php endif; ?>
      </div>
    <?php endif; ?>
    <h1><?= __($headerText); ?></h1>
    <?php if ((!empty($subHeaderText)) && $sliderContext === false): ?>
      <p><?= __($subHeaderText); ?></p>
    <?php endif; ?>
    <?php Component::render('v51/buttons-group', ['buttons' => $buttons, 'slot' => $slot]) ?>
    <?php if (!empty($scrollToSelector)): ?>
      <a href="<?= esc_url($scrollToSelector); ?>" data-scroll="72">
        <i class="material-icons hero-scroll">keyboard_arrow_down</i>
      </a>
    <?php endif; ?>
    <?php if (!empty($headerLogos)): ?>
      <div class="hero-logos">
      <?php foreach ($headerLogos as $logos): ?>
        <img class="hero-logos-img" src="<?php echo esc_url($logos['logo']['url']); ?>" alt="<?php echo esc_attr($logos['alt']); ?>">
      <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</header>

<?php
/**
 * Template file. Template params are stored in $params array
 *
 * @param array  $buttons Associative array of buttons
 * @param string $slot    Custom HTML snippet
 *
 * @example Basic usage
 * Component::render('v51/buttons-group', ['buttons' => $buttons];
 * @endexample
 *
 */

use Instapage\Classes\Component;
?>

<div class="btn-group">
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
  <?php if (!empty($slot)): ?>
    <?= $slot; ?>
  <?php endif; ?>
</div>

<?php
namespace Instapage\Components\v51\LeftRight;

use Instapage\Models\Component as ModelComponent;

/**
 * Description of model-left-right
 */
class LeftRightModel extends ModelComponent {

  /**
   * Gets an array with `left/right` from ACF
   * @return array
   */
  public function getItems() {
    $items = [];

    while (have_rows('leftright')) {
      the_row();
      $items[] = [
        'title' => get_sub_field('title'),
        'layout' => get_sub_field('layout'),
        'id' => get_sub_field('id'),
        'image' => get_sub_field('image'),
        'imageRetina' => get_sub_field('image_retina'),
        'video' => get_sub_field('video'),
        'videoRetina' => get_sub_field('video_retina'),
        'text' => get_sub_field('text'),
        'textAlignment' => get_sub_field('text_alignment'),
        'name' => get_sub_field('name'),
        'avatar' => get_sub_field('avatar'),
        'avatarRetina' => get_sub_field('avatar_retina'),
        'url' => get_sub_field('url'),
        'playButton' => get_sub_field('play_button'),
        'logo' => get_sub_field('logo'),
        'newBadge' => get_sub_field('new_badge')
      ];
    }

    return $items;
  }

  /**
   * Return list of parameters that model can provide.
   *
   * Remember that if paramter name is items, function which will fetch data for this parameter is getItems() etc.
   *
   * @return array Array containg parametes name that model can provide
   */
  public function getParamsListToInject() : array {
    return [
      'items',
    ];
  }

}

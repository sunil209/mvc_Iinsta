<?php
namespace Instapage\Classes;

use Instapage\Classes\Component;

class View extends Component {

  public static function render($view = '', $variation = 'default', $params = array()) {
    
    if (!$view) {
      return;
    }

    if (is_array($variation)) {
      $params = $variation;
      $variation = 'default';
    }

    $templatePath = get_template_directory() . '/v5/views/' . $view . '/templates/' . $variation . '.php';

    if (!file_exists($templatePath)) {
      throw new NoTemplateException($variation, $view);
    }

    extract($params, EXTR_OVERWRITE);
    ob_start();
    include($templatePath);
    $content = ob_get_contents(); 
    ob_end_clean();
    echo self::parseRenderDelayed($content);
  }

  /**
   *  Return array with html string without cuted string and array of cuted
   *
   * @param string $string
   * @param string $start
   * @param string $end
   * @return array
   */
  private static function getStringBetween(string $string, string $start, string $end) : array {
    $splitEnd = explode($end, $string);
    $mainHtml = '';
    $movedHtml = [];

    foreach ($splitEnd as $value) {
      if (strpos($value, $start) !== false) {
        $splitStart = explode($start, $value);
        $mainHtml .= $splitStart[0];
        $movedHtml[] = $splitStart[1];
      } else {
        $mainHtml .= $value;
      }
    }

    return [
      'mainHtml' => $mainHtml, 
      'movedHtml' => $movedHtml
    ];
  }

  /**
   * Move all HTML between html comment after <footer></footer>
   *
   * @param string $string
   * @return string
   */
  private static function parseRenderDelayed(string $string) : string {
    $html = self::getStringBetween($string, '<!-- renderDelayedStart -->','<!-- renderDelayedEnd -->');
    $value = '';

    foreach ($html['movedHtml'] as  $value) {
      $replace .= $value; 
    }

    return str_replace('<!-- renderDelayed -->', $replace, $html['mainHtml']);
  }
}

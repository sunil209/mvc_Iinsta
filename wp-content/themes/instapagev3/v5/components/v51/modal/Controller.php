<?php
namespace Instapage\Components\v51\Modal;

use \Instapage\Helpers\StringHelper;
use \Instapage\Classes\Component;
use \Instapage\Classes\RootComponent;

/**
 * Class used to encapsulate logic for modal component
 */
class Controller extends RootComponent {
  protected $componentNamespace = __NAMESPACE__;

  /**
   * @param $params An array of parameters passed to component template.
   */
  public function __construct($params = []) {
    parent::__construct($params);
  }
}

<?php
namespace Instapage\Classes;

use \Instapage\Helpers\StringHelper;
use \Instapage\Classes\Component;

/**
 * Class used to encapsulate logic common for all components
 */
class RootComponent {
  /**
   * @var array Holds an array of parameters required to render component. This is just a `default` and may be altered with each `render()` / `renderDelayed()` / `fetch()` call
   */
  protected $params;

  /**
   * @var string Holds a string of concrete component namespace. It's set by child class
   */
  protected $componentNamespace;

  /**
   * How many times this particular component was render? It is used for generating ID
   *
   * @var type
   */
  public static $renderCount = [];

  /**
   * @var string Holds a string uniquely identifying given component instance.
   */
  private $componentID;

  /**
   * Get render count, how many times this component was rendered?
   *
   * @return int
   */
  protected function getRenderCount() : int {
    return self::$renderCount[get_called_class()] ?? 0;
  }

  /**
   * Increase render counter, do it only once on one render
   *
   * @return void
   */
  protected function increaseRenderCount() : void {
    self::$renderCount[get_called_class()] = $this->getRenderCount() + 1;
  }

  /**
   * @param $params An array of parameters passed to component template.
   * @uses  self::$params
   * @uses  self::setComponentID()
   */
  public function __construct($params = []) {
    $this->params = $params;
    $this->increaseRenderCount();
    $this->setComponentID();
  }

  /**
   * Sets a string uniquely identifying given component instance.
   * @uses   self::$componentID
   * @uses   self::getVersion
   * @uses   self::getIdentifier()
   * @return void
   * @see    self::getComponentID()
   */
  protected function setComponentID() {
    $this->componentID = 'js-' . $this->getVersion() . '-' . $this->getIdentifier() . '-' . $this->getRenderCount();
  }

  /**
   * Returns string uniquely identifying given component instance.
   * @uses   self::$componentID
   * @return string
   * @see    self::setComponentID()
   */
  public function getComponentID() {
    return $this->componentID;
  }

  /**
   * Returns the version of component this controller operates on
   * @uses   self::$componentNamespace
   * @uses   StringHelper::namespaceToVersion()
   * @return string
   */
  protected function getVersion() {
    return StringHelper::namespaceToVersion($this->componentNamespace);
  }

  /**
   * Returns the name of component this controller operates on
   * @uses   self::$componentNamespace
   * @uses   StringHelper::namespaceToIdentifier()
   * @return string
   */
  protected function getIdentifier() {
    return StringHelper::namespaceToIdentifier($this->componentNamespace);
  }

  /**
   * Renders given component
   * @param  string $variation Component variation. Default value is 'default'.
   * @param  array  $params An array of parameters passed to component template.
   * @uses   self::paramsDecorator()
   * @uses   self::getVersion()
   * @uses   self::getIdentifier()
   * @uses   \Instapage\Classes\Component::render()
   * @return void
   */
  public function render($variation = 'default', $params = []) {
    $params = $this->paramsDecorator($params);
    Component::render($this->getVersion() . '/' . $this->getIdentifier(), $variation, $params);
  }

  /**
   * Renders given component
   * @param  string $variation Component variation. Default value is 'default'.
   * @param  array  $params An array of parameters passed to component template.
   * @uses   self::paramsDecorator()
   * @uses   self::getVersion()
   * @uses   self::getIdentifier()
   * @uses   \Instapage\Classes\Component::fetch()
   * @return string
   */
  public function fetch($variation = 'default', $params = []) {
    $params = $this->paramsDecorator($params);
    return Component::fetch($this->getVersion() . '/' . $this->getIdentifier(), $variation, $params);
  }

  /**
   * Adds filter to `wp_footer` and calls `render()` there
   * @param  string $variation Component variation. Default value is 'default'.
   * @param  array  $params An array of parameters passed to component template.
   * @uses   self::render()
   * @return void
   */
  public function renderDelayed($variation = 'default', $params = []) {
    echo '<!-- renderDelayedStart -->';
    $this->render($variation, $params);
    echo '<!-- renderDelayedEnd -->';
  }

  /**
   * Decorator for params passed to component
   * @param  array An array of parameters passed to component template.
   * @uses   self::$params
   * @return array An array of parameters passed to component template, with necesssary adjustments.
   */
  protected function paramsDecorator($params = []) {
    $className = (isset($params['attributes']['class']) && !empty($params['attributes']['class'])) ? $params['attributes']['class'] : ((isset($this->params['attributes']['class']) && !empty($this->params['attributes']['class'])) ? $this->params['attributes']['class'] : '');
    $className .= ' ' . $this->getComponentID();
    $params['attributes']['class'] = ltrim($className);

    return array_merge($this->params, $params);
  }
}

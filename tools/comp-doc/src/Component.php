<?php
/**
 * Class representing single component
 */
class Component {
  const COMPONENT_TPL = 'templates';
  const COMPONENT_SCSS = 'scss';
  const COMPONENT_JS = 'js';
  const COMPONENT_LOGIC = 'Controller.php';

  /**
   * @var string $name Name of component
   */
  protected $name;

  /**
   * @var string $path Path to component
   */
  protected $path;

  /**
   * @var array $has An array with supported properties: ['templates', 'styles', 'scripts', 'logic']
   */
  protected $has;

  /**
   * @var array $variants An array of ComponentVariant objects, each represnting single variant of current component
   */
  protected $variants;

  /**
   * @param string $path Path to component
   * @uses  self::setPath()
   */
  public function __construct($path) {
    $this->setPath($path);
  }

  /**
   * Return object's string representation
   *
   * @uses   self::getName()
   * @uses   self::getPath()
   * @uses   self::getVariants()
   * @uses   self::has()
   * @return string
   */
  public function __toString() {
    return sprintf(
      'Name: %1$s' . "\n" . 'Path: %2$s' . "\n" . 'Has:' . "\n" . '  templates: %3$s' . "\n" . '  styles:    %4$s' . "\n" . '  scripts:   %5$s' . "\n" . '  logic:     %6$s' . "\n" . '',
      $this->getName(),
      $this->getPath(),
      $this->has('templates') ? 'Yes (' . implode(', ', $this->getVariants()) . ')' : 'No',
      $this->has('styles') ? 'Yes' : 'No',
      $this->has('scripts') ? 'Yes' : 'No',
      $this->has('logic') ? 'Yes' : 'No'
    );
  }

  /**
   * Setter for `name` property
   *
   * @param  string $name
   * @uses   self::$name
   * @return void
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Getter for `name` property
   *
   * @uses   self::$name
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Getter for `path` property
   *
   * @uses   self::$path
   * @return string
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * Setter for `path` property. Also sets few other things
   *
   * @param  string $path
   * @uses   self::$path
   * @uses   self::$has
   * @uses   self::COMPONENT_TPL
   * @uses   self::COMPONENT_SCSS
   * @uses   self::COMPONENT_JS
   * @uses   self::COMPONENT_LOGIC
   * @uses   self::setName()
   * @uses   self::has()
   * @uses   ComponentVariant::getName()
   * @return string
   * @throws Exception in case of any issues with given path
   */
  public function setPath($path) {
    if (!isset($path) || empty($path) || !file_exists($path)) {
      throw new \Exception('Invalid path: ' . $path);
    }

    $this->setName(basename($path));
    $this->path = $path;

    if (file_exists($this->path . self::COMPONENT_TPL)) {
      $this->has['templates'] = true;
    }
    if (file_exists($this->path . self::COMPONENT_SCSS)) {
      $this->has['styles'] = true;
    }
    if (file_exists($this->path . self::COMPONENT_JS)) {
      $this->has['scrits'] = true;
    }
    if (file_exists($this->path . self::COMPONENT_LOGIC)) {
      $this->has['logic'] = true;
    }

    if ($this->has('templates')) {
      $variants = array_diff(scandir($this->getPath() . 'templates'), ['.', '..', '.DS_Store']);
      if (is_array($variants) && !empty($variants)) {
        foreach($variants as $variant) {
          $componentVariant = new ComponentVariant($path . 'templates' . DS . $variant);
          $this->variants[$componentVariant->getName()] = $componentVariant;
        }
      }
    }
  }

  /**
   * Checks whether current component has given functionality available
   *
   * @param  string $property One of ['templates', 'styles', 'scripts', 'logic']
   * @uses   self::$has
   * @return bool
   */
  public function has($property) {
    if (!in_array($property, ['templates', 'styles', 'scripts', 'logic'])) {
      return false;
    }

    return (isset($this->has[$property]) && $this->has[$property]);
  }

  /**
   * Returns an array of component's variants
   *
   * @param  string $property One of ['templates', 'styles', 'scripts', 'logic']
   * @uses   self::$variants
   * @return array
   */
  public function getVariants() {
    return (isset($this->variants) && !empty($this->variants)) ? $this->variants : [];
  }
}

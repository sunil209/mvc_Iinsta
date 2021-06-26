<?php
/**
 * Class used to fetch, parse and compile documentation for Website V5.1 components
 * @see https://github.com/Instapage/website-core/tree/master/wp-content/themes/instapagev3/v5/components/v51
 */
class CompDoc {
  /**
   * @var string $source Path to folder containing components
   */
  protected $source;

  /**
   * @var string $destination Path to folder which will contain generated documentation
   */
  protected $destination;

  /**
   * @var string $title Documentation title
   */
  protected $title;

  /**
   * @var array Holds Component objects, one for each component found
   */
  protected $components;

  /**
   * @uses self::init()
   * @uses self::getComponents()
   * @uses Component::getName()
   * @uses self::save()
   */
  public function __construct() {
    $this->init();

    $components = $this->getComponents($this->source);
    foreach ($components as $component) {
      $this->save($component);
    }
  }

  /**
   * Reads command line options and sets defaults, aso creates necessary directories
   * @uses  self::$source
   * @uses  self::$destination
   * @uses  self::$title
   * @return void
   */
  protected function init() {
    $params = getopt('s:d:t:');

    if (!isset($params['s']) || empty($params['s'])) {
      exit(fwrite(STDERR, '-s parameter is required'));
    } else {
      $this->source = realpath($params['s']);
    }

    if (!isset($params['d']) || empty($params['d'])) {
      exit(fwrite(STDERR, '-d parameter is required'));
    } else {
      @unlink(COMPDOC_ROOT . $params['d']);
      @mkdir(COMPDOC_ROOT . $params['d'], 0777, true);
      $this->destination = COMPDOC_ROOT . $params['d'];
    }

    if (!isset($params['t']) || empty($params['t'])) {
      $params['t'] = 'Documentation';
    }

    $this->title = $params['t'];
  }

  /**
   * Scans given directory and returns an array of Component objects
   *
   * @param  string $path Path to components directory
   * @uses   Component::getName()
   * @return array
   */
  protected function getComponents($path) {
    $components = [];

    $dirs = array_diff(scandir($path), ['.', '..', '.DS_Store']);
    if (is_array($dirs) && !empty($dirs)) {
      foreach($dirs as $dir) {
        $component = new Component($path . DS . $dir . DS);
        $components[$component->getName()] = $component;
      }
    }

    return $components;
  }

  /**
   * Returns path where documentation for given Component should be saved to
   * @param  Component $component
   * @uses   Component::getName()
   * @return string
   */
  protected function getPath(Component $component) {
    return $this->destination . DS . $component->getName() . '.html';
  }

  /**
   * Returns component's documentation as HTML
   *
   * @param  Component $component Component to save documentation for
   * @return string
   */
  protected function getHTML(Component $component) {
    ob_start();
    include 'component.tpl.php';
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
  }

  /**
   * Saves component's documentation to a file
   *
   * @param  Component $component Component to save documentation for
   * @uses   self::getPath()
   * @uses   self::getHTML()
   * @return void
   */
  protected function save(Component $component) {
    file_put_contents(
      $this->getPath($component),
      $this->getHTML($component)
    );
  }
}

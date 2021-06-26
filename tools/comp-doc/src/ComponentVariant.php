<?php
/**
 * Class representing single component variation
 */
class ComponentVariant {
  /**
   * @var string $name Name of component variant
   */
  protected $name;

  /**
   * @var string $path Path to component variant
   */
  protected $path;

  /**
   * @var array $path Array with documentation tags
   */
  protected $tags;

  /**
   * @var array $tags Array holding supported tags along with their RegExp's
   */
  private $supportedTags = [
    [
      'name' => 'description',
      'regexp' => '#^(?<Description>.*?)(?:@)#is',
      'properties' => ['Description']
    ],
    [
      'name' => 'param',
      'regexp' => '#@(?<Tag>param)(?:\s+)(?<Type>[a-z\|]+?)(?:\s+)(?<Name>[a-z\$]+)(?:\s+)(?<Description>[^\n]*)(?<SubParams>.*?)(?=\s+@|$)#is',
      'properties' => ['Type', 'Name', 'Description', 'SubParams']
    ],
    [
      'name' => 'example',
      'regexp' => '#@(?<Tag>example)(?:\s+)(?<Name>[^\n]+?)(?:\n+)(?<Code>.+?)(?<CloseTag>@endexample)#is',
      'properties' => ['Name', 'Code']
    ],
    [
      'name' => 'link',
      'regexp' => '#@(?<Tag>link)(?:\s+)(?<Url>[^\n]+)#',
      'properties' => ['Url']
    ]
  ];

  /**
   * @var array $subParams Array holding details of pulling subparams from within @param tag
   */
  private $subParam = [
    'name' => 'subparam',
    'regexp' => '#(?:\s+)?(?<Type>[a-z\|]+?)(?:\s+)(?<Name>[a-z\$]+)(?:\s+)(?<Description>.*)#i',
    'properties' => ['Type', 'Name', 'Description']
  ];

  /**
   * @param  string $path Path to component variation
   * @uses   self::setName()
   * @uses   self::setPath()
   */
  public function __construct($path) {
    $this->setName($path);
    $this->setPath($path);
    $this->tags = $this->fetchTags($this->fetchDocBlock($this));
    $this->tags = $this->fetchSubTags($this->tags);
  }

  /**
   * Return object's string representation
   *
   * @uses   self::getName()
   * @return string
   */
  public function __toString() {
    return $this->getName();
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
   * Setter for `name` property
   *
   * @param  string $path Path to component variation
   * @uses   self::$name
   * @return void
   * @throws Exception in case of any issues with given path
   */
  public function setName($path) {
    if (!isset($path) || empty($path) || !file_exists($path)) {
      throw new \Exception('Invalid path: ' . $path);
    }

    $this->name = rtrim(basename($path), '.php');
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
   * Setter for `path` property
   *
   * @param  string $path Path to component variation
   * @uses   self::$path
   * @return void
   * @throws Exception in case of any issues with given path
   */
  public function setPath($path) {
    if (!isset($path) || empty($path) || !file_exists($path)) {
      throw new \Exception('Invalid path: ' . $path);
    }

    $this->path = $path;
  }

  /**
   * Getter for `tags` property
   *
   * @uses   self::$tags
   * @return array
   */
  public function getTags() {
    return $this->tags;
  }

  /**
   * Fetches DocBlock from component's variation or empty string if something went wrong
   *
   * @param  ComponenVariant $componentVariant Object encapsulating single component variant
   * @uses   self::getPath()
   * @return string DocBlock without opening/closing comments and leading asterixes
   */
  private function fetchDocBlock(ComponentVariant $componentVariant) {
    $contents = file_get_contents($componentVariant->getPath());
    $pattern = '#(?<OpenTag>\/\*\*)(?<DocBlock>.*?)(?<CloseTag>\*\/)#s';
    $matches = [];
    preg_match_all($pattern, $contents, $matches);
    return (isset($matches['DocBlock'][0]) && !empty($matches['DocBlock'][0])) ? str_replace([' * ', ' *'], '', $matches['DocBlock'][0]) : '';
  }

  /**
   * Fetches tags documentation from given DocBlock and returns them in an array
   *
   * @param  string $docBlock
   * @uses   self::$supportedTags
   * @uses   self::$tags
   * @return array
   */
  private function fetchTags($docBlock = '') {
    $tags = [];

    if (!empty($docBlock)) {
      foreach ($this->supportedTags as $tag) {
        $matches = [];
        preg_match_all($tag['regexp'], $docBlock, $matches);
        if (isset($matches[0]) && !empty($matches[0])) {
          for ($i = 0, $c = count($matches[0]); $i < $c; $i++) {
            foreach ($tag['properties'] as $property) {
              $tags[$tag['name']][$i][$property] = trim($matches[$property][$i]);
            }
          }
        }
      }
    }

    return $tags;
  }

  /**
   * Fetches and parses subtags documentation from given tags array
   * @param  array $tags
   * @uses   self::$subParam
   * @return array
   */
  private function fetchSubTags($tags) {
    if (isset($tags) && is_array($tags) && !empty($tags)) {
      foreach ($tags as &$item) {
        if (isset($item) && is_array($item) && !empty($item)) {
          foreach ($item as &$tag) {
            if (isset($tag['SubParams']) && !empty($tag['SubParams'])) {
              $matches = [];
              preg_match_all($this->subParam['regexp'], $tag['SubParams'], $matches);
              if (isset($matches[0]) && !empty($matches[0])) {
                $tag['SubParams'] = [];
                for ($i = 0, $c = count($matches[0]); $i < $c; $i++) {
                  foreach ($this->subParam['properties'] as $property) {
                    $tag['SubParams'][$i][$property] = $matches[$property][$i];
                  }
                }
              }
            }
          }
        }
      }
    }

    return $tags;
  }
}

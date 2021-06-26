<?php
namespace Instapage\Models\SiteMap;

use Instapage\Models\SiteMap\SiteMapSection;

/**
 * Whole sitemap as an object, simple date
 */
class SiteMapContainer implements \Iterator {
  /*
   * @var integer $position position of iterator
   */
  private $position = 0;
  /**
   * @var SiteMapSection[] Array of site map secitons
   */
  private $siteMapSections = [];

  /**
   * Constructor method of SiteMap - initialize position counter
   */
  public function __construct() {
    $this->position = 0;
  }

  public function rewind() {
    $this->positon = 0;
  }

  /**
   * @return SiteMapSection
   */
  public function current() : SiteMapSection {
    return $this->siteMapSections[$this->position];
  }

  public function key() : integer {
    return $this->position;
  }

  public function next() {
    ++$this->position;
  }

  public function valid() {
    return isset($this->siteMapSections[$this->position]);
  }

  /**
   * Chainable method for adding section to the sitemap
   *
   * @param SiteMapSection $section One section of sitemap.
   * @return $this
   */
  public function addSection(SiteMapSection $section) : SiteMapContainer {
    $this->siteMapSections[] = $section;
    return $this;
  }
}

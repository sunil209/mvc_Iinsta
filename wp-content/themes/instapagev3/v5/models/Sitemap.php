<?php
namespace Instapage\Models;

use Instapage\Models\SiteMap\SiteMapContainer;
use Instapage\Models\SiteMap\SiteMapSection;
use Instapage\Models\SiteMap\SiteMapItem;
use Instapage\Models\SiteMap\SiteMapCache;

/**
 * Model for HTML SiteMap
 */
class SiteMap extends Root {

  /**
   * Names of all needed acf fields to fetch data for sitemap
   */
  const ACF_FIELDS = [
    'sections' => 'sitemap_sections',
    'sectionTitle' => 'section_title',
  ];

  /**
   * @var SiteMapContainer Object holding built sitemap
   */
  protected $siteMap = null;

  /**
   * Build sitemap from ACF by filling SiteMapContainer by all sections
   */
  protected function buildSiteMapFromACF() {
    $this->siteMap = new SiteMapContainer();
    $this->fetchSiteMapSections();
  }

  /**
   * Fetch sitemap section from acf and iterate trough them to create section objects
   */
  protected function fetchSiteMapSections() {
    if (have_rows(self::ACF_FIELDS['sections'])) {
      while (have_rows(self::ACF_FIELDS['sections'])) {
        the_row();
        $sectionTitle = get_sub_field(self::ACF_FIELDS['sectionTitle']);
        $siteMapSection = new SiteMapSection($sectionTitle);
        $siteMapSection->buildFromACF(get_row_layout());
        $this->siteMap->addSection($siteMapSection);
      }
    }
  }

  /**
   * Get SiteMapContainer iterator to iterate trought all sitemap section
   *
   * @return SiteMapContainer
   */
  public function getSiteMap() : SiteMapContainer {
    // if sitemap is avaiable just return iterable object [it was obtained earlier]
    if($this->siteMap !== null) {
      return $this->siteMap;
    }

    // there is no already obtained sitemap, so:
    // try to get sitemap from cache
    if (($htmlSiteMapCached = SiteMapCache::getHtmlSiteMap()) !== false) {
      // we have sitemap in cache so return it and save it for later usage
      return $this->siteMap = $htmlSiteMapCached;
    }

    // cache is empty so build sitemap
    $this->buildSiteMapFromACF();
    // store in cache
    SiteMapCache::storeHtmlSiteMap($this->siteMap);
    // and return iterateable object
    return $this->siteMap;
  }
}

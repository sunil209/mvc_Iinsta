<?php
namespace Instapage\Components\v51\Workable;

use Instapage\Classes\Workable;
use Instapage\Entities\{
  JobOffer,
  GroupedJobsCollection
};
use Instapage\Helpers\StringHelper;
use Instapage\Models\Component as ModelComponent;

/**
 * Workable model - getting jobs from their API and injecting to the component template
 *
 * @package Instapage\Components\v51\Workable
 */
class WorkableModel extends ModelComponent {
  protected static $rawJobsFromWorkable = null;
  protected static $groupedJobs = null;

  public function __construct() {
    $this->getRawJobsFromWorkable();
    $this->groupJobs();
  }

  /**
   * Gets an array with jobs available from workable
   * @throws \Exception - if there was any problem
   * @return array
   */
  protected function getRawJobsFromWorkable() : array {
    if (self::$rawJobsFromWorkable !== null) {
      return (array) self::$rawJobsFromWorkable;
    }

    try {
      if (!\defined('WORKABLE_DOMAIN')) {
        throw new \Exception(__('`WORKABLE_DOMAIN` is not defined in `wp-config.php` file'));
      }

      if (!\defined('WORKABLE_APIKEY')) {
        throw new \Exception(__('`WORKABLE_APIKEY` is not defined in `wp-config.php` file'));
      }

      $workable = new Workable(
        WORKABLE_DOMAIN,
        WORKABLE_APIKEY
      );
      return self::$rawJobsFromWorkable = (array) $workable->getJobs(['include_fields' => '']);
    } catch (\Exception $e) {
      error_log($e->getMessage());
      return self::$rawJobsFromWorkable = [];
    }
  }

  /**
   * Map object from workable response to JobOffer enitity
   *
   * @param object $job From API response
   * @return JobOffer
   */
  protected static function getOnlyNeededInformationFromJobOffer(object $job) : JobOffer {
    $mappedJob = new JobOffer();
    $mappedJob->title = $job->title;
    $mappedJob->workableURL = $job->url;

    return $mappedJob;
  }

  /**
   * Group jobs by proper values: departamens, locations
   *
   * @return array
   */
  protected function groupJobs() : array {
    if (self::$groupedJobs !== null) {
      return self::$groupedJobs;
    }

    $jobsGroupedByDepartment = new GroupedJobsCollection();
    $jobsGroupedByLocation = new GroupedJobsCollection();

    foreach (self::$rawJobsFromWorkable as $rawJob) {
      $mappedJob = self::getOnlyNeededInformationFromJobOffer($rawJob);

      $locationKey = ($rawJob->location->city ?? '') . ' (' . ($rawJob->location->country ?? '' ) . ')';
      $jobsGroupedByDepartment->add($rawJob->department ?? '', $mappedJob);
      $jobsGroupedByLocation->add($locationKey, $mappedJob);
    }

    $jobsGroupedByDepartment->sortCollectionAlphabetically();
    $jobsGroupedByLocation->sortCollectionAlphabetically();
    self::$groupedJobs = [];
    self::$groupedJobs['Department'] = $jobsGroupedByDepartment;
    self::$groupedJobs['Location'] = $jobsGroupedByLocation;

    return self::$groupedJobs;
  }

  /**
   * Get jobs grouped by locations and departments and sorted alphabetically,
   */
  public function getJobs() : array {

    return self::$groupedJobs;
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
      'jobs'
    ];
  }

}

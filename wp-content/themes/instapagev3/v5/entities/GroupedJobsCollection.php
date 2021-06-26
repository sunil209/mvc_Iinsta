<?php

namespace Instapage\Entities;

use Instapage\Entities\JobOffer;
use Instapage\Helpers\StringHelper;

/**
 * Class encapsulating collection of jobs grouped be keys.
 *
 */
class GroupedJobsCollection {
  protected $collection = [];

  /**
   * Add new item with given key to colection
   *
   * @param string $groupingKey
   * @param \Instapage\Entities\JobOffer $job
   * @return bool
   */
  public function add(string $groupingKey, JobOffer $job) : bool {
    $asciiKey = StringHelper::getASCII($groupingKey);

    if (!empty($asciiKey)) {
      $this->collection[$asciiKey][] = $job;
      return true;
    }

    return false;
  }

  /**
   * Get whole colection
   *
   * @return array
   */
  public function get() : array {
    return $this->collection;
  }

  /**
   * Sort collection by grouping keys
   */
  public function sortColectionByKeys() : void {
    uksort(
      $this->collection,
      function (string $groupingKeyA, string $groupingKeyB) : int {
        return strcmp($groupingKeyA, $groupingKeyB);
      }
    );
  }

  /**
   * Sort group of jobs by titles
   *
   * @param \Instapage\Entities\JobOffer ...$jobsGroup
   * @return array
   */
  protected function sortGroupByJobTitle(JobOffer ...$jobsGroup) : array {
    uasort(
      $jobsGroup,
      function (JobOffer $jobA, JobOffer $jobB) : int {
        return strcmp($jobA->title, $jobB->title);
      }
    );

    return $jobsGroup;
  }

  /**
   * Sort collection by job titles
   */
  public function sortCollectionByJobTitle() : void {
    foreach ($this->collection as &$jobsGroup) {
      $jobsGroup = $this->sortGroupByJobTitle(...$jobsGroup);
    }
  }

  /**
   * Sort colleciton alphabetically, grouping keys in alphabetically order, jobs by title
   */
  public function sortCollectionAlphabetically() : void {
    $this->sortColectionByKeys();
    $this->sortCollectionByJobTitle();
  }
}

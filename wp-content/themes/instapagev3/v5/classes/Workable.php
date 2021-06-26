<?php
namespace Instapage\Classes;

/**
 * Class designed to fetch available jobs from workable api. To use it you'll need to know you'r domain within workable and have a valid api key
 */
class Workable extends ExternalService {
  use \Instapage\Traits\ExternalJSON;

  /**
   * @var string - URL-like pattern of api endpoint. Needs processing prior further usage
   **/
  private $apiEndpointPattern = 'https://[ApiDomain].workable.com/spi/v3/jobs';

  /**
   * @var string CACHE_KEY Key used to persist json data
   */
  const CACHE_KEY = 'jobs_json';

  /**
   * @param  string $apiDomain - api domain
   * @param  string $apiKey - api key
   * @throws \Instapage\Classes\WorkableException - when there was any problem
   * @uses   \Instapage\Classes\Workable::setApiEndpoint()
   * @uses   \Instapage\Classes\ExternalService::requireExtensions()
   * @uses   \Instapage\Classes\ExternalService::setApiKey()
   * @return array
   */
  public function __construct($apiDomain, $apiKey) {
    try {
      $this->requireExtensions(['curl']);
      $this->setApiKey($apiKey);
      $this->setApiEndpoint($apiDomain);
    } catch (WorkableException $e) {
      throw $e;
    }
  }

  /**
   * Returns an array with available jobs positions
   * @param  array $options - an array of options to be used when querying api
   * @uses   self::CACHE_KEY
   * @uses   \Instapage\Classes\Factory::getCache()
   * @uses   \Instapage\Classes\Workable::getOptions()
   * @uses   \Instapage\Classes\Workable::fetchJobs()
   * @uses   \Instapage\Classes\ExternalService::getApiEndpoint()
   * @return array
   */
  public function getJobs(array $options = []) {
    $cache = \Instapage\Classes\Factory::getCache();

    try {
      $jobs = $cache::get(self::CACHE_KEY);

      if ($jobs === false) {
        $queryString = http_build_query($this->getOptions($options));
        $url = $this->getApiEndpoint();
        $jobs = $this->fetchJobs($url . '?' . $queryString);
        $cache::set(self::CACHE_KEY, $jobs);
      }

      return $jobs;
    }
    catch (\Exception $e) {
      error_log($e->getMessage());
      return [];
    }
  }

  /**
   * Gets options required for api call
   * @param  array $options - an array of options to be merged with default ones
   * @return array
   */
  protected function getOptions(array $options = []) {
    $defaults = [
      'state' => 'published',
      'limit' => 50,
      'include_fields' => 'description, full_description, requirements, benefits'
    ];
    return array_merge($defaults, $options);
  }

  /**
   * Fetches jobs with matching crteria from api
   * @param  string $url - URL of api endpoint with necessary query string appended (if any)
   * @throws \Instapage\Classes\WorkableException - when there was any problem with fetching the jobs
   * @uses   \Instapage\Classes\ExternalService::getApiKey()
   * @uses   \Instapage\Classes\Workable::parseJSON()
   * @return array
   */
  protected function fetchJobs($url) {
    try {
      $data = wp_remote_request($url, ['headers' => ['Authorization' => 'Bearer ' . $this->getApiKey()]]);
      if (is_wp_error($data)) {
        throw new WorkableException(__('Cannot fetch file from given url'));
      }

      $json = self::parseJSON($data['body']);
      return $json->jobs;
    } catch (WorkableException $e) {
      throw $e;
    }
  }

  /**
   * Sets api endpoint URL based on domain provided.
   * @param  string $apiDomain - domain to use with api endpoint
   * @throws \Instapage\Classes\WorkableException if api domain is empty or missing
   * @throws \Instapage\Classes\ExternalServiceException if there was any problem with setting api endpoint
   * @uses   \Instapage\Classes\ExternalService::setApiEndpoint()
   * @uses   \Instapage\Classes\Workable::$apiEndpointPattern
   * @return void
   */
  protected function setApiEndpoint($apiDomain) {
    if ((isset($apiDomain)) && (!empty($apiDomain))) {
      try {
        $search = '[ApiDomain]';
        $replace = $apiDomain;
        $apiEndpoint = str_replace($search, $replace, $this->apiEndpointPattern);
        parent::setApiEndpoint($apiEndpoint);
      } catch (ExternalServiceException $e) {
        throw $e;
      }
    }
    else {
      throw new WorkableException(
        __('ApiDomain is empty or missing. Should be a domain string to fetch the jobs from.')
      );
    }
  }
}

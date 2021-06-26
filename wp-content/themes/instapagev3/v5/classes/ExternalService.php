<?php
namespace Instapage\Classes;

/**
 * Abstract class to work with external services requiring at least api key and endpoint.
 */
abstract class ExternalService {
  /**
   * @var string - api key
   **/
  private $apiKey;

  /**
   * @var string - URL of api endpoint
   **/
  private $apiEndpoint;

  /**
   * Sets api key for authorization with external service.
   * @param  string $apiKey - api key
   * @throws \Instapage\Classes\ExternalServiceException if api key is empty or missing
   * @see    \Instapage\Classes\ExternalService::getApiKey() for getting api key
   * @return void
   */
  protected function setApiKey($apiKey) {
    if ((isset($apiKey)) && (!empty($apiKey))) {
      $this->apiKey = $apiKey;
    } else {
      throw new ExternalServiceException(
        __('ApiKey is empty or missing. Should be a string to authorize with api endpoint.')
      );
    }
  }

  /**
   * Gets api key for authorization with external service.
   * @throws \Instapage\Classes\ExternalServiceException if api key is empty or missing
   * @see    \Instapage\Classes\ExternalService::setApiKey() for setting api key
   * @return string
   */
  protected function getApiKey() {
    if ((isset($this->apiKey)) && (!empty($this->apiKey))) {
      return $this->apiKey;
    } else {
      throw new ExternalServiceException(
        __('ApiKey is empty or missing.')
      );
    }
  }

  /**
   * Sets api endpoint for accessing external service.
   * @param  string $apiEndpoint - URL of api endpoint
   * @throws \Instapage\Classes\ExternalServiceException if api endpoint is empty or missing
   * @see    \Instapage\Classes\ExternalService::getApiEndpoint() for getting api endpoint
   * @return void
   */
  protected function setApiEndpoint($apiEndpoint) {
    if ((isset($apiEndpoint)) && (!empty($apiEndpoint))) {
      $this->apiEndpoint = $apiEndpoint;
    } else {
      throw new ExternalServiceException(
        __('ApiEndpoint is empty or missing. Should be an URL of api endpoint.')
      );
    }
  }

  /**
   * Gets api endpoint for accessing external service.
   * @throws \Instapage\Classes\ExternalServiceException if api endpoint is empty or missing
   * @see    \Instapage\Classes\ExternalService::setApiEndpoint() for setting api endpoint
   * @return void
   */
  protected function getApiEndpoint() {
    if ((isset($this->apiEndpoint)) && (!empty($this->apiEndpoint))) {
      return $this->apiEndpoint;
    } else {
      throw new ExternalServiceException(
        __('ApiEndpoint is empty or missing.')
      );
    }
  }

  /**
   * Checks is all required extensions are present.
   * @param  array $extensions array of extension names required to run given service
   * @throws \Instapage\Classes\ExternalServiceException if at least one extension is missing
   * @return void
   */
  protected function requireExtensions(array $extensions) {
    if ((isset($extensions)) && (is_array($extensions)) && (!empty($extensions))) {
      $missingExtensions = [];
      foreach ($extensions as $extension) {
        if (!extension_loaded($extension)) {
          $missingExtensions[] = $extension;
        }
      }

      if (!empty($missingExtensions)) {
        if (count($missingExtensions) === 1) {
          throw new ExternalServiceException(
            sprintf(
              __('"%s" extension is missing.'),
              $missingExtensions[0]
            )
          );
        } else {
          throw new ExternalServiceException(
            sprintf(
              __('"%s" extensions are missing.'),
              implode('", "', $missingExtensions)
            )
          );
        }
      }
    } else {
      throw new ExternalServiceException(
        __('Extensions is empty or missing. Should be an array of extensions to look for.')
      );
    }
  }
}

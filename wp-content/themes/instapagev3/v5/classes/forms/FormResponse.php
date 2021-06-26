<?php

namespace Instapage\Classes\Forms;

/**
 * Form Response handling
 *
 * @package Instapage\Classes\Forms
 */
class FormResponse {
  /**
   * @var string status when form passed successfully
   */
  const STATUS_SUCCESS = 'success';
  /**
   * @var string status when form not passed
   */
  const STATUS_ERROR = 'error';
  /**
   * @var string message when form passed successfully
   */
  const MESSAGE_SUCCESS = 'Your message has been sent';
  /**
   * @var string message when form passed not
   */
  const MESSAGE_ERROR = 'Your message has not been sent, please try again later';
  /**
   * @var array $fields list of form fields
   */
  protected $fields = [];
  /**
   * @var string $status form status STATUS_SUCCESS/STATUS_ERROR
   */
  protected $status = null;
  /**
   * @var string $message form message MESSAGE_SUCCESS/MESSAGE_ERROR
   */
  protected $message = null;

  /**
   * Setting list of form fields
   *
   * @param array $fields List of form fields
   * @return void
   */
  public function setFields(array $fields) : void {
      $this->fields = $fields;
  }

  /**
   * Setting form status after submitting
   *
   * @param string $status
   * @return void
   */
  public function setStatus(string $status) : void {
    $this->status = $status;
  }

  /**
   * Getting form status after submitting
   *
   * @return string
   */
  public function getStatus() : string {
    return $this->status;
  }

  /**
   * Setting form message after submitting
   *
   * @param string $message
   * @return void
   */
  public function setMessage(string $message) : void {
    $this->message = $message;
  }

  public function setError() : void {
    $this->setStatus(FormResponse::STATUS_ERROR);
    $this->setMessage(FormResponse::MESSAGE_ERROR);
  }

  public function setSuccess() : void {
    $this->setStatus(FormResponse::STATUS_SUCCESS);
    $this->setMessage(FormResponse::MESSAGE_SUCCESS);
  }

  /**
   * Return response array depends on set args
   *
   * @return array
   */
  public function returnResponse() : array {
    $response = ['fields' => $this->fields];

    if ($this->status !== null && $this->message !== null) {
      $response += [
        'status' => $this->status,
        'message' => $this->message
      ];
    }

    return $response;
  }

  /**
   * check if is error in response
   *
   * @param array $response
   * @return bool
   */
  public static function isError(array $response) : bool {

    return isset($response['status']) && $response['status'] === 'error';
  }
}

<?php

namespace Instapage\Classes\Forms;

use \Instapage\Classes\SimpleNonce;
use \Instapage\Classes\Data;

/**
 * Class encapsuling form functionality
 *
 * @package Instapage\Classes\Forms
 */
class Form {
  protected $fields = [];
  protected $nonceName = '';

  /**
   * Form constructor.
   *
   * @param array $fields Field names as a string
   * @param string $nonceName Nonce name for token, will be checked
   */
  public function __construct(array $fields, string $nonceName) {
    $this->fields = $fields;
    $this->nonceName = $nonceName;
  }

  /**
   * Check if form's fields are valid. For now it only checks if every field if filled.
   *
   * @return bool
   */
  public function areFieldsValid() : bool {

    foreach ($this->fields as $field) {
      if (empty(Data::_post($field))) {
        error_log('FORM-NOT-SUBMITTED: Field with name `' . $field . '` is not filled.');
        return false;
      }
    }

    return true;
  }

  /**
   * Check if nonce is okay, CSRF defence
   *
   * @return bool
   */
  public function isNonceValid() : bool {
    $isNonceValid = SimpleNonce::checkNonce(
      Data::_post($this->nonceName),
      Data::_post(Data::_post($this->nonceName, ''))
    );

    if (!$isNonceValid) {
      error_log('FORM-NOT-SUBMITTED: Invalide nonce `' . $this->nonceName . '`.');
    }

    return $isNonceValid;
  }

  /**
   * Check if form is valid, check all needed conditions.
   *
   * @return bool
   */
  public function isFormValid() : bool {
    return $this->areFieldsValid() && $this->isNonceValid();
  }

}

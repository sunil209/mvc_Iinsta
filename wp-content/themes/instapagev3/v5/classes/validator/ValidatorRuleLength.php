<?php
namespace Instapage\Classes\Validator;

/**
 * @todo Add PHPDoc tags to whole file
 */
class ValidatorRuleLength extends ValidatorRule {
  protected $method = 'strlen';
  protected $operator = '>=';
  protected $value = 12;
  protected $message = 'be %s %s characters long';
}

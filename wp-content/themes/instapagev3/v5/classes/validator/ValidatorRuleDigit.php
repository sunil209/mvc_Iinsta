<?php
namespace Instapage\Classes\Validator;

/**
 * @todo Add PHPDoc tags to whole file
 */
class ValidatorRuleDigit extends ValidatorRule {
  protected $method = ['self', 'digitLength'];
  protected $operator = '>=';
  protected $value = 1;
  protected $message = 'contain %s %s digit';

  public function digitLength($input) {
    return preg_match_all('#([0-9]{1})#', $input, $matches);
  }
}

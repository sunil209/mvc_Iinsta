<?php
namespace Instapage\Classes\Validator;

/**
 * @todo Add PHPDoc tags to whole file
 */
class ValidatorRuleUppercase extends ValidatorRule {
  protected $method = ['self', 'uppercaseLength'];
  protected $operator = '>=';
  protected $value = 1;
  protected $message = 'contain %s %s uppercase characters';

  public function uppercaseLength($input) {
    return preg_match_all('#([A-Z]{1})#', $input, $matches);
  }
}

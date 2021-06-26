<?php
namespace Instapage\Classes\Validator;

/**
 * @todo Add PHPDoc tags to whole file
 */
class ValidatorRuleLowercase extends ValidatorRule {
  protected $method = ['self', 'lowercaseLength'];
  protected $operator = '>=';
  protected $value = 1;
  protected $message = 'contain %s %s lowercase characters';

  public function lowercaseLength($input) {
    return preg_match_all('#([a-z]{1})#', $input, $matches);
  }
}

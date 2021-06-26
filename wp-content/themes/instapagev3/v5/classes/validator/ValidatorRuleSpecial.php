<?php
namespace Instapage\Classes\Validator;

/**
 * @todo Add PHPDoc tags to whole file
 */
class ValidatorRuleSpecial extends ValidatorRule {
  protected $method = ['self', 'specialLength'];
  protected $operator = '>=';
  protected $value = 1;
  protected $message = 'contain %s %s special character';

  public function specialLength($input) {
    return preg_match_all('#([£\!@\#\$%\^&\*\(\)_\+§\-\=\{\}\[\]\:"\|;\'\<\>\?,\.\/`~]{1})#', $input, $matches);
  }
}


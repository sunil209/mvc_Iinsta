<?php
namespace Instapage\Classes\Validator;

/**
 * @todo Add PHPDoc tags to whole file
 */
abstract class ValidatorRule {
  protected $method;
  protected $operator;
  protected $value;
  protected $message;
  protected $isValid = true;
  protected $invalidMessage = '';

  public function __construct($operator = null, $value = null, $message = null) {
    foreach (['operator', 'value', 'message'] as $variable) {
      if (!is_null($$variable)) {
        $this->{$variable} = $$variable;
      }
    }
  }

  public function isValid($input) {
    switch ($this->operator) {
      case '>':
        if (!(call_user_func($this->getMethod(), $input) > $this->getValue())) {
          $this->invalidMessage = $this->getMessage();
          $this->isValid = false;
        }
        break;
      case '>=':
        if (!(call_user_func($this->getMethod(), $input) >= $this->getValue())) {
          $this->invalidMessage = $this->getMessage();
          $this->isValid = false;
        }
        break;
      case '<':
        if (!(call_user_func($this->getMethod(), $input) < $this->getValue())) {
          $this->invalidMessage = $this->getMessage();
          $this->isValid = false;
        }
        break;
      case '<=':
        if (!(call_user_func($this->getMethod(), $input) <= $this->getValue())) {
          $this->invalidMessage = $this->getMessage();
          $this->isValid = false;
        }
        break;
      case '==':
        if (!(call_user_func($this->getMethod(), $input) == $this->getValue())) {
          $this->invalidMessage = $this->getMessage();
          $this->isValid = false;
        }
        break;
    }

    return $this->isValid;
  }

  public function getMethod() {
    return $this->method;
  }

  public function getOperator() {
    return $this->operator;
  }

  public function getOperatorText() {
    $operatorTexts = [
      '>' => __('more than'),
      '>=' => __('at least'),
      '<' => __('less than'),
      '<=' => __('at most'),
      '==' => __('exactly')
    ];
    return $operatorTexts[$this->operator];
  }

  public function getValue() {
    return $this->value;
  }

  public function getMessage() {
    return sprintf($this->message, $this->getOperatorText(), $this->getValue());
  }
}

<?php
namespace Instapage\Models;

use \Instapage\Classes\Data;
use \Instapage\Classes\Forms\{
  Form,
  FormResponse
};

/**
 * Model for /careers page
 */
class Careers extends Root {

  public const NONCE_TOKEN_NAME = 'careers';

  /**
   * Get nonce token name, useful for genrating and checking nonces
   *
   * @return string
   */
  public function getNonceTokenName() : string {
    return self::NONCE_TOKEN_NAME;
  }

  /**
   * Send mail to HR from careers page
   *
   * @param string $office          Office, possible values 'us', 'pl', 'ro'
   * @param string $name            Name of person submitting an email
   * @param string $email           Email of person submitting an email
   * @param string $linkedinProfile
   * @param string $message
   */
  protected function sendMailToHR(string $office, string $name, string $email, string $linkedinProfile, string $message) : void {
    add_filter('wp_mail_content_type', function () {
      return 'text/html';
    });

    wp_mail(
      ['hr@instapage.com'],
      '[' . strtoupper(esc_html($office)) . '] ' . esc_html($name) . ' - Contact from careers page',
      '<b>From:</b> ' . esc_html($name) . '<br />'
      . '<b>Email:</b> ' . esc_html($email) . '<br />'
      . '<b>Linkedin profile:</b> ' . esc_url($linkedinProfile) . '<br /><br />'
      . '<b>Message:</b> ' . esc_html($message) . '<br />'
    );
  }

  /**
   * Check if send to value is proper from form from careers page
   *
   * @param string $sendToValue
   * @return bool
   */
  protected function isSendToValid(string $sendToValue) : bool {
    return \in_array($sendToValue, ['us', 'pl', 'ro']);
  }

  /**
   * Handles form submissions and sends them to HR
   *
   * @return array
   */
  public function handleFormSubmit() : array {
    $formResponse = new FormResponse();
    $formFields = [
      'send-to' => [
        'us' => 'checked',
        'pl' => '',
        'ro' => ''
      ],
      'name-and-surname' => '',
      'work-email' => '',
      'linkedin-profile' => '',
      'message' => ''
    ];
    
    if (!empty($_POST)) {
      $fields = ['name-and-surname', 'work-email', 'linkedin-profile', 'message', 'send-to'];
      $form = new Form($fields, $this->getNonceTokenName());
      $status = '';
      $message = '';

      // send-to validation should be moved to is form valid logic in next refactors
      if ($form->isFormValid() && $this->isSendToValid($_POST['send-to'])) {
        $this->sendMailToHR(
          Data::_post('send-to', '', FILTER_SANITIZE_STRING),
          Data::_post('name-and-surname', '', FILTER_SANITIZE_STRING),
          Data::_post('work-email', '', FILTER_SANITIZE_EMAIL),
          Data::_post('linkedin-profile', '', FILTER_SANITIZE_URL),
          Data::_post('message', '', FILTER_SANITIZE_STRING)
        );
        
        $formResponse->setStatus(FormResponse::STATUS_SUCCESS);
        $formResponse->setMessage(FormResponse::MESSAGE_SUCCESS);
      } else {
        error_log('Tried to submit an invalid form');

        $formFields['send-to']['us'] = '';
        $formFields = [
          'send-to' => [Data::_post('send-to', '', FILTER_SANITIZE_STRING) => 'checked'],
          'name-and-surname' => Data::_post('name-and-surname', '', FILTER_SANITIZE_STRING),
          'work-email' => Data::_post('work-email', '', FILTER_SANITIZE_EMAIL),
          'linkedin-profile' => Data::_post('linkedin-profile', '', FILTER_SANITIZE_URL),
          'message' => Data::_post('message', '', FILTER_SANITIZE_STRING)
        ];
              
        $formResponse->setStatus(FormResponse::STATUS_ERROR);
        $formResponse->setMessage(FormResponse::MESSAGE_ERROR);
      }
    }
    $formResponse->setFields($formFields);

    return $formResponse->returnResponse();
  }
}

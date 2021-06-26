<?php
/**
 * Template file. Message showing after form subbmiting
 *
 * @param string $message        simple message
 */
?>

<div class="form-success">
  <div class="snackbar js-snackbar" data-layout="row" data-state="active">
    <p class="snackbar-message"><?= __($message); ?></p>
    <i class="material-icons snackbar-close js-snackbar-close">close</i>
  </div>
</div>

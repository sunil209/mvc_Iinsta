<div class="form-success">
  <div class="snackbar js-snackbar" data-layout="row" <?= (isset($_REQUEST['action']) && $_REQUEST['action'] === 'form-success') ? 'data-state="active"' : 'style="display:none;"' ?>>
    <p><?= __('Your message has been sent'); ?></p>
    <i class="material-icons snackbar-close js-snackbar-close">close</i>
  </div>
</div>

<?php
add_action('wp_footer', 'changeJsLoadingOrder', 1);

/**
 * Changes the order of loading inline ConvertPro JS scripts.
 * They are dependant on jQuery and we have deferred jQuery script. ConvertPro script has to be loaded after jQuery is initialized.
 */
function changeJsLoadingOrder() {
  $convertProLoaderClass = 'Cp_V2_Services_Loader';
  if (class_exists($convertProLoaderClass)) {
    remove_action('wp_footer', $convertProLoaderClass . '::covertfox_script');
    add_action('wp_footer', $convertProLoaderClass . '::covertfox_script', 998);
  }
}

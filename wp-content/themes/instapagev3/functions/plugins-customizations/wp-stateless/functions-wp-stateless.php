<?php

add_filter('wp_stateless_skip_add_media', 'syncAssetsWithoutWaitingForOptimizations', 11);

/**
 * This function by returning false disable waiting with syncing assets to google storage
 * for optimization of asset. Calm down, assets after optimization are send again to google storage
 *
 * @return bool
 */
function syncAssetsWithoutWaitingForOptimizations() : bool {
  return false;
}

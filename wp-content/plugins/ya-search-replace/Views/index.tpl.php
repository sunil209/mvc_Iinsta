<div class="wrap">
  <h1>Search &amp; Replace</h1>
  <form method="post" class="search-box">
    <input type="text" name="yasr-search" placeholder="Text to search for" value="<?php echo (isset($search)) ? htmlspecialchars($search) : ''; ?>" class="search-field">
    <input type="text" name="yasr-replace" placeholder="Text to replace with" value="<?php echo (isset($replace)) ? htmlspecialchars($replace) : ''; ?>" class="search-field">
    <input type="submit" name="yasr-submit" value="Search" class="button action">
  </form>
  <?php if ((isset($posts)) && (!empty($posts))): ?>
    <?php require_once(dirname(__FILE__) . DS . 'results.tpl.php'); ?>
  <?php elseif ((isset($extendedPosts)) && (!empty($extendedPosts))): ?>
    <?php require_once(dirname(__FILE__) . DS . 'extendedResults.tpl.php'); ?>
  <?php elseif ((isset($countPages)) && (!empty($countPages))): ?>
    <?php require_once(dirname(__FILE__) . DS . 'end.tpl.php'); ?>
  <?php elseif ((isset($search)) && (!empty($search)) && (isset($replace)) && (!empty($replace))): ?>
    <?php require_once(dirname(__FILE__) . DS . 'nothingFound.tpl.php'); ?>
  <?php endif; ?>

  <?php if ((isset($backups)) && (!empty($backups))): ?>
    <?php require_once(dirname(__FILE__) . DS . 'backups.tpl.php'); ?>
  <?php endif; ?>
</div>
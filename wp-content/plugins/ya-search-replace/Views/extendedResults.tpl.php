<div class="extended-results">
  <form method="post" class="extended-results-box">
    <input type="hidden" name="yasr-search" value="<?php echo (isset($search)) ? htmlspecialchars($search) : ''; ?>">
    <input type="hidden" name="yasr-replace" value="<?php echo (isset($replace)) ? htmlspecialchars($replace) : ''; ?>">
    <span class="results-count"><?php echo sprintf('%s items found', count($extendedPosts)); ?></span>
    <h1>
    Results
    <input type="submit" name="yasr-confirm-selected" value="Confirm" class="button action confirm-selected">
    </h1>
    <table class="wp-list-table widefat fixed plugins">
      <thead>
        <td id="cb" class="manage-column column-cb check-column">
          <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
          <input id="cb-select-all-1" type="checkbox">
        </td>
        <th id="id" class="manage-column column-name column-primary" scope="col">ID</th>
        <th id="title" class="column-name column-primary" scope="col">Title</th>
        <th id="utl" class="column-name column-description" scope="col">Url</th>
      </thead>
      <tbody id="the-list">
        <?php foreach ($extendedPosts as $post): ?>
          <tr class="active">
            <th class="check-column" scope="row">
              <label class="screen-reader-text" for="checkbox_<?php echo $post->id; ?>">Select</label>
              <input class="checkbox_post" id="checkbox_<?php echo $post->id; ?>" name="post_id[]" value="<?php echo $post->id; ?>" type="checkbox">
            </th>
            <td class="column-primary"><?php echo $post->id; ?></td>
            <td class="column-primary">
              <strong><?php echo $post->post_title; ?></strong>
            </td>
            <td class="column-primary">
              <a target="_blank" href="<?php echo get_permalink($post->id); ?>"><?php echo substr(get_permalink($post->id), strlen($_SERVER['DESIRED_ROOT'])); ?></a>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="width: 50%">
              <h3>Search matches</h3>
              <?php echo $post->beforePostContent; ?>
            </td>
            <td colspan="2" style="width: 50%">
              <h3>Replacement preview</h3>
              <?php echo $post->afterPostContent; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <td class="manage-column column-cb check-column">
          <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
          <input id="cb-select-all-1" type="checkbox">
        </td>
        <th class="manage-column column-name column-primary" scope="col">ID</th>
        <th class="column-name column-primary" scope="col">Title</th>
        <th class="column-name column-description" scope="col">Url</th>
      </tfoot>
    </table>
  </form>
</div>
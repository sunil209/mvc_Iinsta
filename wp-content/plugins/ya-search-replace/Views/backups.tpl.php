<div class="backups">
  <form method="post" class="backups-box">
    <span class="backups-count"><?php echo sprintf('%s items found', count($backups)); ?></span>
    <h1>
      Backups
      <input type="submit" name="yasr-revert-selected" value="Revert selected rows" class="button action revert-selected">
    </h1>
    <table class="wp-list-table widefat plugins">
      <thead>
        <td id="cb" class="manage-column column-cb check-column">
          <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
          <input id="cb-select-all-1" type="checkbox">
        </td>
        <th id="date" class="manage-column column-name column-primary" scope="col">Date</th>
        <th id="replacer" class="column-name column-description" scope="col">Replaced by</th>
        <th id="search" class="column-name column-description" scope="col">Search</th>
        <th id="replace" class="column-name column-description" scope="col">Replace</th>
        <th id="title" class="column-name column-primary" scope="col">Title</th>
        <th id="title" class="column-name column-description" scope="col">Url</th>
      </thead>
      <tbody id="the-list">
        <?php foreach ($backups as $post): ?>
          <tr class="inactive">
            <th class="check-column" scope="row">
              <label class="screen-reader-text" for="checkbox_<?php echo $post->id; ?>">Select</label>
              <input class="checkbox_post" id="checkbox_<?php echo $post->id; ?>" name="post_id[]" value="<?php echo $post->id; ?>" type="checkbox">
            </th>
            <td class="column-primary"><?php echo DateTime::createFromFormat('Y-m-d H:i:s', $post->timestamp)->format('m/d/Y<\b\r>H:i'); ?></td>
            <td class="column-description">
              <strong><?php echo $post->user_display_name; ?></strong><br>
              <em><?php echo $post->user_login; ?></em>
            </td>
            <td class="column-description">
              <strong><?php echo htmlspecialchars($post->search); ?></strong>
            </td>
            <td class="column-description">
              <strong><?php echo htmlspecialchars($post->replace); ?></strong>
            </td>
            <td class="column-primary">
              <strong><?php echo $post->post_title; ?></strong>
            </td>
            <td class="column-primary">
              <a target="_blank" href="<?php echo get_permalink($post->post_id); ?>">
                <?php echo substr(get_permalink($post->post_id), strlen($_SERVER['DESIRED_ROOT'])); ?>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <td class="manage-column column-cb check-column">
          <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
          <input id="cb-select-all-1" type="checkbox">
        </td>
        <th class="manage-column column-name column-primary" scope="col">Date</th>
        <th class="column-name column-description" scope="col">Replaced by</th>
        <th class="column-name column-description" scope="col">Search</th>
        <th class="column-name column-description" scope="col">Replace</th>
        <th class="column-name column-primary" scope="col">Title</th>
        <th class="column-name column-description" scope="col">Url</th>
      </tfoot>
    </table>
  </form>
</div>
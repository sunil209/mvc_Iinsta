<?php
namespace YASearchReplace;

/**
 * Aids with advanced database operations
 */
trait AdvancedDatabase {

  /**
   * Runs query splitting is as appropriate into smaller chunks
   * @param  string $preQuery  String to append before concatenated rows. Usually something like: `INSERT INTO table (id, name)`
   * @param  array  $dataRows  Array of strings, each representing single row of data to insert/update in database
   * @param  string $postQuery String to append after concatenated rows. Usually just a semicolon or `ON DUPLICATE KEY` clause
   * @uses   self::determineRowsNum()
   * @uses   self::popRows()
   * @uses   self::prepareQuery()
   * @return void
   */
  public function runPartialQuery($preQuery = '', &$dataRows = [], $postQuery = '') {
    global $wpdb;

    while ($rowsNum = $this->determineRowsNum($preQuery, $dataRows, $postQuery)) {
      $rows = $this->popRows($dataRows, $rowsNum);
      $sql = $this->prepareQuery($preQuery, $rows, $postQuery);
      if (!$wpdb->query($sql)) {
        throw new \Exception($wpdb->last_error);
      }
    }
  }

  /**
   * Returns maximum query length (in bytes) mysql can handle. If can't get real value - returns mysql's default - 1MB
   * @return int
   */
  public function getMaximumQueryLength() {
    global $wpdb;

    $result = $wpdb->get_row('SELECT @@global.max_allowed_packet as `result`');
    return (!is_null($result)) ? $result->result : 1000000;
  }

  /**
   * Returns number of rows which can be safely sent to database to not exceed `max_allowed_packet' size
   * @param  string $preQuery  String to append before concatenated rows. Usually something like: `INSERT INTO table (id, name)`
   * @param  array  $dataRows  Array of strings, each representing single row of data to insert/update in database
   * @param  string $postQuery String to append after concatenated rows. Usually just a semicolon or `ON DUPLICATE KEY` clause
   * @uses   self::getMaximumQueryLength()
   * @uses   self::prepareQuery()
   * @return int
   */
  protected function determineRowsNum($preQuery = '', &$dataRows = [], $postQuery = '') {
    if (empty($dataRows)) {
      return 0;
    }

    $rowsNumber = 0;
    $maxQueryLength = $this->getMaximumQueryLength();

    while (($s = strlen($this->prepareQuery($preQuery, array_slice($dataRows, 0, $rowsNumber), $postQuery))) <= $maxQueryLength) {
      $rowsNumber++;
      if ($rowsNumber === count($dataRows)) {
        return $rowsNumber;
      }
    }

    return $rowsNumber - 1;
  }

  /**
   * Pops $numRows elements from the beginning of $sourceArray. After each call to this function $sourceArray is modified.
   * @param  array $sourceArray Reference to $sourceArray
   * @param  int   $numRows Number of rows to be chopped off from the beginning of an array
   * @return array
   */
  protected function popRows(&$sourceArray = [], $numRows = 0) {
    $items = [];
    for ($i = 0; $i < $numRows; $i++) {
      $row = array_shift($sourceArray);
      if ($row) {
        $items[] = $row;
      }
    }

    return $items;
  }

  /**
   * Concatenates given params together to form valid SQL query
   * @param  string $preQuery  String to append before concatenated rows. Usually something like: `INSERT INTO table (id, name)`
   * @param  array  $dataRows  Array of strings, each representing single row of data to insert/update in database
   * @param  string $postQuery String to append after concatenated rows. Usually just a semicolon or `ON DUPLICATE KEY` clause
   * @return string
   */
  protected function prepareQuery($preQuery = '', $dataRows = [], $postQuery = '') {
    return $preQuery . ' ' . implode(', ', $dataRows) . ' ' . $postQuery;
  }
}

class Model {
  use AdvancedDatabase;

  /**
   * Searches wp_posts trying to match post_content of each row to given $query
   * @param  string $query Text to be searched for
   * @return array
   */
  public function searchPosts($query) {
    global $wpdb;

    $sql = $wpdb->prepare(
      'SELECT
        `id`,
        `post_title`
      FROM
        `' . $wpdb->prefix . 'posts`
      WHERE
        `post_type` NOT IN (\'revision\', \'attachment\', \'acf-field\', \'acf-field-group\') AND
        `post_content` LIKE \'%s\' ORDER BY `id` DESC',
      '%' . $wpdb->esc_like($query) . '%'
   );
    return $wpdb->get_results($sql);
  }

  /**
   * Get posts with given id/ids
   * @param int|array $ids ID's of posts within wp_posts to be pulled out.
   * May be array of those ID's
   * @return array
   */
  public function getPosts($ids) {
    global $wpdb;

    if ((is_array($ids)) && (empty($ids))) {
      return [];
    }

    if (!empty($ids)) {
      if (!is_array($ids)) {
        $ids = [0 => intval($ids)];
      }
      else {
        $ids = array_map('intval', $ids);
      }
    }
    else {
      return [];
    }

    $sql = 'SELECT
      `id`,
      `post_title`,
      `post_content`
    FROM
      `' . $wpdb->prefix . 'posts`
    WHERE
      `post_type` NOT IN (\'revision\', \'attachment\') AND
      `id` IN (' . implode(', ', $ids) . ')
    ORDER BY
      `id` DESC';
    return $wpdb->get_results($sql, OBJECT);
  }

  /**
   * Creates backup of posts with given IDs in yasr_posts table (post_content field only) plus search & replace phrases
   * @param  string $search Search phrase
   * @param  string $replace Replace phrase
   * @param  int|array $ids ID's of posts within wp_posts to be backed up. May be array of those ID's
   * @param  WP_User $user object returned from wp_get_current_user()
   * @uses   self::runPartialQuery()
   * @return void
   */
  public function backupPosts($search, $replace, $ids, $user) {
    global $wpdb;

    $userLogin = 'unknown';
    $userName = '';
    if (($user instanceof \WP_User) && ($user->ID > 0)) {
      $userLogin = esc_sql($user->user_login);
      $userName = esc_sql($user->display_name);
    }

    if ((isset($ids)) && (!empty($ids))) {
      $posts = $this->getPosts($ids);
      if (!empty($posts)) {
        $preQuery = 'INSERT INTO `' . $wpdb->prefix . 'yasr_posts` (`timestamp`, `post_id`, `search`, `replace`, `post_title`, `post_content`, `user_login`, `user_display_name`) VALUES';
        $postQuery = ';';
        $rows = [];
        $search = esc_sql($search);
        $replace = esc_sql($replace);
        foreach ($posts as $post) {
          $postTitle = esc_sql($post->post_title);
          $postContent = esc_sql($post->post_content);
          $rows[] = '(NOW(),
          \'' . $post->id . '\',
          \'' . $search . '\',
          \'' . $replace . '\',
          \'' . $postTitle . '\',
          \'' . $postContent . '\',
          \'' . $userLogin . '\',
          \'' . $userName . '\'
          )';
        }

        try {
          $this->runPartialQuery($preQuery, $rows, $postQuery);
        } catch (\Exception $e) {
          error_log($e);
        }
      }
    }
  }

  /**
   * Replaces portions of wp_posts.post_content
   * @param string $search Search phrase
   * @param string $replace Replace phrase
   * @param int|array $ids ID's of posts within wp_posts to be replaced.
   * May be array of those ID's
   * @return void
   */
  public function replacePosts($search, $replace, $ids) {
    global $wpdb;

    if ((isset($ids)) && (!empty($ids))) {
      $posts = $this->getPosts($ids);
      if (!empty($posts)) {
        $preQuery = 'INSERT INTO `' . $wpdb->prefix . 'posts` (`id`, `post_content`) VALUES';
        $postQuery = 'ON DUPLICATE KEY UPDATE `post_content` = VALUES(`post_content`);';
        $rows = [];
        foreach ($posts as $post) {
          $postContent = esc_sql(str_ireplace($search, $replace, $post->post_content));
          $rows[] = '(\'' . $post->id . '\', \'' . $postContent . '\')';
        }
        try {
          $this->runPartialQuery($preQuery, $rows, $postQuery);
        } catch (\Exception $e) {
          error_log($e);
        }
      }
    }
  }

  /**
   * Creates required DB schema during plugin activation
   * @return void
   */
  public function createBackupTable() {
    global $wpdb;

    $sql = 'CREATE TABLE IF NOT EXISTS `' . $wpdb->prefix . 'yasr_posts` (
      `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `timestamp` DATETIME NOT NULL DEFAULT \'0000-00-00 00:00:00\' COMMENT \'Timestamp of row creation\',
      `post_id` BIGINT(20) UNSIGNED NOT NULL COMMENT \'ID of post being altered\',
      `search` VARCHAR(255) NOT NULL COMMENT \'Searched text\',
      `replace` VARCHAR(255) NOT NULL COMMENT \'Replaced text\',
      `post_title` TEXT NOT NULL COMMENT \'Post title for reference\',
      `post_content` LONGTEXT NOT NULL COMMENT \'Post content BEFORE replacement\',
      `user_login` VARCHAR(60) NOT NULL COMMENT \'User login for reference. Not joining to `' . $wpdb->prefix . 'user` on purpose\',
      `user_display_name` VARCHAR(250) NOT NULL COMMENT \'User display name for reference. Not joining to `' . $wpdb->prefix . 'user` on purpose\',
      PRIMARY KEY (`id`),
      FOREIGN KEY (`post_id`) REFERENCES `' . $wpdb->prefix . 'posts`(`id`) ON DELETE CASCADE
   ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;';
    $wpdb->query($sql);
  }

  public function getBackups() {
    global $wpdb;

    $whereQuery = '';
    if (func_num_args() > 0) {
      $ids = func_get_arg(0);
      if (!empty($ids)) {
        if (!is_array($ids)) {
          $ids = intval($ids);
          $whereQuery = 'WHERE `id` = \'' . $ids . '\'';
        }
        else {
          $ids = array_map('intval', $ids);
          $whereQuery = 'WHERE `id` IN (' . implode(', ', $ids) . ')';
        }
      }
    }

    $sql = 'SELECT
              *
            FROM
              `' . $wpdb->prefix . 'yasr_posts`
            ' . $whereQuery . '
            ORDER BY
              `id` DESC';
    return $wpdb->get_results($sql, OBJECT);
  }

  public function revertBackups($ids) {
    global $wpdb;

    if ((is_array($ids)) && (empty($ids))) {
      return [];
    }

    if (!empty($ids)) {
      if (!is_array($ids)) {
        $ids = [0 => intval($ids)];
      }
      else {
        $ids = array_map('intval', $ids);
      }
    }
    else {
      return [];
    }

    $backups = $this->getBackups($ids);

    foreach ($backups as $backup) {
      $sql = 'UPDATE
                `' . $wpdb->prefix . 'posts`
              SET
                `post_content` = \'' . esc_sql($backup->post_content) . '\'
              WHERE
                `ID` = \'' . $backup->post_id . '\'
              LIMIT 1';
      $wpdb->query($sql);
    }
  }

  public function removeBackups($ids) {
    global $wpdb;

    if ((is_array($ids)) && (empty($ids))) {
      return [];
    }

    if (!empty($ids)) {
      if (!is_array($ids)) {
        $ids = [0 => intval($ids)];
      }
      else {
        $ids = array_map('intval', $ids);
      }
    }
    else {
      return [];
    }

    if ((isset($ids)) && (!empty($ids))) {
      foreach ($ids as $id) {
        $sql = 'DELETE FROM `' . $wpdb->prefix . 'yasr_posts`
                WHERE `id` = \'' . $id . '\' LIMIT 1;';
        $wpdb->query($sql);
      }
    }
  }
}

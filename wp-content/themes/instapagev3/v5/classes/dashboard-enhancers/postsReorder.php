<?php

namespace Instapage\Classes\DashboardEnhancers;

use Instapage\Classes\Data;

/**
 * postsReorder class is responsible for enhancment of post menu order functionality, it gives:
 * - showing current menu_order on post listing in edit screen
 * - you can change your post order on post edit screen
 *
 */
class postsReorder {
  use \Instapage\Traits\Singleton;

  /**
   * @var boolean Does our dashboard was enhanced and customizated? Kind of mutex.
   */
  protected $enhanced = false;

  /**
   * @var string Name of cookies containg
   */
  protected $columnName = 'menu-order';
  protected $nonceAction = null;
  protected $nonceName = null;

  private function __construct() {
    // set values for generating nonces
    $this->nonceAction = get_class($this);
    $this->nonceName = get_class($this) . 'nonce';
  }

  /**
   * This method encapsulate checking if currently post type should use our post order customizations?
   *
   * @param string $postType Post type of post to check
   * @return bool If this post type should be customized with menu order return true.
   */
  private function isServicedPostType(string $postType) : bool {
    if ($postType === 'post') {
      return true;
    }
    return false;
  }

  /**
   * Make all needed action to enhance post reorder functionality - but only once.
   */
  public function enhance() : void {
    if (!$this->enhanced && !wp_doing_ajax()) {
      $this->hookFilters();
    }
  }

  /**
   * Method for hooking all necessary utility
   * to perform on proper events during wordpress working
   */
  protected function hookFilters() : void {
    \add_filter('manage_posts_columns', [$this, 'addMenuOrderColumn'], 10, 2);
    \add_action('manage_posts_custom_column', [$this, 'valueMenuOrderColumn'], 10, 2);
    \add_action('add_meta_boxes', [$this, 'addReorderBox'], 10, 2);
    \add_action('save_post', [$this, 'saveMenuOrder'], 10, 3);
    \add_action('admin_init', [$this, 'enqueAssets']);
  }

  public function enqueAssets() {
    wp_enqueue_script(
      'instapage_admin_reorder_posts',
      get_template_directory_uri() . '/v5/classes/dashboard-enhancers/postsReorder.js', ['jquery']
    );
  }

  /**
   * Check all security conditions should we save new post order and is it secure?
   *
   * @param int $postID The ID of the post being saved.
   *
   * @return boolean Return true if it is secure to write new info, otherwise false.
   */
  public function isSaveSecure(int $postID) {
    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */
    $nonce = Data::_post($this->nonceName);

    // Check if our nonce is set.
    if (!isset($nonce)) {
      return false;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($nonce, $this->nonceAction)) {
      return false;
    }

    /*
     * If this is an autosave, our form has not been submitted,
     * so we don't want to do anything.
     */
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return false;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $postID)) {
      return false;
    }

    return true;
  }

  /**
   * Save menu order of the post being saved.
   *
   * @param int $postID    The ID of the post being saved.
   * @param \WP_Post $post Post object which is currently saved.
   */
  public function saveMenuOrder(int $postID, \WP_Post $post) {
    $postType = $post->post_type;
    // do customization only for choosed post types
    if (!$this->isServicedPostType($postType)) {
      return;
    }

    if (!$this->isSaveSecure($postID)) {
      return false;
    }

    /* OK, it's safe for us to save the data now. */
    $newMenuOrder = Data::_int('post', $this->columnName);
    if ($newMenuOrder !== null
        && $newMenuOrder >= 1
        && $newMenuOrder <= $this->getMaxMenuOrderValue($postType)
    ) {
      $this->changePostOrder($newMenuOrder, $postID);
    }
  }

  /**
   * Perform sql query for changing menu order for given post
   *
   * @global \wpdb $wpdb
   * @param int $newMenuOrder New menu order for post
   * @param int $postID       Id of post to change his menu order
   *
   * @return int $numberOfRowsAffected How many rows where affected?
   * @throws Exception When query failed it throws exception.
   */
  protected function actuallyMovePost(int $newMenuOrder, int $postID) : int {
    /* @var $wpdb \wpdb */
    global $wpdb;

    // this query alters menu orders for posts which need to be reorder to have proper menu order values [no duplication]
    $query = 'UPDATE `wp_posts` ' .
             'SET `menu_order` = %d ' .
             'WHERE `ID` = %d';

    $sql = $wpdb->prepare($query, $newMenuOrder, $postID);
    $numberOfRowsAffected = $wpdb->query($sql);

    if ($numberOfRowsAffected === false) {
      throw new Exception('Changing menu order of post with id: ' . $postID . ' failed.');
    }
    return $numberOfRowsAffected;
  }

  /**
   * To perform change of menu_order for given post we need to
   * change menu_order for post between old and new menu_order value
   *
   * @global \wpdb $wpdb
   * @param int $leftRange    Left range value for menu_order to change menu_order value
   * @param int $rightRange   Right range value for menu_order to change menu_order value
   * @param string $postType  Post type to perform menu_order value reordering
   * @param int $direction    Should we move post by one up or down?
   *
   * @return int $numberOfRowsAffected How many rows where affected?
   * @throws Exception When query failed it throws exception.
   */
  public function reorderOtherPosts(int $leftRange, int $rightRange, string $postType = 'post', int $direction = 1) {
    /* @var $wpdb \wpdb */
    global $wpdb;

    // this query alters menu orders for posts which need to be reorder to have proper menu order values [no duplication]
    $query = 'UPDATE `wp_posts` ' .
             'SET `menu_order` = `menu_order` + %d ' .
             'WHERE `menu_order` >= %d AND `menu_order` <= %d ' .
             'AND post_type = %s ' .
             'AND post_status IN (\'publish\', \'pending\', \'draft\', \'private\', \'future\');';

    $sql = $wpdb->prepare($query, $direction, $leftRange, $rightRange, $postType);
    $numberOfRowsAffected = $wpdb->query($sql);

    if ($numberOfRowsAffected === false) {
      throw new Exception('Changing menu order of needed posts failed [Post ID: ' . $postID . '].');
    }
    return $numberOfRowsAffected;
  }

  /**
   * Get reordering params is it forward/backward reordering and in which range?
   *
   * @param int $newMenuOrder New wantend menu order value
   * @param int $oldMenuOrder Old menu order value
   *
   * @return boolean|array False if position are the same, or array [$direction, $leftRange, $rightRange]
   */
  protected function getReorderingParams(int $newMenuOrder, int $oldMenuOrder) {
    /**
     * We change menu order only if it is diffrent
     */
    if ($newMenuOrder === $oldMenuOrder) {
      return false;
    }

    // Forward reorder
    else if ($newMenuOrder > $oldMenuOrder) {
      $direction = -1;
      $leftRange = $oldMenuOrder + 1;
      $rightRange = $newMenuOrder;
    // Backward reorder
    } else {
      $direction = 1;
      $leftRange = $newMenuOrder;
      $rightRange = $oldMenuOrder - 1;
    }

    return [
      $direction,
      $leftRange,
      $rightRange,
    ];
  }

  /**
   * Change menu_order value for post of given id $postID
   *
   * @param int $newMenuOrder New value for menu order param for post
   * @param int $postID       ID of post that we want change menu_order
   * @return void
   */
  public function changePostOrder(int $newMenuOrder, int $postID) : void {
    /* @var $post \WP_Post */
    $post = get_post($postID);
    $oldMenuOrder = $this->getCurrentMenuOrder($postID);

    $reorderParams = $this->getReorderingParams($newMenuOrder, $oldMenuOrder);

    if ($reorderParams === false) {
      return;
    }

    [$direction, $leftRange, $rightRange] = $reorderParams;

    try {
      // make place for post to move
      // we have to reorder others post to release newMenuOrder number
      // and we cannot have two posts with the same menuOrder
      $this->reorderOtherPosts($leftRange, $rightRange, $post->post_type, $direction);
      // move our post
      $this->actuallyMovePost($newMenuOrder, $postID);
    } catch (\Exception $ex) {
      error_log($ex->getMessage());
    }
  }

  /**
   * Get menu_order value for post of id $postID
   *
   * @param int $postID ID of post to get menu_order param value
   * @return int  Menu order value
   */
  public function getCurrentMenuOrder(int $postID) : int {
    $post = get_post($postID);
    return $post->menu_order;
  }

  /**
   * Echos menu_order value for column in wp dashboard
   *
   * @param string $columnName  Name of column renered at this moment.
   * @param int $postID         Post id to show menu order value
   */
  public function valueMenuOrderColumn(string $columnName, int $postID) : void {
    $post = get_post($postID);
    $postType = $post->post_type;
    // do customization only for choosed post types
    if (!$this->isServicedPostType($postType)) {
      return;
    }
    if ($columnName === $this->columnName) {
      echo $this->getCurrentMenuOrder($postID);
    }
  }

  /**
   * Add new custom column for menu order.
   *
   * @param array $columns Value from $columns filter.
   * @return array Array with columns definition with added new for menu order.
   */
  public function addMenuOrderColumn(array $columns, string $postType) : array {
    // do customization only for choosed post types
    if (!$this->isServicedPostType($postType)) {
      return $columns;
    }

    return array_merge(
             $columns,
             [$this->columnName => 'Menu Order']
           );
  }

  /**
   *
   * Get max menu order value for validation purposes
   *
   * @global \wpdb $wpdb
   * @param string $postType Post type to check
   * @return int Get max menu order value for given post type
   */
  protected function getMaxMenuOrderValue(string $postType = 'post') : int {
    /* @var $wpdb \wpdb */
    global $wpdb;

    // this query alters menu orders for posts which need to be reorder to have proper menu order values [no duplication]
    $query = 'SELECT max(menu_order)' .
             'FROM `wp_posts` ' .
             'WHERE post_type = %s ' .
             'AND post_status IN (\'publish\', \'pending\', \'draft\', \'private\', \'future\');';

    $sql = $wpdb->prepare($query, $postType);
    $maxMenuOrder = $wpdb->get_var($sql);

    return $maxMenuOrder;
  }

  /**
   * Add hook to generate reorder box in edit screen in dashboard.
   */
  public function addReorderBox(string $postType) : void {
    // do customization only for choosed post types
    if (!$this->isServicedPostType($postType)) {
      return;
    }
    add_meta_box(
        'reorder-box',                // Unigue ID
        'Post order',                 // Box Title
        [$this, 'renderReorderBox'],  // Callack to generate box content - must echo value
        'post',                       // Post type
        'side',                       // Where on the screen this box should appear?
        'high'                        // Priority of the box, should be hight or can be low placed in choosen colum?
    );
  }

  /**
   * Generate box with reorder input.
   *
   * @param \WP_POST $post
   */
  public function renderReorderBox(\WP_POST $post) {
    wp_nonce_field($this->nonceAction, $this->nonceName);
    $menuOrder = $post->menu_order;
    $postType = $post->post_type;
    $minMenuOrder = 1;
    $maxMenuOrder = $this->getMaxMenuOrderValue($postType);
    // Display the form, using the current value.
    ?>
    <div>
      <label for="menu-order">
          <?php printf(__('Decide about menu order, the lower the higher post will apear. Min allowed value is: %d, max %d'), $minMenuOrder, $maxMenuOrder); ?>
      </label>
    </div>
    <input type="number" min="<?= $minMenuOrder ?>" max="<?= $maxMenuOrder ?>" id="menu-order" name="<?= $this->columnName ?>" value="<?php echo esc_attr($menuOrder); ?>" size="25" />
    <?php
  }
}

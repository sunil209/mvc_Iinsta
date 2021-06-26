<?php
namespace YASearchReplace;

use \WP_Query;

class Main {

  public $view;
  public $model;

  public function __construct() {
    $this->initPlugin();
    $this->processForm();
    $this->processBackups();
  }

  /**
   * Initializes plugin
   * @uses \YASearchReplace\Main::$view
   * @return void
   */
  public function initPlugin() {
    try {
      $this->model = new Model();
      $this->model->createBackupTable();

      $this->view = new Template();
      $this->view->setBasePath(YASR_PLUGIN_PATH . DS . 'Views');

      if (is_admin()) {
        register_activation_hook(
          plugin_basename(YASR_PLUGIN_FILE),
          [&$this->model, 'createBackupTable']
        );
        add_action('admin_menu', [&$this, 'addSubmenuPage']);
        add_filter(
          'plugin_action_links_' . plugin_basename(YASR_PLUGIN_FILE),
          [&$this, 'addActionLink']
        );

        wp_register_style(
          'yasr-css',
          plugins_url('css/style.css',__FILE__)
        );
        wp_enqueue_style('yasr-css');

        wp_register_script(
          'yasr-js',
          plugins_url('js/script.js',__FILE__), ['jquery']
        );
        wp_enqueue_script('yasr-js');
      }
    }
    catch (Exceptions\TemplateBasePathException $exception) {
      error_log($exception->getMessage());
    }
  }

  /**
   * Adds an action link to plugin page
   * @return void
   */
  public function addSubmenuPage() {
    if (function_exists('add_submenu_page')) {
      add_submenu_page(
        'plugins.php',
        __('Yet Another Search &amp; Replace'),
        __('Search &amp; Replace'),
        'manage_options',
        YASR_PLUGIN_ABBR,
        [&$this, 'renderPage']
     );
    }
  }

  /**
   * Adds an action link to plugin page
   * @return void
   */
  public function addActionLink($links) {
    $links[] = '<a href="' . admin_url('admin.php?page=' . YASR_PLUGIN_ABBR) .
               '">Search &amp; Replace</a>';
    return $links;
  }

  /**
   * Processes search form
   * Processes form user uses to find and replace occurences of given string
   * @return void
   */
  public function processForm() {
    if ((isset($_REQUEST['yasr-submit'])) && (!empty($_REQUEST['yasr-submit'])) &&
         (isset($_REQUEST['yasr-search'])) && (!empty($_REQUEST['yasr-search'])) &&
         (isset($_REQUEST['yasr-replace'])) && (!empty($_REQUEST['yasr-replace']))
         ) {
      $search = $_REQUEST['yasr-search'];
      $this->view->assign('search', $search);

      $replace = $_REQUEST['yasr-replace'];
      $this->view->assign('replace', $replace);

      $this->view->assign('posts', $this->model->searchPosts($search));
    }
    else if ((isset($_REQUEST['yasr-edit-selected'])) && (!empty($_REQUEST['yasr-edit-selected'])) &&
              (isset($_REQUEST['yasr-search'])) && (!empty($_REQUEST['yasr-search'])) &&
              (isset($_REQUEST['yasr-replace'])) && (!empty($_REQUEST['yasr-replace'])) &&
              (isset($_REQUEST['post_id'])) && (!empty($_REQUEST['post_id']))) {
      $search = $_REQUEST['yasr-search'];
      $this->view->assign('search', $search);

      $replace = $_REQUEST['yasr-replace'];
      $this->view->assign('replace', $replace);
      $extendedPosts = $this->model->getPosts($_REQUEST['post_id']);
      if (!empty($extendedPosts)) {
        foreach ($extendedPosts as &$post) {
          $post->beforePostContent = $this->highlightBeforeString($search, $post->post_content);
          $post->afterPostContent = $this->highlightAfterString($search, $replace, $post->post_content);
        }
        unset($post);
        $this->view->assign('extendedPosts', $extendedPosts);
      }
    }
    else if ((isset($_REQUEST['yasr-confirm-selected'])) && (!empty($_REQUEST['yasr-confirm-selected'])) &&
              (isset($_REQUEST['yasr-search'])) && (!empty($_REQUEST['yasr-search'])) &&
              (isset($_REQUEST['yasr-replace'])) && (!empty($_REQUEST['yasr-replace'])) &&
              (isset($_REQUEST['post_id'])) && (!empty($_REQUEST['post_id']))) {
      $search = html_entity_decode($_REQUEST['yasr-search']);
      $this->view->assign('search', $search);

      $replace = html_entity_decode($_REQUEST['yasr-replace']);
      $this->view->assign('replace', $replace);

      $this->model->backupPosts($search, $replace, $_REQUEST['post_id'], wp_get_current_user());
      $this->model->replacePosts($search, $replace, $_REQUEST['post_id']);

      $this->view->assign('countPages', count($_REQUEST['post_id']));
    }
  }

  /**
   * Backups
   * @return void
   */
  public function processBackups() {
    if ((isset($_REQUEST['yasr-revert-selected'])) && (!empty($_REQUEST['yasr-revert-selected'])) &&
         (isset($_REQUEST['post_id'])) && (!empty($_REQUEST['post_id']))) {
      $this->model->revertBackups($_REQUEST['post_id']);
      $this->model->removeBackups($_REQUEST['post_id']);
    }

    $this->view->assign('backups', $this->model->getBackups());
  }

  private function highlightBeforeString($search, $text) {
    $search = htmlspecialchars($search);
    return str_ireplace($search, '<span class="highlight-before">' . $search . '</span>', htmlspecialchars($text));
  }

  private function highlightAfterString($search, $replace, $text) {
    $search = htmlspecialchars($search);
    $replace = htmlspecialchars($replace);
    return str_ireplace($search, '<span class="highlight-after">' . $replace . '</span>', htmlspecialchars($text));
  }

  /**
   * Displays template file.
   * Displays content of index.php template file.
   * @uses \YASearchReplace\Template::fetch()
   * @return void
   */
  public function renderPage() {
    try {
      echo $this->view->fetch('index.tpl.php');
    }
    catch (Exceptions\TemplateFileNotFoundException $exception) {
      error_log($exception->getMessage());
    }
  }
}

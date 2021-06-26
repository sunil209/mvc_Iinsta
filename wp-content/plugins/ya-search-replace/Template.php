<?php
namespace YASearchReplace;

/**
 * Provides methods to work with templates.
 * @access public
 */
class Template {

  /**
   * Holds path to template directory.
   * @var string
   * @access private
   */
  private $templateBasePath;

  /**
   * Holds template content.
   * @var string
   * @access private
   */
  private $templateBuffer;

  /**
   * Associative array holding names and values of variables assigned to template.
   * @var array
   * @access private
   */
  private $templateVars = [];

  /**
   * Sets base path.
   * Sets path to directory containing templates and returns true
   * or throws an exception
   * if given string was empty or directory was unreadable.
   * @access public
   * @param string $path Path to directory containing templates
   * @uses \YASearchReplace\Template::$templateBasePath
   * @return bool
   * @throws \YASearchReplace\Exceptions\TemplateBasePathException
   * if given string was empty or directory was unreadable.
   */
  public function setBasePath($path) {
    if ((isset($path)) && (!empty($path)) && (is_readable($path))) {
      $path = rtrim($path, DS) . DS;
      $this->templateBasePath = $path;
      chdir($this->templateBasePath);
      return true;
    }
    else {
      throw new Exceptions\TemplateBasePathException(
        'Specified template base path is empty or unreadable: ' . $path
     );
    }
  }

  /**
   * Gets base path used.
   * Returns previously set base path or throws an exception
   * if base path was not set before.
   * @access public
   * @uses \YASearchReplace\Template::$templateBasePath
   * @return string
   * @throws \YASearchReplace\Exceptions\TemplateBasePathException
   * if base path was not set before.
   */
  public function getBasePath() {
    if ((isset($this->templateBasePath)) &&
      (is_string($this->templateBasePath)) &&
      (!empty($this->templateBasePath))
   ) {
      return $this->templateBasePath;
    }
    else {
      throw new Exceptions\TemplateBasePathException('Base path is empty.');
    }
  }

  /**
   * Sets variable to be used by template.
   * Sets variable for template.
   * It will overwrite any previously set variables with the same name.
   * @access public
   * @param string $variable Name of variable
   * @param mixed $value Value of variable
   * @uses \YASearchReplace\Template::$templateVars
   * @return void
   */
  public function assign($variable, $value) {
    $this->templateVars[(string) $variable] = $value;
  }

  /**
   * Outputs template to web browser.
   * Prints content of given template to user's web browser.
   * It will throw an exception if template could not be found
   * or given template file name is empty.
   * @access public
   * @param string $template File name of template to be loaded
   * @uses \YASearchReplace\Template::$templateBasePath
   * @uses \YASearchReplace\Template::$templateBuffer
   * @uses \YASearchReplace\Template::$templateVars
   * @return void
   * @throws \YASearchReplace\Exceptions\TemplateBasePathException
   * if given template file name is empty.
   * @throws \YASearchReplace\Exceptions\TemplateFileNotFoundException
   * if given template could not be found.
   * @see \YASearchReplace\Template::Import()
   * @see \YASearchReplace\Template::Fetch()
   */
  public function output($template) {
    if ((isset($template)) && (!empty($template))) {
      if (file_exists($this->templateBasePath . $template)) {
        ob_start();

        extract($this->templateVars, EXTR_SKIP);
        require $this->templateBasePath . $template;

        $this->templateBuffer = ob_get_contents();
        ob_end_clean();
      }
      else {
        throw new Exceptions\TemplateFileNotFoundException(
          'Template file could not be found: ' . $template
        );
      }
    }
    else {
      throw new Exceptions\TemplateException('Template file is empty.');
    }
  }

  /**
   * Fetches given template.
   * Returns content of given template.
   * It will throw an exception if template could not be found
   * or given template file name is empty.
   * @access public
   * @param string $template File name of template to be loaded
   * @uses \YASearchReplace\Template::$templateBasePath
   * @uses \YASearchReplace\Template::$templateVars
   * @return string
   * @throws \YASearchReplace\Exceptions\TemplateBasePathException
   * if given template file name is empty.
   * @throws \YASearchReplace\Exceptions\TemplateFileNotFoundException
   * if given template could not be found.
   * @see \YASearchReplace\Template::Import()
   * @see \YASearchReplace\Template::Output()
   */
  public function fetch($template) {
    if ((isset($template)) && (!empty($template))) {
      if (file_exists($this->templateBasePath . $template)) {
        ob_start();

        extract($this->templateVars, EXTR_SKIP);
        require $this->templateBasePath . $template;

        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
      }
      else {
        throw new Exceptions\TemplateFileNotFoundException(
          'Template file could not be found: ' . $template
        );
      }
    }
    else {
      throw new Exceptions\TemplateException('Template file is empty.');
    }
  }

  /**
   * Echoes content of {@see \YASearchReplace\Template::$templateBuffer}
   * @access public
   * @uses \YASearchReplace\Template::$templateBuffer
   * @return void
   */
  public function __destruct() {
    echo $this->templateBuffer;
  }
}

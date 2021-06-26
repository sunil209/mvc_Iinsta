<?php
namespace Instapage\Components\Amp\DocumentStart;

use Instapage\Classes\Templates\ClassTemplates;
use Instapage\Models\Component as ModelComponent;
use WPSEO_Frontend;

/**
 * Description of model-document-start
 */
class DocumentStartModel extends ModelComponent {

  private $description = null;

  public function __construct()
  {
    $yoast = WPSEO_Frontend::$instance;
    $this->description = $yoast->metadesc(false);

    if (!$this->description) {
      $classTemplates = new ClassTemplates();
      $template = $classTemplates->getTemplate($classTemplates->getCurrentTemplateSlug());
      $this->description = $template->description;
    }
  }

  public function getDescription() {
    return $this->description;
  }

  public function getOgImage() {
    return '';
  }

  /**
   * Return list of parameters that model can provide.
   *
   * Remember that if paramter name is items, function which will fetch data for this parameter is getItems() etc.
   *
   * @return array Array containg parametes name that model can provide
   */
  public function getParamsListToInject() : array {
    return [
      'description',
      'ogImage'
    ];
  }

}
